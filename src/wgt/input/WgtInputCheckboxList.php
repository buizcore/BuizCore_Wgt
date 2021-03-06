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
 * @package net.buizcore.wgt
 */
class WgtInputCheckboxList extends WgtInput
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Liste der aktiven Datensätze
   * @var array
   */
  public $activ = array();

  /**
   * Liste der aktiven Datensätze
   * @var array
   */
  protected $data = array();

  /**
   * Type vordefinieren
   * @var array
   */
  public $attributes = array('type' => 'checkbox');

/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param $data
   */
  public function setData($data, $garbage = null)
  {
    $this->data = $data;
  }//end public function setData */

  /**
   *
   * @var string
   */
  public $width = 'small';

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtInput#element()
   */
  public function element($attributes = array())
  {

    $id = $this->getId();

    if (!$this->activ)
      $this->activ = array();
    
    if($attributes){
        $this->attributes = array_merge($this->attributes,$attributes);
    }

    if (isset($this->attributes['value']))
      unset($this->attributes['value']);

    unset($this->attributes['id']);

    $attribute = '';

    foreach ($this->attributes as $key => $value)
      $attribute .= $key.'="'.$value.'" ';

    $html = '';

    foreach ($this->data as $node) {

      $label = $node['label'];
      $value = $node['value'];

      $checked = '';
      if (in_array($node['value'], $this->activ)) {
        $checked = ' checked="checked" ';
      }

      $html .= '<label class="wgt-label" for="'.$id.'_'.$value.'" >'.$label.'</label>
    <div class="wgt-input '.$this->width.'" ><input id="'.$id.'_'.$value.'" '.$checked.' '.$attribute.' value="'.$value.'" /></div>'.NL;

    }

    return $html;

  }//end public function element */

  /**
   * @param array $attributes
   * @return string
   */
  public function build($attributes = array())
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    $id = $this->getId();

    $html = '<div class="wgt-box input has-clearfix" id="wgt-box-'.$id.'" >'.$this->element().'</div>'.NL;

    return $html;

  }//end public function build */

}//end class WgtItemRadio

