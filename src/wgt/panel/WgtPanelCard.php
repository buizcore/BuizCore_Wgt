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
class WgtPanelCard extends WgtPanel
{
/* //////////////////////////////////////////////////////////////////////////// */
// Attributes
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     * the search key is used to prevent naming conflicts in the user backend
     * 
     * @var string
     */
    public $searchKey = null;

    /**
     * the paging form is used to interact with the listing element
     * 
     * @var string
     */
    public $searchForm = null;

    /**
     * the html id of the table object
     * 
     * @var string
     */
    public $tableId = null;

    /**
     * the html id of the table object
     * 
     * @var string
     */
    public $searchFieldSize = 'xlarge';

    /**
     *
     * @var array
     */
    public $menuButtons = array();

    /**
     *
     * @var array
     */
    public $filterButtons = array();

    /**
     *
     * @var WgtPanel
     */
    public $filterPanel = null;

    /**
     *
     * @var boolean
     */
    public $focus = false;
    
/* //////////////////////////////////////////////////////////////////////////// */
// constructor
/* //////////////////////////////////////////////////////////////////////////// */
    
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
            
            // das access objekt der table mit übernehmen
            if ($table->access)
                $this->access = $table->access;
            
            $table->setPanel($this);
        }
    
    } // end public function __construct */
    
/* //////////////////////////////////////////////////////////////////////////// */
// getter & setter
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     *
     * @param
     *            $panel
     */
    public function setFilterPanel($panel)
    {

        $this->filterPanel = $panel;
    
    } // end public function setFilterPanel */
    
/* //////////////////////////////////////////////////////////////////////////// */
// build method
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     *
     * @return string
     */
    public function render()
    {

        $this->setUp();
        
        $html = '';
        
        // $html .= $this->panelTitle();
        $html .= $this->panelMenu();
        // $html .= $this->panelButtons();
        
        if ($this->subPannel) {
            foreach ($this->subPannel as $subPanel) {
                if (is_string($subPanel))
                    $html .= $subPanel;
                else
                    $html .= $subPanel->render();
            }
        }
        
        return $html;
    
    } // end public function render */

    /**
     *
     * @return string
     */
    public function build()
    {

        return $this->render();
    
    } // end public function build */

    /**
     * set up the panel data
     */
    public function setUp()
    {

    } // end public function setUp */
    
/* //////////////////////////////////////////////////////////////////////////// */
// panel methodes
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     * @lang de:
     *
     * Hinzufügen eines Buttons
     * First add, first display
     *
     * @param string $key            
     * @param array $buttonData
     *            {
     *            0 => int, Button Type @see Wgt:: ACTION Constantes
     *            1 => string, Label des Buttons
     *            2 => string, URL oder Javascript Code, je nach Button Type
     *            3 => string, Icon
     *            4 => string, css classes (optional)
     *            5 => string, i18n key für das label (optional)
     *            6 => int, das benötigtes zugriffslevel @see Acl::$accessLevels
     *            7 => int, maximales zugriffslevel @see Acl::$accessLevels
     *            }
     *            
     */
    public function addMenuButton($key, $buttonData)
    {

        $this->menuButtons[$key] = $buttonData;
    
    } // end public function addMenuButton */

    /**
     */
    public function panelMenu()
    {

        $i18n = $this->getI18n();
        
        $html = '';
        $panelClass = '';
        $title = '';
        
        if ($this->title) {
            $panelClass = ''; // title';
            if ($this->buttons) {
                
                $title = '<div class="left wgt-panel-menu" >'.$this->buildButtons().'</div>';
                $title .= '<div class="inline" style="width:40%"  ><h2 style="margin-bottom:0px;" >'.$this->title.'</h2></div>';
            } else {
                
                $title = '<div class="left" style="width:40%"  ><h2 style="margin-bottom:0px;" >'.$this->title.'</h2></div>';
            }
        }
        
        if ($this->searchKey) {
            $html .= '<div class="wgt-panel'.$panelClass.'" >';
            
            $html .= $title;
            
            $customButtons = '';
            
            if ($this->menuButtons) {
                $customButtons = $this->buildButtons($this->menuButtons);
            }
            
            $textSearch = $i18n->l('Search by keyword', 'wbf.label');
            
            $html .= <<<HTML

      {$customButtons}
      <div class="right" >
        <input
          type="text"
          name="free_search"
          placeholder="{$textSearch}"
          id="wgt-search-table-{$this->searchKey}"
          class="{$this->searchFieldSize} wcm wcm_req_search type-search wgt-no-save fparam-{$this->searchForm}" />

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
            
            // $html .= '<div class="do-clear xxsmall" >&nbsp;</div>';
            $html .= '</div>';
        }
        
        return $html;
    
    } // end public function panelMenu */

    /**
     *
     * @return string
     */
    public function panelButtons()
    {

        $i18n = $this->getI18n();
        $html = '';
        
        if ($this->buttons || $this->filterButtons) {
            $html .= '<div class="wgt-panel" >';
            
            if ($this->buttons) {
                $html .= '<div class="left" >';
                $html .= $this->buildButtons();
                $html .= '</div>';
            }
            
            if ($this->filterButtons) {
                $html .= '<div class="right" ><div class="left" ><strong>'.$i18n->l('Filters', 'wbf.label').'&nbsp;|&nbsp;</strong></div>';
                $html .= $this->buildButtons($this->filterButtons);
                $html .= '</div>';
            }
            
            if ($this->filterPanel) {
                $html .= $this->filterPanel->render();
            }
            
            $html .= '</div>';
        }
        
        return $html;
    
    } // end public function panelButtons */

} // end class WgtPanelCard

