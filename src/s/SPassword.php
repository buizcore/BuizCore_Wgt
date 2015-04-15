<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : Buiz Developer Network <contact@buiz.net>
* @project     : Buiz Web Frame Application
* @projectUrl  : http://buiz.net
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
class SPassword
{

    public static function buildToken($size = 6)
    {
        return substr(BuizCore::uniqKey(), 0,$size);
    }  

}// end SPassword

