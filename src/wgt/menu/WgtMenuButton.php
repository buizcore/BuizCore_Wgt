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
class WgtMenuButton
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  public $place = 'replace';

  /**
   * the name of the submenu
   *
   * @var string
   */
  protected $text = null;

  /**
   * the name of the submenu
   *
   * @var string
   */
  protected $icon = null;

  /**
   * the name of the submenu
   *
   * @var string
   */
  protected $action = 'dummy';

  /**
   * Enter description here...
   *
   * @var boolean
   */
  protected $isAction = true;

/*////////////////////////////////////////////////////////////////////////////*/
// Constructor
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param string $name
   * @param string $action
   * @param string $icon
   */
  public function __construct($text = null , $action = null, $icon = null , $isAction = true)
  {

    if ($text) {
      $this->text = $text;
    }

    if ($action) {
      $this->action = $action;
    }

    if ($icon) {
      $this->icon = $icon;
    }

    $this->isAction = $isAction;

  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * set the menu name
   *
   * @param string $text
   */
  public function setText($text)
  {
    $this->text = $text ;
  }//end public function setText */

  /**
   * set the menu name
   *
   * @param string $name
   */
  public function setIcon($icon)
  {
    $this->icon = $icon ;
  }//end public function setIcon */

  /**
   * set the menu name
   *
   * @param string $name
   */
  public function setAction($action)
  {
    $this->action = $action ;
    $this->isAction = true;
  }//end public function setAction */

  /**
   * set the menu name
   *
   * @param string $name
   */
  public function setUrl($url)
  {
    $this->action = $url;
    $this->isAction = false;
  }//end public function setUrl */

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   * @return string
   */
  public function toXml()
  {

    if ($this->isAction) {
      $action = $this->action;
    } else {
      $action = urlencode($this->action);
    }
    $baseFolder = View::$iconsWeb.'xsmall/';

    return '<button action="'.$this->place.'" id="button_'.str_replace(' ','_',$this->text).'" icon="'.$baseFolder.$this->icon.'" value="'.$this->text.'" callback="'.$action.'" />'.NL;
  }//end public function toXml */

  /**
   * @return string
   */
  public function build($menu)
  {
    if ($this->icon) {
      $baseFolder = View::$iconsWeb.'xsmall/';
      $icon = '"'.$baseFolder.$this->icon.'"';
    } else {
      $icon = 'null';
    }

    if ($this->isAction) {
      $action = $this->action;
    } else {
      $action = '"'.$this->action.'"' ;
    }

    return  $menu.'.addButton("'.$this->text.'", '.$icon.', '.$action.' , "button_'.str_replace(' ','_',$this->text).'");'.NL;

  }//end public function build */

} // end class WgtMenuButton

