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
class WgtItemDummy
{

  /**
   * Die Breite des Elements
   */
  public $message = null;

  /**
   * Den Constructor
   * @param string $Message Die Fehlermeldung
   *
   * @return void
   */
  public function __construct($Message)
  {

    $this->message = $Message;

  } // end of member function __construct

  /** Parserfunktion
   *
   * @return String
   */
  public function build()
  {
    return $this->message;
  } // end of member function build

} // end of WgtItemDummy

