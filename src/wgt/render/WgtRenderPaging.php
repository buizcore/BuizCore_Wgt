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

/** Form Class
 *
 * @package net.webfrap.wgt
 */
class WgtRenderPaging
{
/*////////////////////////////////////////////////////////////////////////////*/
// public interface attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
     * Die HTML ID
     * @var string $id
     */
    public $id = null;
    
    /**
     * Die Id des Formulars
     * @var string $keyName
     */
    public $dataSource = null;
    
    /**
     * Die Id des Formulars
     * @var string $keyName
     */
    public $dataFormId = null;
    
   /**
    * Die Anzahl Datensätze
    * @var int $numEnrties
    */
    public $numEntries = 0;
    
   /**
    * @var int $position
    */
    public $position = 0;
    
   /**
    * @var int $position
    */
    public $offset = 0;
    
   /**
    * @var int $position
    */
    public $stepSize = 10;

/*////////////////////////////////////////////////////////////////////////////*/
// Constructor
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * @param string $dataFormId
    * @param string $dataSource
    */
    public function __construct($dataFormId, $dataSource)
    {
    
        $this->dataFormId = $dataFormId;
        $this->dataSource = $dataSource;
    
    }//end public function __construct */


/*////////////////////////////////////////////////////////////////////////////*/
// Some Static help Methodes
/*////////////////////////////////////////////////////////////////////////////*/
    
    public function render($position, $numEntries)
    {
        
        $this->position = $position;
        $this->numEntries = $numEntries;
 
        $last = 0;
        $active = 0;
        
        $numSteps = ceil($this->numEntries / $this->stepSize);
        
        if ($numSteps > 7) {
            
            $lastStep = ($numSteps-1)*$this->stepSize;
             
            $code = <<<HTML
<ul>
     <li><a href="{$this->dataSource}?start=0" onclick="\$R.searchForm('{$this->dataFormId}',0,true);return false;" >1</a></li>
     <li><a>...</a></li>
HTML;
            
     $code .= <<<HTML
     <li><a>...</a></li>
     <li><a href="{$this->dataSource}?start={$lastStep}" onclick="\$R.searchForm('{$this->dataFormId}',{$lastStep},true);return false;" >{$numSteps}</a></li>
</ul>
HTML;

        } else {

            $code = <<<HTML
<ul>
HTML;
            
            for ($pos =0; $pos < $numSteps; $pos++ ){
                
                
                $isActive = '';
                if($this->position == $pos){
                    $isActive = 'active';
                }
                
                $showPos = $pos +1;
                $pagePos = $pos * $this->stepSize;
                
                $code .= <<<HTML
     <li class="{$isActive}" ><a href="{$this->dataSource}?start={$pagePos}"  onclick="\$R.searchForm('{$this->dataFormId}',{$pos},true);return false;" >{$showPos}</a></li>
HTML;
            }
            
            $code .= <<<HTML
</ul>
HTML;
            
            
        }
        
        return $code;
        
    }

}//end class WgtRenderPaging

