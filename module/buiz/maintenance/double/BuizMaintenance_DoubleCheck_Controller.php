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
class BuizMaintenance_DoubleCheck_Controller extends Controller
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
  protected $options = array
  (
    'form' => array
    (
      'method' => array('GET'),
      'views' => array('maintab')
    ),
    'list' => array
    (
      'method' => array('GET'),
      'views' => array('maintab')
    ),
    'subtree' => array
    (
      'method' => array('GET'),
      'views' => array('ajax')
    ),
  );

/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_form($request, $response)
  {

    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'buiz-maintenance-entity-form',
      'BuizMaintenance_DoubleCheck_Form' ,
      'displayform'
    );

    $view->displayform();

  }//end public function service_form */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_showDoubles($request, $response)
  {

    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'buiz-maintenance-entity-form',
      'BuizMaintenance_DoubleCheck_Show' ,
      'displayform'
    );

    $view->displayform();

  }//end public function service_showDoubles */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_list($request, $response)
  {

    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'buiz-maintenance-entity-list',
      'BuizMaintenance_DataIndex_Stats' ,
      'displayStats',
      null,
      true
    );

    $params = $this->getFlags($request);

    $model = $this->loadModel('BuizMaintenance_DataIndex');

    $view->setModel($model);
    $view->displayStats($params);

  }//end public function service_list */

}//end class BuizMaintenance_DataIndex_Controller

