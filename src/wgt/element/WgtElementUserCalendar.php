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
 * Kallender Element für den Desktop
 * @package net.buizcore.wgt
 */
class WgtElementUserCalendar extends WgtAbstract
{

  /**
   * @return string
   */
  public function render($params = null)
  {

    $codeEntr = '';

    /**
     * title:
     * content:
     */
    foreach ($this->data as $entry) {

      $codeEntr .= <<<HTML

  <li class="entry" >
    <h3>{$entry['title']} <span class="date" >[{$entry['created']}]</span></h3>
    <div>{$entry['content']}</div>
  </li>

HTML;

    }

    $id = $this->getId();

    $html = <<<HTML

<ul id="{$id}" class="wgt-news-list" >
{$codeEntr}
</ul>

HTML;

    return $html;

  } // end public function render */

} // end class WgtElementUserCalendar

