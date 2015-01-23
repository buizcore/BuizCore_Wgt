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
class WgtMatrix_Cell_Counter
 extends WgtMatrix_Cell
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Type des cell values
   * @var string
   */
  public $type = 'counter';

  /**
   * @param array $data
   */
  public function render($data)
  {
    return count($data).' Items';
  }//end public function render */

}//end class WgtMatrix_Cell_Counter

