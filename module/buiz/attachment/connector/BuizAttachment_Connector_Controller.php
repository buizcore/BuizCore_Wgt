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
class BuizAttachment_Connector_Controller extends MvcController
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array
  (
    'create' => array(
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'addlink' => array(
      'method' => array('POST'),
      'views' => array('ajax')
    ),
    'savelink' => array(
      'method' => array('PUT'),
      'views' => array('ajax')
    ),
    'edit' => array(
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'formaddstorage' => array(
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'addstorage' => array(
      'method' => array('POST'),
      'views' => array('ajax')
    ),
    'editstorage' => array(
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'savestorage' => array(
      'method' => array('PUT'),
      'views' => array('ajax')
    ),
    'deletestorage' => array(
      'method' => array('DELETE'),
      'views' => array('ajax')
    ),
  );

/*////////////////////////////////////////////////////////////////////////////*/
// Base Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_create($request, $response)
  {

    $context = new BuizAttachment_Request($request);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');
    $model->setProperties($context);

    /*
    $model->loadAccessContainer($context);

    if (!$model->access->update) {
      throw new InvalidPermission_Exception();
    }
    */

    $view = $response->loadView(
      'form-create-attachment',
      'BuizAttachment_Connector',
      'displayCreate',
      View::MODAL
    );
    $view->setModel($model);

    $view->displayCreate($context);

  }//end public function service_create */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_edit($request, $response)
  {

    $context = new BuizAttachment_Request($request);

    $objid = $request->param('objid', Validator::EID);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');
    $model->setProperties($context);
    $model->loadAccessContainer($context);

    if (!$model->access->update) {
      throw new InvalidPermission_Exception();
    }

    $fileNode = $model->loadFile($objid);

    if ($fileNode->link) {
      $view = $response->loadView
      (
        'upload-edit-form',
        'BuizAttachment_Link',
        'displayEdit',
        View::MODAL
      );
    } else {
      $view = $response->loadView
      (
        'upload-edit-form',
        'BuizAttachment_File',
        'displayEdit',
        View::MODAL
      );
    }
    $view->setModel($model);

    $view->displayEdit($objid, $fileNode, $context);

  }//end public function service_edit */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delete($request, $response)
  {

    $context = new BuizAttachment_Request($request);

    $id = $request->param('objid', Validator::EID);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');
    $model->setProperties($context);
    $model->loadAccessContainer($context);

    if (!$model->access->update) {
      throw new InvalidPermission_Exception();
    }

    $model->deleteFile($id);

    /* @var $view BuizAttachment_Ajax_View  */
    $view = $response->loadView
    (
      'upload-form',
      'BuizAttachment',
      'renderRemoveEntry'
    );
    $view->setModel($model);

    $view->renderRemoveEntry($id, $context);

  }//end public function service_delete */


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formUploadFiles($request, $response)
  {

    $context = new BuizAttachment_Request($request);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');
    $model->setProperties($context);
    $model->loadAccessContainer($context);

    if (!$model->access->update) {
      throw new InvalidPermission_Exception();
    }

    /* @var $view BuizAttachment_File_Modal_View */
    $view = $response->loadView
    (
      'upload-form',
      'BuizAttachment_File',
      'displayForm',
      View::MODAL
    );
    $view->setModel($model);

    $view->displayForm($context);

  }//end public function service_formUploadFiles */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_uploadFile($request, $response)
  {

    $context = new BuizAttachment_Request($request);

    // refid

    $file = $request->file('file');

    if (!$file || !is_object($file)) {
      throw new InvalidRequest_Exception
      (
        Error::INVALID_REQUEST,
        Error::INVALID_REQUEST_MSG
      );
    }

    $type = $request->data('type', Validator::EID);
    $versioning = $request->data('version', Validator::BOOLEAN);
    $description = $request->data('description', Validator::TEXT);
    $confidentiality = $request->data('id_confidentiality', Validator::EID);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');
    $model->setProperties($context);
    $model->loadAccessContainer($context);

    if (!$model->access->update) {
      throw new InvalidPermission_Exception();
    }

    $attachNode = $model->uploadFile($context->refId, $file, $type, $versioning, $confidentiality, $description);
    $entryData = $model->getAttachmentList($context->refId, $attachNode->getId());

    /* @var $view BuizAttachment_Ajax_View  */
    $view = $response->loadView
    (
      'upload-form',
      'BuizAttachment',
      'renderAddEntry'
    );
    $view->setModel($model);

    $view->renderAddEntry($entryData, $context);

  }//end public function service_uploadFile */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_saveFile($request, $response)
  {

    $context = new BuizAttachment_Request($request);

    // refid
    $attachId = $request->param('attachid', Validator::EID);

    $file = $request->file('file');

    $objid = $request->data('objid', Validator::EID);
    $type = $request->data('type', Validator::EID);
    $versioning = $request->data('version', Validator::BOOLEAN);
    $description = $request->data('description', Validator::TEXT);
    $confidentiality = $request->data('id_confidentiality', Validator::EID);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');
    $model->setProperties($context);
    $model->loadAccessContainer($context);

    if (!$model->access->update) {
      throw new InvalidPermission_Exception();
    }

    $model->saveFile($objid, $file, $type, $versioning, $confidentiality, $description);
    $entryData = $model->getAttachmentList(null, $attachId);

    $view = $response->loadView
    (
      'upload-form',
      'BuizAttachment',
      'renderUpdateEntry'
    );
    $view->setModel($model);

    if ($entryData)
      $view->renderUpdateEntry($objid, $entryData, $context);

  }//end public function service_saveFile */








} // end class BuizAttachment_Connector_Controller

