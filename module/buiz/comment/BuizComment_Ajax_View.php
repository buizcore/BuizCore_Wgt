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
class BuizComment_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// display methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param BuizComment_Context $context
   * @param int $parent
   * @param array $entry
   */
  public function displayAdd($context, $parent, $entry)
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#wgt-comment_tree-'.$context->element.'-cnt-'.(int) $parent;
    $pageFragment->action = 'append';

    $commentElement = new WgtElementCommentTree();
    $commentElement->setId($context->element);
    $commentElement->context = $context;

    $pageFragment->setContent($commentElement->renderAjaxAddEntry($context->element, $entry));

    $tpl->setArea('comment_entry', $pageFragment);

  }//end public function displayAdd */

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param BuizComment_Context $context
   * @param string $entry
   */
  public function displayUpdate($context, $entry)
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#wgt-comment_tree-'.$context->element.'-'.$context->refId.'  .comment-'.$entry['id'];
    $pageFragment->action = 'replace';

    $commentElement = new WgtElementCommentTree();
    $commentElement->setId('wgt-comment_tree-'.$context->element);

    $pageFragment->setContent($commentElement->renderAjaxUpdateEntry($context->element, $entry));

    $tpl->setArea('comment_entry', $pageFragment);

  }//end public function displayAdd */

  /**
   * @param TFlag $params
   */
  public function displayOverlay($element, $dKey, $objid)
  {

    $item_Comment = new WgtElementCommentTree();
    $item_Comment->view = $this;
    $item_Comment->label = 'Comments';

    $item_Comment->width = 735;

    /* @var $tagModel BuizComment_Model  */
    $item_Comment->setData($this->model->getCommentTree($objid));
    $item_Comment->refId = $objid;
    $item_Comment->refMask = $dKey;
    $item_Comment->access = new TArray;

    //$item_Comment->access = $params->accessComment;
    $item_Comment->render();

    $this->setReturnData($item_Comment->render(), 'html');

  }//end public function displayOverlay */

} // end class BuizComment_Ajax_View */

