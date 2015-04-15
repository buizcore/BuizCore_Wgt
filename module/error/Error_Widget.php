<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
* @projectUrl  : http://buizcore.com
*
* @licence     : BuizCore.com internal only
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class Error_Widget extends WgtWidget
{

  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function asTab($view, $tabId, $tabSize = 'medium')
  {

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize}" title="error"  >
      <h2>The Widget you requested was not loadable</h2>
      <div class="do-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */


  /**
   * @param LibTemplate $view
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function reload($view, $tabId)
  {

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab medium" title="error"  >
      <h2>The Widget you requested was not loadable</h2>
      <div class="do-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */

} // end class Error_Widget

