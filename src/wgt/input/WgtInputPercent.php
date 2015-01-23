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
class WgtInputPercent extends WgtInput
{

  /**
   * @param array $attributes
   * @return string
   */
  public function build($attributes = array())
  {

    $id = $this->getId();

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    // add the date validator for datepicker
    if (!isset($this->attributes['class']))
      $this->attributes['class'] = ' has-button';
    else
      $this->attributes['class'] .= ' has-button';

    $icon = View::$iconsWeb;


    if ($this->renderInput) {
    $this->texts->afterInput = <<<HTML
        <var>{"button":"{$id}-ap-button"}</var>
        <button
          id="{$id}-ap-button"
          class="wgt-button append-inp"
          tabindex="-1"  >
          %
        </button>

HTML;
    }
    


    return parent::build();

  } // end public function build */

} // end class WgtInputPercent

