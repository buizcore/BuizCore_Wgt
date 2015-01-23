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
 * Objekt zum generieren einer Inputbox
 * @package net.buizcore.wgt
 */
class WgtInputNumber extends WgtInputInt
{

 /**
  * @return string
  */
  public function element($attributes = array())
  {

    $this->classes['ar'] = 'ar';

    return '<input '.$this->asmAttributes($attributes).' />';

  }// end public function element */

} // end class WgtItemInput

