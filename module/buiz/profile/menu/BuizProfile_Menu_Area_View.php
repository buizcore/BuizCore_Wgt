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
class BuizProfile_Menu_Area_View extends LibTemplateAreaView
{
 /**
  * add the table item
  * add the search field elements
  *
  * @param int $objid the id of the reference dataset
  * @param TFlag $params
  * @return boolean
  */
  public function displayTab($objid, $params)
  {

    /* @var $acl LibAclAdapter_Db */
    $acl = $this->getAcl();

    // set the tab template
    $this->setTemplate('buiz/profile/menu/tab', true);
    $this->setPosition('#'.$params->tabId);

    $this->addVar('objid', $objid);

    $menuProvider = new BuizDesktop_Menu_Provider();
    $menuTree = $menuProvider->getMainMenu( $objid );

    $this->addVar('mainMenuData', $menuTree);

    // ok gab scheins kein fehler
    return null;

  }//end public function displayTab */

}//end class BuizProfile_Menu_Area_View

