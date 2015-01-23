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
abstract class WgtItemAbstract extends WgtAbstract
{

 /**
  * @param mixed $data
  * @return void
  */
  public function setContent($data)
  {

    $this->attributes['value'] = $data;

  }// end public function setContent */

 /**
  * @return mixed
  */
  public function getContent()
  {
    return $this->attributes['value'];

  }// end public function getContent */

} // end class WgtItemAbstract

