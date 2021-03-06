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
class BuizMessage_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// display methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $elementId
   */
  public function displayOpen($elementId)
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#'.$elementId;
    $pageFragment->action = 'replace';

    $msgElement = new WgtElementMessageList();
    $msgElement->setId($elementId);

    $messagesRes = $this->model->loadMessages();

    $pageFragment->setContent($msgElement->renderFull($messagesRes));

    $tpl->setArea('message_list', $pageFragment);

  }//end public function displayOpen */
  
  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $elementId
   */
  public function displayMsgPreview( $msgNode )
  {
  
    $tpl = $this->getTplEngine();
  
    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#wgt-message-list-show_messagebox';
    $pageFragment->action = 'html';
  
    $pageFragment->addVar( 'message', $msgNode );
    $pageFragment->setTemplate('buiz/message/maintab/list_msgbox',true);
    $pageFragment->render();

    $tpl->setArea('message_list', $pageFragment);
  
  }//end public function displayMsgPreview */  


  /**
   * Autocomplete für User
   *
   * @param string $key
   * @param TArray $params
   */
  public function displayUserAutocomplete($key, $params)
  {

    $view = $this->getTpl();
    $view->setRawJsonData($this->model->getUserListByKey($key, $params));

  }//end public function displayUserAutocomplete */
  
  
  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $elementId
   */
  public function displayAddRef($refId, $msgId)
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#wgt-list-show-msg-ref-'.$msgId;
    $pageFragment->action = 'append';

    $msgRef = $this->model->loadRefById($refId);

    $pageFragment->setContent(<<<HTML
  <li><a 
    class="wcm wcm_req_ajax" 
    href="maintab.php?c={$msgRef['edit_link']}&objid={$msgRef['vid']}" 
    >{$msgRef['name']}:{$msgRef['title']}</a></li>
HTML

);

    $tpl->setArea('new_ref', $pageFragment);

  }//end public function displayAddRef */
  
  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param int $linkId
   */
  public function displayDelRef($linkId)
  {

    $tpl = $this->getTplEngine();
    $tpl->addJsCode("\$S('li#wgt-entry-msg-ref-".$linkId."').remove();");

  }//end public function displayDelRef */

} // end class BuizMessage_Ajax_View */

