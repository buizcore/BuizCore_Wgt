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
class BuizMessage_Attachment_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array(

    // message logic
    'formnew' => array(
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'formedit' => array(
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'insert' => array(
      'method' => array('POST'),
      'views' => array('ajax')
    ),
    'update' => array(
      'method' => array('POST'),
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
  public function service_formNew($request, $response)
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
    
    $params->msgId = $request->param('msg',Validator::EID);
    
    if( !$params->msgId ) {
      throw new InvalidRequest_Exception('Missing the request id');
    }

    /* @var $view BuizMessage_Attachment_Modal_View */
    $view = $response->loadView(
      'form-messages-attachment-new',
      'BuizMessage_Attachment',
      'displayCreate'
    );
    

    // request bearbeiten
    /* @var $model BuizMessage_Model */
    $model = $this->loadModel('BuizMessage');
    $view->setModel($model);

    $view->displayCreate($params);

  }//end public function service_formNew */
  
 /**
  * Form zum erstellen einer neuen Message
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_insert($request, $response)
  {

    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = new BuizMessage_Attachment_Request($request);

    $model = $this->loadModel('BuizMessage');
    $model->loadTableAccess($params);

    if (!$model->access->listing) {
      throw new InvalidRequest_Exception(
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }

    /* @var $view BuizMessage_Attachment_Modal_View */
    $view = $response->loadView(
      'form-messages-attachment-insert',
      'BuizMessage_Attachment',
      'displayInsert'
    );

    // request bearbeiten
    /* @var $model BuizMessage_Attachment_Model */
    $attachModel = $this->loadModel('BuizMessage_Attachment');
    $view->setModel($attachModel);
    
    $attachModel->insert( $params );

    $view->displayInsert($params);

  }//end public function service_insert */
  
  
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

    /* @var $view BuizMessage_Attachment_Ajax_View */
    $view = $response->loadView(
      'form-messages-attachment-delete',
      'BuizMessage_Attachment',
      'displayDelete'
    );

    // request bearbeiten
    /* @var $model BuizMessage_Attachment_Model */
    $attachModel = $this->loadModel('BuizMessage_Attachment');
    $view->setModel($attachModel);
    
    $attachModel->delete( $params->delId, $params );

    $view->displayDelete( $params->delId );

  }//end public function service_insert */
  
} // end class BuizMessage_Attachment_Controller
