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
class BuizTutorial_Controller extends Controller
{
/*////////////////////////////////////////////////////////////////////////////*/
// Parent Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  protected $defaultAction = 'index';

  protected $callAble = array
  (
  'index',
  'show'
  );

/*////////////////////////////////////////////////////////////////////////////*/
// Der Controller
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $action
   */
  public function run($action = null)
  {

    $this->show();

  }//end public function run($action = null)

/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function show()
  {

    $request = $this->getRequest();

    if (!$template = $request->param('page' , Validator::CNAME)) {
      $template = 'start';
    }

    View::$sendBody = true;

    $this->view->addVar('page' , $template  );
    $this->view->setTemplate('index' , 'tutorial');

  } // end public function show()

} // end class MexBuizBase

