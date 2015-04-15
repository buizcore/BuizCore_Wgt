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
class BuizContactData_Search_Request extends Context
{
    
    /**
     * @var int
     */
    public $idPerson = null;
    
    /**
     * @var int
     */
    public $types = [];

    /**
     * @param LibRequestHttp $request
     */
    public function interpretCustom($request)
    {

        $this->idPerson = $request->param('refid', Validator::EID);
        $this->types = $request->param('type', Validator::CKEY);

    }//end public function interpretCustom */

    
}//end BuizContactData_Search_Request

