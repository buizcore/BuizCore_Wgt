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
 * A Menu that looks like a filesystem folder
 *
 * @package net.buizcore.wgt
 */
class WgtControlDateList
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/


    
    /**
     * @var []
     */
    public $years = [];
  
    /**
     * das aktive jahr
     * @var int
     */
    public $active = null;
    
    /**
     * das aktive jahr
     * @var int
     */
    public $actionClass = 'search-param';
    
    /**
     * die id des suchformulars
     * @var int
     */
    public $searchForm = null;
    public $searchParam = null;
    public $searchParamName = null;
    
    protected $allYears = [];
    protected $showYears = [];
    
    protected $start;
    protected $end;
    
    protected $yearStart = null;
    protected $yearBefore = null;
    protected $yearNext = null;
    protected $yearEnd = null;
    
    
    /**
     * @param string $start
     * @param string $end
     */
    public function __construct($active, $start, $end = null, $formId = null, $searchParam = null, $paramName = null) 
    {
        
        $this->active = $active;
        
        $this->start = $start;
        $this->end = $end;
        $this->searchForm = $formId;
        $this->searchParam = $searchParam;
        $this->searchParamName = $paramName;
        

        Log::debug( "Start: {$this->start}  End: {$this->end}" );
        
    }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/


    /**
     * 
     */
    public function processData()
    {
        
        $dateTimeStart = new DateTime($this->start);
        
        $dateEnd = $this->end;
        
        if (!$dateEnd) {
            $dateEnd = date('Y-m-d');
        }
        
        $dateTimeEnd = new DateTime($dateEnd);
        $this->yearEnd = $dateTimeEnd->format('Y');
        
        $beginYear = $dateTimeStart->format('Y');
        $this->yearStart = $beginYear;
        

        
        $numYears = $this->yearEnd - $this->yearStart;
        

        Log::debug( "Start: {$this->yearStart}  End: {$this->yearEnd} Num: {$numYears}" );
        
        
        if (!$numYears) {
            $numYears = 1;
        }
        
        $this->allYears = [];
        
        for ($num = 0; $num <= $numYears; ++$num) {
            $this->allYears[] = $beginYear;
            ++$beginYear;
        }
        
        if (!$this->active) {
            $this->active = $this->yearEnd;
        }
        
        $active = $this->active;
        
        $this->yearBefore = $active-1;
        $this->yearAfter = $active+1;
        
        // ok ganz simple
        if (count($this->allYears) > 5) {

           
            if ($active + 2 >= $this->yearEnd) {
                $active = $this->yearEnd - 2;
            }
      
            if ( ($active - 2) <= $this->yearStart) {
                $active = $this->yearStart + 2;
            }
            
            $this->showYears[] = $active-2;
            $this->showYears[] = $active-1;
            $this->showYears[] = $active;
            $this->showYears[] = $active+1;
            $this->showYears[] = $active+2;
            
        } else {
            
            $this->showYears = $this->allYears;
        }
        
        $this->allYears = array_reverse($this->allYears);

    }//end public function processData */
  
    /**
     * @return string
     */
    public function render() 
    {
      
        $this->processData();
    
        $code = <<<CODE
<div class="wcm wcm_list_filter do-align" style="margin-right:20px;" >
    <var class="list_filter" >{"form":"{$this->searchForm}","param":"{$this->searchParam}","param_name":"{$this->searchParamName}"}</var>
    <ul class="wgt-controls-list" >
        <li><a class="{$this->actionClass}" data-val="{$this->yearStart}" >&lt;&lt;</a></li>
        <li><a class="{$this->actionClass}" data-val="{$this->yearBefore}" >&lt;</a></li>
CODE;
      
     foreach ($this->showYears as $year) { 
         
         $isActive = '';
         if ($this->active == $year) {
             $isActive = ' action-is-active ';
         }
         
         $code .= <<<CODE
        <li><a class="{$this->actionClass} {$isActive}" data-val="{$year}" >{$year}</a></li>
CODE;
          
      } 
      
      $code .= <<<CODE
        <li><a class="{$this->actionClass}" data-val="{$this->yearNext}" >&gt;</a></li>
        <li><a class="{$this->actionClass}" data-val="{$this->yearEnd}" >&gt;&gt;</a></li>
    </ul>
</div>
            
<div class="do-align" >
    <select class="wcm wcm_widget_selectbox" style="width:90px;" >
CODE;

    foreach ($this->allYears as $year) {
        
        $selected = '';
        
        if ($this->active == $year) {
            $selected = ' selected="selected" ';
        }
        
        $code .= "<option value=\"{$year}\" {$selected} >{$year}</option>";
    }
            
    $code .= <<<CODE
    </select>
</div>
      
CODE;
 
        
        return $code;
      
    }

} // end class WgtControlCrumb

