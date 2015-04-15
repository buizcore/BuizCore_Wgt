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
class BuizMessage_Attachment_Request extends Context
{
/*////////////////////////////////////////////////////////////////////////////*/
// Aspects
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  public $msgId = null;
  
  /**
   * @var array
   */
  public $data = [];
  
  /**
   * @var array
   */
  public $file = null;
  
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {
    
    $this->file = $request->file('file');

    if (!$this->file || !is_object($this->file)) {
      throw new InvalidRequest_Exception(
        Error::INVALID_REQUEST,
        Error::INVALID_REQUEST_MSG
      );
    }
    
    $this->msgId = $request->data('msg', Validator::EID);

    $this->data['id_type'] = $request->data('type', Validator::EID);
    $this->data['flag_versioning'] = $request->data('version', Validator::BOOLEAN);
    $this->data['description'] = $request->data('description', Validator::TEXT);
    $this->data['id_confidentiality'] = $request->data('id_confidentiality', Validator::EID);

    $this->interpretRequestAcls($request);
    
  }//end public function interpretRequest */

}//end class BuizMessage_Attachment_Request */

