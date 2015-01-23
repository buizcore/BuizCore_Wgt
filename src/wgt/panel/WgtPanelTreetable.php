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
 * @package net.buizcore.wgt
 */
class WgtPanelTreetable extends WgtPanelTable
{

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

        $title = '<div class="left" >'.$this->panelButtons().'</div>';
        $title .= '<div class="inline" style="width:40%"  ><h2 style="margin-bottom:0px;" >'.$this->title.'</h2></div>';

      } else {

        $title = '<div class="left" style="width:40%"  ><h2 style="margin-bottom:0px;" >'.$this->title.'</h2></div>';
      }
    }

    if ($this->searchKey) {
      $html .= '<div class="wgt-panel'.$panelClass.'" >';

      $html .= $title;

      $iconInfo = $this->icon('control/info.png', 'Info');

      $customButtons = '';


      if ($this->menuButtons) {
        $customButtons = $this->buildButtons($this->menuButtons);
      }

      $textSearch = $i18n->l('Search by keyword','wbf.label');

      $html .= <<<HTML

      {$customButtons}
      <div class="right search-field" >
        <input
          type="text"
          name="free_search"
          placeholder="{$textSearch}"
          id="wgt-search-treetable-{$this->searchKey}"
          class="{$this->searchFieldSize} wcm wcm_req_search wgt-no-save type-search fparam-{$this->searchForm}" />

        <button
          onclick="\$R.form('{$this->searchForm}',null,{search:true});return false;"
          title="Search"
          class="wgt-button inline wcm wcm_ui_tip"
          tabindex="-1" >
          <i class="fa fa-search" ></i>
        </button>
        <button
          onclick="\$S('table#{$this->tableId}-table').grid('cleanFilter');\$UI.resetForm('{$this->searchForm}');\$R.form('{$this->searchForm}');return false;"
          title="Reset"
          class="wgt-button right wcm wcm_ui_tip"
          tabindex="-1" >
          <i class="fa fa-minus-circle" ></i>
        </button>

      </div>

HTML;

      //$html .= '<div class="do-clear xxsmall" >&nbsp;</div>';
      $html .= '</div>';
    }

    return $html;

  }//end public function panelMenu */

} // end class WgtPanelTreetable

