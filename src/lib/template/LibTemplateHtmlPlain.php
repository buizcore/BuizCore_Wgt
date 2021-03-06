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
class LibTemplateHtmlPlain extends LibTemplateHtml
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * what type of view ist this object, html, ajax, document...
   * @var string
   */
  public $type = 'html';

  /**
   * Einfaches bauen der Seite ohne Caching oder sonstige Rücksicht auf
   * Verluste
   *
   * @return void
   */
  public function buildPage()
  {

    if (trim($this->compiled) != '')
      return;

    // Parsing Data
    try {
      $this->buildBody();
    } catch (Exception $e) {

      $content = ob_get_contents();
      ob_end_clean();

      $this->assembledBody = '<h2>Error: '.get_class($e).': '.$e->getMessage().'</h2><pre>'.$content.$e.'</pre>';
    }

    $this->compiled =  $this->assembledBody.NL;

  } // end public function buildPage */

} // end class LibTemplateHtmlPlain

