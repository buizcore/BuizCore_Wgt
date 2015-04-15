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
class MaintenanceDb_Index_Stats_Maintab_View extends LibViewMaintabCustom
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * @var MaintenanceDb_Index
    */
    public $model = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * Methode zum befüllen des BuizMessage Create Forms
  * mit Inputelementen
  *
  * Zusätzlich werden soweit vorhanden dynamische Texte geladen
  *
  * @param TFlag $params
  * @return Error im Fehlerfall sonst null
  */
  public function displayStats($params)
  {

    // laden der mvc/utils adapter Objekte
    $request = $this->getRequest();

    $i18nLabel = $this->i18n->l(
      'Data Index Stats',
      'wbf.label'
    );

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle($i18nLabel);
    $this->setLabel($i18nLabel  );

    $this->addVar('modules', $this->model->getModules());
    $this->addVar('stats', $this->model->getStats());

    // set the form template
    $this->setTemplate('maintenance/db/index/maintab/stats', true);

    // Setzen von Viewspezifischen Control Flags
    $params->viewType = 'maintab';
    $params->viewId = $this->getId();

    // Menü und Javascript Logik erstellen
    $this->addMenu($params);
    $this->addActions($params);

    // kein fehler aufgetreten? bestens also geben wir auch keinen zurück
    return null;

  }//end public function displayStats */

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

    $menu = $this->newMenu
    (
      $this->id.'_dropmenu',
      'MaintenanceDb_Index_Stats'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->setAcl($this->getAcl());
    $menu->setModel($this->model);

    $menu->buildMenu($params);

    // Setzen der Crumbs
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
          'Menu',
          'maintab.php?c=Buiz.Navigation.explorer',
          'fa fa-sitemap',
          null,
          'wgt_tab-maintenance-menu'
        ),
        array(
          'System',
          'maintab.php?c=Buiz.Base.menu&amp;menu=maintenance',
          'fa fa-folder-o',
          null,
          'wgt_tab-maintenance-menu'
        ),
        array(
          'System Status',
          'maintab.php?c=Maintenance.Db_Index.stats',
          'fa fa-cog',
          'active',
          'wgt_tab-buiz-maintenance-data_index-stats'
        )
      )
    );

    return true;

  }//end public function addMenu */

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

self.getObject().find(".wgtac_recreate").click(function() {
  \$R.put('ajax.php?c=Maintenance.Db_Index.recalcAll',{});
});

self.getObject().find(".wgtac_search_form").click(function() {
  \$R.get('maintab.php?c=Maintenance.Db_Index.searchForm');
});


BUTTONJS;

    $this->addJsCode($code);

  }//end public function addActions */

}//end class MaintenanceDb_Index_Stats_Maintab_View

