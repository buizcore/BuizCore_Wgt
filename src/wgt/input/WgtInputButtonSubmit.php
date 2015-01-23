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
 * class WgtItemAutocomplete
 * Objekt zum generieren einer Inputbox
 * @package net.buizcore.wgt
 */
class WgtInputButtonSubmit extends WgtInput
{

  /**
   * Parser for the input field
   *
   * @return String
   */
  public function build($attributes = array())
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    $this->attributes['type'] = 'submit';

    $attributes = $this->asmAttributes();

    $html = '<input '.$attributes.' />'.NL;

    return $html;

  } // end public function build()

} // end class WgtItemInput

