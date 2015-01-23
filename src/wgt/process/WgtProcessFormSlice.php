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

/** Form Class
 *
 * @package net.buizcore.wgt
 */
class WgtProcessFormSlice
{
/*////////////////////////////////////////////////////////////////////////////*/
// public interface attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * der Prozess
   * @var LibProcessSlice
   */
  public $sliceData = null;

  /**
   * @param LibProcessSlice $sliceData
   */
  public function __construct($sliceData)
  {

    $this->sliceData = $sliceData;

  }//end public function __construct */

  public function getI18n()
  {
    return BuizCore::$env->getI18n();
  }//end public function getI18n */

}//end class WgtProcessFormSlice

