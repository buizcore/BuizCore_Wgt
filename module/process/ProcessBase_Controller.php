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
class ProcessBase_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestPhp $request
   * @param LibResponsePhp $response
   * @return void
   */
  public function service_showHistory($request, $response)
  {

    $request = $this->getRequest();
    $response = $this->getResponse();

    $processId = $request->param('process', Validator::INT  );
    $objid = $request->param('objid', Validator::INT  );
    $entity = $request->param('entity', Validator::CNAME  );

    $view = $response->loadView(
      'process-base-history',
      'ProcessBase',
      'displayHistory'
    );

    $params = $this->getFlags($request);

    $model = $this->loadModel('ProcessBase');
    $model->loadEntity($entity, $objid);
    $model->setProcessId($processId);

    $view->setModel($model);

    $view->displayHistory($processId, $params);

  }//end public function showHistory */

}//end class ProcessBase_Controller

