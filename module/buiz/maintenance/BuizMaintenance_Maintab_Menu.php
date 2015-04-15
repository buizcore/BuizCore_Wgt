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
class BuizMaintenance_Maintab_Menu extends WgtDropmenu
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * Enter description here ...
   * @var unknown_type
   */
  public $crumbs = null;

  /**
   * @param TArray $params
   */
  public function buildMenu($params)
  {

    $iconMenu = '<i class="fa fa-reorder" ></i>';
    $iconClose = '<i class="fa fa-times " ></i>';

    $entries = new TArray;

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
        <a class="wgtac_close" ><i class="fa fa-times" ></i> {$this->view->i18n->l('Close', 'wbf.label')}</a>
      </li>
    </ul>
  </div>

HTML;

    $this->content .= $this->crumbs;

  }//end public function buildMenu */


  /**
   * @param TArray $params
   */
  protected function entriesSupport($params)
  {

    $html = <<<HTML

      <li>
        <p><i class="fa fa-question-sign" ></i> Support</p>
        <ul>
          <li><a class="wcm wcm_req_ajax" href="maintab.php?c=Buiz.Base.help&refer=buiz-maintenance-menu" ><i class="fa fa-info-circle" ></i> Help</a></li>
          <li><a class="wcm wcm_req_ajax" href="maintab.php?c=Buiz.Issue.create&refer=buiz-maintenance-menu" ><i class="fa fa-bug" ></i> Bug</a></li>
          <li><a class="wcm wcm_req_ajax" href="maintab.php?c=Buiz.Faq.create&refer=buiz-maintenance-menu" ><i class="fa fa-question" ></i> Faq</a></li>
        </ul>
      </li>

HTML;

    return $html;

  }//end public function entriesSupport */

}//end class BuizMaintenance_Maintab_Menu

