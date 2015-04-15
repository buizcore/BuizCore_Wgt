<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
* @projectUrl  : http://buizcore.com
*
* @licence     : BuizCore.com internal only
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class BuizText_Manager extends Manager
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

    /**
     * @param string $mod
     * @param string $key
     * @param string $lang
     */
    public function _($mod, $key, $lang = null)
    {
        
        $file = PATH_CACHE.'/texts/'.$lang.'/'.$mod.'php';
        
        $orm = $this->getOrm();
        
        $val = $orm->getField('BuizText', ['mod_key' =>  $mod, 'access_key' =>$key ], 'content');
        
        if(!$val){
            $val = $key;
        }
        
        return $val;
        
    }//end public function _ */
    
    /**
     * @param string $lang
     * @param string $mod
     */
    public function loadModule($lang, $mod)
    {
        
    }
        

}//end class BuizText_Model

