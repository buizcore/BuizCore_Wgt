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
 * class WgtItemInput
 * Objekt zum generieren einer Inputbox
 * 
 * @package net.buizcore.wgt
 */
class WgtInputFileImage extends WgtInput
{

    /**
     *
     * @var string
     */
    public $link = null;

    /**
     *
     * @var string
     */
    public $source = null;

    /**
     *
     * @param string $link            
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * die build methode zum rendern des input elements
     *
     * @param array $attributes            
     * @return string
     */
    public function build($attributes = array())
    {
        if ($attributes)
            $this->attributes = array_merge($this->attributes, $attributes);
            
            // ist immer ein text attribute
        $this->attributes['type'] = 'text';
        
        $value = null;
        
        if (isset($this->attributes['value'])) {
            $value = $this->attributes['value'];
        }
        
        $id = $this->getId();
        
        $required = $this->required ? '<span class="wgt-required" >*</span>' : '';
        
        // $htmlImage = '';
        if ($this->source) {
            $this->texts->afterInput = '<div class="wgt-box-thumb" ><img
                onclick="$D.openImageWindow({src:\'' . $this->link . '\',alt:\'' . $this->label . '\'})"
                src="' . $this->source . '" alt="' . $this->label . '" /></div>';
        }
        
        $fName = $this->attributes['name'];
        $required = $this->required ? '<span class="wgt-required">*</span>' : '';
        $icon = '<i class="fa fa-picture" ></i>';
        
        $this->attributes['class'] = isset($this->attributes['class']) ? $this->attributes['class'] . ' wgt-ignore wgt-overlay has-button' : 'wgt-ignore wgt-overlay has-button';
        
        $this->attributes['id'] .= '-display';
        $this->attributes['name'] = 'display-' . $this->attributes['id'];
        
        $asgdForm = $this->assignedForm ? 'asgd-' . $this->assignedForm : '';
        
        $html = <<<HTML
    <div class="wgt-box input has-clearfix" id="wgt-box-{$id}" >
      {$this->texts->topBox}
      <div class="wgt-label" >
        <label for="{$id}" >{$this->texts->beforeLabel}{$this->label}{$this->texts->afterLabel} {$required}{$this->texts->endLabel}</label>
      </div>
      {$this->texts->middleBox}
      <div class="inline" >
        <div class="wgt-input {$this->width}" style="position:relative;" >
            <input 
                class="wgt-behind wcm {$asgdForm}" 
                onchange="\$S('input#{$id}-display').val(\$S(this).val());\$S(this).attr('title',\$S(this).val());" 
                type="file" 
                name="{$fName}" 
                id="{$id}" />
            {$this->element()}<button
              class="wgt-button wgt-overlay append-inp"
              tabindex="-1"  >{$icon}</button>{$this->texts->afterInput}</div>
      </div>
      {$this->texts->bottomBox}
    </div>

HTML;
        
        return $html;
    } // end public function build */
    
    /**
     * (non-PHPdoc)
     * 
     * @see src/wgt/WgtAbstract#buildAjaxArea()
     */
    public function buildAjaxArea()
    {
        if (! isset($this->attributes['id']))
            return '';
        
        if (! isset($this->attributes['value']))
            $this->attributes['value'] = '';
        
        $html = '<htmlArea selector="input#' . $this->attributes['id'] . '" action="value" ><![CDATA[' . $this->attributes['value'] . ']]></htmlArea>' . NL;
        
        return $html;
    } // end public function buildAjaxArea */
} // end class WgtInputFileImage

