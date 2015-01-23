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
 * @package net.webfrap.wgt
 */
class WgtList_Card extends WgtList_Element
{
    
    
    /**
     * (non-PHPdoc)
     * @see src/wgt/WgtAbstract#buildAjaxArea()
     */
    public function buildAjaxArea ()
    {
    
        $this->refresh = true;
    
        if ($this->xml)
            return $this->xml;
    
        if ($this->appendMode) {
    
            $html = '<htmlArea selector="#'.$this->id.'" action="append" ><![CDATA[';
            $html .= $this->build();
            $html .= ']]></htmlArea>'.NL;
    
        } else {
    
            $html = '<htmlArea selector="#'.$this->id.'" action="html" ><![CDATA[';
            $html .= $this->build();
            $html .= ']]></htmlArea>'.NL;
    
        }
    
        $this->xml = $html;
    
        return $html;
    
    } //end public function buildAjaxArea */


}//end class WgtList_Card

