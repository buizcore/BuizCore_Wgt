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
class BuizAttachment_Link_Modal_View extends LibViewModal
{

  /**
   * Die Breite des Modal Elements
   * @var int in px
   */
  public $width = 690 ;

  /**
   * Die Höhe des Modal Elements
   * @var int in px
   */
  public $height = 450 ;

/*////////////////////////////////////////////////////////////////////////////*/
// Display Methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * the default edit form
  * @param $context
  * @return void
  */
  public function displayForm($context)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Add Link';

    // set the window title
    $this->setTitle($i18nText);

    // set the from template
    $this->setTemplate('buiz/attachment/modal/form_add_link', true);

    if ($context->maskFilter) {
       $this->addVar('typeFilter', $context->maskFilter);
       $this->addVar('paramTypeFilter', '&amp;mask_filter='.$context->maskFilter);
    } elseif ($context->typeFilter) {
      $this->addVar('typeFilter', $context->typeFilter);
      $this->addVar('paramTypeFilter', '&amp;type_filter[]='.implode('&amp;type_filter[]=', $context->typeFilter)  );
    }

    $this->addVars(array(
      'refId' => $context->refId,
      'elementKey' => $context->element,
      'refMask' => $context->refMask,
      'preUrl' => $context->toUrlExt(),
    ));

  }//end public function displayForm */

   /**
  * the default edit form
  * @param int $attachId
  * @param BuizFile_Entity $fileNode
  * @param BuizAttachment_Request $context
  * @return void
  */
  public function displayEdit($attachId, $fileNode, $context)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Edit Link';

    // set the window title
    $this->setTitle($i18nText);

    // set the from template
    $this->setTemplate('buiz/attachment/modal/form_edit_link', true);

    if ($context->maskFilter) {
       $this->addVar('typeFilter', $context->maskFilter);
    } elseif ($context->typeFilter) {
      $this->addVar('typeFilter', $context->typeFilter);
    }

    $this->addVars(array(
      'attachmentId' => $attachId,
      'refId' => $context->refId,
      'link' => $fileNode,
      'elementKey' => $context->element,
      'refMask' => $context->refMask,
      'preUrl' => $context->toUrlExt(),
    ));

  }//end public function displayEdit */

}//end class BuizAttachment_Link_Modal_View

