<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore.com <contact@buizcore.com>
* @project     : BuizCore platform
* @projectUrl  : http://buizcore.com
*
* @licence     : BuizCore.com internal only
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 *
 * @package com.buizcore.mabo
 */
class BcpSummaryList_Widget extends WgtAbstract
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    
    
    /**
     * (non-PHPdoc)
     * @see WgtAbstract::render()
     */
    public function renderList($label, $data, $link)
    {
        
        $helper = $this->view->helper;

        
        $entries = '';
        
            foreach($data as $entry){
                
                $entries .= <<<HTML
<li>
    <h3><a href="{$helper->link('news',$entry['id'],$entry['title'])}" >{$helper->sanitize($entry['title'])}</a></h3>
    <p>{$helper->sanitize($entry['summary'],true)}</p>
</li>
HTML;
        }
        
        $code = <<<HTML
        
<section class="wgt-list-half" >
    <header><h2><a>{$label}</a></h2></header>
    <ul>
        {$entries} 
    </ul>
</section>
        
HTML;
        
        return $code;
        
    }//end public function renderList */

    /**
     * (non-PHPdoc)
     * @see WgtAbstract::render()
     */
    public function renderListStatic($label, $data, $link, $addClass = null)
    {
    
        $helper = $this->view->helper;
    
        $entries = '';
    
        foreach($data as $entry){
    
            $entries .= <<<HTML
<li>
    <h3><a href="{$link}" >{$helper->sanitize($entry['title'])}</a></h3>
    <p>{$helper->sanitize($entry['summary'],true)}</p>
</li>
HTML;
        }
    
        $code = <<<HTML
    
<section class="wgt-list-half {$addClass}" >
    <header><h2><a>{$label}</a></h2></header>
    <ul>
        {$entries}
    </ul>
</section>
    
HTML;
    
        return $code;
    
    }//end public function renderListStatic */

} // end class MaboSummaryList_Widget

