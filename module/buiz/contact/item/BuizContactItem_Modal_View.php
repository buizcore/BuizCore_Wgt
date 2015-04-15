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
class BuizContactItem_Modal_View extends LibViewModal
{

  /**
   * Die Breite des Modal Elements
   * @var int in px
   */
  public $width = 630 ;

  /**
   * Die Höhe des Modal Elements
   * @var int in px
   */
  public $height = 280 ;

/*////////////////////////////////////////////////////////////////////////////*/
// Display Methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * the default edit form
  * @param int $refId
  * @param string $elementId
  * @param TFlag $params
  * @return void
  */
  public function displayForm($refId, $elementId, $params = null)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Add Link';

    // set the window title
    $this->setTitle($i18nText);

    // set the from template
    $this->setTemplate('buiz/attachment/modal/form_add_link');

    $this->addVars(array(
      'refId' => $refId,
      'elementKey' => $elementId,
    ));


  }//end public function displayForm */

   /**
  * the default edit form
  * @param int $attachId
  * @param int $refId
  * @param BuizFile_Entity $fileNode
  * @param string $elementId
  * @return void
  */
  public function displayEdit($attachId, $refId, $fileNode, $elementId)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Edit Link';

    // set the window title
    $this->setTitle($i18nText);

    // set the from template
    $this->setTemplate('buiz/attachment/modal/form_edit_link');

    $this->addVars(array(
      'attachmentId' => $attachId,
      'refId' => $refId,
      'link' => $fileNode,
      'elementKey' => $elementId,
    ));

  }//end public function displayEdit */

}//end class BuizAttachment_Link_Modal_View

