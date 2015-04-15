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
class BuizMessage_Modal_View extends LibViewModal
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $menuName
   * @return void
   */
  public function displayMessageForm($menuName , $params)
  {

    $this->setStatus('Explorer');
    $this->setTitle('Explorer');

    $this->setTemplate('buiz/modmenu'  );

    $modMenu = $this->newItem('modMenu', 'WgtElementMenuExplorer');
    $modMenu->setData(DaoFoldermenu::get('buiz/root',true));

  }//end public function display */

}//end class BuizMessage_Modal_View

