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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class LibTemplateHtmlPrint extends LibTemplateHtml
{

  /**
   * @var string
   */
  public $keyCss = 'print';

  /**
   * @var string
   */
  public $keyTheme = 'print';

  /**
   * @var string
   */
  public $keyJs = 'print';

  /**
   * doctype of the page
   * @var string
   */
  protected $doctype = View::HTML5;



} // end class LibTemplateHtmlPrint

