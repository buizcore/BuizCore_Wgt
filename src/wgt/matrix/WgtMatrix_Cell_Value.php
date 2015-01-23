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
class WgtMatrix_Cell_Value
 extends WgtMatrix_Cell
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $openUrl = null;

  /**
   * @var string
   */
  public $keyField = null;

  /**
   * @var string
   */
  public $labelField = null;

  /**
   * Type des cell values
   * @var string
   */
  public $type = 'short';

/*////////////////////////////////////////////////////////////////////////////*/
// Method
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param array $data
   */
  public function render($dataList)
  {

    $html = array();

    foreach ($dataList as $node) {
      $html[] = '<a class="wcm wcm_req_ajax" href="'.$this->openUrl.$node[$this->keyField].'" >'.$node[$this->labelField].'</a>';
    }

    return implode(', ', $html);

  }//end public function render */

}//end class WgtMatrix_Cell_Id

