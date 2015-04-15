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
class BuizDesktop_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// Parent Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Mit den Options wird der zugriff auf die Service Methoden konfiguriert
   *
   * @var array
   */
  protected $options = array(
    'display' => array(
      'method' => array('GET', 'POST'),
      'views' => array('html')
    ),
    'displaysimple' => array(
      'method' => array('GET'),
      'views' => array('html')
    ),
    'dropmenu' => array(
      'method' => array('GET'),
      'views' => array('html')
    ),
  );

/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * default method for creating the desktop
   * @return void
   */
  public function service_display($request, $response)
  {

    $view = $this->getView();
    $view->setTitle('Desktop');

    $conf = Conf::get('view');

    $profile = $this->getUser()->getProfile();

    $view->menu = $profile->getNavigation();

    $profile->getDesktop()->display($view);

  } // end public function service_display */

  /**
   * default method for creating the desktop
   * @return void
   */
  public function service_refresh($request, $response)
  {

    $user = $this->getUser();

    $tpl = $this->getTpl();
    $tpl->setTitle('Desktop');

    $area = $tpl->newArea('wgt-ui-desktop');
    $area->position = '#wgt-ui-desktop';
    $area->action = 'html';

    $profile = $this->getUser()->getProfile();
    $profile->getDesktop()->display($area);

    /* @var $modelMsg BuizMessage_Model
    $modelMsg = $this->loadModel('BuizMessage');
    $areaMsg = $tpl->newArea('desktop-panel-message');
    $areaMsg->position = '#desktop-panel-message>span';
    $areaMsg->action = 'html';
    $areaMsg->setContent($modelMsg->countNewMessages($user));
    */

    $tpl->setJsonData(time());

  } // end public function service_refresh */

  /**
   * default method for creating the desktop
   * @return void
   */
  public function service_dropmenu($request, $response)
  {

    $view = $this->getView();
    $view->setTitle('Desktop');

    $conf = Conf::get('view');

    $profile = $this->getUser()->getProfile();

    $view->menu = $profile->getNavigation();

    $profile->getDesktop()->display($view);

  } // end public function service_dropmenu */

  /**
   * default method for creating the desktop
   * @return void
   */
  public function service_displaySimple( $request, $response  )
  {

    $view = $this->getTpl();

    $view->setTitle('Desktop');
    $view->setTemplate('buiz/desktop_simple'  );

  } // end public function service_displaySimple */

} // end class BuizDesktop_Controller

