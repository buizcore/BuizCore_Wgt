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
class BuizProtocol_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array
  (
    'overlaydset' => array
    (
      'method' => array('GET'),
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
  public function service_overlayDset($request, $response)
  {

    $dKey = $request->param('dkey', Validator::TEXT);
    $objid = $request->param('objid', Validator::EID);

    /* @var $view BuizProtocol_Ajax_View  */
    $view = $response->loadView
    (
      'buiz-protocol-dset',
      'BuizProtocol',
      'displayOverlay'
    );

    /* @var $model BuizProtocol_Model */
    $model = $this->loadModel('BuizProtocol');

    $view->setModel($model);
    $view->displayOverlay($dKey, $objid);

  }//end public function service_overlayDset */

} // end class BuizProtocol_Controller

