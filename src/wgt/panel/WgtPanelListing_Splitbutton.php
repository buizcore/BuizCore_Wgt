<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH
* @project     : BuizCore - The Business Core
* @projectUrl  : http://buizcore.net
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
 * @package net.buizcore.wgt
 */
class WgtPanelListing_Splitbutton extends WgtPanel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  public $listType = 'listing';

  /**
   * Die HTML ID des Elements
   * @var string
   */
  public $elementId = null;

  /**
   * key zum erstellen eines suchformulars
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
  public $searchFieldSize = 'large';

  /**
   *
   * @var array
   */
  public $menuButtons = array();

  /**
   * @var array
   */
  public $filterButtons = array();

  /**
   * @var WgtPanel
   */
  public $filterPanel = null;

  /**
   * @var boolean
   */
  public $focus = false;

/*////////////////////////////////////////////////////////////////////////////*/
// panel methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param WgtListing $element
   */
  public function __construct($element)
  {

    $this->listType = $element->type;
    $this->elementId = $element->id;

    $element->panel = $this;

  }//end public function __construct */

  /**
   * @return string
   */
  public function build()
  {

    $html = '';

    $html .= $this->panelMenu();
    $html .= $this->panelButtons();

    return $html;

  }//end public function build */

  /**
   *
   */
  public function panelMenu()
  {

    $i18n = $this->getI18n();

    $html = '';
    $panelClass = '';
    $title = '';

    if ($this->title) {
      $panelClass = '';// title';
      $title = '<div class="left" style="width:40%"  ><h2 style="margin-bottom:0px;" >'.$this->title.'</h2></div>';
    }

    if ($this->searchKey) {
      $html .= '<div class="wgt-panel'.$panelClass.'" >';

      $html .= $title;


      $buttonAdvanced = '';
      $customButtons = '';

      $textSearchUF = " {$i18n->l('Search &amp; Filter', 'wbf.label')}";
      $textSearch = " {$i18n->l('Search', 'wbf.label')}";

      $setFocus = '';
      if ($this->focus)
        $setFocus = ' wcm_ui_focus';

      $htmlFilters = '';
      if ($this->filterButtons)
        $htmlFilters .= $this->buildButtons($this->filterButtons);

      $codeFilter = '';

      if ($this->filterPanel) {
        $htmlFilters .= $this->filterPanel->render();
        $codeFilter = "<span class=\"wcm wcm_ui_tip-top\" tooltip=\"numer of active filters / number of filters\" >"
          ."(<span id=\"wgt-search-{$this->listType}-{$this->searchKey}-numfilter\" >"
          ."{$this->filterPanel->numFilterActive}</span>/<span>{$this->filterPanel->numFilter}</span>)</span>";
      }

      $html .= <<<HTML

      <div class="right" >

        <div class="left search-field" >
          <strong>{$textSearchUF}</strong>
          <input
            type="text"
            name="free_search"
            style="margin-right:0px;"
            id="wgt-search-{$this->listType}-{$this->searchKey}"
            class="{$this->searchFieldSize} wcm wcm_req_search{$setFocus} wgt-no-save type-search fparam-{$this->searchForm}"
            wgt_drop_trigger="wgt-search-{$this->listType}-{$this->searchKey}-dcon" />
         </div>

        <div
          id="wgt-search-{$this->listType}-{$this->searchKey}-control"
          class="wcm wcm_control_split_button wgt-panel-control"  >

          <button
            onclick="\$S('#wgt-search-{$this->listType}-{$this->searchKey}-dcon').dropdown('close');\$R.form('{$this->searchForm}',null,{search:true});return false;"
            title="Search"
            class="wgt-button append-inp splitted wcm wcm_ui_tip"
            tabindex="-1" >
            <i class="fa fa-search" ></i>
          </button><button
            class="wgt-button append"
            tabindex="-1"
            id="wgt-search-{$this->listType}-{$this->searchKey}-dcon"
            data-drop-box="wgt-search-{$this->listType}-{$this->searchKey}-dropbox" ><i class="fa fa-angle-down" ></i></button>

        <var
          id="wgt-search-{$this->listType}-{$this->searchKey}-control-cfg-split"
          >{"triggerEvent":"click","align":"right"}</var>
        <var
          id="wgt-search-{$this->listType}-{$this->searchKey}-control-reset-docu"
          >Reset the search form</var>
        <var
          id="wgt-search-{$this->listType}-{$this->searchKey}-control-ext_search-docu"
          >Open the advanced search</var>

      </div>

      <div class="wgt-dropdownbox" id="wgt-search-{$this->listType}-{$this->searchKey}-dropbox"  >
        <ul>
          <li><a
            onclick="\$S('#wgt-search-{$this->listType}-{$this->searchKey}-dcon').dropdown('close');\$S('table#{$this->elementId}-{$this->listType}').grid('cleanFilter');\$UI.resetForm('{$this->searchForm}');\$R.form('{$this->searchForm}');return false;"
            wgt_doc_src="wgt-search-{$this->listType}-{$this->searchKey}-control-reset-docu"
            wgt_doc_cnt="wgt-search-{$this->listType}-{$this->searchKey}-control-docu_cont"
            class="wcm wcm_ui_docu_tip" >
            <i class="fa fa-minus-circle"></i> Reset search
          </a></li>
          <li><a
            onclick="\$S('#wgt-search-table-{$this->searchKey}-dcon').dropdown('close');\$S('table#{$this->tableId}-table').grid('cleanFilter');\$UI.resetForm('{$this->searchForm}');\$R.form('{$this->searchForm}');return false;"
            wgt_doc_src="wgt-search-table-{$this->searchKey}-control-reset-filter"
            wgt_doc_cnt="wgt-search-table-{$this->searchKey}-control-docu_cont"
            class="wcm wcm_ui_docu_tip" >
            <i class="fa fa-times"></i> Unset all filters
          </a></li>
        </ul>
        {$htmlFilters}
        <ul>
          <li>
            <p id="wgt-search-{$this->listType}-{$this->searchKey}-control-docu_cont" ></p>
          </li>
        </ul>
      </div><!-- end wgt-dropdownbox -->
                
      <div class="wgt-panel-control" ><strong>{$codeFilter}</strong></div>

    </div><!-- end wgt-panel -->

HTML;

    } elseif ($this->title) {


      $html .= '<div class="wgt-panel'.$panelClass.'" >';
      $html .= $title;

      if ($this->buttons) {
        $html .= '<div class="right" >';
        $html .= $this->buildButtons();
        $html .= '</div>';
      }

      $html .= <<<HTML

    </div>

HTML;

    }

    return $html;

  }//end public function panelMenu */

  /**
   * @return string
   */
  public function panelButtons()
  {

    if (!$this->searchKey)
      return '';

    $html = '';

    if ($this->buttons) {
      $html .= '<div class="wgt-panel" >';

      if ($this->buttons) {
        $html .= '<div class="left" >';
        $html .= $this->buildButtons();
        $html .= '</div>';
      }

      $html .= '</div>';
    }

    return $html;

  }//end public function panelButtons */

} // end class WgtPanelListing_Splitbutton

