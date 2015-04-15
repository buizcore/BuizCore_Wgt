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
class WbfpageText_Model extends MvcModel
{

  /**
   *
   * @var array
   */
  protected $texts = [];

  /**
   * @return string
   */
  public function text($key)
  {
    return isset($this->texts[$key])?$this->texts[$key]:'<!-- missing '.$key.' -->';
  }//end public function text */

  /**
   * @param array $keys
   * @return array
   */
  public function loadTexts($keys)
  {

    $this->texts = [];

    $condKeys = "'".implode("','",$keys)."'";

    $query = <<<CODE
select access_key, content from buiz_text where access_key in({$condKeys});
CODE;

    $result = $this->getDb()->select($query);

    foreach ($result as $entry) {
      $this->texts[$entry['access_key']] = $entry['content'];
    }

    return $this->texts;

  }//end public function getTexts */

}//end class WbfpageText_Model

