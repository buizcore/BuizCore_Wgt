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
class BuizProtocol_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
//  Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $dKey
   * @param int $objid
   * @return BuizProtocol_Overlay_Query
   */
  public function loadDsetProtocol($dKey, $objid)
  {

    $db = $this->getDb();

    $condition = [];
    $condition['vid'] = $objid;

    /* @var $query BuizProtocol_Overlay_Query  */
    $query = $db->newQuery('BuizProtocol_Overlay');
    $query->fetch($condition);

    return $query;

  }//end public function loadDsetProtocol */

}//end class BuizHistory_Model

