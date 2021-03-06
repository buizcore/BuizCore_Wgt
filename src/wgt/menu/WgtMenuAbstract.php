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
 * @deprecated use WgtMenu
 */
abstract class WgtMenuAbstract
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * the data array
   *
   * @var array
   */
  protected $data = array();

  /**
   * is the menu already assembled
   *
   * @var boolean
   */
  protected $assembled = null;

  /**
   * id of the Menu
   *
   * @var string
   */
  protected $name = null;

  /**
   * xml/html id of the menu
   *
   * @var string
   */
  protected $menuId = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Magic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * constructor
   *
   * @return string
   */
  public function __construct($name , $id = null)
  {
    $this->name = $name;
  }//end public function __construct */

  /**
   * the to string method
   *
   * @return string
   */
  public function __toString()
  {
    return $this->build();
  }//end public function __toString  */

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * setter for the menu id
   *
   * @param string $id
   */
  public function setId($id)
  {
    $this->menuId = $id;
  }//end public function setId */

  /**
   * setter for the menu name
   *
   * @param string $name
   */
  public function setName($name)
  {
    $this->name = $name;
  }//end public function setName */

  /**
   * Enter description here...
   *
   * @return string
   */
  public function toHtml()
  {
    if ($this->assembled) {
      return $this->assembled;
    } else {
      return $this->build();
    }
  }//end public function toHtml */

  /**
   * the Load function
   *
   */
  public function load()
  {
    // debug is here ok despire of that this will give a warning
    if (Log::$levelDebug)
     Log::startOverride(__FILE__,__LINE__,__METHOD__);

  }//end public function load */

  /**
   * @return string
   */
  abstract public function build();

} // end WgtMenuAbstract

