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
class BuizText_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibTemplate $view
   * @param array $keys
   * @return void
   */
  public function apppendTexts($view , $keys)
  {

    $cond = "'".implode($keys , "','")."'";

    $sql = <<<CODE
SELECT access_key as k, content as c from buiz_text where access_key in({$cond});

CODE;

    $res = $this->getDb()->select($sql);

    $texts = [];
    foreach ($res as $text) {
      $texts['text_'.strtolower($text['k'])] = $text['c'];
    }

    $view->addVar($texts);

  }//end public function apppendTexts */

}//end class BuizText_Model

