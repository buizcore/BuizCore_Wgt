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
class BuizDashboard_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Mit den Options wird der zugriff auf die Service Methoden konfiguriert
   *
   * @var array
   */
  protected $options = array
  (
    'dashboard' => array
    (
      'method' => array('GET'),
      'views' => array('html')
    ),
    'reloadquiklinks' => array
    (
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'reloadbookmarks' => array
    (
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'reloadlastvisited' => array
    (
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'reloadmostvisited' => array
    (
      'method' => array('GET'),
      'views' => array('ajax')
    ),
    'reloaddesktop' => array
    (
      'method' => array('GET'),
      'views' => array('ajax')
    ),
  );

/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResonseHttp $response
   * @return void
   */
  public function service_dashboard($request, $response)
  {

    $view = $this->view;

    $selectWidget = $view->newInput('selectWidget' , 'SelectboxCmsMashupWidget'  );
    $selectWidget->addAttributes
    (array(
    'class' => 'medium'
    ));

    $mashup = $view->addItem('dashboard' , 'Mashup');
    $mashup->where = ' id_owner = '.User::getActive()->getId();

    $view->setTitle('Dashboard');
    $view->setTemplate('mashup' , 'buiz');

  } // end public function service_dashboard */

  /**
   * @param LibRequestHttp $request
   * @param LibResonseHttp $response
   * @return void
   */
  public function service_reloadQuikLinks($request, $response)
  {

    // laden der passenden subview
    $view = $response->loadView
    (
      'buiz_desktop_reload_quik_links',
      'BuizDashboard',
      'displayReloadQuikLinks',
      null,
      true
    );

    $model = $this->loadModel('BuizDashboard');

    $view->setModel($model);

    $view->displayReloadQuikLinks();

  } // end public function service_reloadQuikLinks */

} // end class BuizDashboard_Controller

