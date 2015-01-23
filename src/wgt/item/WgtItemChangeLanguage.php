<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
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
 * @package net.webfrap.wgt
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

