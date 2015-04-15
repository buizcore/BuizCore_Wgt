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
class BuizUserSync_Controller extends Controller
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
    'listgoupusers' => array(
      'method' => array('GET'),
      'views' => array('json')
    ),
  );

  protected $servKey = 'buiz-user-sync';

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
  public function service_listGoupUsers($request, $response)
  {
  
      // resource laden
      $user = $this->getUser();
      $acl = $this->getAcl();
      
      if (!$acl->hasRole('bc_bot_web_user')) {
        throw new InvalidRequest_Exception(
            'Access denied',
            Response::FORBIDDEN
        );
      }
   
      // prüfen ob irgendwelche steuerflags übergeben wurde
      $params = new Context($request);

      
      $groups = $request->param('groups',Validator::TEXT);
  
      /* @var $view BuizCoreAddress_Ajax_View */
      $view = $response->loadView(
          $this->servKey.'-sync',
          'BuizUserSync',
          'displayData',
          View::JSON
      );
      
      $buizUserMgr = new BuizUser_Manager($this);
      
      $userlist = $buizUserMgr->getUserSyncdataByGroup(explode(',',$groups));
  
      // die view zum baue des formulars veranlassen
      $view->displayData($userlist, $params);
  
  }//end public function service_listGoupUsers */
  

} // end class BuizUserSync_Controller */

