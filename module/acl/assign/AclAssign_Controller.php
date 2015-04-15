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
 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 * @copyright Buiz Developer Network <contact@buiz.net>
 */
class AclAssign_Controller extends MvcController
{
/* //////////////////////////////////////////////////////////////////////////// */
// Attributes
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     *
     * @var array
     */
    protected $options = array(
        'search' => array(
            'method' => array(
                'GET'
            ),
            'views' => array(
                'ajax'
            )
        ),
        'disconnect' => array(
            'method' => array(
                'DELETE'
            ),
            'views' => array(
                'ajax'
            )
        ),
        'delete' => array(
            'method' => array(
                'DELETE'
            ),
            'views' => array(
                'ajax'
            )
        ),
        'formuploadfiles' => array(
            'method' => array(
                'GET'
            ),
            'views' => array(
                'modal'
            )
        ),
        'uploadfile' => array(
            'method' => array(
                'POST'
            ),
            'views' => array(
                'ajax'
            )
        ),
        'savefile' => array(
            'method' => array(
                'POST'
            ),
            'views' => array(
                'ajax'
            )
        ),
        'formaddlink' => array(
            'method' => array(
                'GET'
            ),
            'views' => array(
                'modal'
            )
        ),
        'addlink' => array(
            'method' => array(
                'POST'
            ),
            'views' => array(
                'ajax'
            )
        ),
        'savelink' => array(
            'method' => array(
                'PUT'
            ),
            'views' => array(
                'ajax'
            )
        ),
        'edit' => array(
            'method' => array(
                'GET'
            ),
            'views' => array(
                'modal'
            )
        ),
        'formaddstorage' => array(
            'method' => array(
                'GET'
            ),
            'views' => array(
                'modal'
            )
        ),
        'addstorage' => array(
            'method' => array(
                'POST'
            ),
            'views' => array(
                'ajax'
            )
        ),
        'editstorage' => array(
            'method' => array(
                'GET'
            ),
            'views' => array(
                'modal'
            )
        ),
        'savestorage' => array(
            'method' => array(
                'PUT'
            ),
            'views' => array(
                'ajax'
            )
        ),
        'deletestorage' => array(
            'method' => array(
                'DELETE'
            ),
            'views' => array(
                'ajax'
            )
        )
    );
    
/* //////////////////////////////////////////////////////////////////////////// */
// Base Methodes
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     *
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
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        $model->deleteFile($id);
        
        /* @var $view BuizAttachment_Ajax_View  */
        $view = $response->loadView('upload-form', 'BuizAttachment', 'renderRemoveEntry');
        $view->setModel($model);
        
        $view->renderRemoveEntry($id, $context);
    
    } // end public function service_delete */

    /**
     *
     * @param LibRequestHttp $request            
     * @param LibResponseHttp $response            
     * @return void
     */
    public function service_disconnect($request, $response)
    {

        $context = new BuizAttachment_Request($request);
        
        $id = $request->param('objid', Validator::EID);
        
        /* @var $model BuizAttachment_Model */
        $model = $this->loadModel('BuizAttachment');
        $model->setProperties($context);
        $model->loadAccessContainer($context);
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        $model->disconnect($id);
    
    } // end public function service_disconnect */

    /**
     *
     * @param LibRequestHttp $request            
     * @param LibResponseHttp $response            
     * @return void
     */
    public function service_search($request, $response)
    {

        $context = new BuizAttachment_Request($request);
        
        $searchKey = $request->param('skey', Validator::SEARCH);
        
        /* @var $model BuizAttachment_Model */
        $model = $this->loadModel('BuizAttachment');
        $model->setProperties($context);
        $model->loadAccessContainer($context);
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        $searchData = $model->getAttachmentList($context->refId, null, $searchKey);
        
        /* @var $view BuizAttachment_Ajax_View */
        $view = $response->loadView('search-form', 'BuizAttachment', 'renderSearch');
        $view->setModel($model);
        
        $view->renderSearch($searchData, $context);
    
    } // end public function service_search */

    /**
     *
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
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        /* @var $view BuizAttachment_File_Modal_View */
        $view = $response->loadView('upload-form', 'BuizAttachment_File', 'displayForm', View::MODAL);
        $view->setModel($model);
        
        $view->displayForm($context);
    
    } // end public function service_formUploadFiles */

    /**
     *
     * @param LibRequestHttp $request            
     * @param LibResponseHttp $response            
     * @return void
     */
    public function service_uploadFile($request, $response)
    {

        $context = new BuizAttachment_Request($request);
        
        // refid
        
        $file = $request->file('file');
        
        if (! $file || ! is_object($file)) {
            throw new InvalidRequest_Exception(Error::INVALID_REQUEST, Error::INVALID_REQUEST_MSG);
        }
        
        $type = $request->data('type', Validator::EID);
        $versioning = $request->data('version', Validator::BOOLEAN);
        $description = $request->data('description', Validator::TEXT);
        $confidentiality = $request->data('id_confidentiality', Validator::EID);
        
        /* @var $model BuizAttachment_Model */
        $model = $this->loadModel('BuizAttachment');
        $model->setProperties($context);
        $model->loadAccessContainer($context);
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        $attachNode = $model->uploadFile($context->refId, $file, $type, $versioning, $confidentiality, $description);
        $entryData = $model->getAttachmentList($context->refId, $attachNode->getId());
        
        /* @var $view BuizAttachment_Ajax_View  */
        $view = $response->loadView('upload-form', 'BuizAttachment', 'renderAddEntry');
        $view->setModel($model);
        
        $view->renderAddEntry($entryData, $context);
    
    } // end public function service_uploadFile */

    /**
     *
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
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        $model->saveFile($objid, $file, $type, $versioning, $confidentiality, $description);
        $entryData = $model->getAttachmentList(null, $attachId);
        
        $view = $response->loadView('upload-form', 'BuizAttachment', 'renderUpdateEntry');
        $view->setModel($model);
        
        if ($entryData)
            $view->renderUpdateEntry($objid, $entryData, $context);
    
    } // end public function service_saveFile */

    /**
     *
     * @param LibRequestHttp $request            
     * @param LibResponseHttp $response            
     * @return void
     */
    public function service_formAddLink($request, $response)
    {

        $context = new BuizAttachment_Request($request);
        
        /* @var $model BuizAttachment_Model */
        $model = $this->loadModel('BuizAttachment');
        $model->setProperties($context);
        $model->loadAccessContainer($context);
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        /* @var $view BuizAttachment_Link_Modal_View  */
        $view = $response->loadView('upload-form', 'BuizAttachment_Link', 'displayForm', View::MODAL);
        $view->setModel($model);
        
        $view->displayForm($context);
    
    } // end public function service_formAddLink */

    /**
     *
     * @param LibRequestHttp $request            
     * @param LibResponseHttp $response            
     * @return void
     */
    public function service_addLink($request, $response)
    {

        $context = new BuizAttachment_Request($request);
        
        $link = $request->data('link', Validator::LINK);
        $type = $request->data('id_type', Validator::EID);
        $storage = $request->data('id_storage', Validator::EID);
        $description = $request->data('description', Validator::TEXT);
        $confidentiality = $request->data('id_confidentiality', Validator::EID);
        
        /* @var $model BuizAttachment_Model */
        $model = $this->loadModel('BuizAttachment');
        $model->setProperties($context);
        $model->loadAccessContainer($context);
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        $attachNode = $model->addLink($context->refId, $link, $type, $storage, $confidentiality, $description);
        $entryData = $model->getAttachmentList($context->refId, $attachNode->getId());
        
        $view = $response->loadView('upload-form', 'BuizAttachment', 'renderAddEntry');
        $view->setModel($model);
        
        $view->renderAddEntry($entryData, $context);
    
    } // end public function service_addLink */

    /**
     *
     * @param LibRequestHttp $request            
     * @param LibResponseHttp $response            
     * @return void
     */
    public function service_saveLink($request, $response)
    {

        $context = new BuizAttachment_Request($request);
        
        // refid
        $attachId = $request->param('attachid', Validator::EID);
        
        $objid = $request->data('objid', Validator::EID);
        $link = $request->data('link', Validator::LINK);
        $type = $request->data('id_type', Validator::EID);
        $storage = $request->data('id_storage', Validator::EID);
        $description = $request->data('description', Validator::TEXT);
        $confidentiality = $request->data('id_confidentiality', Validator::EID);
        
        /* @var $model BuizAttachment_Model */
        $model = $this->loadModel('BuizAttachment');
        $model->setProperties($context);
        $model->loadAccessContainer($context);
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        $model->saveLink($objid, $link, $type, $storage, $confidentiality, $description);
        $entryData = $model->getAttachmentList(null, $attachId);
        
        $view = $response->loadView('upload-form', 'BuizAttachment', 'renderUpdateEntry');
        $view->setModel($model);
        
        $view->renderUpdateEntry($objid, $entryData, $context);
    
    } // end public function service_saveLink */

    /**
     *
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
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        $fileNode = $model->loadFile($objid);
        
        if ($fileNode->link) {
            $view = $response->loadView('upload-edit-form', 'BuizAttachment_Link', 'displayEdit', View::MODAL);
        } else {
            $view = $response->loadView('upload-edit-form', 'BuizAttachment_File', 'displayEdit', View::MODAL);
        }
        $view->setModel($model);
        
        $view->displayEdit($objid, $fileNode, $context);
    
    } // end public function service_edit */
    
    /* //////////////////////////////////////////////////////////////////////////// */
    // Storage
    /* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     *
     * @param LibRequestHttp $request            
     * @param LibResponseHttp $response            
     * @return void
     */
    public function service_deleteStorage($request, $response)
    {

        $context = new BuizAttachment_Request($request);
        
        $id = $request->param('objid', Validator::EID);
        
        /* @var $model BuizAttachment_Model */
        $model = $this->loadModel('BuizAttachment');
        $model->setProperties($context);
        $model->loadAccessContainer($context);
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        $model->deleteStorage($id);
        
        /* @var $view BuizAttachment_Ajax_View  */
        $view = $response->loadView('upload-form', 'BuizAttachment', 'renderRemoveStorageEntry');
        $view->setModel($model);
        
        $view->renderRemoveStorageEntry($id, $context);
    
    } // end public function service_deleteStorage */

    /**
     *
     * @param LibRequestHttp $request            
     * @param LibResponseHttp $response            
     * @return void
     */
    public function service_formAddStorage($request, $response)
    {

        $context = new BuizAttachment_Request($request);
        
        /* @var $model BuizAttachment_Model */
        $model = $this->loadModel('BuizAttachment');
        $model->setProperties($context);
        $model->loadAccessContainer($context);
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        /* @var $view BuizAttachment_Link_Modal_View  */
        $view = $response->loadView('upload-form', 'BuizAttachment_Storage', 'displayForm', View::MODAL);
        $view->setModel($model);
        
        $view->displayForm($context);
    
    } // end public function service_formAddStorage */

    /**
     *
     * @param LibRequestHttp $request            
     * @param LibResponseHttp $response            
     * @return void
     */
    public function service_addStorage($request, $response)
    {

        $context = new BuizAttachment_Request($request);
        
        $name = $request->data('name', Validator::TEXT);
        $link = $request->data('link', Validator::LINK);
        $type = $request->data('id_type', Validator::EID);
        $description = $request->data('description', Validator::TEXT);
        $confidentiality = $request->data('id_confidentiality', Validator::EID);
        
        /* @var $model BuizAttachment_Model */
        $model = $this->loadModel('BuizAttachment');
        $model->setProperties($context);
        $model->loadAccessContainer($context);
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        $storageNode = $model->addStorage($context->refId, $name, $link, $type, $confidentiality, $description);
        $entryData = $model->getStorageList(null, $storageNode->getId());
        
        $view = $response->loadView('form-add-storage', 'BuizAttachment', 'renderAddStorageEntry');
        $view->setModel($model);
        
        $view->renderAddStorageEntry($entryData, $context);
    
    } // end public function service_addStorage */

    /**
     *
     * @param LibRequestHttp $request            
     * @param LibResponseHttp $response            
     * @return void
     */
    public function service_editStorage($request, $response)
    {

        $context = new BuizAttachment_Request($request);
        
        $objid = $request->param('objid', Validator::EID);
        
        /* @var $model BuizAttachment_Model */
        $model = $this->loadModel('BuizAttachment');
        $model->setProperties($context);
        $model->loadAccessContainer($context);
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        $storageNode = $model->loadStorage($objid);
        
        $view = $response->loadView('upload-edit-form', 'BuizAttachment_Storage', 'displayEdit', View::MODAL);
        $view->setModel($model);
        
        $view->displayEdit($storageNode, $context);
    
    } // end public function service_editStorage */

    /**
     *
     * @param LibRequestHttp $request            
     * @param LibResponseHttp $response            
     * @return void
     */
    public function service_saveStorage($request, $response)
    {

        $context = new BuizAttachment_Request($request);
        
        $objid = $request->data('objid', Validator::EID);
        $name = $request->data('name', Validator::TEXT);
        $link = $request->data('link', Validator::LINK);
        $type = $request->data('id_type', Validator::EID);
        $description = $request->data('description', Validator::TEXT);
        $confidentiality = $request->data('id_confidentiality', Validator::EID);
        
        /* @var $model BuizAttachment_Model */
        $model = $this->loadModel('BuizAttachment');
        $model->setProperties($context);
        $model->loadAccessContainer($context);
        
        if (! $model->access->update) {
            throw new InvalidPermission_Exception();
        }
        
        $model->saveStorage($objid, $name, $link, $type, $confidentiality, $description);
        $entryData = $model->getStorageList(null, $objid);
        
        $view = $response->loadView('form-save-storage', 'BuizAttachment', 'renderUpdateStorageEntry');
        $view->setModel($model);
        
        $view->renderUpdateStorageEntry($objid, $entryData, $context);
    
    } // end public function service_saveStorage */

} // end class BuizAttachment_Controller

