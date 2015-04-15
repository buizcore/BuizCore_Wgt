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
class MaintenanceDb_Index_Stats_Maintab_Menu extends WgtDropmenu
{
/*////////////////////////////////////////////////////////////////////////////*/
// menu: create
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   * add a drop menu to the create window
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu($params)
  {

    // laden der mvc/utils adapter Objekte
    $acl = $this->getAcl();
    $view = $this->getView();

    $entries = new TArray;

    $this->content = <<<HTML
<div class="wgt-panel-control" >
  <button
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}-control"
    data-drop-box="{$this->id}_dropmenu"  ><i class="fa fa-reorder" ></i> {$view->i18n->l('Menu','wbf.label')}</button>
  <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"mouseover","closeOnLeave":"true","align":"right"}</var>
</div>

<div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >
  <ul>
    <li>
      <a class="wgtac_bookmark" ><i class="fa fa-bookmark" ></i> {$view->i18n->l('Bookmark', 'wbf.label')}</a>
    </li>
  </ul>
  <ul>
    <li>
      <a class="deeplink" ><i class="fa fa-info-circle" ></i> {$view->i18n->l('Support', 'wbf.label')}</a>
      <span>
      <ul>
        <li><a class="wcm wcm_req_ajax" href="modal.php?c=Buiz.Faq.create&amp;context=menu" ><i class="fa fa-info-circle" ></i> {$view->i18n->l('Faq', 'wbf.label')}</a></li>
      </ul>
      </span>
    </li>
    <li>
      <a class="wgtac_close" ><i class="fa fa-times-sign" ></i> {$view->i18n->l('Close','wbf.label')}</a>
    </li>
  </ul>
</div>

<div class="wgt-panel-control" >
	<button
      class="wcm wcm_ui_button wgtac_recreate wcm_ui_tip-top"
      title="{$view->i18n->l('Recreate the index','wbf.label')}" ><i class="fa fa-refresh" ></i> {$view->i18n->l('Recreate index','wbf.label')}</button>
</div>

<div class="wgt-panel-control" >
  <button
      class="wcm wcm_ui_button wgtac_search_form wcm_ui_tip-top"
      title="{$view->i18n->l('Open search form','wbf.label')}" ><i class="fa fa-refresh" ></i> {$view->i18n->l('Search','wbf.label')}</button>
</div>

HTML;

  }//end public function buildMenu */


}//end class MaintenanceDb_Index_Stats_Maintab_Menu

