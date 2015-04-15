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
class BuizMaintenance_Maintab extends LibViewMaintab
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $menuName
   * @return void
   */
  public function display($menuName, $params)
  {

    $this->setLabel('Maintenance');
    $this->setTitle('Maintenance');

    $this->setTemplate('buiz/navigation/maintab/modmenu');

    $modMenu = $this->newItem('modMenu', 'WgtElementMenuExplorer');
    $modMenu->setData
    (
      DaoFoldermenu::get('maintenance/'.$menuName, true),
      'maintab.php'
    );

    $params = new TArray;
    $this->addMenuMenu($modMenu, $params);

  }//end public function displayMenu */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenuMenu($modMenu, $params)
  {

    $menu = $this->newMenu
    (
      $this->id.'_dropmenu',
      'BuizMaintenance'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->crumbs = $modMenu->buildCrumbs();
    $menu->buildMenu($params);

  }//end public function addMenuMenu */

}//end class BuizMaintenance_Maintab

