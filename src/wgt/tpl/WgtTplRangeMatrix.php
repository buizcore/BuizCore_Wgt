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
 * Template für ein Modal Element
 * @package net.buizcore.wgt/tpl
 */
class WgtTplRangeMatrix
{

  /**
   * @var LibTemplate $view
   * @var string $id
   * @var string $nameEntries
   * @var int $formId
   * @var string $nameEntries
   * @var array $entries
   */
  public static function render(
    $view,
    $start,  $end,  $step,
    $id,
    $nameEntries,
    $formId,
    $active = null
  )
  {

    $entries = range($start, $end, $step);

    $codeEntries = '';
    foreach ($entries as $entry) {

      $codeChecked = '';
      $codeActive = '';
      if (isset($active->{$entry}) && $active->{$entry}) {
        $codeChecked = ' checked="checked" ';
        $codeActive = "wgt-active";
      }

      $codeEntries .= <<<HTML
    <div class="cell" ><input
      type="checkbox"
      name="{$nameEntries}[{$entry}]"
      {$codeChecked}
      class="hidden {$formId}"
      value="{$entry}" /><button
        class="wgt-button {$codeActive}"
        wgt_key="{$nameEntries}[{$entry}]" >{$entry}</button></div>

HTML;

    }

    $code = <<<HTML

  <div
    id="{$id}"
    class="wcm wcm_ui_button_check_matrix wgt-matrix" >
    {$codeEntries}
  </div>

HTML;

    return $code;

  }//end public static function render */

}//end class WgtTplRangeMatrix

