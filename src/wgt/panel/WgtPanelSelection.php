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
class WgtPanelSelection extends WgtPanelTable
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
      $title = '<div class="left" style="width:40%"  ><h2 style="margin-bottom:0px;" >'.$this->title.'</h2></div>';
    }

    if ($this->searchKey) {
      $html .= '<div class="wgt-panel'.$panelClass.'" >';

      $html .= $title;

      $customButtons = '';

      if ($this->menuButtons) {
        $customButtons = $this->buildButtons($this->menuButtons);
      }

      $html .= <<<HTML

      {$customButtons}
      <div class="right" >
        <strong>Search</strong>
        
        <input
          type="text"
          name="free_search"
          id="wgt-search-selection-{$this->searchKey}"
          class="{$this->searchFieldSize} wcm wcm_req_search wgt-no-save fparam-{$this->searchForm}" />

        <button
          onclick="\$R.form('{$this->searchForm}',null,{search:true});return false;"
          title="Search"
          class="wgt-button append-inp wcm wcm_ui_tip"
          tabindex="-1" >
          <i class="fa fa-search" ></i>
        </button>
      </div>

HTML;

      //$html .= '<div class="do-clear xxsmall" >&nbsp;</div>';
      $html .= '</div>';
    }

    return $html;

  }//end public function panelMenu */

} // end class WgtPanelSelection

