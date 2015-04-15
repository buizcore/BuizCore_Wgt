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
class Error_Html_View extends LibViewAjax
{

    /**
     *
     */
    public function display($errorTitle,$errorMessage )
    {

        $this->setTemplate('error/default');
        $this->addVar('errorTitle', $errorTitle);
        $this->addVar('errorMessage', $errorMessage);
    
    
    }//end public function display */
    
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

} // end class Error_Html_View

