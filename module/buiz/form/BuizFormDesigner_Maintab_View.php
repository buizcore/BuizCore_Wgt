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
class BuizFormDesigner_Maintab_View extends LibViewMaintabTabbed
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

    /**
     * Flag was mit nicht passenden inhalt passieren soll.
     * Bei Grids brauchen wir z.B Hidden
     * @var string
     */
    public $overflowY = 'auto';
    
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
  <button class="wgt-button wgtac_search" ><i class="fa fa-search" ></i> {$this->i18n->l('Search','wbf.label')}</button>
      
      
      
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
                'Form Designer',
                'maintab.php?c=Buiz.FormDesigner.list',
                'fa fa-list',
                null,
                'wgt_tab-'.$this->getIdKey()
            ),
            array(
                'New Form',
                'maintab.php?c=Buiz.FormDesigner.create',
                'fa fa-list-alt',
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
        <li><a data-key="text" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-terminal" ></i> Textfeld</a></li>
        <li><a data-key="textarea" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-align-left" ></i> Text</a></li>
        <li><a data-key="checkboxes" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-square-o" ></i> Checkboxes</a></li>
        <li><a data-key="radios" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-circle-blank" ></i> Radios</a></li>
        <li><a data-key="range" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-resize-horizontal" ></i> Range</a></li>
        <li><a data-key="money" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-eur" ></i> Money</a></li>
        <li><a data-key="matrix" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-th" ></i> Matrix</a></li>
        <li><a data-key="list" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-list" ></i> List</a></li>
        <li><a data-key="file" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-file-alt" ></i> File / Document</a></li>
        <li><a data-key="image" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-picture" ></i> Image</a></li>
        <li><a data-key="photo" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-camera" ></i> Photo</a></li>
        <li><a data-key="date" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-calendar" ></i> Date</a></li>
        <li><a data-key="rating" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-star-half-empty" ></i> Rating</a></li>
        <li><a data-key="location" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-map-marker" ></i> Location</a></li>
        <li><a data-key="address" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-credit-card" ></i> Address</a></li>
    </ul>
</div>
      

HTML;
      
      $this->tabs[] = $tab1;
  
  }//end public function buildTabs */

}//end class BuizFormDesigner_Maintab_View

