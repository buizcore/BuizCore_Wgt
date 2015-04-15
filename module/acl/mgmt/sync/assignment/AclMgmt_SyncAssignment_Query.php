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
class AclMgmt_SyncAssignment_Query extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /** build criteria, interpret conditions and load data
   *
   * @param int $areaId
   *
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetch($areaId)
  {

    $this->sourceSize = null;
    $db = $this->getDb();

    if (!$this->criteria) {
      $criteria = $db->orm->newCriteria();
    } else {
      $criteria = $this->criteria;
    }

    $cols = array(
      'buiz_group_users.rowid as "buiz_group_users_rowid"',
      'buiz_group_users.vid as "buiz_group_users_vid"',
      'buiz_group_users.id_user as "buiz_group_users_id_user"',
      'buiz_group_users.id_group as "buiz_group_users_id_group"',
      'buiz_group_users.date_start as "buiz_group_users_date_start"',
      'buiz_group_users.date_end as "buiz_group_users_date_end"'
    );

    $criteria->select($cols);

    $criteria->from('buiz_group_users');

    $criteria->where(
      "buiz_group_users.id_area={$areaId} and buiz_group_users.partial = 0"
    );

    // Run Query und save the result
    $this->result = $db->orm->select($criteria);

  }//end public function fetch */

} // end class AclMgmt_SyncAssignment_Query */

