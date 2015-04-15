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
class BuizAttachment_Storage_Modal_View extends LibViewModal
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
  * @param BuizAttachment_Request $context
  * @return void
  */
  public function displayForm($context)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Add Storage';

    // set the window title
    $this->setTitle($i18nText);

    // set the from template
    $this->setTemplate('buiz/attachment/modal/form_add_storage', true);

    $this->addVars(array(
      'elementKey' => $context->element,
      'refMask' => $context->refMask,
      'preUrl' => $context->toUrlExt(),
    ));

  }//end public function displayForm */

 /**
  * the default edit form
  * @param BuizFileStorage_Entity $fileNode
  * @param BuizAttachment_Request $context
  * @return void
  */
  public function displayEdit($storageNode, $context)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Edit Storage';

    // set the window title
    $this->setTitle($i18nText);

    // set the from template
    $this->setTemplate('buiz/attachment/modal/form_edit_storage', true);

    $this->addVars(array(
      'storage' => $storageNode,
      'elementKey' => $context->element,
      'refMask' => $context->refMask,
      'preUrl' => $context->toUrlExt(),
    ));

  }//end public function displayEdit */

}//end class BuizAttachment_Storage_Modal_View

