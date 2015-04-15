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
class MaintenanceDb_Index_Search_Maintab_View extends LibViewMaintabCustom
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
  public function displayForm($params)
  {

    // laden der mvc/utils adapter Objekte
    $request = $this->getRequest();

    $i18nLabel = $this->i18n->l
    (
      'Index Search',
      'wbf.label'
    );

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle($i18nLabel);
    $this->setLabel($i18nLabel  );

    // set the form template
    $this->setTemplate('maintenance/db/index/maintab/search_form', true);

    // Setzen von Viewspezifischen Control Flags
    $params->viewType = 'maintab';
    $params->viewId = $this->getId();

    // Menü und Javascript Logik erstellen
    $this->addMenu($params);
    $this->addActions($params);

    // kein fehler aufgetreten? bestens also geben wir auch keinen zurück
    return null;

  }//end public function displayForm */

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
    $view = $this->getView();

    $iconMenu = '<i class="fa fa-reorder" ></i>';
    $iconRebuild = $view->icon( 'maintenance/rebuild_index.png', 'Rebuild Index');
    $iconClose = '<i class="fa fa-times " ></i>';

    $entries = new TArray;
    $entries->support = $this->entriesSupport($params);

    $menu = $this->newMenu($this->id.'_dropmenu');
    $menu->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}" >
  <li class="wgt-root" >
    <button class="wcm wcm_ui_button" ><i class="fa fa-reorder" ></i> {$view->i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
      <li>
        <p class="wgtac_bookmark" ><i class="fa fa-bookmark" ></i> {$view->i18n->l('Bookmark','wbf.label')}</p>
      </li>
{$entries->custom}
{$entries->support}
      <li>
        <p class="wgtac_close" ><i class="fa fa-times" ></i> {$view->i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>

  <li class="wgt-root" >
  <form
    method="get"
    id="wgt-form-maintenance-db_index-search"
    action="ajax.php?c=Maintenance.Db_Index.search" />

    <input
      type="text"
      class="wcm wcm_req_search wgt-no-save fparam-wgt-form-maintenance-db_index-search xxlarge"
      name="key"
      id="wgt-input-maintenance-db_index-search" />
    <button class="wgt-button append" id="wgt-button-buiz_navigation_search">Search <i class="fa fa-search" ></i></button>
    <ul style="margin-top:-10px;" >
    </ul>
  </li>

{$entries->customButton}
</ul>
HTML;

  }//end public function buildMenu */

  /**
   * @param TArray $params
   */
  protected function entriesSupport($params)
  {

    $html = <<<HTML

      <li>
        <p><i class="fa fa-question-sign" ></i> {$this->i18n->l('Support','wbf.label')}</p>
        <ul>
          <li><a class="wcm wcm_req_ajax" href="modal.php?c=Buiz.Docu.open&amp;key=buiz_message-create" ><i class="fa fa-info-circle" ></i> {$this->i18n->l('Help','wbf.label')}</a></li>
            <li><a class="wcm wcm_req_ajax" href="modal.php?c=Buiz.Faq.create&amp;context=create" ><i class="fa fa-question" ></i> {$this->i18n->l('FAQ','wbf.label')}</a></li>
        </ul>
      </li>

HTML;

    return $html;

  }//end public function entriesSupport */

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

self.getObject().find(".wgtac_search").click(function() {
  \$R.form('ajax.php?c=Maintenance.Db_Index.search');
});

BUTTONJS;

    $this->addJsCode($code);

  }//end public function addActions */

}//end class MaintenanceDb_Index_Stats_Maintab_View

