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
class BuizBookmark_Model extends MvcModel
{

  /**
   * @param LibTemplate $view
   * @return void
   */
  public function desktop($view  )
  {

    $db = $this->getDb();

    $query = $db->newQuery('BuizBookmark');
    $query->fetch($this->getUser()->getId());

    $table = $view->newItem('widgetDesktopBookmark' , 'TableBuizBookmark');
    $table->setData($query);
    $table->setId('wbf_desktop_bookmark');

  }//end public function desktop */

} // end class BuizBookmark_Model

