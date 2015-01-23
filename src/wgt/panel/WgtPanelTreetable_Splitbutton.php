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
class WgtPanelTreetable_Splitbutton extends WgtPanelTable_Splitbutton
{
/*////////////////////////////////////////////////////////////////////////////*/
// panel methodes
/*////////////////////////////////////////////////////////////////////////////*/

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
          if ($this->buttons) {

        $title = '<div class="left third" >'.$this->panelButtons().'</div>';
        $title .= '<div class="inline third" style="min-width:200px;text-align:center;"  >'
          .'<h2 style="margin-bottom:0px;" >'.$this->title.'</h2></div>';

      } else {

        $title = '<div class="left third" >&nbsp;</div>';
        $title .= '<div class="inline third" style="min-width:200px;text-align:center;"  >'
          .'<h2 style="margin-bottom:0px;" >'.$this->title.'</h2></div>';
      }
    }

    if ($this->searchKey) {

      $html .= '<div class="wgt-panel'.$panelClass.'" >';
      $html .= $title;

      $customButtons = '';

      $textSearch = " {$i18n->l('Search by keyword', 'wbf.label')}";

      $setFocus = '';
      if ($this->focus)
        $setFocus = ' wcm_ui_focus';

      $htmlFilters = '';
      if ($this->filterButtons)
        $htmlFilters .= $this->buildButtons($this->filterButtons);

      $codeFilter = '';

      if ($this->filterPanel) {

        $htmlFilters = $this->filterPanel->render();
        $codeFilter = "<span class=\"wcm wcm_ui_tip-top wgt-corner\" style=\"padding:3px 6px;\"  >"
            ." <span id=\"wgt-search-treetable-{$this->searchKey}-numfilter\" >{$this->filterPanel->numFilterActive}</span> "
            .$i18n->l('active filters','wbf.label')." </span>";
      }

      $html .= <<<HTML

      <div class="right" >

        <div class="left search-field" >
          <input
            type="text"
            name="free_search"
            placeholder="{$textSearch}"
            style="margin-right:0px;"
            id="wgt-search-treetable-{$this->searchKey}"
            class="{$this->searchFieldSize} wcm wcm_req_search{$setFocus} wgt-no-save type-search fparam-{$this->searchForm}"
            wgt_drop_trigger="wgt-search-table-{$this->searchKey}-dcon" />
         </div>

        <div
          id="wgt-search-treetable-{$this->searchKey}-control"
          class="wcm wcm_control_split_button wgt-panel-control"  >

          <button
            onclick="\$S('#wgt-search-treetable-{$this->searchKey}-dcon').dropdown('close');\$R.form('{$this->searchForm}',null,{search:true});return false;"
            title="Search"
            class="wgt-button append-inp splitted wcm wcm_ui_tip"
            tabindex="-1" >
            <i class="fa fa-search" ></i>
          </button><button
            class="wgt-button append"
            tabindex="-1"
            id="wgt-search-table-{$this->searchKey}-dcon"
            data-drop-box="wgt-search-treetable-{$this->searchKey}-dropbox" ><i class="fa fa-angle-down" ></i></button>


        <var id="wgt-search-treetable-{$this->searchKey}-control-cfg-split"  >{"triggerEvent":"click","align":"right"}</var>
        <var id="wgt-search-treetable-{$this->searchKey}-control-reset-docu" >Reset the search form</var>
        <var id="wgt-search-treetable-{$this->searchKey}-control-ext_search-docu" >Open the advanced search</var>

      </div><!-- end right -->

      <div class="wgt-dropdownbox" id="wgt-search-treetable-{$this->searchKey}-dropbox"  >
        <ul>
          <li><a
            onclick="\$S('#wgt-search-treetable-{$this->searchKey}-dcon').dropdown('close');\$S('table#{$this->tableId}-table').grid('cleanFilter');\$UI.resetForm('{$this->searchForm}');\$R.form('{$this->searchForm}');return false;"
            wgt_doc_src="wgt-search-treetable-{$this->searchKey}-control-reset-docu"
            wgt_doc_cnt="wgt-search-treetable-{$this->searchKey}-control-docu_cont"
            class="wcm wcm_ui_docu_tip" >
            <i class="fa fa-minus-circle"></i> Reset search
          </a></li>
        </ul>
        {$htmlFilters}
        <ul>
          <li>
            <a id="wgt-search-treetable-{$this->searchKey}-control-docu_cont" ></a>
          </li>
        </ul>
      </div><!-- end wgt-dropdownbox -->

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

} // end class WgtPanelTable

