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
 * class WgtItemButton
 * Objekt zum generieren einer Inputbox
 * @package net.buizcore.wgt
 */
class WgtInputButton extends WgtInput
{

  /**
   *
   *
   * @return string
   */
  public function build($attributes = array())
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    if (!isset($this->attributes['class']))
      $this->attributes['class'] = 'wgt-button';

    if (!isset($this->attributes['tabindex']))
      $this->attributes['tabindex'] = '-1';

    $attributes = $this->asmAttributes();
    $html = '<button name="'.$this->getName().'" '.$attributes.' />'.NL;

    return $html;

  } // end public function build()

} // end class WgtItemButton

