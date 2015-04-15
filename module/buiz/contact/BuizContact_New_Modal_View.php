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
class BuizContact_New_Modal_View extends LibViewModal
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  public $width = 830;

  public $height = 600;

  /**
   * @param string $menuName
   * @return void
   */
  public function displayNew($params)
  {

    $this->setStatus('Create Contact');
    $this->setTitle('Create Contact');

    $this->setTemplate('buiz/contact/tpl/form_new', true  );


  }//end public function displayNew */

}//end class BuizContact_New_Modal_View

