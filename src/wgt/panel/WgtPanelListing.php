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
class WgtPanelListing extends WgtPanel
{
/*////////////////////////////////////////////////////////////////////////////*/
//
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

    if ($table) {
      $this->tableId = $table->id;
      $this->searchForm = $table->searchForm;
      $table->setPanel($this);
    }

  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// build method
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function build()
  {

    $html = '';

    $html .= $this->panelTitle();
    $html .= $this->panelMenu();
    $html .= $this->panelButtons();

    return $html;

  }//end public function build */

/*////////////////////////////////////////////////////////////////////////////*/
// panel methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function panelMenu()
  {

    $html = '';

    if ($this->searchKey) {
      $html .= '<div class="wgt-panel" >';

      $html .= <<<HTML

      <input
        type="text"
        name="free_search"
        id="wgt-search-listing-{$this->searchKey}"
        class="{$this->searchFieldSize} wcm wcm_req_search wgt-no-save fparam-{$this->searchForm}" />

      <button
        onclick="\$R.form('{$this->searchForm}',null,{search:true});return false;"
        class="wgt-button inline"
        tabindex="-1" >
        <i class="fa fa-search" ></i> Search
      </button>
      <button
        onclick="\$S('table#{$this->tableId}-listing').grid('cleanFilter');\$UI.resetForm('{$this->searchForm}');\$R.form('{$this->searchForm}');return false;"
        title="With this button, you can reset the search, and load the original table."
        class="wgt-button right"
        tabindex="-1" >
        <i class="fa fa-minus-circle"></i> Reset
      </button>

HTML;

      $html .= '</div>';
    }

    return $html;

  }//end public function panelMenu */

} // end class WgtPanelTable

