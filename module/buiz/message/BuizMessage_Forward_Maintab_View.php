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
class BuizMessage_Forward_Maintab_View extends LibViewMaintab
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayForm( $params)
  {

    $message = $this->model->getMessageNode();

    $this->setLabel('Forward: '.$message->title);
    $this->setTitle('Forward: '.$message->title);

    $this->addVar('msgNode', $message);
    $this->setTemplate('buiz/message/maintab/forward_form', true);

    $this->addMenu($params);

  }//end public function displayForm */

  /**
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($params)
  {

    $iconSend = '<i class="fa fa-envelope" ></i>';

    $menu = $this->newMenu($this->id.'_dropmenu');

    $menu->id = $this->id.'_dropmenu';

    $menu->content = <<<HTML

<div class="inline" >
  <button
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}_dropmenu-control"
    data-drop-box="{$this->id}_dropmenu"
  ><i class="fa fa-reorder" ></i> {$this->i18n->l('Menu','wbf.label')} <i class="fa fa-angle-down" ></i></button>
</div>

<div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >
  <ul>
    <li>
      <a class="deeplink" ><i class="fa fa-info-circle" ></i> {$this->i18n->l('Support', 'wbf.label')}</a>
      <span>
      <ul>
        <li><a
        	class="wcm wcm_req_ajax"
        	href="modal.php?c=Buiz.Faq.create&amp;context=menu" ><i
        		class="fa fa-question-sign" ></i> {$this->i18n->l('Faq', 'wbf.label')}</a></li>
      </ul>
      </span>
    </li>
    <li>
      <a class="wgtac_close" ><i
      	class="fa fa-times" ></i> {$this->i18n->l('Close','wbf.label')}</a>
    </li>
  </ul>
</div>

<div class="wgt-panel-control" >
  <button
  	class="wgt-button wgtac_send" ><i
  		class="fa fa-envelope" ></i> {$this->i18n->l('Send','wbf.label')}</button>
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

    self.getObject().find(".wgtac_send").click(function() {
      \$R.form('wgt-form-wbf-forward-message-form',null,{success:function() { self.close(); }});
    });


BUTTONJS;

    $this->addJsCode($code);

  }//end public function injectActions */

}//end class BuizMessage_Forward_Maintab_View

