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
class BuizBase_Maintab_View extends LibViewMaintab
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  public $crumbs = '';

  /**
   * Wenn true wird der close button rechts oben nicht mit generiert
   * @var boolean
   */
  public $closeCustom = true;

  /**
   * @param string $menuName
   * @return void
   */
  public function displayMenu($menuName, $params  )
  {

    $this->setTemplate('buiz/navigation/maintab/modmenu'  );

    $className = 'ElementMenu'.ucfirst($params->menuType) ;

    $modMenu = $this->newItem('modMenu', $className);

    $menuData = DaoFoldermenu::get('buiz/'.$menuName, true);
    $modMenu->setData(
      $menuData,
      'maintab.php'
    );
    
    $this->crumbs->setCrumbs($modMenu->getCrumbs());
    
    //$this->crumbs = $modMenu->buildCrumbs();

    if ($modMenu->title  )
      $this->setTitle($menuData->title);
    else
      $this->setTitle('Buiz Menu');

    if ($modMenu->label  )
      $this->setLabel($menuData->label);
    else
      $this->setLabel('Buiz Menu');

    $params = new TArray;
    $this->addMenu($params);
    $this->addActions($params);

  }//end public function displayMenu */

  /**
   * add a drop menu to the create window
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($params)
  {

    // laden der mvc/utils adapter Objekte
    $acl = $this->getAcl();
    $user = $this->getUser();
    $access = $params->access;

    $entries = new TArray;

    $menu = $this->newMenu(
      $this->id.'_dropmenu'
    );
    $menu->id = $this->id.'_dropmenu';

    $menu->content = <<<HTML

  <div class="inline" >
    <button
      class="wcm wcm_control_dropmenu wgt-button"
      id="{$menu->id}-control"
      data-drop-box="{$menu->id}"  ><i class="fa fa-reorder" ></i> {$this->i18n->l('Menu','wbf.label')} <i class="fa fa-angle-down" ></i></button>
      <var id="{$menu->id}-control-cfg-dropmenu"  >{"triggerEvent":"click"}</var>
  </div>

  <div class="wgt-dropdownbox" id="{$menu->id}" >

    <ul>
{$entries->support}
    </ul>
    <ul>
      <li>
        <a class="wgtac_close" ><i class="fa fa-times" ></i> {$this->i18n->l('Close', 'wbf.label')}</a>
      </li>
    </ul>

  </div>

HTML;

    $menu->content .= <<<HTML

<div class="right" >
  &nbsp;&nbsp;&nbsp;
  <button
    class="wcm wcm_ui_tip-left wgt-button wgtac_close"
    tabindex="-1"
    tooltip="Close the active tab"  ><i class="fa fa-times" ></i></button>
</div>

<div class="right" >
  <input
    type="text"
    id="wgt-input-buiz_navigation_search-tostring"
    name="key"
    class="large wcm wcm_ui_autocomplete wgt-ignore"  />
  <var class="wgt-settings" >{
      "url"  : "ajax.php?c=Buiz.Navigation.search&amp;key=",
      "type" : "ajax"
    }</var>
  <button
    id="wgt-button-buiz_navigation_search"
    tabindex="-1"
    class="wgt-button append" >
    <i class="fa fa-search" ></i>
  </button>

</div>


HTML;

  }//end public function addMenu */



  /**
   * @param TArray $params
   */
  protected function entriesSupport($menu)
  {

    $html = <<<HTML

      <li>
        <a class="deeplink" ><i class="fa fa-info-circle" ></i> {$this->i18n->l('Support','wbf.label')}</a>
        <span>
          <ul>
            <li><a
              class="wcm wcm_req_ajax"
              href="modal.php?c=Buiz.Docu.open&amp;key=buiz_message-create" ><i class="fa fa-info-circle" ></i> {$this->i18n->l('Help','wbf.label')}</a></li>
          </ul>
        </span>
      </li>

HTML;

    return $html;

  }//end public function entriesSupport */



}//end class BuizNavigation_Maintab

