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
 * @package net.buizcore.wgt
 */
class WgtInputSearchCheckbox extends WgtInput
{
/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string
   * @deprecated
   */
  public function setChecked($activ)
  {

    if ($activ) {
      $this->attributes['checked'] = "checked";
    } else {
      if (isset($this->attributes['checked'])) {
        unset($this->attributes['checked']);
      }
    }

  }//end public function setChecked

  /**
   * @param string
   */
  public function setActive($activ = true)
  {

    if ($activ) {
      $this->attributes['checked'] = "checked";
    } else {
      if (isset($this->attributes['checked'])) {
        unset($this->attributes['checked']);
      }
    }

  }//end public function setActive($activ = true)

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return unknown_type
   */
  public function build($attributes = array())
  {

    if ($attributes) $this->attributes = array_merge($this->attributes,$attributes);

    // ist immer ein text attribute
    $this->attributes['type']= 'checkbox';

    $attributes = $this->asmAttributes();

    $required = $this->required?'<span class="wgt_required">*</span>':'';

    $html = '<div class="wgt_box input" id="wgt-box-'.$this->attributes['id'].'" >
      <label class="wgt-label" for="'.$this->attributes['id'].'" >'.$this->label.' '.$required.'</label>
      <div class="wgt-input" ><input '.$attributes.' /></div>
      <div class="do-clear tiny" >&nbsp;</div>
    </div>'.NL;

    return $html;

  } // end public function build()

  /**
   * Dummybuildr
   *
   * @return string
   */
  public function buildAjax()
  {
    return '<input '.$this->asmAttributes().' />';

  } // end public function buildAjax()

}//end class WgtInputCheckbox

