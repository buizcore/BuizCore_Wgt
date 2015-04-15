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
class AclMgmt_SyncGroup_Query_Postgresql extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Laden aller assignten Gruppen
   *
   * @param int $areaId
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

    $cols = array
    (
      'buiz_security_access.rowid as "buiz_security_access_rowid"',
      'buiz_security_access.access_level as "buiz_security_access_access_level"',
      'buiz_security_access.date_start as "buiz_security_access_date_start"',
      'buiz_security_access.date_end as "buiz_security_access_date_end"',
      'buiz_security_access.id_group as "buiz_security_access_id_group"'
    );
    $criteria->select($cols);

    $criteria->from('buiz_security_access');

    $criteria->where("id_area={$areaId} and partial = 0");

    // Run Query und save the result
    $this->result = $db->orm->select($criteria);

  }//end public function fetch */

} // end class AclMgmt_SyncGroup_Query_Postgresql */

