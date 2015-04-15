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
class BuizProfile_Menu_Controller extends Controller
{

/*////////////////////////////////////////////////////////////////////////////*/
// attributes
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
    'tab' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'reload' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'deleteentry' => array(
      'method' => array('DELETE'),
      'views' => array('ajax')
    ),
    'deletemenu' => array(
      'method' => array('DELETE'),
      'views' => array('ajax')
    ),
  );

/*////////////////////////////////////////////////////////////////////////////*/
// tab methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * open tab project_milestone for management view  project_activity_mask_software
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  */
  public function service_tab($request, $response)
  {

    $user = $this->getUser();

    // prüfen ob eine valide id mit übergeben wurde
    if (!$objid = $request->getOID()) {
      // wenn nicht ist die anfrage per definition invalide
      throw new InvalidRequest_Exception(
        $response->i18n->l(
          'The Request for {@resource@} was invalid. ID was missing!',
          'wbf.message',
          array(
            'resource' => $response->i18n->l(
              'Software Project',
              'project.activity_mask_software.label'
            )
          )
        ),
        Response::BAD_REQUEST
      );
    }

    // load request parameters an interpret as flags
    $params = new ContextTab($request);

    // create a new area with the id of the target element, this area will replace
    // the HTML Node of the target UI Element
    $view = $response->loadView(
      $params->tabId,
      'BuizProfile_Menu',
      'displayTab',
      View::AREA
    );

    $view->displayTab($objid, $params);

    // everything is fine
    return State::OK;

  }//end public function load */

  /**
   * open tab project_milestone for management view  project_activity_mask_software
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   */
  public function service_deleteMenu($request, $response)
  {

    // load request parameters an interpret as flags
    $rqtContext = new ContextDset($request);

    // prüfen ob eine valide id mit übergeben wurde
    if (!$rqtContext->objid) {
      // wenn nicht ist die anfrage per definition invalide
      throw new InvalidRequest_Exception(
        'Missing the id',
        Response::BAD_REQUEST
      );
    }

    /* @var BuizMenu_Manager $menuManager */
    $menuManager = Manager::get('BuizMenu');

    $menuManager->deleteSubMenu($rqtContext->objid);

    $response->addMessage('Dropped Submenu');

  }//end public function service_deleteMenu */

  /**
   * open tab project_milestone for management view  project_activity_mask_software
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   */
  public function service_deleteEntry($request, $response)
  {

    // load request parameters an interpret as flags
    $rqtContext = new ContextDset($request);

    // prüfen ob eine valide id mit übergeben wurde
    if (!$rqtContext->objid) {
      // wenn nicht ist die anfrage per definition invalide
      throw new InvalidRequest_Exception(
        'Missing the id',
        Response::BAD_REQUEST
      );
    }

    /* @var BuizMenu_Manager $menuManager */
    $menuManager = Manager::get('BuizMenu');

    $menuManager->deleteSubMenu($rqtContext->objid);

    $response->addMessage('Dropped Submenu');

  }//end public function service_deleteEntry */




 /**
  * open tab project_milestone for management view  project_activity_mask_software
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  */
  public function service_reload($request, $response)
  {

    $user = $this->getUser();

    // check if we got a valid objid
    if (!$objid = $request->getOID()) {
      throw new InvalidRequest_Exception(
        'Missing the ID',
        Response::BAD_REQUEST
      );
    }
    // load request parameters an interpret as flags
    $params = new ContextTab($request);

    // die übergebene objid ist die refId
    $params->refId = $objid;

    // set the save form id
    if (!$params->saveFormId)
      $params->saveFormId = 'wgt-form-project_activity_mask_software-edit-'.$objid;

    // set the flag to load also the sizes
    $params->loadFullSize = true;

    // ok nun kommen wir zu der zugriffskontrolle
    /* @var $acl LibAclAdapter_Db */
    $acl = $this->getAcl();

    $access = new ProjectActivityMaskSoftware_Crud_Access_Tab($this);
    $access->init(new TFlag(), $objid);

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if (!$access->access) {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception(
        $response->i18n->l(
          'You have no permission to access {@resource@}:{@id@}',
          'wbf.message',
          array(
            'resource' => $response->i18n->l('Software Project', 'project.activity_mask_software.label'),
            'id' => $objid
          )
        ),
        Response::FORBIDDEN
      );
    }


    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    $params_RefTpl = clone $params;

    // tab many to one reference ProjectMilestone
    $paramsProjectMilestone = clone $params_RefTpl;
    $params->paramsProjectMilestone = $paramsProjectMilestone;

    $paramsProjectMilestone->aclNode = 'mgmt-project_activity-ref-project_milestone';

    // zugriffsrechte der project_milestone referenz prüfen
    $accessProjectMilestone = new ProjectActivityMaskSoftware_Ref_ProjectMilestone_Table_Access($this);
    $accessProjectMilestone->init($paramsProjectMilestone);

    $params->accessProjectMilestone = $accessProjectMilestone;

    $paramsProjectMilestone->access = $accessProjectMilestone;
    $paramsProjectMilestone->accessProjectMilestone = $accessProjectMilestone;

    // no embeded items


    // create a new area with the id of the target element, this area will replace
    // the HTML Node of the target UI Element
    $view = $response->loadView(
      $params->tabId,
      'ProjectActivityMaskSoftware_Tab_ProjectMilestone',
      'displayTab',
      View::AREA
    );
    $view->setPosition('#'.$params->tabId);



    // try to display the tab
    if ($error = $view->displayTab($objid, $params)) {
      return $error;
    }

    // everything is fine
    return State::OK;

  }//end public function reload */


} // end ProjectActivityMaskSoftware_Tab_ProjectMilestone_Controller */

