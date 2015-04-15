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
class BuizMenu_Model extends MvcModel
{

  /**
   * @param LibTemplate $view
   * @return void
   */
  public function getMainMenu()
  {
    return DaoFoldermenu::get('buiz/root',true);

  }//end public function desktop */

  /**
   * @return void
   */
  public function getStartMenu(  )
  {

    $db = $this->getDb();

    $conf = $this->getConf();
    $appKey = $conf->getStatus('gateway.key');

    if (!$appKey)
      return [];

    $app = $db->orm->getBeyKey('BuizApp', "{$appKey}");

    $query = $db->newQuery('BuizMenu');

    if (!$app->id_main_menu) {
      return $query->fetchMenuEntries($app->id_main_menu);
    } else {
      return [];
    }

  }//end public function getStartMenu */

} // end class BuizMenu_Model

