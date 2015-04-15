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
class BuizTaskPlanner_Calendar_Maintab_View extends LibViewMaintab
{

  public $cacheDirs = [];

/*////////////////////////////////////////////////////////////////////////////*/
// form export methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param TFlag $params
  */
  public function displayStats($params)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      'Cache Statistics',
      'wbf.label'
    );

    // set the window title
    $this->setTitle($i18nText);

    // set the window status text
    $this->setLabel($i18nText);

    $this->cacheDirs = $this->model->getTasks();

    // set the from template
    $this->setTemplate('buiz/cache/stats', true);

    $this->addMenu($params);
    $this->addActions($params);

    // kein fehler aufgetreten
    return null;

  }//end public function displayStats */

/*////////////////////////////////////////////////////////////////////////////*/
// protocol for entities
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
  public function addMenu($params)
  {

    $i18n = $this->getI18n();


    $menu = $this->newMenu($this->id.'_dropmenu');
    $menu->content = <<<HTML

<div class="wgt-panel-control" >
  <button
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}-control"
    data-drop-box="{$this->id}_dropmenu"  ><i class="fa fa-reorder" ></i> {$this->i18n->l('Menu','wbf.label')} <i class="fa fa-chevron-down" ></i></button>
  <var id="{$this->id}-control-cfg-dropmenu"  >{"triggerEvent":"mouseover","closeOnLeave":"true","align":"right"}</var>
</div>

<div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >
  <ul>
    <li>
      <a class="wgtac_bookmark" ><i class="fa fa-bookmark" ></i> {$this->i18n->l('Bookmark', 'wbf.label')}</a>
    </li>
  </ul>
  <ul>
    <li>
      <a class="deeplink" ><i class="fa fa-question-sign" ></i> {$this->i18n->l('Support', 'wbf.label')}</a>
      <span>
      <ul>
        <li><a class="wcm wcm_req_ajax" href="modal.php?c=Buiz.Faq.create&amp;context=menu" ><i class="fa fa-question" ></i> {$this->i18n->l('Faq', 'wbf.label')}</a></li>
      </ul>
      </span>
    </li>
    <li>
      <a class="wgtac_close" ><i class="fa fa-times" ></i> {$this->i18n->l('Close','wbf.label')}</a>
    </li>
  </ul>
</div>

<div class="wgt-panel-control" >
  <button
      class="wcm wcm_ui_button wgtac_refresh wcm_ui_tip-top"
      title="Refresh view" ><i class="fa fa-refresh" ></i> {$this->i18n->l('Refresh','wbf.label')}</button>
</div>

<div class="wgt-panel-control" >
  <button
      class="wcm wcm_ui_button wgtac_clean_cache wcm_ui_tip-top"
      title="Clean the full cache" ><i class="fa fa-eraser" ></i> {$this->i18n->l('Clean all','wbf.label')}</button>
</div>

HTML;

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

self.getObject().find(".wgtac_clean_cache").click(function() {
  \$R.del('ajax.php?c=Buiz.Cache.cleanAll');
});

self.getObject().find(".wgtac_refresh").click(function() {
  self.close();
  \$R.get('maintab.php?c=Buiz.Cache.stats');
});

// close tab
self.getObject().find(".wgtac_close").click(function() {
  self.close();
});

BUTTONJS;

    $this->addJsCode($code);

  }//end public function addActions */

  /**
   *
   * Enter description here ...
   * @param unknown_type $cDir
   */
  protected function renderDisplay($cDir)
  {

    $code = [];

    if (isset($cDir->display)) {
      foreach ($cDir->display as $action) {
        switch ($action) {
          case 'created':
          {
            $code[] = "Updated: ".SFilesystem::timeChanged(PATH_GW.'cache/'.$cDir->dir);
            break;
          }
          case 'size':
          {
            $code[] = "Size: ".SFilesystem::getFolderSize(PATH_GW.'cache/'.$cDir->dir);
            break;
          }
          case 'num_files':
          {
            $code[] = "Files: ".SFilesystem::countFiles(PATH_GW.'cache/'.$cDir->dir);
            break;
          }
        }
      }
    }

    return implode('<br />', $code);
  }

  /**
   * @param unknown_type $cDir
   */
  protected function renderActions($cDir)
  {

    $code = [];

    if (isset($cDir->actions)) {
      foreach ($cDir->actions as $action) {
        switch ($action->type) {
          case 'request':
          {
            $code[] = <<<CODE

<button
  class="wgt-button"
  onclick="\$R.{$action->method}('{$action->service}');" >{$action->label}</button>

CODE;
            break;
          }
        }
      }
    }

    return implode('<br />', $code);

  }//end renderActions */

}//end class MaintenanceCache_Maintab_View

