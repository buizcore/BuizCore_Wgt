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
class BuizStats_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array
  (
    'open' => array
    (
      'method' => array('GET'),
      'views' => array('maintab')
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
  public function service_open($request, $response)
  {

    $idContainer = $request->param('container', Validator::EID);
    $nodeKey = $request->param('node', Validator::TEXT);
    $objid = $request->param('objid', Validator::EID);

    /* @var $view BuizKnowhowNode_Maintab_View  */
    $view = $response->loadView
    (
      'know_how-node-form',
      'BuizKnowhowNode',
      'displayForm'
    );

    /* @var $model BuizKnowhowNode_Model */
    $model = $this->loadModel('BuizKnowhowNode');

    if ($objid) {
      $model->loadNodeById($objid);
    } elseif ($nodeKey) {
      $model->loadNodeByKey($nodeKey, $idContainer);
    }

    $view->setModel($model);
    $view->displayForm($nodeKey, $idContainer);

  }//end public function service_open */

} // end class BuizStats_Controller

