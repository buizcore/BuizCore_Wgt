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
class BuizText_Provider extends Provider
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  protected $texts = [];
  
  /**
   * @param string $key
   * @return string
   */
  public function __get($key)
  {
    
    if (!isset($this->texts[$key])) {
      $this->loadText($key);
    }
    
    return isset($this->texts[$key])?$this->texts[$key]:null;
  }//end public function __get */
  
  /**
   * @param string $key
   * @return string
   */
  public function __isset($key)
  {
  
    if (!isset($this->texts[$key])) {
      $this->loadText($key);
    }
  
    return isset($this->texts[$key])?true:false;
    
  }//end public function __isset */
  
  /**
   * @param LibTemplate $view
   * @param array $keys
   * @return void
   */
  public function loadText($key)
  {

    $sql = <<<CODE
SELECT access_key as k, content as c from buiz_text where access_key = '{$key}';

CODE;

    $res = $this->getDb()->select($sql);

    $texts = [];
    foreach ($res as $text) {
      $this->texts[strtolower($text['k'])] = $text['c'];
    }

  }//end public function loadText */

  /**
   * @param LibTemplate $view
   * @param array $keys
   * @return void
   */
  public function loadTexts($keys)
  {
  
    $cond = "'".implode($keys , "','")."'";
  
    $sql = <<<CODE
SELECT access_key as k, content as c from buiz_text where access_key IN({$keys});

CODE;

    $res = $this->getDb()->select($sql);

    $texts = [];
    foreach ($res as $text) {
      $this->texts[strtolower($text['k'])] = $text['c'];
    }
  
  }//end public function loadTexts */
  
}//end class BuizText_Provider

