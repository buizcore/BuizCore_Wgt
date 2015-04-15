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
class ProcessBase_Query extends LibSqlQuery
{

  /**
   * @param int $processId
   */
  public function fetchProcessEdges($processId)
  {

    $sql = <<<SQL

SELECT
  step.rowid,
  step.id_from,
  node_from.label as node_from_name,
  step.id_to,
  node_to.label as node_to_name,
  step.comment,
  step.rate,
  step.m_time_created,
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

SQL;

    $this->result = $this->getDb()->select($sql);

  }//end public function fetchProcessEdges */

} // end class ProcessBase_Query

