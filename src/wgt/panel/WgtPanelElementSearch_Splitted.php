<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * Basisklasse für Table Panels
 *
 * @package net.webfrap.wgt
 */
class WgtPanelElementSearch_Splitted extends WgtPanelElement
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * the search key is used to prevent naming conflicts in the user backend
   * @var string
   */
  public $searchKey = null;

  /**
   * the paging form is used to interact with the listing element
   * @var string
   */
  public $searchForm = null;

  /**
   * the html id of the table object
   * @var string
   */
  public $tableId = null;

  /**
   * the html id of the table object
   * @var string
   */
  public $searchFieldSize = 'xlarge';

  /**
   * wenn true wird automatisch der focus auf das search field gelegt
   * @var string
   */
  public $focus = false;

  /**
   * Filterelement
   * @var WgtPanelElementFilter
   */
  public $filters = null;

  /**
   * Suche kann vorbelegt sein
   * @var string
   */
  public $searchValue = null;

  /**
   * Context des Filterelements
   * @var string
   */
  public $context = 'table';

/*////////////////////////////////////////////////////////////////////////////*/
// constructor
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * when a table object is given, the panel is automatically injected in the
   * table object
   *
   * @param WgtTable $table
   */
  public function __construct($table = null)
  {
  	$this->env = Webfrap::$env;
    if ($table) {
      $this->tableId = $table->id;
      $this->searchForm = $table->searchForm;
    }

  }//end public function __construct */

  /**
   * @param WgtPanelElementFilter $filters
   */
  public function setFilter(WgtPanelElementFilter $filters)
  {

    $this->filters = $filters;

  }//end public function setFilter */

/*////////////////////////////////////////////////////////////////////////////*/
// build method
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function render()
  {

    $this->setUp();

    $html = '';

    $html .= $this->renderSearchArea();

    return $html;

  }//end public function render */

/*////////////////////////////////////////////////////////////////////////////*/
// panel methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param boolean $flagButtonText
   * @return string
   */
  public function renderSearchArea($flagButtonText = false)
  {

    $i18n = $this->getI18n();

    $html = '';
    $panelClass = '';

    if ($this->searchKey) {

      $customButtons = '';

      $textSearchUF = " {$i18n->l('Filter', 'wbf.label')}";
      $textSearch = " {$i18n->l('Search', 'wbf.label')}";

      $setFocus = '';
      if ($this->focus)
        $setFocus = ' wcm_ui_focus';

      $htmlFilters = '';

      $codeFilter = '';
      if ($this->filters) {
        $htmlFilters = $this->filters->render();
        $codeFilter = "<div class=\"wgt-panel-filter\" ><span class=\"wcm wcm_ui_tip-top\"   >"
          ." <span id=\"wgt-search-{$this->context}-{$this->searchKey}-numfilter\" >{$this->filters->numFilterActive}</span> "
          .$i18n->l('active filters','wbf.label')." <a ><i class=\"fa fa-times\" ></i></a></span></div>";

        // <span>{$this->filters->numFilter}</span>
      }

      $html .= <<<HTML

        <div class="wgt-panel-search-field" >
          <input
            type="text"
            name="free_search"
            placeholder="{$i18n->l('Search by keyword', 'wbf.label')}"
            style="margin-right:0px;"
            value="{$this->searchValue}"
            id="wgt-search-{$this->context}-{$this->searchKey}"
            class="wcm wcm_req_search{$setFocus} {$this->searchFieldSize} type-search wgt-no-save fparam-{$this->searchForm}"
            wgt_drop_trigger="wgt-search-{$this->context}-{$this->searchKey}-dcon" />
        </div>

        <div
          id="wgt-search-{$this->context}-{$this->searchKey}-control"
          class="wcm wcm_control_split_button wgt-panel-search-field-buttons"  >

          <button
            onclick="\$S('#wgt-search-{$this->context}-{$this->searchKey}-dcon').dropdown('close');\$R.form('{$this->searchForm}',null,{search:true});return false;"
            title="{$i18n->l('Search', 'wbf.label')}"
            class="wgt-button splitted append-inp wcm wcm_ui_tip"
            tabindex="-1" >
            <i class="fa fa-search" ></i>
          </button><button
            class="wgt-button append"
            tabindex="-1"
            id="wgt-search-{$this->context}-{$this->searchKey}-dcon"
            data-drop-box="wgt-search-{$this->context}-{$this->searchKey}-dropbox" ><i class="fa fa-angle-down" ></i></button>

        <var id="wgt-search-{$this->context}-{$this->searchKey}-control-cfg-split"  >{"triggerEvent":"click","align":"right"}</var>
        <var id="wgt-search-{$this->context}-{$this->searchKey}-control-reset-docu" >{$i18n->l('Reset the search form', 'wbf.label')}</var>
        <var id="wgt-search-{$this->context}-{$this->searchKey}-control-reset-filters-docu" >{$i18n->l('Unset all filters', 'wbf.label')}</var>

      </div>    
 
      <div
        class="wgt-dropdownbox"
        id="wgt-search-{$this->context}-{$this->searchKey}-dropbox"  >
        <ul>
          <li><a
            onclick="\$S('#wgt-search-{$this->context}-{$this->searchKey}-dcon').dropdown('close');\$S('{$this->context}#{$this->tableId}-table').grid('cleanFilter');\$UI.resetForm('{$this->searchForm}');\$R.form('{$this->searchForm}');return false;"
            wgt_doc_src="wgt-search-{$this->context}-{$this->searchKey}-control-reset-docu"
            wgt_doc_cnt="wgt-search-{$this->context}-{$this->searchKey}-control-docu_cont"
            class="wcm wcm_ui_docu_tip" >
            <i class="fa fa-minus-circle"></i> {$i18n->l('Reset search', 'wbf.label')}
          </a></li>
        </ul>
        {$htmlFilters}
        <ul>
          <li>
            <p id="wgt-search-{$this->context}-{$this->searchKey}-control-docu_cont" ></p>
          </li>
        </ul>

    </div>

   {$codeFilter}

HTML;

    }

    return $html;

  }//end public function renderSearchArea */

}//end class WgtPanelElementSearch_Splitted

