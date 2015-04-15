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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>

 */
class AclMgmt_Backpath_Controller extends MvcController_Domain
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Mit den Options wird der zugriff auf die Service Methoden konfiguriert
   *
   * method: Der Service kann nur mit den im Array vorhandenen HTTP Methoden
   *   aufgerufen werden. Wenn eine falsche Methode verwendet wird, gibt das
   *   System automatisch eine "Method not Allowed" Fehlermeldung zurück
   *
   * views: Die Viewtypen die erlaubt sind. Wenn mit einem nicht definierten
   *   Viewtype auf einen Service zugegriffen wird, gibt das System automatisch
   *  eine "Invalid Request" Fehlerseite mit einer Detailierten Meldung, und der
   *  Information welche Services Viewtypen valide sind, zurück
   *
   * public: boolean wert, ob der Service auch ohne Login aufgerufen werden darf
   *   wenn nicht vorhanden ist die Seite per default nur mit Login zu erreichen
   *
   * @var array
   */
  protected $options = array(

    'opentab' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'search' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'autoarea' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'autogroups' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'autoreffield' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),
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
// Group By Group Logik
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_openTab($request, $response)
  {

    // load request parameters an interpret as flags
    $params = $this->getTabFlags($request);
    $domainNode = $this->getDomainNode($request);

    /* @var $model AclMgmt_Backpath_Model */
    $model = $this->loadModel('AclMgmt_Backpath');
    $model->domainNode = $domainNode;
    $model->checkAccess($domainNode, $params);

    // target for some ui element
    $areaId = $model->getAreaId();

    // create a new area with the id of the target element, this area will replace
    // the HTML Node of the target UI Element
    /* @var $view AclMgmt_Backpath_Area_View  */
    $view = $response->loadView(
      $params->tabId,
      'AclMgmt_Backpath',
      'displayTab',
      View::AREA
    );
    $view->domainNode = $domainNode;

    $view->setPosition('#'.$params->tabId);
    $view->setModel($model);

    $view->displayTab($areaId, $params);

  }//end public function service_tabUsers */

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_search($request, $response)
  {

    // load the flow flags
    $params = new ContextListing($request);
    $domainNode = $this->getDomainNode($request);

    // load the default model
    /* @var $model AclMgmt_Backpath_Model */
    $model = $this->loadModel('AclMgmt_Backpath');
    $model->domainNode = $domainNode;
    $model->checkAccess($domainNode, $params);

    $areaId = $model->getAreaId();

    // this can only be an ajax request, so we can directly load the ajax view
    /* @var $view AclMgmt_Backpath_Ajax_View */
    $view = $response->loadView(
      $domainNode->domainName.'-mgmt-acl',
      'AclMgmt_Backpath',
      'displaySearch'
    );

    $view->domainNode = $domainNode;

    $view->setModel($model);
    $view->displaySearch($areaId, $params);

  }//end public function service_searchUsers */

/*////////////////////////////////////////////////////////////////////////////*/
// CRUD Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_edit($request, $response)
  {
  
    // load request parameters an interpret as flags
    $params = new ContextDomainCrud($request);
    $domainNode = $this->getDomainNode($request);
  
    $pathId = $request->param('objid',Validator::EID);
  
    /* @var $model AclMgmt_Backpath_Model */
    $model = $this->loadModel('AclMgmt_Backpath');
    $model->domainNode = $domainNode;
    $model->checkAccess($domainNode, $params);
    
    $model->getEntityBuizSecurityBackpath($pathId);
    
    $areaId = $model->getAreaId();
    
    /* @var $view AclMgmt_Backpath_Ajax_View */
    $view = $response->loadView(
      $domainNode->domainName.'-backpath',
      'AclMgmt_Backpath',
      'displayEditForm',
      View::AREA
    );
    $view->setModel($model);
    $view->domainNode = $domainNode;
    
    $view->setPosition('#wgt-box-'.$domainNode->aclDomainKey.'-backpath_crudform');
  
    $view->displayEditForm($areaId,$params);
  
  }//end public function service_edit */

  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_save($request, $response)
  {

    // load request parameters an interpret as flags
    $params = new ContextDomainCrud($request);
    $domainNode = $this->getDomainNode($request);
    
    $pathId = $request->data('objid',Validator::EID);

    /* @var $model AclMgmt_Backpath_Model */
    $model = $this->loadModel('AclMgmt_Backpath');
    $model->domainNode = $domainNode;
    $model->checkAccess($domainNode, $params);

    $view = $response->loadView(
      $domainNode->domainName.'-backpath',
      'AclMgmt_Backpath'
    );
    $view->setModel($model);
    $view->domainNode = $domainNode;


    if ($pathId) {
      
      // fetch the data from the http request and load it in the model registry
      // if fails stop here
      /* @throws InvalidRequest_Exception */
      $model->fetchUpdateData($pathId, $params);
      
      $model->update($params);
      $pathEntity = $model->getEntityBuizSecurityBackpath();
      $view->displayUpdate($pathEntity, $params);
      
    } else {
      
      // fetch the data from the http request and load it in the model registry
      // if fails stop here
      /* @throws InvalidRequest_Exception */
      $model->fetchInsertData($params);
      
      // prüfen ob die zuweisung unique ist
      ///TODO hier muss noch ein trigger in die datenbank um raceconditions zu vermeiden
      if (!$model->checkUnique()) {
      
        throw new InvalidRequest_Exception(
            $response->i18n->l(
              'This Assignment allready exists!',
              'wbf.message'
            ),
            Error::CONFLICT
        );
      
      }

      $model->insert($params);
      $pathEntity = $model->getEntityBuizSecurityBackpath();
      $view->displayInsert($pathEntity, $params);
    }

  }//end public function service_save */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_delete($request, $response)
  {
  
    // load request parameters an interpret as flags
    $params = new ContextDomainCrud($request);
    $domainNode = $this->getDomainNode($request);
  
    $pathId = $request->param('objid',Validator::EID);
  
    /* @var $model AclMgmt_Backpath_Model */
    $model = $this->loadModel('AclMgmt_Backpath');
    $model->domainNode = $domainNode;
    $model->checkAccess($domainNode, $params);
  
    /* @var $view AclMgmt_Backpath_Ajax_View */
    $view = $response->loadView(
      $domainNode->domainName.'-backpath',
      'AclMgmt_Backpath'
    );
    $view->setModel($model);
    $view->domainNode = $domainNode;
  
    $model->delete($pathId, $params);
    $view->displayDelete($pathId, $params);
  
  }//end public function service_delete */
  
/*////////////////////////////////////////////////////////////////////////////*/
// autoload
/*////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_autoGroups($request, $response)
  {
  
    // load request parameters an interpret as flags
    $params = new ContextListing($request);
    $domainNode = $this->getDomainNode($request);
  
    /* @var $model AclMgmt_Qfdu_Model */
    $model = $this->loadModel('AclMgmt_Qfdu');
    $model->domainNode = $domainNode;
    $model->checkAccess($domainNode, $params);
  
    $view = $response->loadView
    (
        $domainNode->domainName.'-acl-mgmt',
        'AclMgmt_Qfdu',
        'displayAutocompleteEntity'
    );
    $view->setModel($model);
    $view->domainNode = $domainNode;
  
    $searchKey = $request->param('key', Validator::TEXT);
    $areaId = $model->getAreaId();
  
    $view->displayAutocompleteEntity($areaId, $searchKey, $params);
  
  
  }//end public function service_autoGroups */
  
  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_autoArea($request, $response)
  {
  
    // load request parameters an interpret as flags
    $params = new ContextListing($request);
    $domainNode = $this->getDomainNode($request);
  
    /* @var $model AclMgmt_Model */
    $model = $this->loadModel('AclMgmt');
    $model->domainNode = $domainNode;
    $model->checkAccess($domainNode, $params);
  
    /* @var $view AclMgmt_Ajax_View */
    $view = $response->loadView(
      $domainNode->domainName.'-acl-mgmt',
      'AclMgmt',
      'displayAutocompleteArea'
    );
    $view->setModel($model);
    $view->domainNode = $domainNode;
  
    $searchKey = $request->param('key', Validator::TEXT);
    $areaId = $model->getAreaId();
  
    $view->displayAutocompleteArea($areaId, $searchKey, $params);
  
  
  }//end public function service_autoArea */
  
  /**
   * the default table for the management EnterpriseEmployee
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_autoRefField($request, $response)
  {
  
    // load request parameters an interpret as flags
    $params = new ContextListing($request);
    $domainNode = $this->getDomainNode($request);
  
    /* @var $model AclMgmt_Model */
    $model = $this->loadModel('AclMgmt');
    $model->domainNode = $domainNode;
    $model->checkAccess($domainNode, $params);
  
    /* @var $view AclMgmt_Ajax_View */
    $view = $response->loadView(
      $domainNode->domainName.'-acl-mgmt',
      'AclMgmt_Backpath',
      'displayAutocompleteRefField'
    );
    $view->setModel($model);
    $view->domainNode = $domainNode;
  
    $searchKey = $request->param('key', Validator::TEXT);
    $areaId = $model->getAreaId();
  
    $view->displayAutocompleteRefField($areaId, $searchKey, $params);
  
  
  }//end public function service_autoRefField */

/*////////////////////////////////////////////////////////////////////////////*/
// parse flags
/*////////////////////////////////////////////////////////////////////////////*/



  /**
   * @param LibRequestHttp $request
   * @return ContextListing
   */
  protected function getTabFlags($request)
  {

    $response = $this->getResponse();

    $params = new ContextPlain($request);


    // per default
    $params->categories = [];

    // listing type
    if ($ltype = $request->param('ltype', Validator::CNAME))
      $params->ltype = $ltype;

    // context type
    if ($context = $request->param('context', Validator::CNAME))
      $params->context = $context;

    // start position of the query and size of the table
    $params->start
 = $request->param('start', Validator::INT);

    // stepsite for query (limit) and the table
    if (!$params->qsize = $request->param('qsize', Validator::INT))
      $params->qsize = Wgt::$defListSize;

    // order for the multi display element
    $params->order
 = $request->param('order', Validator::CNAME);

    // target for a callback function
    $params->target
 = $request->param('target', Validator::CKEY  );

    // target for some ui element
    $params->targetId
 = $request->param('target_id', Validator::CKEY  );

    // target for some ui element
    $params->tabId
 = $request->param('tabid', Validator::CKEY  );

    // flag for beginning seach filter
    if ($text = $request->param('begin', Validator::TEXT  )) {
      // whatever is comming... take the first char
      $params->begin = $text[0];
    }

    // exclude whatever
    $params->exclude
 = $request->param('exclude', Validator::CKEY  );

    // the activ id, mostly needed in exlude calls
    $params->objid
 = $request->param('objid', Validator::EID  );

    // startpunkt des pfades für die acls
    if ($aclRoot = $request->param('a_root', Validator::CKEY))
      $params->aclRoot = $aclRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($aclRootId = $request->param('a_root_id', Validator::INT))
      $params->aclRootId = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($aclKey = $request->param('a_key', Validator::CKEY))
      $params->aclKey = $aclKey;

    // der name des knotens
    if ($aclNode = $request->param('a_node', Validator::CKEY))
      $params->aclNode = $aclNode;

    // an welchem punkt des pfades befinden wir uns?
    if ($aclLevel = $request->param('a_level', Validator::INT))
      $params->aclLevel = $aclLevel;

    return $params;

  }//end protected function getTabFlags */

} // end class AclMgmt_Qfdu_Controller */

