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
class BuizAttachment_Connector_Modal_View extends LibViewModal
{

  /**
   * Die Breite des Modal Elements
   * @var int in px
   */
  public $width = 600 ;

  /**
   * Die Höhe des Modal Elements
   * @var int in px
   */
  public $height = 300 ;

/*////////////////////////////////////////////////////////////////////////////*/
// Display Methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * the default edit form
  * @param BuizAttachment_Request $context
  * @return void
  */
  public function displayCreate($context)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Attachment';

    // set the window title
    $this->setTitle($i18nText);

    // set the from template
    $this->setTemplate('buiz/attachment/connector/modal/form_new', true);

    $this->addVars(array(
      'refId' => $context->refId,
      'elementKey' => $context->element,
      'refMask' => $context->refMask,
      'preUrl' => $context->toUrlExt(),
    ));

  }//end public function displayCreate */

}//end class BuizAttachment_Connector_Modal_View

