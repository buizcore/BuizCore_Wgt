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
class MaintenanceDbConsistency_Maintab_View extends LibViewMaintabCustom
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * @var MyMessage_Crud_Model
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
  public function display($params)
  {

    // laden der mvc/utils adapter Objekte
    $request = $this->getRequest();

    // I18n Label und Titel Laden
    $i18nLabel = $this->i18n->l
    (
      'Database Consistency',
      'pontos.label'
    );

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle($i18nLabel);
    $this->setLabel($i18nLabel  );
    //$this->setTabId('wgt-tab-form-my_message-create');

    // set the form template
    $this->setTemplate('maintenance/db/consistency/list', true);

    $extensionLoader = new ExtensionLoader('fix_db');
    $this->addVar('extensions', $extensionLoader);

    // Setzen von Viewspezifischen Control Flags
    $params->viewType = 'maintab';
    $params->viewId = $this->getId();

    // Setzen der letzten metadaten
    $this->addVar('params', $params);
    $this->addVar('context', 'list');

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

    $menu = $this->newMenu
    (
      $this->id.'_dropmenu',
      'MaintenanceDbConsistency'
    );
    $menu->id = $this->id.'_dropmenu';
    $menu->setAcl($this->getAcl());
    $menu->setModel($this->model);

    $menu->buildMenu($params);

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

self.getObject().find(".wgtac_run_all").click(function() {
  \$R.get('ajax.php?c=Maintenance.DbConsistency.fixAll');
});

// close tab
self.getObject().find(".wgtac_close").click(function() {
  self.close();
});

BUTTONJS;

    $this->addJsCode($code);

  }//end public function addActions */

}//end class BuizMessage_Crud_Create_Maintab_View

