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
class BuizUserImport_Controller extends Controller
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
    'form' => array(
      'method' => array('GET', 'POST'),
      'views' => array('modal')
    ),
    'upload' => array(
      'method' => array('POST'),
      'views' => array('ajax')
    ),
    'import' => array(
      'method' => array('POST'),
      'views' => array('ajax')
    ),
  );


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
  public function service_form($request, $response)
  {

    // resource laden
    $user = $this->getUser();

    
    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params = new ContextCrud($request);

    // der contextKey wird benötigt um potentielle Konflikte in der UI
    // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
    $params->contextKey = 'business_customer_import-form';
    
   
    // erst mal brauchen wir das passende model
    /* @var $model BuizUserImport_Model */
    $model = $this->loadModel('BuizUserImport');

    /* @var $view BuizUserImport_Modal_View */
    $view = $response->loadView(
      'form-business_customer_import',
      'BuizUserImport',
      'displayForm',
      null,
      true
    );
    // laden des models und direkt übergabe in die view
    $view->setModel($model);

    // die view zum baue des formulars veranlassen
    $view->displayForm($params );

  }//end public function service_mask */

  
    /**
    * @param LibRequestHttp $request
    * @param LibResponseHttp $response
    */
    public function service_upload($request, $response)
    {
        
        // resource laden
        $user = $this->getUser();
        
        // prüfen ob irgendwelche steuerflags übergeben wurde
        $params = new ContextCrud($request);
        
        // der contextKey wird benötigt um potentielle Konflikte in der UI
        // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
        $params->contextKey = 'business_customer_import-upload';
  
       
        // erst mal brauchen wir das passende model
        /* @var $model BuizUserImport_Model */
        $model = $this->loadModel('BuizUserImport');
        
        /* @var $view BuizUserImport_Ajax_View */
        $view = $response->loadView(
          'action-business_customer_import-upload',
          'BuizUserImport',
          'displayUpload',
          null,
          true
        );
        // laden des models und direkt übergabe in die view
        $view->setModel($model);
        
        $model->handleUpload($request);
        
        // die view zum baue des formulars veranlassen
        $view->displayUpload($params);

    }//end public function service_upload */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   */
  public function service_import($request, $response)
  {
  
      // resource laden
      $user = $this->getUser();
  
  
      // prüfen ob irgendwelche steuerflags übergeben wurde
      $params = new ContextCrud($request);
  
      // der contextKey wird benötigt um potentielle Konflikte in der UI
      // bei der Anzeige von mehreren Windows oder Tabs zu vermeiden
      $params->contextKey = 'business_customer_import-import';
  
       
      // erst mal brauchen wir das passende model
      /* @var $model BuizUserImport_Model */
      $model = $this->loadModel('BuizUserImport');
  
      $view = $response->loadView(
          'action-business_customer_import-import',
          'BuizUserImport',
          'displayImport',
          null,
          true
      );
      // laden des models und direkt übergabe in die view
      $view->setModel($model);
      
      $model->handleMapping($request);
      $model->executeImport($request);

      // die view zum baue des formulars veranlassen
      $view->displayImport($params);
  
  }//end public function service_clean */
  

} // end class BuizUserImport_Controller */

