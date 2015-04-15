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
class BuizComment_Modal_View extends LibViewModal
{

  /**
   * Die Breite des Modal Elements
   * @var int in px
   */
  public $width = 450 ;

  /**
   * Die Höhe des Modal Elements
   * @var int in px
   */
  public $height = 380 ;

/*////////////////////////////////////////////////////////////////////////////*/
// Display Methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * the default edit form
  * @param TFlag $params
  * @return boolean
  */
  public function displayDialog($params)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Know How Ref';

    // set the window title
    $this->setTitle($i18nText);

    // set the window status text
    $this->setLabel($i18nText);

    // set the from template
    $this->setTemplate('buiz/knowhow_node/modal/dialog');


    $this->addVar('context', 'protocol');

    // ok kein fehler aufgetreten
    return null;

  }//end public function displayDialog */

}//end class BuizComment_Modal_View

