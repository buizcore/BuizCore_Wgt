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
class BuizNavigation_Maintab_Menu extends WgtDropmenu
{

  /**
   * build the window menu
   * @param TArray $params
   */
  public function buildMenu($params)
  {

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

  <div class="wgt-panel-control" >
    <div
      class="wcm wcm_control_buttonset wgt-button-set"
      id="wgt-mentry-navigation-boxtype" >
      <input
        type="radio"
        class="wgt-mentry-navigationtype fparam-wgt-form-navigation-search"
        id="wgt-mentry-navigationtype-box"
        value="box"
        name="nav-boxtype"
        checked="checked" /><label
          for="wgt-mentry-navigationtype-box"
          class="wcm wcm_ui_tip-top"
          tooltip="Show boxes"  ><i class="fa fa-th" ></i></label>
      <input
        type="radio"
        class="wgt-mentry-navigation-boxtype fparam-wgt-form-navigation-search"
        id="wgt-mentry-navigationtype-tile"
        value="tile"
        name="nav-boxtype"  /><label
          for="wgt-mentry-navigationtype-tile"
          class="wcm wcm_ui_tip-top"
          tooltip="Show tiles" ><i class="fa fa-th-list" ></i></label>
      <input
        type="radio"
        class="wgt-mentry-navigation-boxtype fparam-wgt-form-navigation-search"
        id="wgt-mentry-navigationtype-list"
        value="list"
        name="nav-boxtype" /><label
          for="wgt-mentry-navigationtype-list"
          class="wcm wcm_ui_tip-top"
          tooltip="Show as List" ><i class="fa fa-list" ></i></label>
    </div>
  </div>

HTML;


    $this->content .= <<<HTML
<div class="right" >
  &nbsp;&nbsp;&nbsp;
  <button
    class="wcm wcm_ui_tip-left wgt-button wgtac_close"
    tabindex="-1"
    tooltip="Close the active tab"  ><i class="fa fa-times" ></i></button>
</div>
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

