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
class BuizMaintenance_Metadata_List_Menu extends WgtSimpleListmenu
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  public $listActions = <<<JSON
[
  {
    "type" : "request",
    "label": "",
    "icon": "fa fa-times",
    "method": "del",
    "service": "ajax.php?c=Buiz.TaskPlanner.deletePlan&objid="
  }
]
JSON;

}//end class BuizTaskPlanner_List_Ajax_View

