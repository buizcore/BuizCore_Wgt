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
class BuizFormDesigner_Controller extends Controller
{

    /**
     * Die Options zum definieren der Zugriffsparameter
     * 
     * @var array
     */
    protected $options = array(
        'create' => array(
            'method' => array(
                'GET'
            ),
            'views' => array(
                'maintab'
            )
        ),
        'save' => array(
            'method' => array(
                'GET'
            ),
            'views' => array(
                'ajax'
            )
        )
    );
    

    /**
     *
     * @param LibRequestHttp $request
     * @param LibResponseHttp $response
     * @return void
     */
    public function service_create($request, $response)
    {
        
        $params = new Context($request);
        
        $view = $response->loadView(
            'buiz-form-designer-form', 
            'BuizFormDesigner', 
            'displayForm'
        );

        $view->displayForm($params);
        
    } // end public function service_create */

    /**
     *
     * @param LibRequestHttp $request            
     * @param LibResponseHttp $response            
     * @return void
     */
    public function service_search($request, $response)
    {
        
        $searchRequest = new BuizSearch_Request($request);
        
        /* @var $model BuizSearch_Model */
        $model = $this->loadModel('BuizSearch');
        
        /* @var $view BuizSearch_Ajax_View */
        $view = $response->loadView(
            'buiz-search-request', 
            'BuizSearch', 
            'displaySearch'
        );
        
        $view->setModel($model);
        
        $view->displaySearchTable($searchRequest);
        
    } // end public function service_search */
    
} // end class BuizFormDesigner_Controller

