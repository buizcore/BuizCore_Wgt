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
class BuizMessage_Attachment_Modal_View extends LibViewModal
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayCreate( $params )
  {

    $this->setStatus('Upload Attachment');
    $this->setTitle('Upload Attachment');
    
    $this->addVar( 'msgId', $params->msgId );

    $this->setTemplate('buiz/message/attachment/modal/create_form', true);

  }//end public function displayCreate */
  
  /**
   * @param TFlag $params
   * @return void
   */
  public function displayEdit( $params )
  {

    $this->setStatus('Upload Attachment');
    $this->setTitle('Upload Attachment');

    $this->setTemplate('buiz/message/attachment/modal/edit_form', true);

  }//end public function displayEdit */

}//end class BuizMessage_Attachment_Modal_View

