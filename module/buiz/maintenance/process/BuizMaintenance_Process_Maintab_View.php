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
class BuizMaintenance_Process_Maintab_View extends LibViewMaintabList
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * @var BuizMaintenance_Process_Model
    */
    public $model = null;

    /**
     * @var array
     */
    public $processes = null;

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
  public function displayList()
  {

    $i18nLabel = $this->i18n->l
    (
      'Process Manager',
      'wbf.label'
    );

    // Setzen des Labels und des Titles, sowie diverser Steuerinformationen
    $this->setTitle($i18nLabel);
    $this->setLabel($i18nLabel);

    // set the form template
    $this->setTemplate('buiz/maintenance/process/maintab/list_processes', true);

    $this->processes = $this->model->getProcesses();

    // Menü und Javascript Logik erstellen
    $this->addMenu();
    $this->addActions();
    $this->addListActions();

    // kein fehler aufgetreten? bestens also geben wir auch keinen zurück
    return null;

  }//end public function displayShow */

  /**
   * add a drop menu to the create window
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu()
  {

    // laden der mvc/utils adapter Objekte
    $acl = $this->getAcl();

    $menu = $this->newMenu($this->id.'_dropmenu');
    $menu->id = $this->id.'_dropmenu';
    $menu->setAcl($acl);
    $menu->setModel($this->model);

    $i18n = $this->getI18n();
    $iconMenu = '<i class="fa fa-reorder" ></i>';
    $iconClose = '<i class="fa fa-times " ></i>';

    $entries = new TArray;
    $entries->support = $this->entriesSupport( $menu);

    $menu->content = <<<HTML

  <div class="inline" >
    <button
      class="wcm wcm_control_dropmenu wgt-button"
      tabindex="-1"
      id="{$menu->id}-control"
      data-drop-box="{$menu->id}"  ><i class="fa fa-reorder" ></i> {$i18n->l('Menu','wbf.label')}</button>
      <var id="{$menu->id}-control-cfg-dropmenu"  >{"triggerEvent":"click"}</var>
  </div>

  <div class="wgt-dropdownbox" id="{$menu->id}" >
    <ul>
      <li>
        <a class="wgtac_bookmark" ><i class="fa fa-bookmark" ></i> {$i18n->l('Bookmark','wbf.label')}</a>
      </li>
    {$entries->support}
      <li>
        <a class="wgtac_close" ><i class="fa fa-times" ></i> {$i18n->l('Close', 'wbf.label')}</a>
      </li>
    </ul>
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
        <a class="deeplink" ><i class="fa fa-question-sign" ></i> {$this->i18n->l('Support','wbf.label')}</a>
        <span>
          <ul>
            <li><a
              class="wcm wcm_req_ajax"
              href="modal.php?c=Buiz.Docu.open&amp;key=buiz_message-create" ><i class="fa fa-info-circle" ></i> {$this->i18n->l('Help','wbf.label')}</a></li>
            <li><a
              class="wcm wcm_req_ajax"
              href="modal.php?c=Buiz.Faq.create&amp;context=create" ><i class="fa fa-question" ></i> {$this->i18n->l('FAQ','wbf.label')}</a></li>
          </ul>
        </span>
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
  public function addActions()
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
  public function addListActions()
  {

    // "label": "Change",

    $code = <<<BUTTONJS
[
  {
    "type" : "request",
    "method": "get",
    "service": "modal.php?c=Buiz.Maintenance_Process.formSwitchStatus&process_id",
    "icon" : "control/change.png",
    "params" : {
      "dkey": "entity_name"
    }
  }
]
BUTTONJS;

    $this->listActions = json_decode($code);

  }//end public function addActions */

}//end class BuizMaintenance_DataIndex_Maintab_View

