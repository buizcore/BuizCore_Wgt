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
class BuizMaintenance_DataIndex_Stats_Maintab_Menu extends WgtDropmenu
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

    $iconMenu = '<i class="fa fa-reorder" ></i>';
    $iconRebuild = $view->icon( 'maintenance/rebuild_index.png', 'Rebuild Index');
    $iconClose = '<i class="fa fa-times " ></i>';

    $entries = new TArray;
    $entries->support = $this->entriesSupport($params);

    // prüfen ob der aktuelle benutzer überhaupt neue einträge anlegen darf
    if ($params->access->maintenance) {

      $entries->buttonInsert = <<<BUTTON

  <div class="wgt-panel-control" >
    <button
      class="wcm wcm_ui_button wgtac_recreate wcm_ui_tip-top"
      title="{$view->i18n->l('Recreate the index','wbf.label')}" >{$iconRebuild} {$view->i18n->l('Recreate index','wbf.label')}</button>
  </div>

BUTTON;

    }

    $this->content = <<<HTML

  <div class="inline" >
    <button
      class="wcm wcm_control_dropmenu wgt-button"
      tabindex="-1"
      id="{$this->id}-control"
      data-drop-box="{$this->id}"  ><i class="fa fa-reorder" ></i> {$this->view->i18n->l('Menu','wbf.label')}</button>
      <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"click"}</var>
  </div>

  <div class="wgt-dropdownbox" id="{$this->id}" >
    <ul>
      <li>
        <a class="wgtac_bookmark" ><i class="fa fa-bookmark" ></i> {$view->i18n->l('Bookmark','wbf.label')}</a>
      </li>
    {$entries->support}
      <li>
        <a class="wgtac_close" ><i class="fa fa-times" ></i> {$this->view->i18n->l('Close', 'wbf.label')}</a>
      </li>
    </ul>
  </div>

{$entries->buttonInsert}

HTML;

  }//end public function buildMenu */

  /**
   * @param TArray $params
   */
  protected function entriesSupport($params)
  {
    $html = <<<HTML

      <li>
        <a class="deeplink" ><i class="fa fa-question-sign" ></i> {$this->view->i18n->l('Support','wbf.label')}</a>
        <span>
          <ul>
            <li><a
              class="wcm wcm_req_ajax"
              href="modal.php?c=Buiz.Docu.open&amp;key=buiz_message-create" ><i class="fa fa-info-circle" ></i> {$this->view->i18n->l('Help','wbf.label')}</a></li>
            <li><a
              class="wcm wcm_req_ajax"
              href="modal.php?c=Buiz.Faq.create&amp;context=create" ><i class="fa fa-question" ></i> {$this->view->i18n->l('FAQ','wbf.label')}</a></li>
          </ul>
        </span>
      </li>

HTML;

    return $html;

  }//end public function entriesSupport */

}//end class BuizMaintenance_DataIndex_Stats_Maintab_Menu

