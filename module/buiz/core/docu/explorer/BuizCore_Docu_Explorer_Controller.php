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
class BuizCore_Docu_Explorer_Controller extends MvcController
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
    'root' => array(
      'method' => array('GET'),
      'views' => array('modal', 'maintab')
    ),
  );

/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/



  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @throws LibRequest_Exception
   */
  public function service_root($request, $response)
  {

    $params = $this->getFlags($request);

    /* @var $view  BuizCore_Docu_Explorer_Maintab_View */
    $view = $response->loadView(
      'buizcore-docu-explorer',
      'BuizCore_Docu_Explorer',
      'displayRoot'
    );

    $model = $this->loadModel('BuizCore_Docu_Explorer');

    $view->setModel($model);
    $view->displayRoot($params);

  }//end public function service_root */

}//end class BuizCore_Docu_Controller

