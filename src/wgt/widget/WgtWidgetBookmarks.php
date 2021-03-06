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
class WgtWidgetBookmarks extends WgtWidget
{

  /**
   * @param string $containerId
   * @param string $tabId
   * @param string $tabSize
   * @return void
   */
  public function asTab($containerId, $tabId, $tabSize = 'medium')
  {

    $db = $this->getDb();
    $user = $this->getUser();
    $view = $this->getView();

    $query = $db->newQuery('BuizBookmark');
    $query->fetch($this->getUser()->getId());

    $table = $view->newItem('widgetDesktopBookmark' , 'TableBuizBookmark');
    $table->setData($query);
    $table->setId('wbf_desktop_bookmark');

    $html = <<<HTML
   <div id="{$tabId}" title="My Bookmarks" class="wgt_tab {$tabSize} {$containerId}"  >

      <fieldset>
        <legend>filter</legend>

        <form>
          <input type="text" class="medium" /> <button class="wgt-button" tabindex="-1" >{$view->i18n->l('Search','wfb.label.search')}</button>
        </form>

      </fieldset>

      <div class="do-clear small"></div>

      <div>{$table}</div>

      <div class="do-clear small"></div>

   </div>
HTML;

    return $html;

  }//end public function asTab */

} // end class WgtWidgetBookmarks

