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
class WgtInputIcon extends WgtInput
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * path to the icon
   *
   * @var string
   */
  protected $icon = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * setter for the icon
   *
   * @param string $icon
   */
  public function setIcon($icon)
  {

    $this->icon = $icon;

  }//end public function setIcon($icon)

  /**
   *
   *
   * @return
   */
  public function build($attributes = array())
  {

    if ($attributes) $this->attributes = array_merge($this->attributes,$attributes);

    if (isset($this->attributes['type'])) {
      unset($this->attributes['type']);
    }

    if ($this->icon) {
      $src = 'background:url('.View::$iconsWeb.'xsmall/'.$this->icon.') no-repeat;' ;
    }

    $html = '<input input="text" style="'.$src.'padding-left:20px;" '.$this->asmAttributes().' />';

    return $html;

  } // end public function build()

  public function buildAjax()
  {

    if (isset($this->attributes['type'])) {
      unset($this->attributes['type']);
    }

    $html = '<input '.$this->asmAttributes().' />';

    return $html;

  } // end public function buildAjax()

} // end class WgtItemInput

