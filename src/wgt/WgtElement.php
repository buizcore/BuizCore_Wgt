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
abstract class WgtElement extends WgtAbstract
{

  /**
   * @var string
   */
  public $label = null;

  /**
   * @var array
   */
  public $urls = array();

  /**
   * @var WgtMenuBuilder
   */
  public $menuBuilder = null;

  /**
   * @var array
   */
  public $icons = array();

  /**
   * Die ID des Datensatzes der getaggt werden soll
   * @var int
   */
  public $refId = null;

  /**
   * @var string
   */
  public $idKey = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Getter & Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function getIdKey()
  {

    if (is_null($this->idKey))
      $this->idKey = BuizCore::uniqKey();

    return $this->idKey;

  }//end public function getIdKey */

  /**
   * @param string $idKey
   */
  public function setIdKey($idKey)
  {
    $this->idKey = $idKey;
  }//end public function setIdKey */

  /**
   * @param string $refId
   */
  public function setRefId($refId)
  {
    $this->refId = $refId;
  }//end public function setRefId */

  /**
   * (non-PHPdoc)
   * @see WgtAbstract::setId()
   */
  public function setId($id)
  {
    $this->idKey = $id;
  }//end public function setId */

}//end class WgtElement

