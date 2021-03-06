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
 * class WgtTreeMenu
 * @package net.buizcore.wgt
 */
class WgtTreeMenu extends WgtMenu
{

  /**
   *
   */
  public function build()
  {

    $html = '';

    foreach ($this->data as $node) {
      $html .= '<li><a class="wcm wcm_req_ajax" href="'.$node[WgtMenu::ACTION].'" >';

      if ($node[WgtMenu::ICON])
        $html .= Wgt::icon($node[WgtMenu::ICON] , 'xsmall' , $node[WgtMenu::TITLE]);

      $html .= $node[WgtMenu::TEXT];

      $html .= '</a></li>';
    }

    return $this->decorateMenu($html);

  }//end public function build */

  /**
   *
   */
  public function buildAjax()
  {

  }//end public function buildAjax */

  /**
   * @param $menu
   */
  protected function decorateMenu($menu)
  {

    $html = '<ul class="wgt_menu_tree" >';
    $html .= $menu;
    $html .= '</ul>';

    return $html;
  }//end protected function decorateMenu */

}// end class WgtTreeMenu

