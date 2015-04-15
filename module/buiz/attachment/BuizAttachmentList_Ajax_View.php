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
class BuizAttachmentList_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// display methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param BuizAttachment_Request $context
   * @param Entity $attachNode
   */
  public function renderAddEntry($entry, $context)
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'div#wgt-atlist-'.$context->element.'>ul';
    $pageFragment->action = 'prepend';

    $attachmentElement = new WgtElementAttachmentList('tmp', $context);
    $attachmentElement->setId($context->element);
    $attachmentElement->preRenderUrl();

    $pageFragment->setContent($attachmentElement->renderAjaxEntry($context->element, $entry));

    $tpl->setArea('attachment', $pageFragment);


  }//end public function renderAddEntry */

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param int $objid
   * @param array $entry
   * @param BuizAttachment_Request $context
   */
  public function renderUpdateEntry($objid, $entry, $context  )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'li#wgt-'.$context->element.'-entry-'.$entry['attach_id'];
    $pageFragment->action = 'replace';

    $attachmentElement = new WgtElementAttachmentList('tmp', $context);
    $attachmentElement->setId($context->element);
    $attachmentElement->preRenderUrl();

    $pageFragment->setContent($attachmentElement->renderAjaxEntry($context->element, $entry));

    $tpl->setArea('attachment', $pageFragment);

  }//end public function renderUpdateEntry */

  /**
   * @param int $attachId
   * @param BuizAttachment_Request $context
   */
  public function renderRemoveEntry($attachId, $context)
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'li#wgt-'.$context->element.'-entry-'.$attachId;
    $pageFragment->action = 'remove';

    $tpl->setArea('attachment', $pageFragment);


  }//end public function renderRemoveEntry */

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param array $data
   * @param BuizAttachment_Request $context
   */
  public function renderSearch($data, $context)
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'div#wgt-atlist-'.$context->element.'>ul';
    $pageFragment->action = 'html';

    $attachmentElement = new WgtElementAttachmentList('tmp', $context);
    $attachmentElement->setData($data);
    $attachmentElement->preRenderUrl();

    $pageFragment->setContent($attachmentElement->renderAjaxBody($context->element, $data));

    $tpl->setArea('attachment', $pageFragment);


  }//end public function renderSearch */



} // end class BuizAttachmentList_Ajax_View */

