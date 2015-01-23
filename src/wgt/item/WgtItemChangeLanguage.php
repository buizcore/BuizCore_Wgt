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
class WgtItemInput extends WgtItemAbstract
{

  /**
   * Dummybuildr
   *
   * @return
   */
  public function build()
  {
    return '<input '.$this->asmAttributes().' />'.NL;

  } // end public function build()

} // end class WgtItemInput

