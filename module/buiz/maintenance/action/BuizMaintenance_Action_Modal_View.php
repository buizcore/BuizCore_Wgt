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
class BuizMaintenance_Action_Modal_View extends LibViewModal
{

  /**
   * Die Breite des Modal Elements
   * @var int in px
   */
  public $width = 600 ;

  /**
   * Die Höhe des Modal Elements
   * @var int in px
   */
  public $height = 300 ;

/*////////////////////////////////////////////////////////////////////////////*/
// Display Methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * the default edit form
  * @param BuizMaintenanceAction_Entity $actionNode
  * @return void
  */
  public function displayExec($actionNode)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Execute Action';

    // set the window title
    $this->setTitle($i18nText);

    // set the from template
    $this->setTemplate('buiz/maintenance/action/modal/exec', true);

    if (!BuizCore::classLoadable($actionNode->cl_name) ){
      throw new ClassNotFound_Exception($actionNode->cl_name);
    }
    
    $actionRunner = new $actionNode->cl_name();
    
    if (!method_exists($actionRunner, $actionNode->me_name)) {
      throw new MethodNotExists_Exception($actionRunner, $actionNode->me_name);
    }
    
    $message = $actionRunner->{$actionNode->me_name}();
    $this->addVar('message', $message);
    
  }//end public function displayExec */



}//end class BuizMaintenance_Action_Modal_View

