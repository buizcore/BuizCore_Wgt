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
class BuizContact_List_Menu extends WgtMenuBuilder_SplitButton
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/
  
  public function setup()
  {
    
    $this->buttons = array(
      'edit' => array(
        Wgt::ACTION_BUTTON_GET,
        'Edit',
        'maintab.php?c=Buiz.Contact.edit&amp;objid=',
        'fa fa-edit',
        '',
        'wbf.label',
        Acl::UPDATE
      ),
      'message' => array(
        Wgt::ACTION_BUTTON_GET,
        'Contact',
        'modal.php?c=Buiz.Contact.contactForm&amp;objid=',
        'fa fa-envelope',
        '',
        'wbf.label',
        Acl::LISTING
      ),
      'delete' => array(
        Wgt::ACTION_DELETE,
        'Delete',
        'index.php?c=Buiz.Contact.delete&amp;objid=',
        'fa fa-times',
        '',
        'wbf.label',
        Acl::DELETE
      ),
      'sep' => array(
        Wgt::ACTION_SEP
      ),
    
    );
    
    $this->actions = array(
      'edit',
      'message',
      'sep',
      'delete'
    );
    
  }//end public function setup */


}//end class BuizContact_List_Menu

