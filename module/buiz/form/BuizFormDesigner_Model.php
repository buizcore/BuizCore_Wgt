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
class BuizFormDesigner_Model extends LibViewMaintabTabbed
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayForm( $params)
  {

    $this->setLabel('Form Designer');
    $this->setTitle('Form Designer');

    $this->setTemplate('buiz/form/maintab/form', true);

    $this->addMenu($params);

  }//end public function displayCreate */

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($params)
  {

    $menu = $this->newMenu($this->id.'_dropmenu');

    $menu->id = $this->id.'_dropmenu';

    $menu->content = <<<HTML

<div class="wgt-panel-control" >
  <button class="wgt-button wgtac_save" ><i class="fa fa-save" ></i> {$this->i18n->l('Save','wbf.label')}</button>
</div>


HTML;
    


    $this->buildCrumbs($menu, $params);
    $this->buildTabs($menu, $params);
    $this->injectActions($menu, $params);

  }//end public function addMenu */

  /**
   * just add the code for the edit ui controls
   *
   * @param int $objid die rowid des zu editierende Datensatzes
   * @param TFlag $params benamte parameter
   * {
   *   @param LibAclContainer access: der container mit den zugriffsrechten für
   *     die aktuelle maske
   *
   *   @param string formId: die html id der form zum ansprechen des update
   *     services
   * }
   */
  public function injectActions($menu, $params)
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    // close tab
    self.getObject().find(".wgtac_close").click(function() {
      \$S('#{$this->id}_dropmenu-control').dropdown('remove');
      self.close();
    });

    self.getObject().find(".wgtac_search").click(function() {
      \$R.form('wgt-search-form-dataix');
    });

BUTTONJS;

    $this->addJsCode($code);

  }//end public function injectActions */
  
  /**
   * @param WgtDropmenu $menu
   * @param Context $params
   */
  public function buildCrumbs($menu, $params)
  {
  
    $this->crumbs->setCrumbs(
        array(
            array(
                'Dashboard',
                '',
                'fa fa-dashboard',
                null,
                'wgt-ui-desktop'
            ),
            array(
                'Search',
                'maintab.php?c=Maintab.Search.form',
                'fa fa-list',
                'active',
                'wgt_tab-'.$this->getIdKey()
            )
        )
    );
  
  }//end public function buildCrumbs */
  

  /**
   * @param WgtDropmenu $menu
   * @param Context $params
   */
  public function buildTabs($menu, $params)
  {
  
      $tab1 = new WgtTabHead();
      $tab1->key = 'designer';
      $tab1->label = 'Designer';
      $tab1->content = <<<HTML

<div class="link-list" >
    <h4>Form designer</h4>
    <ul>
        <li><a><i class="fa fa-terminal" ></i> Textfeld</a></li>
    </ul>
</div>
      

HTML;
      
      $this->tabs[] = $tab1;
  
  }//end public function buildTabs */

}//end class BuizFormDesigner_Maintab_View

