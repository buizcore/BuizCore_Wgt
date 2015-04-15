<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore
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
 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 *
 */
class BuizAnnouncement_Controller extends MvcController_Domain
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/
    
    /**
    * @var array
    */
    protected $options = [
        'sendcustomer' => [
            'method' => ['POST'],
            'views' => ['json','ajax']
        ],
    ];

/*////////////////////////////////////////////////////////////////////////////*/
// Listing Methodes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    *
    * @param LibRequestHttp $request
    * @param LibResponseHttp $response
    * @return boolean
    */
    public function service_sendCustomer($request, $response)
    {
    
        // resource laden
        $user = $this->getUser();
        $i18n = $this->getI18n();
        
        //TODO acls, required fields
        
        $userRqt = new BuizAnnouncement_Create_Request($request);
        
        // erst mal brauchen wir das passende model
        $manager = new BuizAnnouncement_Manager();
        $manager->createCustomerAnnouncement(
            'Persönliche Nachricht', 
            '<p>'.$userRqt->field('message','announcement').'</p>', 
            [$userRqt->field('vid','announcement')], 
            $userRqt->field('importance','announcement')
        );
        
        $response->addMessage($i18n->l('Message was sent','wbf.msg.base'));
    
    }//end public function service_sendCustomer */

   /**
    * @param LibRequestHttp $request
    * @param LibResponseHttp $response
    * @return boolean
    */
    public function service_sendByDatasource($request, $response)
    {
  
        // resource laden
        $user = $this->getUser();
        $i18n = $this->getI18n();
        
        //TODO acls, required fields
        
        $userRqt = new BuizAnnouncement_Create_Request($request);
        
        $dataSource = $request->param('target', Validator::CNAME);
        
        $classname = "{$dataSource}_Manager";
      
        if (BuizCore::classExists($classname) && method_exists($classname, 'createAnnouncement')) {
            // erst mal brauchen wir das passende model
            $manager = new $classname();
            $manager->createAnnouncement(
                'Persönliche Nachricht',
                '<p>'.$userRqt->field('message','announcement').'</p>',
                $userRqt->field('vid','announcement'),
                $userRqt->field('importance','announcement')
            );
            $response->addMessage($i18n->l('Message was sent','wbf.msg.base'));
            
        } else {
            
            $response->addMessage($i18n->l('Error','wbf.msg.base'));
        }
      
    
    }//end public function service_sendCustomer */

} // end class BuizExport_Controller */

