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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>

 */
class AclMgmt_Dset_Query_Postgresql extends LibSqlQuery
{/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Loading the tabledata from the database
   * @param int $areaId
   * @param TFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchGroups($areaid, $params = null)
  {

    if (!$params)
      $params = new TFlag();

    $this->sourceSize = null;
    $db = $this->getDb();

    $sql = <<<SQL
  SELECT
    distinct buiz_role_group.rowid as id,
    buiz_role_group.name as value

  FROM
    buiz_role_group
  JOIN
    buiz_security_access
      ON buiz_security_access.id_group =  buiz_role_group.rowid
  WHERE
    buiz_security_access.id_area = {$areaid}

  ORDER BY
    buiz_role_group.name

SQL;

    $this->data = $db->select($sql)->getAll();

  }//end public function fetchAreaGroups */

  /**
   * Loading the tabledata from the database
   *
   * @param int $areaId
   * @param string $key
   * @param TFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchUsersByKey($areaId, $key, $params = null)
  {

    if (!$params)
      $params = new TFlag();

    $this->sourceSize = null;
    $db = $this->getDb();

    $tmp = explode(',',$key);

    $wheres = [];

    foreach ($tmp as $value) {

      $safeVal = $db->escape(trim($value));

      if ('' == $safeVal)
        continue;

      $wheres[] = " buiz_role_user.name like upper('{$safeVal}%')
        or upper(core_person.lastname) like upper('{$safeVal}%')
        or upper(core_person.firstname) like upper('{$safeVal}%') ";
    }

    $sqlWhere = "(".implode(' or ',$wheres).")";

    $sql = <<<SQL
  SELECT
    buiz_role_user.rowid as id,
    COALESCE ('('||buiz_role_user.name||') ', '') || COALESCE (core_person.lastname || ', ' || core_person.firstname, core_person.lastname, core_person.firstname, '') as value,
    COALESCE ('('||buiz_role_user.name||') ', '') || COALESCE (core_person.lastname || ', ' || core_person.firstname, core_person.lastname, core_person.firstname, '') as label

  FROM
    buiz_role_user

  JOIN
    core_person
    ON
      core_person.rowid = buiz_role_user.id_person

  WHERE
    {$sqlWhere}
    AND NOT buiz_role_user.rowid IN
    (
      SELECT
        buiz_group_users.rowid
          FROM
            buiz_group_users
          WHERE
          (
            buiz_group_users.id_area = {$areaId}
              AND buiz_group_users.vid is null
          )
            OR buiz_group_users.id_area is null
    )
  LIMIT 10;
SQL;

    $this->result = $db->select($sql);

  }//end public function fetchUsersByKey */

} // end class AclMgmt_Dset_Query_Postgresql */

