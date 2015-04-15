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
class BuizMessage_Table_Access extends LibAclPermission
{

  /**
   * @param TFlag $params
   * @param BuizMessage_Entity $entity
   */
  public function loadDefault($params, $entity = null)
  {

    // laden der mvc/utils adapter Objekte
    $acl = $this->getAcl();

    $this->level = Acl::DELETE;

  }//end public function loadDefault */

  /**
   * @param LibSqlQuery $query
   * @param string $condition
   * @param TFlag $params
   */
  public function fetchListTableDefault($query, $condition, $params)
  {

    // laden der mvc/utils adapter Objekte
    $acl = $this->getAcl();
    $user = $this->getUser();
    $orm = $this->getDb()->getOrm();

    $userId = $user->getId();

    // erstellen der Acl criteria und befüllen mit den relevanten cols
    $criteria = $orm->newCriteria();

    $criteria->select(array('buiz_message.rowid as rowid')  );

    if (!$this->defLevel) {
      $greatest = <<<SQL

  acls."acl-level"

SQL;

      $joinType = ' ';

    } else {

      $greatest = <<<SQL

  greatest
  (
    {$this->defLevel},
    acls."acl-level"
  ) as "acl-level"

SQL;

      $joinType = ' LEFT ';

    }

    $criteria->selectAlso($greatest  );

    $query->setTables($criteria);
    $query->appendConditions($criteria, $condition, $params  );
    $query->checkLimitAndOrder($criteria, $params);
    $query->appendFilter($criteria, $condition, $params);

    $criteria->join(
      " {$joinType} JOIN
        {$acl->sourceRelation} as acls
        ON
          UPPER(acls.\"acl-area\") IN(UPPER('mod-buiz'), UPPER('mgmt-buiz_message'))
            AND acls.\"acl-user\" = {$userId}
            AND acls.\"acl-vid\" = buiz_message.rowid ",
      'acls'
    );

    $tmp = $orm->select($criteria);
    $ids = [];

    foreach ($tmp as $row) {
      $ids[$row['rowid']] = $row['acl-level'];
    }

    $query->setCalcQuery($criteria, $params);

    return $ids;

  }//end public function fetchListTableDefault */

}//end class BuizMessage_Widget_Access

