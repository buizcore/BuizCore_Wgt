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
class BuizMessage_Checklist_Request extends Context
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
    
    parent::interpretRequest($request);
    
    $saveFields = [];
    $saveFields['checklist'][] = 'label';
    $saveFields['checklist'][] = 'flag_checked';
    $saveFields['checklist'][] = 'vid';
    $saveFields['checklist'][] = 'priority';


    try{

      // if the validation fails report
      $this->dataBody = $request->validateMultiSave(
        'BuizChecklistEntry',
        'checklist',
        $saveFields['checklist']
      );

      return null;

    } catch(InvalidInput_Exception $e) {
    
      return $e;
    }
    
  }//end public function interpretRequest */

}//end class BuizMessage_Attachment_Request */

