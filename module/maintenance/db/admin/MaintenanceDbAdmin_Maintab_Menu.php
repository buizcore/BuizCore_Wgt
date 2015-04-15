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
class MaintenanceDbAdmin_Maintab_Menu extends WgtDropmenu
{
/*////////////////////////////////////////////////////////////////////////////*/
// menu: create
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * add a drop menu to the create window
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu($params)
  {

    // laden der mvc/utils adapter Objekte
    $acl = $this->getAcl();
    $view = $this->getView();


    $this->content = <<<HTML
<div class="wgt-panel-control" >
  <button
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}-control"
    data-drop-box="{$this->id}_dropmenu"  ><i class="fa fa-reorder" ></i> {$view->i18n->l('Menu','wbf.label')}</button>
  <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"mouseover","closeOnLeave":"true","align":"right"}</var>
</div>

<div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >
  <ul>
    <li>
      <a class="wgtac_bookmark" ><i class="fa fa-bookmark" ></i> {$view->i18n->l('Bookmark', 'wbf.label')}</a>
    </li>
    <li>
      <a class="wgtac_close" ><i class="fa fa-times" ></i> {$view->i18n->l('Close','wbf.label')}</a>
    </li>
  </ul>
</div>


HTML;

  }//end public function buildMenu */

 
    /**
    * this method is for adding the buttons in a create window
    * per default there is only one button added: save with the action
    * to save the window onclick
    *
    * @param TFlag $params the named parameter object that was created in
    *   the controller
    * {
    *   string formId: the id of the form;
    * }
    */
    public function addActions($params)
    {
  
        // add the button actions for create in the window
        // the code will be binded direct on a window object and is removed
        // on close
        // all buttons with the class save will call that action
        $code = <<<BUTTONJS
  
// close tab
self.getObject().find(".wgtac_close").click(function() {
  self.close();
});
  
BUTTONJS;
  
        $this->addJsCode($code);
  
    }//end public function addActions */


}//end class MaintenanceDbConsistency_Maintab_Menu

