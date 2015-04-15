<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore
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
 * @copyright BuizCore.com <BuizCore.com>
 * @licence BuizCore.com
 */
class BuizCoreAddress_Search_Request extends Context
{
    
    /**
     * @var int
     */
    public $idPerson = null;

    /**
     * @param LibRequestHttp $request
     */
    public function interpretCustom($request)
    {

        $this->idPerson = $request->param('refid',Validator::EID);

    }//end public function interpretCustom */

    
}//end BuizCoreAddress_Search_Request

