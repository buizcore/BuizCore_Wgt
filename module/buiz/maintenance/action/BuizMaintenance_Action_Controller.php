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
class BuizMaintenance_Action_Controller extends MvcController
{
/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array(

    'exec' => array(
      'method' => array('PUT'),
      'views' => array('ajax')
    ),

  );

/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_exec($request, $response)
  {

    $acl = $this->getAcl();
    $orm = $this->getOrm();
    
    if (!$acl->hasRole('developer','maintenance')) {
      throw new InvalidPermission_Exception();
    }

    // load the view object
    /* @var $view BuizDms_Maintab_View */
    $view = $response->loadView(
      'buiz-maintenance-action',
      'BuizMaintenance_Action',
      'displayExec',
      View::MODAL
    );

    $actionId = $request->param('objid', Validator::EID);
    $actionNode = $orm->get('BuizMaintenanceAction', $actionId);

    $view->displayExec($actionNode);

  }//end public function service_explorer */



} // end class BuizMaintenance_Action_Controller
