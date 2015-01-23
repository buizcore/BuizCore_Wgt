<?php

/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * Input element for Intvalues
 * 
 * @package net.webfrap.wgt
 */
class WgtInputInt extends WgtInput
{

    /**
     * @param array $attributes
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
        
    } // end public function element */
    
} // end class WgtInputInt

