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
class WgtInputProcess extends WgtInput
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Quelle für den Prozessbutton zum laden des aktuellen Prozesstatus
   * @var string
   */
  public $source = null;

  /**
   * Die Quelle für den Prozessbutton zum laden des aktuellen Prozesstatus
   * @var string
   */
  public $nodeLabel = 'Process not started';

/*////////////////////////////////////////////////////////////////////////////*/
// Getter & Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $source
   */
  public function setSource($source)
  {
    $this->source = $source;
  }//end public function setSource */

  /**
   * @param string $nodeLabel
   */
  public function setNodeLabel($nodeLabel)
  {
    $this->nodeLabel = $nodeLabel;
  }//end public function setNodeLabel */

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param array $attributes
   * @return string
   */
  public function build($attributes = array())
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes, $attributes);

    $attributes = $this->asmAttributes();
    $required = $this->required
      ?  '<span class="wgt-required">*</span>'
      :  '';

    $id = $this->getId();

    $varCode = '';
    if ($this->source) {
      $varCode = '<var>{"url":"'.$this->source.'"}</var>';
    }

    if (!isset($this->attributes['class']))
      $this->attributes['class'] = '';

    if (!isset($this->attributes['name']))
      $this->attributes['name'] = '';

    if (!isset($this->attributes['value']))
      $this->attributes['value'] = '';

    $html = '<div class="wgt-box input has-clearfix" id="wgt-box-'.$id.'" >
      <label class="wgt-label" for="'.$id.'" >'.$this->label.' '.$required.'</label>
      <div class="wgt-input '.$this->width.'" >'
      .'<button class="wgt-button wcm wcm_ui_dropform" id="'.$id.'" tabindex="-1"  >'
      .$this->nodeLabel.$varCode
      .'</button>'
      .'<input type="hidden" '
      .' class="'.$this->attributes['class'].'" '
      .' name="'.$this->attributes['name'].'" '
      .' value="'.$this->attributes['value'].'" />'
      .'</div>
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

} // end class WgtInputProcess

