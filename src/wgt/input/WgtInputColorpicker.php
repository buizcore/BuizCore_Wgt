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
 * Objekt zum generieren einer Inputbox
 * @package net.buizcore.wgt
 */
class WgtInputColorpicker extends WgtInput
{

  /**
   * @param array $attributes
   * @return string
   */
  public function build($attributes = array())
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    // ist immer ein text attribute
    $this->attributes['type']= 'text';

    if (isset($this->attributes['class'])) {
      $this->attributes['class'] .= ' wcm wcm_ui_color_picker has-button';
    } else {
      $this->attributes['class'] = '  wcm wcm_ui_color_picker has-button';
    }

    $attributes = $this->asmAttributes();

    $required = $this->required?'<span class="wgt-required">*</span>':'';

    $id = $this->getId();

    $html = '<div class="wgt-box input has-clearfix" id="wgt-box-'.$id.'" >
      <label class="wgt-label" for="'.$id.'" >'.$this->label.' '.$required.'</label>
      <div class="wgt-input '.$this->width.'" >
        <input '.$attributes.' />
        <var>{"button":"'.$id.'-ap-button"}</var>
        <button
          id="'.$id.'-ap-button"
          class="wgt-button append-inp"
          tabindex="-1"  ><i class="fa fa-asterisk" ></i></button>
       </div>
    </div>'.NL;

    return $html;

  }//end public function build */

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjax()
   */
  public function buildAjax()
  {

    if (!isset($this->attributes['id']))
      return '';

    if (!isset($this->attributes['value']))
      $this->attributes['value'] = '';

    $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="value" ><![CDATA['
      .$this->attributes['value'].']]></htmlArea>'.NL;

    return $html;

  }//end public function buildAjax */

} // end class WgtInputColorpicker

