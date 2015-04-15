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
class BuizAnnouncement_Create_Request extends Context
{

    /**
     * Die ID der Person an welche die Nachricht geschickt wurde
     * @var int
     */
    public $refId = null;
    
    /**
     * @var fields
     */
    public $fields = array(
    	'announcement' => array(
    	   'title' => array(Validator::TEXT, null),
    	   'message'  => array(Validator::TEXT, null),
    	   'importance'  =>  array(Validator::INT, 30),
    	   'vid'  =>  array(Validator::INT, null)
        )
    );

    
    /**
     * @param LibRequestHttp $request
     */
    public function interpretCustom($request)
    {

        $this->validateFields($request);

    }//end public function interpretCustom */
    

}//end BuizAnnouncement_Create_Request

