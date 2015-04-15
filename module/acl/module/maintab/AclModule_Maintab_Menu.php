<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@buizcore.com>
* @date        :
* @copyright   : buizcore.com <contact@buizcore.com>
* @project     : buizcore.com
* @projectUrl  : buizcore.com
*
* @licence     : buizcore.com
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
class AclModule_Maintab_Menu extends WgtDropmenu
{

  /**
  * @var DomainNode
  */
  public $domainNode = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Menu Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * build the dropmenu for the maintab
   *
   * @param int $areaId
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu($areaId, $params)
  {

    $access = $params->access;
    $user = $this->getUser();

    // load entries
    $entries = new TArray;
    $entries->support = $this->entriesSupport($areaId, $params);

    // assemble all parts to the menu markup
    $this->content = <<<HTML

  <div class="inline" >
    <button
      class="wcm wcm_control_dropmenu wgt-button"
      data-drop-box="{$this->id}"
      id="{$this->id}-control" ><i class="fa fa-reorder" ></i> {$this->view->i18n->l('Menu','wbf.label')} <i class="fa fa-angle-down" ></i></button>
    <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"click"}</var>
  </div>

  <div class="wgt-dropdownbox" id="{$this->id}" >

    <ul>
      <li>
        <a class="wgtac_bookmark" ><i class="fa fa-bookmark"></i> {$this->view->i18n->l('Bookmark', 'wbf.label')}</a>
      </li>
    </ul>
    <ul>
{$entries->support}
    </ul>
    <ul>
      <li>
        <a class="wgtac_close" ><i class="fa fa-times" ></i> {$this->view->i18n->l('Close', 'wbf.label')}</a>
      </li>
    </ul>

  </div>

  <div class="wgt-panel-control"  >
    <button
      class="wcm wgt-button wgtac_edit wcm_ui_tip"
      title="Save Changes" ><i class="fa fa-save" ></i>  {$this->view->i18n->l('Save','wbf.label')}</button>
  </div>

  <div
    class="wgt-panel-control {$this->view->id}-project_activity-acl box-qfd_users"
    style="display:none;"
     >
    <div
      class="wcm wcm_control_buttonset wcm_ui_radio_tab wgt-button-set"
      data-tab-body="tab-box-{$this->domainNode->domainName}-acl-content"
      id="{$this->id}-boxtype" >
      <input
        type="radio"
        class="{$this->id}-boxtype"
        id="{$this->id}-boxtype-group"
        value="groups"
        name="grouping"
        checked="checked" /><label
          for="{$this->id}-boxtype-group"
          class="wcm wcm_ui_tip-top"
          tooltip="Group by group"  ><i class="fa fa-group" ></i></label>
      <input
        type="radio"
        class="{$this->id}-boxtype"
        id="{$this->id}-boxtype-user"
        wgt_src="ajax.php?c=Acl.Mgmt_Qfdu.listByUsers&dkey={$this->domainNode->domainName}"
        value="users"
        name="grouping"  /><label
          for="{$this->id}-boxtype-user"
          class="wcm wcm_ui_tip-top"
          tooltip="Group by user" ><i class="fa fa-user" ></i></label>
      <input
        type="radio"
        class="{$this->id}-boxtype"
        id="{$this->id}-boxtype-dset"
        wgt_src="ajax.php?c=Acl.Mgmt_Qfdu.listByDsets&dkey={$this->domainNode->domainName}"
        value="dsets"
        name="grouping" /><label
          for="{$this->id}-boxtype-dset"
          class="wcm wcm_ui_tip-top"
          tooltip="Group by {$this->domainNode->label}" ><i class="fa fa-file-alt" ></i></label>
    </div>
  </div>

HTML;

  }//end public function buildMenu */

  /**
   * build the support submenu part
   *
   * @param int $areaId
   * @param TArray $params named parameter / control flags
   */
  protected function entriesSupport($areaId, $params)
  {


    // assemble al parts to the html submenu
    $html = <<<HTML

  <li>
    <a class="deeplink" ><i class="fa fa-question-sign" ></i> {$this->view->i18n->l('Support','wbf.label')}</a>
    <span>
      <ul>
        <li><a
          class="wcm wcm_req_ajax"
          href="modal.php?c=Buiz.Docu.open&amp;key=project_activity-acl"
        ><i class="fa fa-info-circle" ></i> {$this->view->i18n->l('Help','wbf.label')}</a>
        </li>
      </ul>
    </span>
  </li>

HTML;

    return $html;

  }//end public function entriesSupport */

  /**
   * inject the menu logic in the maintab object.
   * the javascript will be executed after the creation of the tab in the browser
   *
   * @param ProjectActivity_Acl_Maintab $view
   * @param int $areaId
   * @param TArray $params
   */
  public function injectMenuLogic($view, $areaId, $params  )
  {

    // add the button actions for new and search in the window
    // the code will be binded direct on a window object and is removed
    // on window Close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_edit").click(function() {
      \$R.form('{$params->formId}');
      \$S('#{$this->id}-control').dropdown('close');
    });

    self.getObject().find(".wgtac_mask_entity_rights").click(function() {
      \$S('#{$this->id}-control').dropdown('remove');
      self.close();
      \$R.get('maintab.php?c=Mgmt.Acl.listing&dkey=project_activity');
    });

    self.getObject().find(".wgtac_masks_overview").click(function() {
      \$R.get('modal.php?c=Mgmt.Acl.listAllMasks&dkey=project_activity');
      \$S('#{$this->id}-control').dropdown('close');
    });


    self.getObject().find('#wgt-button-project_activity-acl-form-append').click(function() {

      if (\$S('#wgt-input-project_activity-acl-id_group').val()=='') {
        \$D.errorWindow('Error','Please select a group first');
        return false;
      }

      \$R.form('wgt-form-project_activity-acl-append');
      \$S('#wgt-form-project_activity-acl-append').get(0).reset();
      return false;

    });

    self.getObject().find(".wgtac_close").click(function() {
      \$S('#{$this->id}-control').dropdown('remove');
      self.close();
    });

BUTTONJS;

    $view->addJsCode($code);

  }//end public function injectMenuLogic */



} // end class ProjectActivity_Acl_Maintab_Menu */

