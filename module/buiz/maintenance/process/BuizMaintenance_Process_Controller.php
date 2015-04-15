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
class BuizMaintenance_Process_Controller extends MvcController_Domain
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
  protected $options = [
    'list' => [
      'method' => ['GET'],
      'views' => ['maintab']
    ],
    'formswitchstatus' => [
      'method' => ['GET'],
      'views' => ['modal', 'maintab']
    ],
    'changestatus' => [
      'method' => ['PUT'],
      'views' => ['ajax']
    ]
 ];

/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_list($request, $response)
  {

    /* @var  */
    $view = $response->loadView(
      'buiz-maintenance-process-list',
      'BuizMaintenance_Process' ,
      'displayList'
    );

    $model = $this->loadModel('BuizMaintenance_Process');

    $view->setModel($model);
    $view->displayList();

  }//end public function service_list */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formSwitchStatus($request, $response)
  {

    $statusId = $request->param('active', Validator::EID);

    $domainNode = $this->getDomainNode($request);

    ///@trows InvalidRequest_Exception
    /* @var $view BuizMaintenance_ProcessStatus_Modal_View */
    $view = $response->loadView(
      'buiz-maintenance-process-status',
      'BuizMaintenance_ProcessStatus' ,
      'displayform'
    );

    /* @var $model BuizMaintenance_Process_Model  */
    $model = $this->loadDomainModel($domainNode, 'BuizMaintenance_Process');
    $view->model = $model;

    $model->loadStatusById($domainNode, $statusId);

    $view->displayform();

  }//end public function service_formSwitchStatus */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_changeStatus($request, $response)
  {

    $idStatus = $request->data('id_status', Validator::EID);
    $idNew = $request->data('id_new', Validator::EID);
    $comment = $request->data('comment', Validator::TEXT);

    $domainNode = $this->getDomainNode($request, true);

    $checkContext = $response->createContext();

    $checkContext->assertInt('Missing Process Status ID', $idStatus);
    $checkContext->assertInt('Missing the new Process Status', $idNew);

    if ($checkContext->hasError)
      throw new InvalidRequest_Exception();

    /* @var $model BuizMaintenance_Process_Model  */
    $model = $this->loadDomainModel($domainNode, 'BuizMaintenance_Process');

    $model->changeStatus($domainNode, $idStatus, $idNew, $comment);

  }//end public function service_changeStatus */

}//end class BuizMaintenance_DataIndex_Controller

