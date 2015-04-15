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
class BuizMessage_Attachment_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// display methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Context $params
   */
  public function displayInsert( $params )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#wgt-list-show-msg-attach-'.$params->msgId;
    $pageFragment->action = 'prepend';
    
    $encName = base64_encode($this->model->file->name);

    $pageFragment->setContent(<<<HTML
  <li id="wgt-entry-msg-attach-{$this->model->attachment->getId()}" ><a 
      target="attach"
      href="file.php?f=buiz_file-name-{$this->model->file->getId()}&n={$encName}" 
      >{$this->model->file->name}</a><a 
      class="wcm wcm_req_del" 
      title="Please confirm you want to delete this Attachment"
      href="ajax.php?c=Buiz.Message_Attachment.delete&delid={$this->model->attachment->getId()}"  ><i class="fa fa-times" ></i></a></li>
HTML
    );

    $tpl->setArea('attachment', $pageFragment);


  }//end public function displayInsert */
  
  /**
   * @param Context $params
   */
  public function displayUpdate($params)
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'wgt-entry-msg-attach-'.$this->model->attachment->getId();
    $pageFragment->action = 'replace';
    
    $encName = base64_encode($this->model->file->name);

    $pageFragment->setContent(<<<HTML
  <li id="wgt-entry-msg-attach-{$this->model->attachment->getId()}" ><a 
      target="attach"
      href="file.php?f=buiz_file-name-{$this->model->file->getId()}&n={$encName}" 
      >{$this->model->file->name}</a><a 
      class="wcm wcm_req_del" 
      title="Please confirm you want to delete this Attachment"
      href="ajax.php?c=Buiz.Message_Attachment.delete&delid={$this->model->attachment->getId()}"  ><i class="fa fa-times" ></i></a></li>
HTML
    );

    $tpl->setArea('attachment', $pageFragment);

  }//end public function displayUpdate */
  
  /**
   * @param int $delId
   */
  public function displayDelete($delId)
  {

    $tpl = $this->getTplEngine();
    
    $tpl->addJsCode( <<<JSCODE
	\$S('#wgt-entry-msg-attach-{$delId}').remove();
JSCODE
    );
 
  }//end public function displayDelete */

} // end class BuizMessage_Attachment_Ajax_View */

