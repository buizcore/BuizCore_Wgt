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
class BuizUserImport_Model extends MvcModel
{
    
    /**
     * @var BuizUserImport_Manager
     */
    public $manager = null;

    /**
     * @param LibRequestHttp $request
     */
    public function handleUpload($request)
    {
        
        $this->manager = new BuizUserImport_Manager($this);
        $this->manager->handleUpload($request);
        
        $this->manager->loadMapping();
        
    }//end public function handleUpload */

    /**
     * mapping request auswerten
     * @param LibRequestHttp $request
     */
    public function handleMapping($request)
    {
        
        $this->manager = new BuizUserImport_Manager($this);
        $this->manager->handleMapping($request);
        
    }//end public function handleUpload */

    /**
     * import durchführen
     * @param LibRequestHttp $request
     */
    public function executeImport($request)
    {
        
        $this->manager->executeImport($request);
        
    }//end public function executeImport */


 

}//end EventImportVisitors_Model

