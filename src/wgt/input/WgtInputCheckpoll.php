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
class WgtInputCheckpoll extends WgtInput
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
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
  public function setElements($data)
  {
    $this->data = $data;
  }//end public function setElements */

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

      if (!isset($this->attributes['name'])) {
        Log::warn(__FILE__,__LINE__,'invalid attributes for checkpoll');

        if (Log::$levelDebug)
          return 'invalid attributes for checkpoll';
        else
          return '';
      }
      
      if($attributes){
          $this->attributes = array_merge($this->attributes,$attributes);
      }

      $name = $this->attributes['name'];

      unset($this->attributes['id']);

      $attribute = '';

      foreach ($this->attributes as $key => $value)
        $attribute .= $key.'="'.$value.'" ';

      $html = '';

      foreach ($this->data as $value => $label) {
        $html .= '
        <label class="wgt-label" for="'.$id.'_'.$value.'" >'.$label.'</label>
        <div class="wgt-input '.$this->width.'" >
          <input id="'.$id.'_'.$value.'" name="'.$name.'['.$value.']" '.$attribute.' />
        </div>'.NL;

      }

      return $html;

  }//end public function element */

  /**
   *
   * @param $attributes
   * @return unknown_type
   */
  public function build($attributes = array())
  {

    if ($attributes) $this->attributes = array_merge($this->attributes,$attributes);

    $id = $this->getId();

    $html = '<div class="wgt-box input has-clearfix" id="wgt-box-'.$id.'" >'.$this->element().'</div>'.NL;

    return $html;

  }//end public function build($attributes = array())

}//end class WgtItemRadio

