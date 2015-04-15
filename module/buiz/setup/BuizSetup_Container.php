<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
* @projectUrl  : http://buizcore.com
*
* @licence     : BuizCore.com internal only
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class BuizSetup_Container extends DataContainer
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function run()
  {

    $db = Db::connection('admin');

    $conf = Conf::get('db','connection');
    $defCon = $conf['default'];

    $dbAdmin = $db->getManager();
    $dbAdmin->setOwner($defCon['dbuser']);

    $this->checkSequences($dbAdmin, $defCon);
    $this->checkAclViews($dbAdmin, $defCon);
    $this->checkPersonViews($dbAdmin, $defCon);
    

    //$this->setupBuizMasks($dbAdmin, $defCon);

  }//end public function run */

  /**
   * @param LibDbAdminPostgresql $dbAdmin
   * @param array $defCon
   */
  public function checkSequences($dbAdmin, $defCon)
  {

    if (!$dbAdmin->sequenceExists('entity_oid_seq')) {
      $dbAdmin->createSequence('entity_oid_seq');
    }

    if (!$dbAdmin->sequenceExists('buiz_deploy_revision')) {
      $dbAdmin->createSequence('buiz_deploy_revision');
    }

  }//end public function checkSequences */

  /**
   * @param LibDbAdminPostgresql $dbAdmin
   * @param array $defCon
   */
  public function checkAclViews($dbAdmin, $defCon)
  {

    if (!$dbAdmin->viewExists('buiz_acl_max_permission_view')) {

      $ddl = <<<DDL
CREATE OR REPLACE VIEW buiz_acl_max_permission_view
AS
  SELECT
    max(acl_access.access_level)  as "acl-level",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.id_user                as "acl-user",
    acl_gu.vid                    as "acl-vid",
    min(acl_gu.partial)           as "assign-partial"
  FROM
    buiz_security_access acl_access
  JOIN
    buiz_security_area acl_area
    ON
      acl_access.id_area = acl_area.rowid
  JOIN
    buiz_group_users acl_gu
    ON
      acl_access.id_group = acl_gu.id_group
  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_gu.vid,
    acl_area.rowid,
    acl_gu.partial
;
DDL;

      $dbAdmin->ddl($ddl);
      $dbAdmin->setViewOwner('buiz_acl_max_permission_view');

    }//end buiz_acl_max_permission_view

    if (!$dbAdmin->viewExists('buiz_area_user_level_view')) {

      $ddl = <<<DDL
CREATE  OR REPLACE VIEW buiz_area_user_level_view
  AS
  SELECT
    max(acl_access.access_level)  as "acl-level",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.vid                    as "acl-vid",
    acl_gu.id_user                as "acl-user",
    acl_gu.id_group               as "acl-group"
  FROM
    buiz_security_area acl_area
  JOIN
    buiz_security_access acl_access
    ON
      acl_access.id_area = acl_area.rowid
  JOIN
    buiz_group_users acl_gu
    ON
    (
      CASE WHEN
        acl_gu.id_area IS NOT NULL
      THEN
      (
        CASE WHEN
          acl_gu.vid IS NOT NULL
        THEN
          acl_access.id_group = acl_gu.id_group
            and acl_gu.id_area = acl_area.rowid
            and (acl_gu.partial = 0)
        ELSE
          acl_access.id_group = acl_gu.id_group
            and acl_gu.id_area = acl_area.rowid
            and (acl_gu.partial = 0)
            and acl_gu.vid is null
        END
      )
      ELSE
        acl_access.id_group = acl_gu.id_group
          and acl_gu.id_area is null
          and (acl_gu.partial = 0)
          and acl_gu.vid is null
      END
    )
  where
    acl_access.partial = 0

  GROUP BY
    acl_gu.id_user,
    acl_area.access_key,
    acl_area.rowid,
    acl_gu.vid,
    acl_gu.id_group
;
DDL;

      $dbAdmin->ddl($ddl);
      $dbAdmin->setViewOwner('buiz_area_user_level_view');

    }//end buiz_area_user_level_view

    if (!$dbAdmin->viewExists('buiz_acl_assigned_view')) {

      $ddl = <<<DDL
CREATE  OR REPLACE VIEW buiz_acl_assigned_view
AS
  SELECT
    max(acl_gu.partial)           as "assign-has-partial",
    min(acl_gu.partial)           as "assign-is-partial",
    acl_area.access_key           as "acl-area",
    acl_area.rowid                as "acl-id_area",
    acl_gu.id_user                as "acl-user",
    acl_gu.vid                    as "acl-vid"
  FROM
    buiz_security_access acl_access
  JOIN
    buiz_security_area acl_area
    ON
      acl_access.id_area = acl_area.rowid
  JOIN
    buiz_group_users acl_gu
    ON
      acl_access.id_group = acl_gu.id_group
  WHERE
    acl_gu.vid is null
  GROUP BY
    acl_area.access_key,
    acl_gu.id_user,
    acl_area.rowid,
    acl_gu.vid
;
DDL;

      $dbAdmin->ddl($ddl);
      $dbAdmin->setViewOwner('buiz_acl_assigned_view');

    }//end buiz_acl_assigned_view

  }//end public function checkAclViews */

  /**
   * @param LibDbAdminPostgresql $dbAdmin
   * @param array $defCon
   */
  public function checkPersonViews($dbAdmin, $defCon)
  {

    if (!$dbAdmin->viewExists('view_person_role')) {

      $ddl = <<<DDL
CREATE OR REPLACE VIEW view_person_role AS
 SELECT
  core_person.rowid AS core_person_rowid,
  core_person.salutation AS core_person_salutation,
  core_person.firstname AS core_person_firstname,
  core_person.second_firstname AS core_person_second_firstname,
  core_person.lastname AS core_person_lastname,
  core_person.academic_title AS core_person_academic_title,
  buiz_role_user.rowid AS buiz_role_user_rowid,
  buiz_role_user.name AS buiz_role_user_name
   FROM
    buiz_role_user
   JOIN
    core_person
      ON core_person.rowid = buiz_role_user.id_person;
DDL;

      $dbAdmin->ddl($ddl);
      $dbAdmin->setViewOwner('view_person_role');

    }//end view_person_role

    if (!$dbAdmin->viewExists('view_user_role_contact_item')) {

      $ddl = <<<DDL
CREATE OR REPLACE VIEW view_user_role_contact_item AS
 SELECT
  core_person.rowid AS core_person_rowid,
  core_person.firstname AS core_person_firstname,
  core_person.lastname AS core_person_lastname,
  core_person.academic_title AS core_person_academic_title,
  core_person.noblesse_title AS core_person_noblesse_title,
  buiz_role_user.rowid AS buiz_role_user_rowid,
  buiz_role_user.name AS buiz_role_user_name,
  buiz_address_item.address_value AS buiz_address_item_address_value,
  buiz_address_item_type.name AS buiz_address_item_type_name
  FROM
    buiz_role_user
  JOIN
    core_person
      ON core_person.rowid = buiz_role_user.id_person
  JOIN
    buiz_address_item
      ON buiz_role_user.rowid = buiz_address_item.id_user
  JOIN
    buiz_address_item_type
      ON buiz_address_item_type.rowid = buiz_address_item.id_type
  WHERE
    buiz_address_item.use_for_contact = true;
DDL;

      $dbAdmin->ddl($ddl);
      $dbAdmin->setViewOwner('view_user_role_contact_item');

    }//end view_person_role

  }//end public function checkPersonViews */

}//end class BuizSetup_Container

