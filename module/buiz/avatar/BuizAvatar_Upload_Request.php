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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.
 *
 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class BuizAvatar_Upload_Request extends Context
{
    
    /**
     * @var int
     */
    public $objid = null;

    /**
     * @var int
     */
    public $tSource = null;

    /**
     * @var int
     */
    public $tField = null;

    /**
     * Domainkey
     * @var string
     */
    public $dKey = null;

    /**
     * @var int
     */
    public $imgId = null;

    /**
     * @var int
     */
    public $dimX = null;

    /**
     * @var int
     */
    public $dimY = null;
    
    /**
     * @param LibRequestHttp $request
     */
    public function interpretCustom($request)
    {

        $this->objid = $this->getOID();

        $this->tSource = $request->param('ts', Validator::CKEY);
        $this->tField = $request->param('tf', Validator::CKEY);
        $this->imgId = $request->param('elem', Validator::CKEY);
        $this->dKey = $request->param('dkey', Validator::CKEY);
        
        $tmp = $request->param('dim', Validator::SEARCH);
        $tmp = explode('-', $tmp);
        $this->dimX = $tmp[0];
        $this->dimY = isset($tmp[1])?$tmp[1]:null;
    
    }//end public function interpretCustom */
    
    /**
     * @return LibUploadImage
     */
    public function getUpload()
    {
        
        return $this->request->file('image', 'Image');
        
    }//end public function getUpload */
    
}//end BuizAvatar_Upload_Request

