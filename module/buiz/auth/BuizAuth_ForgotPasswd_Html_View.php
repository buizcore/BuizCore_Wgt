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
class BuizAuth_ForgotPasswd_Html_View extends LibTemplateHtmlView
{

  public function init()
  {
    $this->setIndex('public/plain');
  }

  /**
   *
   */
  public function displayError($errorMessage)
  {
    $this->addVar('error', $errorMessage);
    $this->setTemplate('buiz/auth/form_forgot_pwd', true  );

  }//end public function displayError */

  /**
   * @param string $message
   */
  public function displaySuccess($message)
  {

    $this->addVar('message', $message);
    $this->setTemplate('buiz/auth/success', true  );

  }//end public function displaySucess */

} // end class BuizAuth_ForgotPasswd_Html_View

