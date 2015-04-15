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
 * @package com.buizcore.acl
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class Acl_Manager extends Manager
{


    /**
     * @param string $key
     * @param string $name
     */
    public function addAclArea($key, $name)
    {
        
        $orm = $this->getOrm();
        
        $secArea = new BuizSecurityArea_Entity(true);
        $secArea->access_key = $key;
        $secArea->name = $name;
        
        $orm->save($secArea);
        
    }//end public function addAclArea */

}//end class BuizMessage_Consistency

