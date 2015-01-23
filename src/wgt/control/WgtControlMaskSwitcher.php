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
class WgtControlMaskSwitcher
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Rendern des Menüs
   * @param LibViewMaintab $view
   * @param WgtDropmenu $menu
   * @param string $context
   * @param Entity $entity
   * @param string $maskName
   */
  public function renderMenu($view, $menu, $context, $entity, $maskName)
  {

  }//end public function renderMenu */

  /**
   * Render des Javascripts
   * @param LibViewMaintab $view
   * @param WgtDropmenu $menu
   */
  public function renderActions($view,  $menu)
  {

    $html = <<<HTML

    self.getObject().find('.{$menu->id}-maskswitcher').change(function() {
      \$R.get(\$S(this).val());
    });

HTML;

    return $html;

  }//end public function renderActions */

} // end class WgtControlMaskSwitcher

