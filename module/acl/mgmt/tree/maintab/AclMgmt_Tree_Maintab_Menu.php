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
class AclMgmt_Tree_Maintab_Menu extends WgtDropmenu
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attribute
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var DomainNode
   */
  public $domainNode = null;

/*////////////////////////////////////////////////////////////////////////////*/
// build methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * add a drop menu to the create window
   *
   * @param int $objid
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu($objid, $params)
  {

    $view = $this->view;
    $iconMenu = '<i class="fa fa-reorder" ></i>';
    $iconEdit = '<i class="fa fa-save" ></i>';
    $iconClose = '<i class="fa fa-times " ></i>';

    $access = $params->access;
    $user = $this->getUser();

    $entries = new TArray;
    $entries->support = $this->entriesSupport($objid, $params);

    $this->content = <<<HTML

  <div class="inline" >
    <button
      class="wcm wcm_control_dropmenu wgt-button"
      tabindex="-1"
      id="{$this->id}-control"
      data-drop-box="{$this->id}"  ><i class="fa fa-reorder" ></i> {$view->i18n->l('Menu','wbf.label')}</button>
      <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"click"}</var>
  </div>

  <div class="wgt-dropdownbox" id="{$this->id}" >

    <ul>
      <li>
        <a class="wgtac_bookmark" ><i class="fa fa-bookmark" ></i> {$view->i18n->l('Bookmark', 'wbf.label')}</a>
      </li>
    </ul>

    <ul>
{$entries->support}
    </ul>

    <ul>
      <li>
        <a class="wgtac_close" ><i class="fa fa-times" ></i> {$this->view->i18n->l('Close','wbf.label')}</a>
      </li>
    </ul>
  </div>

HTML;

  }//end public function buildMenu */

  /**
   * @param int $objid
   * @param TArray $params
   */
  protected function entriesSupport($objid, $params)
  {


    $html = <<<HTML

  <li>
    <a class="deeplink" ><i class="fa fa-question-sign" ></i> {$this->view->i18n->l('Support','wbf.label')}</a>
    <span>
      <ul>
        <li><a
          class="wcm wcm_req_ajax"
          href="modal.php?c=Buiz.Faq.create&refer={$this->domainNode->domainName}-acl-path" ><i class="fa fa-question" ></i> Faq</a>
        </li>
      </ul>
    </span>
  </li>

HTML;

    return $html;

  }//end public function entriesSupport */

  /**
   * @param LibTemplatePresenter $view
   * @param int $objid
   * @param TArray $params
   */
  public function addMenuLogic($view, $objid, $params  )
  {

    // add the button actions for new and search in the window
    // the code will be binded direct on a window object and is removed
    // on window Close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find('#wgt-button-{$this->domainNode->domainName}-acl-form-append').click(function() {
      if (\$S('#wgt-input-{$this->domainNode->domainName}-acl-id_group').val()=='') {
        \$D.errorWindow('Error', 'Please select a group first');

        return false;
      }

      \$R.form('wgt-form-{$this->domainNode->domainName}-acl-append');
      \$S('#wgt-form-{$this->domainNode->domainName}-acl-append').get(0).reset();

      return false;

    });

    self.getObject().find(".wgtac_close").click(function() {
      \$S('#{$this->id}-control').dropdown('remove');
      self.close();
    });

BUTTONJS;

    $view->addJsCode($code);

  }//end public function addMenuLogic */

} // end class AclMgmt_Tree_Maintab_Menu */

