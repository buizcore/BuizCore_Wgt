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
class BuizStatsUsage_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array
  (
    'show' => array
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
  public function service_show($request, $response)
  {

    /* @var $view BuizStatsUsage_Maintab_View  */
    $view = $this->loadView
    (
      'stats-usage-page',
      'BuizStatsUsage',
      'displayStats'
    );

    /* @var $model BuizStatsUsage_Model */
    $model = $this->loadModel('BuizStatsUsage');

    $view->setModel($model);
    $view->displayStats();

  }//end public function service_show */

} // end class BuizStats_Controller

