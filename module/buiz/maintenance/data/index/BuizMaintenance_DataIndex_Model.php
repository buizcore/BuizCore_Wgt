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
class BuizMaintenance_DataIndex_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function getStats()
  {

    $db = $this->getDb();

    $stats = [];

    $query = <<<SQL
SELECT
  count(vid) as num
FROM
  buiz_data_index
SQL;

    $stats['numer_entries'] =  $db->select($query)->getField('num');

  }//end public function getStats */

  /**
   * @return void
   */
  public function getModules()
  {
    return [];

  }//end public function getModules */

}//end class BuizMaintenance_DataIndex_Model */

