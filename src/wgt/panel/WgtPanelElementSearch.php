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
class WgtPanelElementSearch extends WgtPanelElement
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
    public $searchFieldSize = 'large';

    /**
     * wenn true wird automatisch der focus auf das search field gelegt
     * 
     * @var string
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

        $this->env = Webfrap::$env;
        if ($table) {
            $this->tableId = $table->id;
            $this->searchForm = $table->searchForm;
        }
    
    } // end public function __construct */
    
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
        
        $html = $this->renderSearchArea();
        
        return $html;
    
    } // end public function render */
    
/* //////////////////////////////////////////////////////////////////////////// */
// panel methodes
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     *
     * @param boolean $flagButtonText            
     */
    public function renderSearchArea($flagButtonText = false)
    {

        $i18n = $this->getI18n();
        
        $html = '';
        $panelClass = '';
        
        if ($this->searchKey) {
            
            $customButtons = '';
            
            $textSearch = " {$i18n->l('Search','wbf.label')}";
            
            $setFocus = '';
            if ($this->focus)
                $setFocus = ' wcm_ui_focus';
            
            $html .= <<<HTML

      <div class="right search-field" >

        <strong>{$textSearch}</strong>
        <input
          type="text"
          name="free_search"
          id="wgt-search-table-{$this->searchKey}"
          class="{$this->searchFieldSize} wcm wcm_req_search{$setFocus} type-search wgt-no-save fparam-{$this->searchForm}" />

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
          class="wgt-button right wcm wcm_ui_tip-l"
          tabindex="-1" >
          <i class="fa fa-minus-circle"></i>
        </button>

      </div>

HTML;
        }
        
        return $html;
    
    } // end public function renderSearchArea */

}//end class WgtPanelElementSearch

