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
class WgtInputNumeric extends WgtInput
{

 /**
  * @return string
  */
  public function element($attributes = array())
  {

    $this->classes['ar'] = 'ar';

    if ($this->renderInput) {
        
        return '<input ' . $this->asmAttributes($attributes) . ' />';
        
    } else {
        
        if (! isset($this->attributes['value'])) {
            $this->attributes['value'] = '';
        }
        
        return '<span> ' . $this->attributes['value'] . '</span>';
    }

  }// end public function element */

} // end class WgtInputNumeric

