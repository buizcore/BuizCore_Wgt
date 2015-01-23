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
 * class WgtItemAutocomplete
 * Objekt zum generieren einer Inputbox
 * @package net.webfrap.wgt
 */
class WgtInputPassword extends WgtInput
{

  /**
   * @return unknown_type
   */
  public function build($attributes = array())
  {

    $this->type = 'password';

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    // ist immer ein text attribute
    $this->attributes['type']= 'password';

    if (isset($this->attributes['value']))
      unset($this->attributes['value']);

    $attributes = $this->asmAttributes();
    
    if (!$this->renderInput) {
        
        $id = $this->getId();
    
        $html = <<<HTML
    <div class="wgt-box kv" id="wgt-box-{$id}"  >
      {$this->texts->topBox}
      <label
        for="{$id}" >{$this->texts->beforeLabel}{$this->label} {$this->texts->afterLabel}
      </label>
      {$this->texts->middleBox}
      <div>{$this->texts->beforInput}*********{$this->texts->afterInput}</div>
      {$this->texts->bottomBox}
        <div class="do-clear tiny" >&nbsp;</div>
      </div>
    <div class="do-clear tiny" >&nbsp;</div>
    
HTML;
    
          return $html;
    }

    $attr = $this->attributes;
    $attr['name'] = str_replace(array('[',']'),array('_','_repeat'),$attr['name']);
    $attr['id'] =  $attr['id'].'_repeat';

    $attributesRep = $this->asmAttributes($attr);

    $required = $this->required?'<span class="wgt-required">*</span>':'';
    
  

    $html = '<div class="wgt-box input has-clearfix" id="wgt-box-'.$this->attributes['id'].'" >
      <div class="wgt-label" ><label for="'.$this->attributes['id'].'" >'.$this->label.' '.$required.'</label></div>
      <div class="wgt-input '.$this->width.'" ><input '.$attributes.' /></div>
      <div class="do-clear small" >&nbsp;</div>
      <div class="wgt-label" ><label for="'.$this->attributes['id'].'_repeat" >'.$this->label.' repeat '.$required.'</label></div>
      <div class="wgt-input '.$this->width.'" ><input '.$attributesRep.' /></div>
    </div>'.NL;

    return $html;

  } // end public function build()

  /**
   * Parser for the input field
   *
   * @return String
   */
  public function buildAjax()
  {
    return '';

  } // end public function buildAjax()

} // end class WgtItemPassword

