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
class BuizMessage_Checklist_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array(

    // message logic
    'save' => array(
      'method' => array('PUT'),
      'views' => array('ajax')
    ),
    'delete' => array(
      'method' => array('DELETE'),
      'views' => array('ajax')
    ),

  );

/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/


 /**
  * Form zum erstellen einer neuen Message
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_save($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = new BuizMessage_Checklist_Request($request);

    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }
    
    $params->msgId = $request->param('msg',Validator::EID);
    
    if( !$params->msgId ) {
      throw new InvalidRequest_Exception('Missing the request id');
    }

    /* @var $view BuizMessage_Checklist_Ajax_View */
    $view = $response->loadView(
      'form-messages-checklist-save',
      'BuizMessage_Checklist',
      'displaySave'
    );

    // request bearbeiten
    /* @var $model BuizMessage_Checklist_Model */
    $checklistModel = $this->loadModel('BuizMessage_Checklist');
    $view->setModel($checklistModel);
    
    $newIds = $checklistModel->save($params);
    
    $entries = $checklistModel->loadChecklistEntries(array_keys($newIds));

    $view->displaySave($params->msgId,$newIds,$entries,$params);

  }//end public function service_save */
  
  
 /**
  * Form zum erstellen einer neuen Message
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_delete($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = $this->getFlags($request);

    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }
    
    $params->delId = $request->param('delid',Validator::EID);
    
    if( !$params->delId ) {
      throw new InvalidRequest_Exception('Missing the request id');
    }

    // request bearbeiten
    /* @var $model BuizMessage_Checklist_Model */
    $checklistModel = $this->loadModel('BuizMessage_Checklist');

    $checklistModel->delete( $params->delId, $params );


  }//end public function service_insert */
  
} // end class BuizMessage_Attachment_Controller
