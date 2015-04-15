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
class ProcessBase_Query_Postgresql extends ProcessBase_Query
{

  /*
CREATE TABLE production.buiz_process_step
(
  id_from integer,
  id_to integer,
  id_type integer,
  id_process integer,
  "comment" text,
  rowid integer NOT NULL DEFAULT nextval('buiz.entity_oid_seq'::regclass),
  m_time_created timestamp without time zone,
  m_role_created integer,
  m_time_changed timestamp without time zone,
  m_role_changed integer,
  m_version integer,
  m_uuid uuid,
  rate integer,
  CONSTRAINT buiz_process_step_pkey PRIMARY KEY (rowid)
)
WITH (
  OIDS=FALSE
);

CREATE OR REPLACE VIEW buiz.view_person_role AS
  SELECT
    core_person.rowid AS core_person_rowid,
    core_person.firstname AS core_person_firstname,
    core_person.lastname AS core_person_lastname,
    buiz_role_user.rowid AS buiz_role_user_rowid,
    buiz_role_user.name AS buiz_role_user_name,
    buiz_role_user.email AS buiz_role_user_email
  FROM
    buiz.buiz_role_user
  JOIN
    buiz.core_person ON core_person.rowid = buiz_role_user.id_person;

   */

  /**
   * @param int $processId
   */
  public function fetchProcessEdges($processId)
  {

    $sql = <<<SQL

SELECT
  step.rowid,
  step.id_from,
  step.id_to,
  step.comment,
  step.rate,
  step.m_time_created,
  node_from.label as node_from_name,
  node_to.label as node_to_name,
  role.buiz_role_user_rowid,
  role.core_person_firstname,
  role.core_person_lastname,
  role.buiz_role_user_name

  from
    buiz_process_step step

  LEFT JOIN
    buiz_process_node node_from
    ON
      node_from.rowid = step.id_from

  JOIN
    buiz_process_node node_to
    ON
      node_to.rowid = step.id_to

  JOIN
    view_person_role role
    ON
      role.buiz_role_user_rowid = step.m_role_created

  where
    step.id_process_instance = {$processId}

  ORDER BY
    step.m_time_created asc;

SQL;

    $this->result = $this->getDb()->select($sql);

  }//end public function fetchProcessEdges */

} // end class ProcessBase_Query_Postgresql

