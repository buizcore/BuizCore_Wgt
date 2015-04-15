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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>

 */
class AclMgmt_Dset_Maintab_Menu extends WgtDropmenu
{

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
   * @param int $objid Die ID des Relevanten Datensatzes
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu($objid, $params)
  {

    $iconEdit = '<i class="fa fa-save" ></i>';
    $iconListMask = '<i class="fa fa-list-alt" ></i>';

    // setting the crumb menu
    $this->view->crumbs->setCrumbs(
      array(
        array(
          'Dashboard',
          'index.php',
          'fa fa-dashboard'
        ),
        array(
          'Table: '.$this->domainNode->pLabel,
          'maintab.php?c=Project.Activity.listing',
          'fa fa-list'
        ),
        array(
          $objid->text(),
          'maintab.php?c='.$this->domainNode->domainUrl.'.edit&amp;objid='.$objid,
          'fa fa-th-large'
        ),
        array(
          'ACLs: '.$objid->text(),
          'maintab.php?c=Acl.Mgmt_Dset.listing&dkey='.$this->domainNode->domainName.'&objid='.$objid,
          'fa fa-shield',
          'active'
        )
      )
    );

    $access = $params->access;
    $user = $this->getUser();

    $entries = new TArray;
    $entries->support = $this->entriesSupport($objid, $params);


    $codeButton = '';

    if ($this->domainNode->aclKey != $this->domainNode->aclBaseKey) {
      $codeButton = <<<BUTTON

  <div class="wgt-panel-control"  >
    <button
      class="wcm wcm_ui_button wgtac_mask_entity_rights" ><i class="fa fa-list-alt" ></i> {$this->view->i18n->l('Entity Rights','wbf.label')}</button>
  </div>

BUTTON;

    }


    $this->content = <<<HTML

  <div class="wgt-panel-control" >
    <button
      class="wcm wcm_control_dropmenu wgt-button"
      tabindex="-1"
      data-drop-box="{$this->id}"
      id="{$this->id}-control" ><i class="fa fa-reorder" ></i> {$this->view->i18n->l('Menu','wbf.label')} <i class="fa fa-angle-down" ></i></button>
  </div>
  <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"mouseover","closeOnLeave":"true"}</var>

  <div class="wgt-dropdownbox" id="{$this->id}" >

    <ul>
      <li>
        <a class="wgtac_bookmark" ><i class="fa fa-bookmark" ></i> {$this->view->i18n->l('Bookmark','wbf.label')}</a>
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

{$codeButton}

  <div class="wgt-panel-control"  >
    <button class="wcm wcm_ui_button wgtac_mask_list_rights" ><i class="fa fa-list-alt" ></i> {$this->view->i18n->l('List Rights','wbf.label')}</button>
  </div>

  <div class="wgt-panel-control" >
    <button class="wcm wcm_ui_button wgtac_edit" ><i class="fa fa-save" ></i> {$this->view->i18n->l('Save','wbf.label')}</button>
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
          href="modal.php?c=Buiz.Faq.create&refer={$this->domainNode->domainName}-acl-dset" ><i class="fa fa-question" ></i> Faq</a>
        </li>
      </ul>
    </span>
  </li>

HTML;

    return $html;

  }//end public function entriesSupport */

  /**
   * @param AclMgmt_Dset_Maintab_View $view
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

    self.getObject().find(".wgtac_edit").click(function() {
      \$R.form('{$params->formId}');
    });

    self.getObject().find(".wgtac_close").click(function() {
      self.close();
    });

    self.getObject().find(".wgtac_mask_entity_rights").click(function() {
      \$S('#{$this->id}-control').dropdown('remove');
      self.close();
      \$R.get('maintab.php?c=Acl.Mgmt_Dset.listing&dkey={$view->domainNode->srcName}&objid={$objid}');
    });

    self.getObject().find(".wgtac_mask_list_rights").click(function() {
      \$S('#{$this->id}-control').dropdown('remove');
      self.close();
      \$R.get('maintab.php?c=Acl.Mgmt.listing&dkey={$view->domainNode->domainName}&objid={$objid}');
    });

    self.getObject().find(".wgtac_search").click(function() {
      \$R.form('{$params->searchFormId}',null,{search:true});
    });

    self.getObject().find('#wgt-button-{$view->domainNode->aclDomainKey}-acl-form-append').click(function() {

      if (\$S('#wgt-input-{$view->domainNode->aclDomainKey}-acl-id_group').val() === '') {

        \$D.errorWindow('Error','Please select a group first');

        return false;
      }

      \$R.form('wgt-form-{$view->domainNode->aclDomainKey}-acl-append');
      \$S('#wgt-form-{$view->domainNode->aclDomainKey}-acl-append').get(0).reset();

      return false;

    });

BUTTONJS;

    $view->addJsCode($code);

  }//end public function addMenuLogic */

} // end class AclMgmt_Dset_Maintab_Menu */

