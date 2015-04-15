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
class BuizImport_Maintab_Menu extends WgtDropmenu
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu($params)
  {

    $iconMenu = '<i class="fa fa-reorder" ></i>';
    $iconClose = $this->view->icon('control/close_tab.png'     ,'Close');

    $entries = new TArray;
    //$entries->support = $this->entriesSupport($params);

    $this->content = <<<HTML

  <div class="inline" >
    <button
      class="wcm wcm_widget_dropmenu wgt-button"
      id="{$this->id}-control"
      data-drop-box="{$this->id}"  ><i class="fa fa-reorder" ></i> {$this->view->i18n->l('Menu','wbf.label')}</button>
  </div>

  <div class="wgt-dropdownbox" id="{$this->id}" >
    <ul>
      <li>
        <a class="wgtac_bookmark" ><i class="fa fa-bookmark" ></i> {$this->view->i18n->l('Bookmark','wbf.label')}</a>
      </li>
    </ul>
    <ul>
{$entries->support}
{$entries->report}
    </ul>
    <ul>
      <li>
        <a class="wgtac_close" ><i class="fa fa-times" ></i> {$this->view->i18n->l('Close','wbf.label')}</a>
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

    $iconFaq = $this->view->icon('control/faq.png'      ,'Faq');


    $html = <<<HTML

      <li>
        <a class="deeplink" ><i class="fa fa-question-sign" ></i> Support</a>
        <span>
          <ul>
            <li><a class="wcm wcm_req_ajax" href="modal.php?c=_Maintenance.help&amp;context=menu" ><i class="fa fa-info-circle" ></i> Help</a></li>
            <li><a class="wcm wcm_req_ajax" href="modal.php?c=Buiz.Faq.create&amp;context=menu" ><i class="fa fa-question" ></i> Faq</a></li>
          </ul>
        </span>
      </li>

HTML;

    return $html;

  }//end public function entriesSupport */

}//end class AdminBase_Maintab_Menu

