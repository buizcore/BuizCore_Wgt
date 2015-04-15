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
class BuizStatsUsage_Model  extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
//  Attributes
/*////////////////////////////////////////////////////////////////////////////*/

/*////////////////////////////////////////////////////////////////////////////*/
//  Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return array
   */
  public function loadData()
  {
    $db = $this->getDb();

    $sql = <<<SQL

SQL;

    return $db->select($sql);

  }//end public function loadData */

}//end  class  BuizKnowhowNode_Model

