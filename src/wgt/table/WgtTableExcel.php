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
abstract class WgtTableExcel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * backref to the owning view element
   * @var LibTemplate
   */
  public $view = null;

  /**
   *
   * @var array
   */
  protected $data = array();

/*////////////////////////////////////////////////////////////////////////////*/
// Magic methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param string $name
   */
  public function __construct($name = null)
  {
    $this->name = $name;
  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// getter and setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param array $data
   * @param array $value
   * @return void
   */
  public function setData($data  )
  {

    if (!$data)
      return;

    $this->data = $data;

  }//end public function setData */

  /**
   * request the existing tables
   *
   * @return array
   */
  public function getData()
  {
    return $this->data;
  }//end public function getData */

} // end abstract class WgtTableExel

