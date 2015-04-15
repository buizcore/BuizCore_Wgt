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
class BuizMessage_Show_Maintab_View extends LibViewMaintab
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayShow( $params)
  {

    $message = $this->model->getMessageNode();

    $this->setLabel('Message: '.$message->title);
    $this->setTitle('Message: '.$message->title);

    $this->addVar('msgNode', $message);
    $this->addVar('refs', $this->model->loadMessageReferences($message->msg_id));
    $this->addVar('attachments', $this->model->loadMessageAttachments($message->msg_id));
    $this->addVar('checklist', $this->model->loadMessageChecklist($message->msg_id));
    $this->setTemplate('buiz/message/maintab/show_page', true);

    $this->addMenu($params,$message);

  }//end public function displayShow */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($params,$message)
  {

    $menu = $this->newMenu($this->id.'_dropmenu');

    $menu->id = $this->id.'_dropmenu';

    $menu->content = <<<HTML

<div class="inline" >
  <button
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}_dropmenu-control"
    data-drop-box="{$this->id}_dropmenu"  ><i class="fa fa-reorder" ></i> {$this->i18n->l('Menu','wbf.label')}</button>
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

<div class="wgt-panel-control" >
  <button
  	class="wgt-button wgtac_forward" ><i class="fa fa-share-alt" ></i> {$this->i18n->l('Forward','wbf.label')}</button>
</div>

<div class="wgt-panel-control" >
  <button
  	class="wgt-button wgtac_reply" ><i class="fa fa-reply" ></i> {$this->i18n->l('Reply','wbf.label')}</button>
</div>

<div class="wgt-panel-control" >
  <button
  	class="wgt-button wgtac_save save_first"
  	id="wgt-btn-show-msg-save-{$message->msg_id}" ><i class="fa fa-save" ></i> {$this->i18n->l('Save','wbf.label')}</button>
</div>

HTML;

    $this->injectActions($menu, $params);

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

    $message = $this->model->getMessageNode();

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    // close tab
    self.getObject().find(".wgtac_close").click(function() {
      \$S('#{$this->id}_dropmenu-control').dropdown('remove');
      self.close();
    });

    self.getObject().find(".wgtac_forward").click(function() {
      \$R.get('maintab.php?c=Buiz.Message.formForward&objid={$message->msg_id}',{success:function() { self.close(); }});
    });

    self.getObject().find(".wgtac_reply").click(function() {
      \$R.get('maintab.php?c=Buiz.Message.formReply&objid={$message->msg_id}',{success:function() { self.close(); }});
    });

   self.getObject().find(".wgtac_save").click(function() {
      \$R.form('wgt-form-msg-show-save-{$message->msg_id}');
   });

BUTTONJS;

    $this->addJsCode($code);

  }//end public function injectActions */

}//end class BuizMessage_Show_Maintab_View

