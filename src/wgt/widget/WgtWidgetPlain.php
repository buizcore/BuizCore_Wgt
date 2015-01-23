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
 * @author Dominik Bonsch
 * @copyright Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class WgtWidgetPlain extends WgtWidget
{

  /**
   * @param string $containerId
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function asTab($containerId, $tabId, $tabSize = 'medium')
  {

    $html = <<<HTML
    <div id="{$tabId}" class="wgt_tab {$tabSize} {$containerId}" title="Plain"  >
      <div class="do-clear small"></div>
    </div>
HTML;

    return $html;

  }//end public function asTab */

} // end class WgtWidgetPlain

