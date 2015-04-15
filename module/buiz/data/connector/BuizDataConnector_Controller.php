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
class BuizDataConnector_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array(
    'form' => array(
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'selection' => array(
      'method' => array('GET'),
      'views' => array('modal')
    ),
    'search' => array(
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
    $view = $response->loadView(
      'buiz-data-connector-form',
      'BuizDataConnector' ,
      'displayForm'
    );

    $view->displayForm();

  }//end public function service_form */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_selection($request, $response)
  {

    ///@trows InvalidRequest_Exception
    /* @var $view BuizDataConnector_Modal_View */
    $view = $response->loadView(
      'buiz-data-connector-selection',
      'BuizDataConnector' ,
      'displaySelection'
    );
    
    $searchReq = new BuizDataConnector_Search_Request($request);

    $view->displaySelection($searchReq);

  }//end public function service_selection */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_search($request, $response)
  {

    ///@throws InvalidRequest_Exception
    /* @var $view BuizDataConnector_Ajax_View */
    $view = $response->loadView(
      'buiz-data-connector-search',
      'BuizDataConnector' ,
      'displaySearch'
    );
    
    $searchReq = new BuizDataConnector_Search_Request($request);
    
    /* @var $model BuizDataConnector_Model */
    $model = $this->loadModel('BuizDataConnector');
    $view->setModel($model);
    $view->displaySearch($searchReq);

  }//end public function service_search */

}//end class BuizDataConnector_Controller

