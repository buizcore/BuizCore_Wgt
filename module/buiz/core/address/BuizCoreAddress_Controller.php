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
 * @copyright BuizCore.com <BuizCore.com>
 * @licence BuizCore.com
 */
class BuizCoreAddress_Controller extends Controller
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
    'search' => array(
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'save' => array(
      'method' => array('POST'),
      'views' => array('ajax')
    ),
    'saveall' => array(
      'method' => array('POST'),
      'views' => array('ajax')
    ),
    'delete' => array(
      'method' => array('DELETE'),
      'views' => array('ajax')
    ),
    'deleteall' => array(
      'method' => array('DELETE'),
      'views' => array('ajax')
    ),
  );

  protected $servKey = 'buiz-core-address';

/*////////////////////////////////////////////////////////////////////////////*/
// Form Methodes
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   *   @param LibRequestHttp $request
   *   @param LibResponseHttp $response
   *
   *   @throws InvalidRequest_Exception
   *   @throws AccessDenied_Exception
   * }
   */
  public function service_save($request, $response)
  {
  
      // resource laden
      $user = $this->getUser();
   
  
      // prüfen ob irgendwelche steuerflags übergeben wurde
      $params = new BuizCoreAddress_Crud_Request($request, $this);
      $params->fetchFormData($request);


      $manager = new BuizCoreAddress_Manager($this);
      $manager->saveAddress($params->address);
  
      /* @var $view BuizCoreAddress_Ajax_View */
      $view = $response->loadView(
          $this->servKey.'-save',
          'BuizCoreAddress',
          'displaySave'
      );
  
      // die view zum baue des formulars veranlassen
      $view->displaySave($params);
  
  }//end public function service_save */
  
  /**
   *   @param LibRequestHttp $request
   *   @param LibResponseHttp $response
   *
   *   @throws InvalidRequest_Exception
   *   @throws AccessDenied_Exception
   * }
   */
  public function service_saveAll($request, $response)
  {
  
      // resource laden
      $user = $this->getUser();
       
  
      // prüfen ob irgendwelche steuerflags übergeben wurde
      $params = new BuizCoreAddress_Crud_Request($request, $this);
      $params->fetchMultiFormData($request);
  
  
      $manager = new BuizCoreAddress_Manager($this);
      $manager->saveMultiAddresses($params->address);
  
      /* @var $view BuizCoreAddress_Ajax_View */
      $view = $response->loadView(
          $this->servKey.'-save-all',
          'BuizCoreAddress',
          'displaySaveAll'
      );
  
      // die view zum baue des formulars veranlassen
      $view->displaySaveAll($params);
  
  }//end public function service_save */
  

  /**
   *   @param LibRequestHttp $request
   *   @param LibResponseHttp $response
   *
   *   @throws InvalidRequest_Exception
   *   @throws AccessDenied_Exception
   * }
   */
  public function service_delete($request, $response)
  {
  
      // resource laden
      $user = $this->getUser();
       
  
      // prüfen ob irgendwelche steuerflags übergeben wurde
      $params = new BuizCoreAddress_Crud_Request($request, $this);
  
  
      $manager = new BuizCoreAddress_Manager($this);
      $manager->deleteAddress($params->objid);
  
      /* @var $view BuizCoreAddress_Ajax_View */
      $view = $response->loadView(
          $this->servKey.'-delete',
          'BuizCoreAddress',
          'displayDelete'
      );
  
      // die view zum baue des formulars veranlassen
      $view->displayDelete($params);
  
  }//end public function service_save */
  
  /**
   *   @param LibRequestHttp $request
   *   @param LibResponseHttp $response
   *
   *   @throws InvalidRequest_Exception
   *   @throws AccessDenied_Exception
   * }
   */
  public function service_deleteAll($request, $response)
  {

      // prüfen ob irgendwelche steuerflags übergeben wurde
      $params = new BuizCoreAddress_Crud_Request($request, $this);
  
  
      $manager = new BuizCoreAddress_Manager($this);
      $manager->deleteAllAddresses($params->idPerson);
  
      /* @var $view BuizCoreAddress_Ajax_View */
      $view = $response->loadView(
          $this->servKey.'-deleteall',
          'BuizCoreAddress',
          'displayDeleteAll'
      );
  
      // die view zum baue des formulars veranlassen
      $view->displayDeleteAll($params);
  
  }//end public function service_deleteAll */
  
  /**
   *   @param LibRequestHttp $request
   *   @param LibResponseHttp $response
   *
   *   @throws InvalidRequest_Exception
   *   @throws AccessDenied_Exception
   * }
   */
  public function service_search($request, $response)
  {
  
      // resource laden
      $user = $this->getUser();
  
      // prüfen ob irgendwelche steuerflags übergeben wurde
      $params = new BuizCoreAddress_Search_Request($request);

      /* @var $view BuizCoreAddress_Ajax_View */
      $view = $response->loadView(
          $this->servKey.'-search',
          'BuizCoreAddress',
          'displaySearch'
      );
      
      // die view zum baue des formulars veranlassen
      $view->displaySearch($params);
  
  }//end public function service_search */
    

} // end class BuizCoreAddress_Controller */

