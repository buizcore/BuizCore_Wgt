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
 * @lang de:
 *
 *
 * @package net.buizcore.wgt
 */
abstract class WgtMatrix_Cell
{

  /**
   * Type der Cell
   * @var string
   */
  public $type = '';

  /**
   * Env object
   * @var Base
   */
  public $env = null;

  /**
   * @param array $data
   */
  public function render($data)
  {

  }//end public function render */

}//end class WgtMatrix_Cell

