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
class BuizCore_Docu_Explorer_Maintab_View extends LibViewMaintabCustom
{

  /**
   * @var BuizCore_Docu_Page_Model
   */
  public $model = null;

  /**
   */
  public $overflowY = 'auto';

/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   * @param TFlag $params
   * @return void
   */
  public function displayRoot($params)
  {

    $this->setLabel('Docu Root');
    $this->setTitle('Docu Root');

    $this->setTemplate('buiz/core/docu/explorer/maintab/root', true);

    $this->addVar('modules', $this->model->getModules());

    $this->addMenu($params);
    $this->injectActions($params);

  }//end public function displayRoot */

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

    $crumbs = array(
      array(
        'Dashboard',
        '',
        'fa fa-dashboard',
        null,
        'wgt-ui-desktop'
      ),
      array(
        'Menu',
        'maintab.php?c=Buiz.Navigation.explorer',
        'fa fa-sitemap',
        null,
        'wgt_tab-maintenance-menu'
      ),
      array(
        'Docu Root',
        'maintab.php?c=Buiz.Core_Docu_Explorer.root',
        'fa fa-file-alt',
        null,
        'wgt_tab-buiz-docu-explorer'
      ),
    );

    /*
    $path = [];
    foreach ($tmp as $cData) {
      $path[] = $cData;

      $crumb = array(
        SParserString::subToName($cData),
        'maintab.php?c=Buiz.Docu.page&page='.implode('-',$path),
        'fa fa-folder-o',
        null,
        'wgt_tab-buiz_docu_page'
      );

      $crumbs[] = $crumb;
    }*/


    // Setzen der Crumbs
    $this->crumbs->setCrumbs($crumbs);


    $menu = $this->newMenu($this->id.'_dropmenu');
    $menu->id = $this->id.'_dropmenu';

    $menu->content = <<<HTML

<div class="inline" >
  <button
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$menu->id}_dropmenu-control"
    data-drop-box="{$menu->id}_dropmenu"  ><i class="fa fa-reorder" ></i> {$this->i18n->l('Menu','wbf.label')} <i class="fa fa-angle-down" ></i></button>
</div>

<div class="wgt-dropdownbox" id="{$menu->id}_dropmenu" >
  <ul>
    <li>
      <a class="wgtac_bookmark" ><i class="fa fa-bookmark" ></i> {$this->i18n->l('Bookmark', 'wbf.label')}</a>
    </li>
  </ul>
  <ul>
    <li>
      <a class="wgtac_close" ><i class="fa fa-times" ></i>  {$this->i18n->l('Close', 'wbf.label')}</a>
    </li>
  </ul>
</div>

HTML;


  }//end public function buildMenu */

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
  public function injectActions($params)
  {

    // add the button action for save in the window
    // the code will be binded direct on a window object and is removed
    // on close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.getObject().find(".wgtac_close").click(function() {
      self.close();
    });

BUTTONJS;

    $this->addJsCode($code);

  }//end public function injectActions */

}//end class BuizCore_Docu_Menu_Maintab_View

