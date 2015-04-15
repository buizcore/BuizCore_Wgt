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
class MaintenanceBase_Maintab_Menu extends WgtDropmenu
{

  /**
   * @var array
   */
  public $crumbs = null;

  /**
   * @param TArray $params
   */
  public function buildMenu($params)
  {

    $iconMenu = '<i class="fa fa-reorder" ></i>';
    $iconClose = '<i class="fa fa-times " ></i>';
    $iconEntity = $this->view->icon('control/entity.png' , 'Entity'  );

    $entries = new TArray;

    $this->content = <<<HTML

  <div class="wgt-panel-control" >
    <button
      class="wcm wcm_control_dropmenu wgt-button"
      id="{$this->id}-control"
      data-drop-box="{$this->id}"  ><i class="fa fa-reorder" ></i> {$this->view->i18n->l('Menu','wbf.label')}</button>
      <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"mouseover","closeOnLeave":"true"}</var>
  </div>

  <div class="wgt-dropdownbox" id="{$this->id}" >
    <ul>
      <li>
        <a class="wgtac_close" ><i class="fa fa-times" ></i> {$this->view->i18n->l('Close', 'wbf.label')}</a>
      </li>
    </ul>
  </div>

HTML;

    $this->content .= $this->crumbs;

    $this->content .= <<<HTML
<div class="right" >
  <input
    type="text"
    id="wgt-input-buiz_navigation_search-tostring"
    name="key"
    class="large wcm wcm_ui_autocomplete wgt-ignore"  />
  <var class="wgt-settings" >
    {
      "url"  : "ajax.php?c=Buiz.Navigation.search&amp;key=",
      "type" : "ajax"
    }
  </var>
  <button
    id="wgt-button-buiz_navigation_search"
    class="wgt-button append"
  >
    <i class="fa fa-search" ></i> Search
  </button>

</div>
HTML;

  }//end public function buildMenu */

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

}//end class BuizNavigation_Maintab_Menu

