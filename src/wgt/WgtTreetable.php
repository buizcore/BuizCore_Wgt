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
 *
 */
abstract class WgtTreetable extends WgtTable
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attribute
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  protected $num = 0;

  /**
   * @var string
   */
  public $type = 'treetable';

/*////////////////////////////////////////////////////////////////////////////*/
// Method
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function menuNumEntries()
  {

    ///@todo extend this
    //wcm wcm_req_page '.$this->searchForm
    // $S(\'form#'.$this->searchForm.'\').data(\'size\',$S(this).val());

    //$onchange = 'onchange="$S(\'form#'.$this->searchForm.'\').data(\'qsize\',$S(this).val());$R.form(\''.$this->searchForm.'\');"';
    $onchange = 'onchange="$S(\'table#'.$this->id.'-table\').grid(\'pageSize\', \''.$this->searchForm.'\',this)"';

    if (!$sizes = Conf::status('ui.listing.numEntries'))
      $sizes = array(10,25,50,100,250,500);

    $menu = '<select class="wgt-no-save small" '.$onchange.' >';

    foreach ($sizes as $size) {
      $selected = ($size==$this->stepSize)?'selected="selected"':'';
      $menu .= '<option value="'.$size.'" '.$selected.' >'.$size.'</option>';
    }

    $menu .= '</select>';

    return $menu;

  }//end public function menuNumEntries */

}//end class WgtTreetable
