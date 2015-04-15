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
class BuizSystem_Status_Modal_View extends LibViewModal
{

  public $width = 950;

  public $height = 650;

/*////////////////////////////////////////////////////////////////////////////*/
// form export methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param TFlag $params
  */
  public function displayInfo()
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l(
      'PHP Info',
      'wbf.label'
    );

    // set the window title
    $this->setTitle($i18nText);

    // set the window status text
    $this->setLabel($i18nText);

    // set the from template
    $this->setTemplate('buiz/system/status/modal/php_info', true);

    // kein fehler aufgetreten
    return null;

  }//end public function displayInfo */

 /**
  * @param TFlag $params
  */
  public function displayEnv()
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l(
      'SERVER ENV',
      'wbf.label'
    );

    // set the window title
    $this->setTitle($i18nText);

    // set the window status text
    $this->setLabel($i18nText);

    // set the from template
    $this->setTemplate('buiz/system/status/modal/php_server_env', true);

    // kein fehler aufgetreten
    return null;

  }//end public function displayEnv */

 /**
  * @param TFlag $params
  */
  public function displayServer()
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l(
      'SERVER Data',
      'wbf.label'
    );

    // set the window title
    $this->setTitle($i18nText);

    // set the window status text
    $this->setLabel($i18nText);

    // set the from template
    $this->setTemplate('buiz/system/status/modal/php_server_server', true);

    // kein fehler aufgetreten
    return null;

  }//end public function displayServer */

}//end class BuizSystem_Status_Modal_View

