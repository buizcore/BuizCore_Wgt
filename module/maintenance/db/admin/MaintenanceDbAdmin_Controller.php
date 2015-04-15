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
class MaintenanceDbAdmin_Controller extends MvcController
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

    /**
     * @var []
     */
    protected $options = [
        'form' => [
            'method' => ['GET'],
            'views' => ['maintab']
        ],
        'query' => [
            'method' => ['PUT','POST'],
            'views' => ['ajax']
        ],
    ];
    
    
    /**
    * @var LibRequestPhp $request
    * @var LibResponseHttp $response
    * @return void
    */
    public function service_form($request, $response)
    {
    
        $context = new Context($request);

        $view = $response->loadView(
            'MaintenanceDbAdmin', 
            'MaintenanceDbAdmin'
        );
        
        $view->display($context);
    
    }//end public function service_form */
    
    
    /**
    * @var LibRequestPhp $request
    * @var LibResponseHttp $response
    * @return void
    */
    public function service_query($request, $response)
    {
    
        $context = new Context($request);
        
        
        $db = $this->getDb();
        
        $query = $request->data('query',Validator::TEXT);
        
        
        if ($query) {
            
            try {
                $res = $db->exec($query);
                
                $response->addMessage('Query executed');
                
            } catch (LibDb_Exception $exc ){
                
                $response->addError($exc->getMessage());
            }

            
        }
        
        
        
        
    }//end public function service_form */

 

}//end class MaintenanceDbAdmin_Controller */

