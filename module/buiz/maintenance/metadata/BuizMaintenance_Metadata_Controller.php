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
class BuizMaintenance_Metadata_Controller extends Controller
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
    'stats' => array(
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'cleansource' => array(
      'method' => array('DELETE'),
      'views' => array('modal')
    ),
    'cleanall' => array(
      'method' => array('DELETE'),
      'views' => array('modal')
    )
  );

/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_stats($request, $response)
  {

    /* @var $view BuizMaintenance_Metadata_Modal_View  */
    $view = $response->loadView(
      'buiz-maintenance-metadata-stats',
      'BuizMaintenance_Metadata' ,
      'displayStats'
    );

    $model = $this->loadModel('BuizMaintenance_Metadata');

    $view->setModel($model);
    $view->displayStats();

  }//end public function service_stats */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_cleanAll($request, $response)
  {

    /* @var $model BuizMaintenance_Metadata_Model */
    $model = $this->loadModel('BuizMaintenance_Metadata');
    $model->cleanAllMetadata();

    $response->addMessage("Cleaned Metadata");

    /* @var $view BuizMaintenance_Metadata_Log_Modal_View  */
    $view = $response->loadView(
      'buiz-maintenance-metadata-cleanlog',
      'BuizMaintenance_Metadata_Log' ,
      'displayLog'
    );

    $view->setModel($model);
    $view->displayLog();

  }//end public function service_cleanAll */

}//end class BuizMaintenance_Metadata_Controller

