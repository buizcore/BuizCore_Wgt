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
class WgtBitmaskDatacategory extends WgtAbstract
{
/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param $activ
   * @return null
   */
  public function setActive($activ = true)
  {
    $this->activ = new TBitmask($activ);
  }//end public function setActiv */

  /*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @return string
   */
  public function build()
  {

    if (is_null($this->activ)) {
      $this->activ = new TBitmask();
    }

    $checked0 = $this->activ['0']?'checked="checked"':'';
    $checked1 = $this->activ['1']?'checked="checked"':'';
    $checked2 = $this->activ['2']?'checked="checked"':'';
    $checked3 = $this->activ['3']?'checked="checked"':'';

    return <<<HTML

    <ul class="wgt-list inline">
      <li><input type="checkbox" {$checked0} name="{$this->attributes['name']}[0]" title="public" /></li>
      <li><input type="checkbox" {$checked1} name="{$this->attributes['name']}[1]" title="public" /></li>
      <li><input type="checkbox" {$checked2} name="{$this->attributes['name']}[2]" title="public" /></li>
      <li><input type="checkbox" {$checked3} name="{$this->attributes['name']}[3]" title="public" /></li>
    </ul>

HTML;

  }//end public function build()

  /**
   * Enter description here...
   *
   * @return unknown
   */
  public function buildAsTd()
  {

    if (is_null($this->activ)) {
      $this->activ = new TBitmask();
    }

    $checked0 = $this->activ['0']?'checked="checked"':'';
    $checked1 = $this->activ['1']?'checked="checked"':'';
    $checked2 = $this->activ['2']?'checked="checked"':'';
    $checked3 = $this->activ['3']?'checked="checked"':'';

    return <<<HTML

    <td><input type="checkbox" {$checked0} name="{$this->attributes['name']}[0]" title="public" /></td>
    <td><input type="checkbox" {$checked1} name="{$this->attributes['name']}[1]" title="public" /></td>
    <td><input type="checkbox" {$checked2} name="{$this->attributes['name']}[2]" title="public" /></td>
    <td><input type="checkbox" {$checked3} name="{$this->attributes['name']}[3]" title="public" /></td>


HTML;

  }//end public function buildAsTd */

}//end class WgtBitmaskDatacategory

