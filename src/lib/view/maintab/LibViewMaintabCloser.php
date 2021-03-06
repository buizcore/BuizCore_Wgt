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
 * class WgtItemAbstract
 * Abstraktes View Objekt als Vorlage für alle ViewObjekte
 * @package net.buizcore.wgt
 */
class LibViewMaintabCloser
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var string
   */
  public $id = null ;

/*////////////////////////////////////////////////////////////////////////////*/
// magic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * tt
   * @todo some error handling here!!!
   */
  public function __get($key)
  {
    return null;
  }

  /**
   * tt
   * @todo some error handling here!!!
   */
  public function __set($key , $value)
  {

  }

  /**
   * tt
   * @todo some error handling here!!!
   */
  public function __call($name , $args)
  {

  }//end public function __call */

  /**
   * Enter description here...
   *
   * @param unknown_type $id
   */
  public function __construct($id = null)
  {
    if ($id) {
      $this->id = $id;
    }

  }//end public function __construct */

  /**
   * the buildr method
   * @return string
   */
  public function build()
  {
    return '<tab id="'.$this->id.'" close="true" ></tab>'.NL;

  }//end public function build()

}//end class LibViewMaintabCloser

