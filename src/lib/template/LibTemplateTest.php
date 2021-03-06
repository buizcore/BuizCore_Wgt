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
class LibTemplateTest extends LibTemplateHtml
{

  /**
   * build the page
   *
   * @return string the assembled page
   */
  public function build()
  {

    $filename = PATH_TEST.'templates/template/'.$this->template.'.tpl';

    if (file_exists($filename) and is_readable($filename)) {

      $VAR = $this->var;
      $ITEM = $this->object;
      $LANG = $this->getI18n();
      $USER = $this->getUser();

      ob_start();
      include $filename;
      $content = ob_get_contents();
      ob_end_clean();

      //$this->html = $this->head.$content.$this->foot;
      return $content ;
    } else {
      if (Log::$levelDebug)
        return '!!!Template:'.$filename.' not exists ';
      else
        return '<strong class="wgt-box error">!!!Sorry an error occured!!!</strong><!-- '.$filename.' -->';
    }

  } // end public function build()

} // end class LibTemplateTest

