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
class MaintenanceDbConsistency_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function service_table($request, $response)
  {

    $params = $this->getFlags($request);

    $view = $response->loadView('maintenance-db-consistency' , 'MaintenanceDbConsistency');

    $view->display($params);

  }//end public function service_table */

  /**
   * @return void
   */
  public function service_fix($request, $response)
  {

    $extensionLoader = new ExtensionLoader('fix_db');
    //$protocol = new TProtocol();

    foreach ($extensionLoader as $extension) {
      if (BuizCore::classExists($extension)) {
        $ext = new $extension($this);
        try {
          $ext->run();
        } catch (Exception $e) {
          $response->addError($e->getMessage());
        }
      }
    }

  }//end public function service_fix */

  /**
   * @return void
   */
  public function service_fixAll($request, $response)
  {

    $extensionLoader = new ExtensionLoader('fix_db');
    //$protocol = new TProtocol();

    foreach ($extensionLoader as $extension) {
      if (BuizCore::classExists($extension)) {
        $ext = new $extension($this);
        try {
          $ext->run();
        } catch (Exception $e) {
          $response->addError($e->getMessage());
        }
      }
    }

    $response->addMessage("Sucessfully executed all fixes");

  }//end public function service_fixAll */

}//end class MaintenanceDbConsistency_Controller

