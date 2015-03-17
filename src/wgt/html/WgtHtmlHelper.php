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
        
    }//end public function booleanToCheckIcon */
    
    /**
     * @param string $name
     * @param string $alt
     * @param string $size
     */
    public function icon($name, $alt, $size = 'xsmall', $attributes = array())
    {
    
        $attributes['alt'] = $alt;
    
        return Wgt::icon($name, $size, $attributes);
    
    }//end public function icon */
    
    /**
     * @param string $name
     * @param string $alt
     * @param string $size
     */
    public function iconUrl($name, $size = 'xsmall')
    {
        return Wgt::iconUrl($name, $size);
    
    }//end public function iconUrl */
    
    /**
     * @param string $name
     * @param string $param
     * @param boolean $flag
     */
    public function image($name, $param, $flag = false)
    {
        return Wgt::image($name, array('alt'=>$param),true);
    
    }//end public function image */

} // end class WgtHtmlHelper

