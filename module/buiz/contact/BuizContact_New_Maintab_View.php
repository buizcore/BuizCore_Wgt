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
class BuizContact_New_Maintab_View extends LibViewMaintab
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param BuizMessage_Table_Search_Request $params
   * @return void
   */
  public function displayNew($params)
  {

    $this->setLabel('Create Contact');
    $this->setTitle('Create Contact');

    $this->setTemplate('buiz/contact/tpl/form_new', true);

    $this->addMenu($params);

  }//end public function displayNew */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($params)
  {

    $menu = $this->newMenu($this->id.'_dropmenu');

    $menu->id = $this->id.'_dropmenu';

    $menu->content = <<<HTML

<div class="inline" >
  <button
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}_dropmenu-control"
    style="text-align:left;"
    data-drop-box="{$this->id}_dropmenu"  ><i class="fa fa-reorder" ></i> Menu <i class="fa fa-angle-down" ></i></button>
</div>

<div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >
  <ul>
    <li>
      <a class="wgtac_bookmark" ><i class="fa fa-bookmark" ></i> {$this->i18n->l('Bookmark', 'wbf.label')}</a>
    </li>
  </ul>
  <ul>
    <li>
      <a class="deeplink" ><i class="fa fa-info-circle" ></i> {$this->i18n->l('Support', 'wbf.label')}</a>
      <span>
      <ul>
        <li><a
        	class="wcm wcm_req_ajax"
        	href="modal.php?c=Buiz.Faq.create&amp;context=menu" ><i class="fa fa-question-sign" ></i> {$this->i18n->l('Faq', 'wbf.label')}</a></li>
      </ul>
      </span>
    </li>
    <li>
      <a class="wgtac_close" ><i class="fa fa-times" ></i> {$this->i18n->l('Close','wbf.label')}</a>
    </li>
  </ul>
</div>

<div
  id="{$this->id}-cruddrop"
  class="wcm wcm_control_split_button inline" style="margin-left:3px;"  >

  <button
    class="wcm wcm_ui_tip-top wgt-button wgtac_create  splitted"
    tabindex="-1"
      ><i class="fa fa-plus-circle" ></i> {$this->i18n->l('Create','wbf.label')}</button><button
    id="{$this->id}-cruddrop-split"
    class="wgt-button append"
    tabindex="-1"
    style="margin-left:-4px;"
    data-drop-box="{$this->id}-cruddropbox" ><i class="fa fa-angle-down" ></i></button>

</div>

<div class="wgt-dropdownbox" id="{$this->id}-cruddropbox" >

  <ul>
    <li><a
      class="wcm wgtac_search_con wcm_ui_tip-top"
      title="Search for Persons and connect with them" ><i class="fa fa-plus-circle" ></i> {$this->i18n->l('Search & Connect','wbf.label')}</a></li>
    <li>
  </ul>

  <var id="{$this->id}-cruddrop-cfg"  >{"triggerEvent":"click","align":"right"}</var>
</div>


HTML;

    $this->injectActions($menu, $params);

    // Setzen der Crumbs
    $this->crumbs->setCrumbs(
      array(
        array(
          'Dashboard',
          '',
          'fa fa-dashboard',
          null,
          'wgt-ui-desktop'
        ),
        array(
          'Colab',
          'maintab.php?c=Buiz.Colab.overview',
          'fa fa-puzzle-piece',
          null,
          'wgt_tab-buiz-colab-overview'
        ),
        array(
          'Contacts',
          'maintab.php?c=Buiz.Contact.list',
          'fa fa-group',
          'active',
          'wgt_tab-'.$this->getIdKey()
        )
      )
    );

  }//end public function addMenu */

  /**
   * just add the code for the edit ui controls
   *
   * @param int $objid die rowid des zu editierende Datensatzes
   * @param TFlag $params benamte parameter
   * {
   *   @param LibAclContainer access: der container mit den zugriffsrechten für
   *     die aktuelle maske
   *
   *   @param string formId: die html id der form zum ansprechen des update
   *     services
   * }
   */
  public function injectActions($menu, $params)
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function() {
      self.close();
    });

    self.getObject().find(".wgtac_save").click(function() {
      \$R.form('{$params->saveForm}');
    });

BUTTONJS;

    $this->addJsCode($code);

  }//end public function injectActions */

}//end class DaidalosBdlNodeProfile_Maintab_View

