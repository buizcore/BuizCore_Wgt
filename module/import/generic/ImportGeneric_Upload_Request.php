<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
* @projectUrl  : http://buizcore.com
*
* @licence     : Conias
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/


/**
 * @package com.buizcore.conias
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class ImportGeneric_Upload_Request extends Context
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

    public $importKey = '';
    
    /**
     * @var LibUploadFile
     */
    public $importFile = '';
    
    /**
     * @param LibRequestHttp $request
     */
    public function interpretCustom($request)
    {
        
        $this->importKey = $request->data('type',Validator::CKEY);
        
        $this->importFile = $request->file('import_file');
    
    }//end public function interpretCustom */

}//end class ImportGeneric_Upload_Request

