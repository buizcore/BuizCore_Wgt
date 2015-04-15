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
class BuizCache_Controller extends Controller
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
  protected $options = array
  (
    'stats' => array
    (
      'method' => array('GET'),
      'views' => array('maintab')
    ),
    'cleanall' => array
    (
      'method' => array('GET', 'DELETE', "CLI"),
      'views' => array('ajax', 'cli')
    ),
    'rebuildcss' => array
    (
      'method' => array('PUT', "CLI"),
      'views' => array('ajax', 'cli')
    ),
    'rebuildjs' => array
    (
      'method' => array('PUT', "CLI"),
      'views' => array('ajax', 'cli')
    ),
    'rebuildwebtheme' => array
    (
      'method' => array('PUT', "CLI"),
      'views' => array('ajax', 'cli')
    ),
    'rebuildapptheme' => array
    (
      'method' => array('PUT', "CLI"),
      'views' => array('ajax', 'cli')
    ),
    'rebuildallcss' => array
    (
      'method' => array('PUT', "CLI"),
      'views' => array('ajax', 'cli')
    ),
    'rebuildalljs' => array
    (
      'method' => array('PUT', "CLI"),
      'views' => array('ajax', 'cli')
    ),
    'rebuildallwebtheme' => array
    (
      'method' => array('PUT', "CLI"),
      'views' => array('ajax', 'cli')
    ),
    'rebuildallapptheme' => array
    (
      'method' => array('PUT', "CLI"),
      'views' => array('ajax', 'cli')
    ),
    'cleancss' => array
    (
      'method' => array('DELETE', "CLI"),
      'views' => array('ajax', 'cli')
    ),
    'cleanjs' => array
    (
      'method' => array('DELETE', "CLI"),
      'views' => array('ajax', 'cli')
    ),
    'cleanwebtheme' => array
    (
      'method' => array('DELETE', "CLI"),
      'views' => array('ajax', 'cli')
    ),
    'cleanapptheme' => array
    (
      'method' => array('DELETE', "CLI"),
      'views' => array('ajax', 'cli')
    ),
    'flushmemcache' => array
    (
      'method' => array('GET', 'DELETE', "CLI"),
      'views' => array('ajax', 'cli')
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
  public function service_stats($request, $response)
  {

    $acl = $this->getAcl();

    if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
      throw new InvalidPermission_Exception();

    ///@trows InvalidRequest_Exception
    $view = $response->loadView
    (
      'buiz-cache-stats',
      'BuizCache' ,
      'displayStats'
    );

    $params = $this->getFlags($request);

    $model = $this->loadModel('BuizCache');

    $view->setModel($model);
    $view->displayStats($params);

  }//end public function service_stats */

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_cleanAll($request, $response)
  {

    // access check wenn nicht per cli
    if ($this->tpl->type !== View::CLI) {
      $acl = $this->getAcl();

      if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
        throw new InvalidPermission_Exception();
    }

    /* @var $model BuizCache_Model  */
    $model = $this->loadModel('BuizCache');
    $model->cleanCache();

  }//end public function service_cleanAll */
  
  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_flushMemcache($request, $response)
  {
  
      // access check wenn nicht per cli
      if ($this->tpl->type !== View::CLI) {
          $acl = $this->getAcl();
  
          if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
              throw new InvalidPermission_Exception();
      }
  
      $memcached = new Memcache();
      $memcached->connect('127.0.0.1');
      $memcached->flush();
  
  }//end public function service_cleanAll */

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_rebuildCss($request, $response)
  {

    // access check wenn nicht per cli
    if ($this->tpl->type !== View::CLI) {
      $acl = $this->getAcl();

      if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
        throw new InvalidPermission_Exception();
    }

    $key = $request->param('key', Validator::CNAME);

    /* @var $model BuizCache_Model  */
    $model = $this->loadModel('BuizCache');
    $model->rebuildCss($key);

  }//end public function service_rebuildCss */

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_rebuildJs($request, $response)
  {

    // access check wenn nicht per cli
    /* */
    if ($this->tpl->type !== View::CLI) {
      $acl = $this->getAcl();

      if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
        throw new InvalidPermission_Exception();
    }

    $key = $request->param('key', Validator::CNAME);

    /* @var $model BuizCache_Model  */
    $model = $this->loadModel('BuizCache');
    $model->rebuildJs($key);

  }//end public function service_rebuildJs */

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_rebuildWebTheme($request, $response)
  {

    // access check wenn nicht per cli
    if ($this->tpl->type !== View::CLI) {
      $acl = $this->getAcl();

      if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
        throw new InvalidPermission_Exception();
    }

    $key = $request->param('key', Validator::CNAME);

    /* @var $model BuizCache_Model  */
    $model = $this->loadModel('BuizCache');
    $model->rebuildWebTheme($key);

  }//end public function service_rebuildWebTheme */

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_rebuildAppTheme($request, $response)
  {

    // access check wenn nicht per cli
    if ($this->tpl->type !== View::CLI) {
      $acl = $this->getAcl();

      if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
        throw new InvalidPermission_Exception();
    }

    $key = $request->param('key', Validator::CNAME);

    /* @var $model BuizCache_Model  */
    $model = $this->loadModel('BuizCache');
    $model->rebuildAppTheme($key);

  }//end public function service_rebuildAppTheme */

/*////////////////////////////////////////////////////////////////////////////*/
// Rebuild all
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_rebuildAllCss($request, $response)
  {

    // access check wenn nicht per cli
    if ($this->tpl->type !== View::CLI) {
      $acl = $this->getAcl();

      if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
        throw new InvalidPermission_Exception();
    }

    /* @var $model BuizCache_Model  */
    $model = $this->loadModel('BuizCache');
    $model->rebuildAllCss();

  }//end public function service_rebuildAllCss */

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_rebuildAllJs($request, $response)
  {

    // access check wenn nicht per cli
    /* */
    if ($this->tpl->type !== View::CLI) {
      $acl = $this->getAcl();

      if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
        throw new InvalidPermission_Exception();
    }

    /* @var $model BuizCache_Model  */
    $model = $this->loadModel('BuizCache');
    $model->rebuildAllJs();

  }//end public function service_rebuildAllJs */

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_rebuildAllWebTheme($request, $response)
  {

    // access check wenn nicht per cli
    if ($this->tpl->type !== View::CLI) {
      $acl = $this->getAcl();

      if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
        throw new InvalidPermission_Exception();
    }

    /* @var $model BuizCache_Model  */
    $model = $this->loadModel('BuizCache');
    $model->rebuildAllWebTheme();

  }//end public function service_rebuildAllWebTheme */

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_rebuildAllAppTheme($request, $response)
  {

    // access check wenn nicht per cli
    if ($this->tpl->type !== View::CLI) {
      $acl = $this->getAcl();

      if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
        throw new InvalidPermission_Exception();
    }

    /* @var $model BuizCache_Model  */
    $model = $this->loadModel('BuizCache');
    $model->rebuildAllAppTheme();

  }//end public function service_rebuildAllAppTheme */

/*////////////////////////////////////////////////////////////////////////////*/
// Delete all
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_cleanCss($request, $response)
  {

    // access check wenn nicht per cli
    if ($this->tpl->type !== View::CLI) {
      $acl = $this->getAcl();

      if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
        throw new InvalidPermission_Exception();
    }

    /* @var $model BuizCache_Model  */
    $model = $this->loadModel('BuizCache');

    // now we just to have to clean the code folder :-)
    $toClean = array
    (
      'Css Cache' => PATH_GW.'cache/css/'
    );

    $model->clean($toClean);

  }//end public function service_cleanCss */

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_cleanJs($request, $response)
  {

    // access check wenn nicht per cli
    /* */
    if ($this->tpl->type !== View::CLI) {
      $acl = $this->getAcl();

      if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
        throw new InvalidPermission_Exception();
    }

    /* @var $model BuizCache_Model  */
    $model = $this->loadModel('BuizCache');

    // now we just to have to clean the code folder :-)
    $toClean = array
    (
      'Js Cache' => PATH_GW.'cache/js/'
    );

    $model->clean($toClean);

  }//end public function service_cleanJs */

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_cleanWebTheme($request, $response)
  {

    // access check wenn nicht per cli
    if ($this->tpl->type !== View::CLI) {
      $acl = $this->getAcl();

      if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
        throw new InvalidPermission_Exception();
    }

    /* @var $model BuizCache_Model  */
    $model = $this->loadModel('BuizCache');

    // now we just to have to clean the code folder :-)
    $toClean = array
    (
      'Web Theme Cache' => PATH_GW.'cache/web_theme/'
    );

    $model->clean($toClean);

  }//end public function service_cleanWebTheme */

  /**
   * Clean the complete cache
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_cleanAppTheme($request, $response)
  {

    // access check wenn nicht per cli
    if ($this->tpl->type !== View::CLI) {
      $acl = $this->getAcl();

      if (!$acl->hasRole(array('admin', 'maintenance', 'developer')))
        throw new InvalidPermission_Exception();
    }

    /* @var $model BuizCache_Model  */
    $model = $this->loadModel('BuizCache');

    // now we just to have to clean the code folder :-)
    $toClean = array
    (
      'App Theme Cache' => PATH_GW.'cache/app_theme/'
    );

    $model->clean($toClean);

  }//end public function service_cleanAppTheme */

} // end class BuizCache_Controller

