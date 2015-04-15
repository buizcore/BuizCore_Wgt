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
class BuizError_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * list with all callable methodes in this subcontroller
   *
   * @var array
   */
  protected $callAble = array
  (
    'lastphperror'
  );

  /**
   * Name of the default action
   *
   * @var string
   */
  protected $defaultAction = 'lastphperror';

/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function lastPhpError()
  {

    if (!$this->view->isType(View::SUBWINDOW)) {
      $this->invalidRequest();

      return false;
    }

    $view = $this->view->newWindow('BuizLastError', 'Default');
    $view->setTitle('Last PHP Error');

    $view->setTemplate('error/last_error');
    $view->addVar('errorData' , file_get_contents(PATH_GW.'log/first_log.html'));

  }//end public function lastPhpError */

}//end class ControllerBuizEditor

