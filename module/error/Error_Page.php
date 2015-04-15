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
class Error_Page extends Controller
{

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

/**
   * Enter description here...
   *
   * @var String
   */
  protected $errorTitle = null;

  /**
   * Enter description here...
   *
   * @var String
   */
  protected $errorMessage = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Run Method
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * the controll function sends an error message to the user
   *
   * @param string $aktion
   * @return void
   */
  public function run($aktion = null)
  {

    $response = $this->getResponse();
    $view = $response->loadView('error-message', 'Error');

    $view->display($this->errorTitle, $this->errorMessage  );

    /*
    $this->view->setTemplate('error/message');

    $this->view->addVar
    (array
    (
      'errorTitle' => $this->errorTitle,
      'errorMessage' => $this->errorMessage
    ));
    */

  }//end public function run */

/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter Method
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Setter for title
   *
   * @param string $title
   */
  public function setErrorTitle($title)
  {

    $this->errorTitle = $title;
  }//end public function setErrorTitle */

  /**
   * setter for message
   *
   * @param string $message
   */
  public function setErrorMessage($message)
  {
    $this->errorMessage = $message;
  }//end public function setErrorMessage */

  /**
   *
   * @param unknown_type $message
   * @return void
   */
  public function displayError($type, $data = []  )
  {

    $this->$type($data);

  }

  /**
   *
   * Enter description here ...
   * @param unknown_type $data
   */
  public function displayException($data = [])
  {

    $response = $this->getResponse();

    $view = $response->loadView('error-message', 'Error','displayException', View::MODAL);
    $view->displayException($data[0]);

  }//end public function displayException */

  /**
   *
   * Enter description here ...
   * @param unknown_type $data
   */
  public function displayEnduserError($data = [])
  {

    $response = $this->getResponse();

    $view = $response->loadView('error-message', 'Error');
    $view->displayEnduserError($data[0]);

  }//end public function displayEnduserError */

} // end class Error_Controller
