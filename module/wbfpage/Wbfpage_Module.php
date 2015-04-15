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
class Wbfpage_Module extends MvcModule
{

  /**
   * the main controller, should be overwrited
   * @return void
   */
  public function main()
  {

    $this->tplEngine->setIndex('public/default');

    $this->runController();

  }//end public function main */

  /**
   * Ausführen des Controllers
   *
   * @return void
   */
  protected function runController()
  {

    try {

      $request = $this->getRequest();

      if (!$this->initModul())
        throw new BuizSys_Exception('Failed to initialize Modul');

      // Initialisieren der Extention
      if (!$this->controller || !$this->controller->initController())
        throw new BuizSys_Exception('Failed to initialize Controller');

      // Run the mainpart

      $method = 'page'.ucfirst($request->param('do',Validator::CNAME));

      if (method_exists($this->controller, $method)) {
        if (!$this->controller->$method()) {
          $this->controller->errorPage('Error 500' , 'something went wrong');
        }
      } else {
        $this->controller->errorPage('Error 404' , 'requested page not exists');
      }

      // shout down the extension
      $this->controller->shutdownController();
      $this->shutdownModul();

    } catch (Exception $exc) {

      if (DEBUG) {
        $this->modulErrorPage
        (
          'Exception: '.get_class($exc).' msg: '.$exc->getMessage().' not catched ',
          Debug::dumpToString($exc)
        );
      } else {
        $this->modulErrorPage
        (
          I18n::s('Sorry Internal Error','wbf.error.ModulCaughtErrorTitle'),
          I18n::s('An Internal Error Occured','wbf.error.ModulCaughtError')
        );
      }

    }//end catch

  } // end protected function runController */

  /**
   * Funktion zum aktivsetzen von extentions
   *
   * @return void
   */
  protected function setController($name = null)
  {

    $request = $this->getRequest();

    if (!$name  )
      $name = $request->param('mex',Validator::CNAME);

     $classname = ''.ucfirst($name).'_Page';

     if (!BuizCore::classExists($classname))
       $classname = 'Page'.ucfirst($name);

    if (DEBUG)
      Debug::console('Page: '.$classname);

    if (BuizCore::classExists($classname)) {
      $this->controller = new $classname();
      $this->controllerName = $classname;
      //$this->controllerBase = $name;
      return true;
    } else {
      //Reset The Extention
      $this->controller = null;
      $this->controllerName = null;
      //\Reset The Extention

      // Create a Error Page
      $this->modulErrorPage
      (
        'Modul Error',
        I18n::s('The requested resource not exists' , 'wbf.message')
      );
      //\ Create a Error Page

      Error::addError
      (
        'Unbekannte Extension angefordert: '.$classname
      );

      return false;
    }

  } // end protected function setController */

}// end class Wbfpage_Module

