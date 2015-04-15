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
class BuizMessage_List_Maintab_View extends LibViewMaintab
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param BuizMessage_Table_Search_Request $params
   * @return void
   */
  public function displayList($params)
  {

    $this->setLabel('My Communications &amp; Tasks');
    $this->setTitle('My Communications &amp; Tasks');

    //$this->addVar('node', $this->model->node);

    // laden der mvc/utils adapter Objekte
    $user = $this->getUser();
    $acl = $this->getAcl();
    $request = $this->getRequest();

    $access = $params->access;

    $params->qsize = 50;

    // die query muss für das paging und eine korrekte anzeige
    // die anzahl der gefundenen datensätze ermitteln
    $params->loadFullSize = true;

    $params->searchFormId = 'wgt-form-buiz-groupware-search';

    $this->addVar('settings', $params->settings);

    $data = $this->model->fetchMessages($params);

    $table = new BuizMessage_Table_Element('messageList', $this);
    $table->setId('wgt-table-buiz-groupware_message');
    $table->access = $params->access;

    $table->setData($data);
    $table->addAttributes(array(
      'style' => 'width:99%;'
    ));

    $table->setPagingId($params->searchFormId);


    $table->buildHtml();

    // Über Listenelemente können Eigene Panelcontainer gepackt werden
    // hier verwenden wir ein einfaches Standardpanel mit Titel und
    // simplem Suchfeld
    $tabPanel = new WgtPanelTable($table);

    //$tabPanel->title = $view->i18n->l('Tasks', 'project.task.label');
    //$tabPanel->searchKey = 'project_task';

    // display the toggle button for the extended search
    //$tabPanel->advancedSearch = true;

    // search element im maintab
    /* @var $searchElement WgtPanelElementSearch_Overlay */
    $searchElement = $this->setSearchElement(new WgtPanelElementSearch_Overlay($table));
    $searchElement->searchKey = 'my_message';
    $searchElement->searchFieldSize = 'xlarge';
    //$searchElement->advancedSearch = true;
    $searchElement->focus = true;


    $searchElement->setSearchFields($params->searchFields);

    // Ein Panel für die Filter hinzufügen
    // Die Filteroptionen befinden sich im Panel
    // Die UI Klasse wird als Environment übergeben
    $filterSubPanel = new BuizMessage_List_SubPanel_Filter($this);

    // Search Form wird benötigt um die Filter an das passende Suchformular zu
    // binden
    $filterSubPanel->setSearchForm($params->searchFormId);



    // Setzen der Filterzustände, werden aus der URL ausgelesen
    $filterSubPanel->setFilterStatus($params->settings);

    // Access wird im Panel als Rechte Container verwendet
    $filterSubPanel->setAccess($access);
    $filterSubPanel->searchKey = $searchElement->searchKey;

    // Jetzt wird das SubPanel in den Suchen Splittbutton integriert
    $searchElement->setFilter($filterSubPanel);


    // templates

    $this->setTemplate('buiz/message/maintab/list', true);

    $this->addMenu($params);

  }//end public function displayList */

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

    $iconLtChat = $this->icon('groupware/group_chat.png'      ,'Chat');
    $iconLtFull = $this->icon('groupware/group_full.png'      ,'Full');
    $iconLtHead = $this->icon('groupware/group_head.png'     ,'Head');

    $menu = $this->newMenu($this->id.'_dropmenu');

    $menu->id = $this->id.'_dropmenu';

    $menu->content = <<<HTML

<div class="inline" >
  <button
    class="wcm wcm_control_dropmenu wgt-button"
    id="{$this->id}_dropmenu-control"
    style="text-align:left;"
    data-drop-box="{$this->id}_dropmenu"  ><i class="fa fa-reorder" ></i> Menu <i class="fa fa-angle-down" ></i></button>
</div>

<div class="wgt-dropdownbox" id="{$this->id}_dropmenu" >
  <ul>
    <li>
      <a class="wgtac_bookmark" ><i class="fa fa-bookmark" ></i> {$this->i18n->l('Bookmark', 'wbf.label')}</a>
    </li>
  </ul>
  <ul>
    <li>
      <a class="deeplink" ><i class="fa fa-info-circle" ></i> {$this->i18n->l('Support', 'wbf.label')}</a>
      <span>
      <ul>
        <li><a class="wcm wcm_req_ajax" href="modal.php?c=Buiz.Faq.create&amp;context=menu" ><i class="fa fa-question-sign" ></i> {$this->i18n->l('Faq', 'wbf.label')}</a></li>
      </ul>
      </span>
    </li>
    <li>
      <a class="wgtac_close" ><i class="fa fa-times" ></i> {$this->i18n->l('Close','wbf.label')}</a>
    </li>
  </ul>
</div>

<div class="wgt-panel-control" >
  <div
    class="wcm wcm_control_buttonset wgt-button-set"
    id="wgt-mentry-groupware-data" >
    <input
      type="radio"
      id="wgt-mentry-groupware-data-mail"
      value="maintab.php?c=Buiz.Message.messageList"
      class="{$this->id}-maskswitcher"
      name="nav-boxtype"
      checked="checked" /><label
        for="wgt-mentry-groupware-data-mail"
        class="wcm wcm_ui_tip-top"
        tooltip="Show the messages"  ><i class="fa fa-envelope-alt" ></i></label>
    <input
      type="radio"
      id="wgt-mentry-groupware-data-contact"
      value="maintab.php?c=Buiz.Contact.list"
      class="{$this->id}-maskswitcher"
      name="nav-boxtype"  /><label
        for="wgt-mentry-groupware-data-contact"
        class="wcm wcm_ui_tip-top"
        tooltip="Show the contacts" ><i class="fa fa-user" ></i></label>
    <input
      type="radio"
      id="wgt-mentry-groupware-data-calendar"
      value="maintab.php?c=Buiz.Calendar.element"
      class="{$this->id}-maskswitcher"
      name="nav-boxtype" /><label
        for="wgt-mentry-groupware-data-calendar"
        class="wcm wcm_ui_tip-top"
        tooltip="Show Calendar" ><i class="fa fa-calendar" ></i></label>
  </div>
</div>

<div class="wgt-panel-control" >
  <button
  	class="wgt-button wgtac_new_msg" ><i
  		class="fa fa-plus-circle" ></i> {$this->i18n->l('New Message','wbf.label')}</button>
</div>

<div class="wgt-panel-control" >
  <button
  	class="wgt-button wgtac_refresh" ><i
  		class="fa fa-refresh" ></i> {$this->i18n->l('Check for Messages','wbf.label')}</button>
</div>

HTML;

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
          'Colab',
          'maintab.php?c=Buiz.Colab.overview',
          'fa fa-puzzle-piece',
          null,
          'wgt_tab-buiz-colab-overview'
        ),
        array(
          'My Messages',
          'maintab.php?c=Buiz.Message.messageList',
          'fa fa-envelope-alt',
          'active',
          'wgt_tab-'.$this->getIdKey()
        )
      )
    );

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

    self.getObject().find(".wgtac_close").click(function() {
      self.close();
    });

    self.getObject().find(".wgtac_new_msg").click(function() {
      \$R.get('maintab.php?c=Buiz.Message.formNew');
    });

    self.getObject().find(".wgtac_refresh,.wgtac_search").click(function() {
      \$R.form('wgt-form-buiz-groupware-search');
    });

    self.getObject().find('.wgt-mentry-my_message-boxtype').change(function() {
      \$R.form('wgt-form-buiz-groupware-search');
    });


    self.getObject().find('.{$this->id}-maskswitcher').change(function() {
      \$R.get(\$S(this).val());
    });


BUTTONJS;

    $this->addJsCode($code);

  }//end public function injectActions */

}//end class DaidalosBdlNodeProfile_Maintab_View

