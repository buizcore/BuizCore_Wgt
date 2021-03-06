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
class MaintenanceBase_Maintab_View extends LibViewMaintabCustom
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $menuName
   * @return void
   */
  public function displayMenu($menuName, $params  )
  {

    $this->setLabel('Maintenance Menu');
    $this->setTitle('Maintenance Menu');

    $this->setTemplate('buiz/navigation/maintab/modmenu'  );

    $className = 'ElementMenu'.ucfirst($params->menuType) ;

    $modMenu = $this->newItem('modMenu', $className);
    $modMenu->setData
    (
      DaoFoldermenu::get('maintenance/'.$menuName, true),
      'maintab.php'
    );

    $params = new TArray;
    $this->addMenuMenu($modMenu, $params);
    $this->addActions($params);

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
      'MaintenanceBase'
    );
    $menu->id = $this->id.'_dropmenu';

    $menu->crumbs = $modMenu->buildCrumbs();
    $menu->buildMenu($params);

  }//end public function addMenuMenu */

  /**
   * just add the code for the edit ui controlls
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addActions( $params)
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function() {
      self.close();
    });


BUTTONJS;

    $this->addJsCode($code);

  }//end public function addActions */

}//end class BuizNavigation_Maintab

