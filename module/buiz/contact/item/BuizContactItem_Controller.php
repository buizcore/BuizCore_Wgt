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
class BuizContactItem_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array
  (
    'search' => array
    (
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'disconnect' => array
    (
      'method' => array('DELETE'),
      'views' => array('ajax')
    ),
    'delete' => array
    (
      'method' => array('DELETE'),
      'views' => array('ajax')
    ),
    'formuploadfiles' => array
    (
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'uploadfile' => array
    (
      'method' => array('POST'),
      'views' => array('ajax')
    ),
    'savefile' => array
    (
      'method' => array('POST'),
      'views' => array('ajax')
    ),
    'formaddlink' => array
    (
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'addlink' => array
    (
      'method' => array('POST'),
      'views' => array('ajax')
    ),
    'savelink' => array
    (
      'method' => array('PUT'),
      'views' => array('ajax')
    ),
    'edit' => array
    (
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'formaddstorage' => array
    (
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'addstorage' => array
    (
      'method' => array('POST'),
      'views' => array('ajax')
    ),
    'editstorage' => array
    (
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'savestorage' => array
    (
      'method' => array('PUT'),
      'views' => array('ajax')
    ),
    'deletestorage' => array
    (
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
  public function service_delete($request, $response)
  {

    $id = $request->param('objid', Validator::EID);
    $element = $request->param('element', Validator::CKEY);
    $refId = $request->param('ref_id', Validator::EID);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');
    $model->deleteFile($id);

    /* @var $view BuizAttachment_Ajax_View  */
    $view = $response->loadView
    (
      'upload-form',
      'BuizAttachment',
      'renderRemoveEntry'
    );

    $view->renderRemoveEntry( $refId, $element, $id);

  }//end public function service_delete */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_disconnect($request, $response)
  {

    $id = $request->param('objid', Validator::EID);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');

    $model->disconnect($id);

  }//end public function service_disconnect */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_search($request, $response)
  {

    $refId = $request->param('refid', Validator::EID);
    $element = $request->param('element', Validator::CKEY);
    $searchKey = $request->param('skey', Validator::SEARCH);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');

    $searchData = $model->getAttachmentList($refId, null, $searchKey);

    /* @var $view BuizAttachment_Ajax_View */
    $view = $response->loadView
    (
      'search-form',
      'BuizAttachment',
      'renderSearch'
    );

    $view->renderSearch( $refId, $element, $searchData);

  }//end public function service_search */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formUploadFiles($request, $response)
  {

    $refId = $request->param('refid', Validator::EID);
    $element = $request->param('element', Validator::CKEY);

    $view = $response->loadView
    (
      'upload-form',
      'BuizAttachment_File',
      'displayForm',
      View::MODAL
    );

    $view->displayForm($refId, $element);

  }//end public function service_formUploadFiles */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_uploadFile($request, $response)
  {
    // refid
    $refId = $request->param('refid', Validator::EID);
    $element = $request->param('element', Validator::CKEY);

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

    $attachNode = $model->uploadFile($refId, $file, $type, $versioning, $confidentiality, $description);
    $entryData = $model->getAttachmentList($refId, $attachNode->getId());

    $view = $response->loadView
    (
      'upload-form',
      'BuizAttachment',
      'renderAddEntry'
    );

    $view->renderAddEntry( $refId, $element, $entryData);

  }//end public function service_uploadFile */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_saveFile($request, $response)
  {
    // refid
    $attachId = $request->param('attachid', Validator::EID);
    $element = $request->param('element', Validator::CKEY);

    $file = $request->file('file');

    $objid = $request->data('objid', Validator::EID);
    $type = $request->data('type', Validator::EID);
    $versioning = $request->data('version', Validator::BOOLEAN);
    $description = $request->data('description', Validator::TEXT);
    $confidentiality = $request->data('id_confidentiality', Validator::EID);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');

    $model->saveFile($objid, $file, $type, $versioning, $confidentiality, $description);
    $entryData = $model->getAttachmentList(null, $attachId);

    $view = $response->loadView
    (
      'upload-form',
      'BuizAttachment',
      'renderUpdateEntry'
    );

    if ($entryData)
      $view->renderUpdateEntry($objid, $element, $entryData);

  }//end public function service_saveFile */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formAddLink($request, $response)
  {

    $refId = $request->param('refid', Validator::EID);
    $elementId = $request->param('element', Validator::CKEY);

    /* @var $view BuizAttachment_Link_Modal_View  */
    $view = $response->loadView
    (
      'upload-form',
      'BuizAttachment_Link',
      'displayForm',
      View::MODAL
    );

    $view->displayForm($refId, $elementId);

  }//end public function service_formAddLink */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_addLink($request, $response)
  {
    // refid
    $refId = $request->param('refid', Validator::EID);
    $element = $request->param('element', Validator::CKEY);

    $link = $request->data('link', Validator::LINK);
    $type = $request->data('id_type', Validator::EID);
    $storage = $request->data('id_storage', Validator::EID);
    $description = $request->data('description', Validator::TEXT);
    $confidentiality = $request->data('id_confidentiality', Validator::EID);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');

    $attachNode = $model->addLink($refId, $link, $type, $storage, $confidentiality, $description);
    $entryData = $model->getAttachmentList($refId, $attachNode->getId());

    $view = $response->loadView
    (
      'upload-form',
      'BuizAttachment',
      'renderAddEntry'
    );

    $view->renderAddEntry( $refId, $element, $entryData);

  }//end public function service_addLink */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_saveLink($request, $response)
  {
    // refid
    $refId = $request->param('refid', Validator::EID);
    $attachId = $request->param('attachid', Validator::EID);
    $element = $request->param('element', Validator::CKEY);

    $objid = $request->data('objid', Validator::EID);
    $link = $request->data('link', Validator::LINK);
    $type = $request->data('id_type', Validator::EID);
    $storage = $request->data('id_storage', Validator::EID);
    $description = $request->data('description', Validator::TEXT);
    $confidentiality = $request->data('id_confidentiality', Validator::EID);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');

    $model->saveLink($objid, $link, $type, $storage, $confidentiality, $description);
    $entryData = $model->getAttachmentList(null, $attachId);

    $view = $response->loadView
    (
      'upload-form',
      'BuizAttachment',
      'renderUpdateEntry'
    );

    $view->renderUpdateEntry($refId, $element, $entryData);

  }//end public function service_saveLink */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_edit($request, $response)
  {

    $objid = $request->param('objid', Validator::EID);
    $element = $request->param('element', Validator::CKEY);
    $refId = $request->param('refid', Validator::EID);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');

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

    $view->displayEdit($objid, $refId, $fileNode, $element);

  }//end public function service_edit */

/*////////////////////////////////////////////////////////////////////////////*/
// Storage
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteStorage($request, $response)
  {

    $id = $request->param('objid', Validator::EID);
    $element = $request->param('element', Validator::CKEY);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');
    $model->deleteStorage($id);

    /* @var $view BuizAttachment_Ajax_View  */
    $view = $response->loadView
    (
      'upload-form',
      'BuizAttachment',
      'renderRemoveStorageEntry'
    );

    $view->renderRemoveStorageEntry( $id, $element);

  }//end public function service_deleteStorage */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formAddStorage($request, $response)
  {

    $refId = $request->param('refid', Validator::EID);
    $elementId = $request->param('element', Validator::CKEY);

    /* @var $view BuizAttachment_Link_Modal_View  */
    $view = $response->loadView
    (
      'upload-form',
      'BuizAttachment_Storage',
      'displayForm',
      View::MODAL
    );

    $view->displayForm($refId, $elementId);

  }//end public function service_formAddStorage */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_addStorage($request, $response)
  {
    // refid
    $refId = $request->param('refid', Validator::EID);
    $element = $request->param('element', Validator::CKEY);

    $name = $request->data('name', Validator::TEXT);
    $link = $request->data('link', Validator::LINK);
    $type = $request->data('id_type', Validator::EID);
    $description = $request->data('description', Validator::TEXT);
    $confidentiality = $request->data('id_confidentiality', Validator::EID);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');

    $storageNode = $model->addStorage($refId, $name, $link, $type, $confidentiality, $description);
    $entryData = $model->getStorageList(null, $storageNode->getId());

    $view = $response->loadView
    (
      'form-add-storage',
      'BuizAttachment',
      'renderAddStorageEntry'
    );

    $view->renderAddStorageEntry( $refId, $element, $entryData);

  }//end public function service_addStorage */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_editStorage($request, $response)
  {

    $objid = $request->param('objid', Validator::EID);
    $element = $request->param('element', Validator::CKEY);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');

    $storageNode = $model->loadStorage($objid);

    $view = $response->loadView
    (
      'upload-edit-form',
      'BuizAttachment_Storage',
      'displayEdit',
      View::MODAL
    );

    $view->displayEdit($storageNode, $element);

  }//end public function service_editStorage */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_saveStorage($request, $response)
  {
    // refid
    $element = $request->param('element', Validator::CKEY);

    $objid = $request->data('objid', Validator::EID);
    $name = $request->data('name', Validator::TEXT);
    $link = $request->data('link', Validator::LINK);
    $type = $request->data('id_type', Validator::EID);
    $description = $request->data('description', Validator::TEXT);
    $confidentiality = $request->data('id_confidentiality', Validator::EID);

    /* @var $model BuizAttachment_Model */
    $model = $this->loadModel('BuizAttachment');

    $model->saveStorage($objid, $name, $link, $type, $confidentiality, $description);
    $entryData = $model->getStorageList(null, $objid);

    $view = $response->loadView
    (
      'form-save-storage',
      'BuizAttachment',
      'renderUpdateStorageEntry'
    );

    $view->renderUpdateStorageEntry($objid, $element, $entryData);

  }//end public function service_saveStorage */

} // end class BuizAttachment_Controller

