<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
* @projectUrl  : http://buizcore.com
*
* @licence     : Conias
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/


/**
 * @package com.buizcore.conias
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class ImportGeneric_Maintab_View extends LibViewMaintabTabbed
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $menuName
   * @return void
   */
  public function displayMask()
  {

    $this->setLabel('Import');
    $this->setTitle('Import');
    $this->overflowY = 'auto';

    $this->setTemplate('import/generic/maintab/mask',true);


    $this->addMenuByKey('ImportGeneric');

  }//end public function displayMask */



}//end class ImportGeneric_Maintab_View

