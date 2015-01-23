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
class WgtTplDialog
{

  /**
   * @var string $id
   * @var string $content
   * @var string $code
   * @var LibTemplate $view
   * @var boolean $out
   */
  public static function render($id, $content, $code, $view, $out = true)
  {

    $html = <<<HTML
  <div id="wgt-dialog-{$id}" class="template" >
    {$content}
  </div>
HTML;

    $view->addJsCode($code);

    if ($out)
      echo $html;

    return $html;

  }//end public static function render */

}//end class WgtTplDialog

