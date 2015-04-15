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
class BuizContact_Tile_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// display methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Context $params
   * @param boolean $insert
   */
  public function displayEntry( $params, $entry, $insert = true )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();

    if ($insert) {
      $pageFragment->selector = '#wgt-tiles-contact';
      $pageFragment->action = 'prepend';
    } else {
      $pageFragment->selector = '#wgt-tiles-contact-tile-';
      $pageFragment->action = 'replace';
    }

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


  }//end public function displayEntry */


  /**
   * @param int $delId
   */
  public function displayDelete($delId)
  {

    $tpl = $this->getTplEngine();

    $tpl->addJsCode( <<<JSCODE
	\$S('#wgt-tiles-contact-tile-{$delId}').remove();
JSCODE
    );

  }//end public function displayDelete */

} // end class BuizContact_Tile_Ajax_View */

