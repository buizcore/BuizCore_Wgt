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
 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class Desktop_Module extends MvcModule
{

  /**
   * create a new controller object by a given name
   *
   * @return void
   */
  protected function setController($name = null)
  {

    $request = $this->getRequest();

    if (!$name  )
      $name = $request->param('mex', Validator::CNAME);

    if (Log::$levelDebug)
      Debug::console('Desktop '.$name.' in Module ' .$this->modName);

    if (!$name)
      $name = $this->defaultControllerName;

    $classname = 'Desktop'.$this->modName.ucfirst($name);

    if (BuizCore::classExists($classname)) {
      $this->controller = new $classname();
    } else {

      // Create a Error Page
      $this->modulErrorPage
      (
        'Modul Error',
        I18n::s
        (
          'The requested resource not exists' ,
          'buiz.tpl.requestedResourceNotExists'
        )
      );
      //\ Create a Error Page

      Error::report
      (
        'Tried to load a non existing desktop: '.$classname
      );
    }

  } // end protected function setController  */

  /**
   * run the controller
   *
   * @return void
   */
  protected function runController()
  {

    $request = $this->getRequest();

    try {
      // no controller? asume init allready reported an error
      if (!$this->controller)
        return false;

      // Run the mainpart
      $method = 'run'.ucfirst($request->param('do', Validator::CNAME));

      if (!method_exists($this->controller, $method)) {
        $this->modulErrorPage
        (
          'Invalid Access',
          'Tried to access a nonexisting service'
        );

        return;
      }

      // Initialisieren der Extention
      if (!$this->controller->initDesktop())
        throw new Buiz_Exception('Failed to initialize Controller');

      $this->controller->$method();

      // shout down the extension
      $this->controller->shutdownDesktop();

    } catch (Exception $exc) {

      Error::report
      (
        I18n::s
        (
          'Module Error: '.$exc->getMessage(),
          'wbf.error.caughtModulError' ,
          array($exc->getMessage())
        ),
        $exc
      );

      $type = get_class($exc);

      if (Log::$levelDebug) {
        // Create a Error Page
        $this->modulErrorPage
        (
          $exc->getMessage(),
          '<pre>'.Debug::dumpToString($exc).'</pre>'
        );

      } else {
        switch ($type) {
          case 'Security_Exception':
          {
            $this->modulErrorPage
            (
              I18n::s('wbf.error.ModulActionDeniedTitle'),
              I18n::s('wbf.error.ModulActionDenied')
            );
            break;
          }
          default:
          {

            if (Log::$levelDebug) {
              $this->modulErrorPage
              (
                'Exception '.$type.' not catched ',
                Debug::dumpToString($exc)
              );
            } else {
              $this->modulErrorPage
              (
                I18n::s('Sorry Internal Error','wbf.error.ModulCaughtErrorTitle'),
                I18n::s('An Internal Error Occured','wbf.error.ModulCaughtError')
              );
            }

            break;
          }//end efault:

        }//end switch($type)

      }//end else

    }//end catch(Exception $exc)

  } // end protected function runController */

}// end class Desktop_Module

