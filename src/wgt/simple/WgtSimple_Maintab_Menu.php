<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH
* @project     : BuizCore - The Business Core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package net.buizcore.wgt
 */
class WgtSimple_Maintab_Menu extends WgtDropmenu
{


  /**
   * @param TArray $params
   */
  public function buildMenu($params)
  {

    // laden der mvc/utils adapter Objekte
    $acl = $this->getAcl();
    $view = $this->getView();
    $user = $this->getUser();
    $access = $params->access;

    $this->content = <<<HTML

  <div class="wgt-panel-control" >
    <button
      class="wcm wcm_control_dropmenu wgt-button"
      id="{$this->id}-control"
      data-drop-box="{$this->id}"  ><i class="fa fa-reorder" ></i> {$this->view->i18n->l('Menu','wbf.label')} <i class="fa fa-angle-down" ></i></button>
      <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"click"}</var>
  </div>

  <div class="wgt-dropdownbox" id="{$this->id}" >

    <ul>
      <li>
        <a class="wgtac_close" ><i class="fa fa-times" ></i> {$this->view->i18n->l('Close', 'wbf.label')}</a>
      </li>
    </ul>


</div>
HTML;



  }//end public function buildMenu */

}//end class WgtMenuSimpleDropdown

