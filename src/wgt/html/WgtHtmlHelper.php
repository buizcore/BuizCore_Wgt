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
class WgtHtmlHelper
{

    /**
     * @param mixed $value
     * @return string
     */
    public function booleanToCheckIcon( $value )
    {
        
        if ('t'==$value||1==$value||true===$value) {
            return '<i class="fa fa-check-square-o" ></i>';
        } else {
            return '<i class="fa fa-square-o" ></i>';
        }
        
    }

} // end class WgtHtmlHelper

