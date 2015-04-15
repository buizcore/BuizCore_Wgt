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
class Error_Modal_View extends LibViewModal
{

  /**
   *
   */
  public function displayException($exception)
  {

    $this->setTemplate('error/display_exception');

    $this->addVar('exception', $exception);

  }//end public function displayException */

  /**
   *
   */
  public function displayEnduserError($exception)
  {

    $this->setTemplate('error/display_exception');

    $this->addVar('exception', $exception);

  }//end public function displayEnduserError */

} // end class Error_Subwindow_View

