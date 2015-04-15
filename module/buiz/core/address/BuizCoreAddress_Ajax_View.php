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
 * @copyright BuizCore.com <BuizCore.com>
 * @licence BuizCore.com
 */
class BuizCoreAddress_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * @var BuizUserImport_Model
    */
    public $model = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * Das Edit Form der EventType_Exhibition Maske
    *
    * @param int $objid Die Objid der Hauptentity
    * @param BuizCoreAddress_Save_Request $params Flow Control Flags
    *
    */
    public function displaySave($params)
    {
    
        $data['rowid'] = $params->address->getId();
        $this->setRawJsonData($data);
    
    }//end public function displaySave */
    
    /**
     * Das Edit Form der EventType_Exhibition Maske
     *
     * @param int $objid Die Objid der Hauptentity
     * @param BuizCoreAddress_Save_Request $params Flow Control Flags
     *
     */
    public function displaySaveAll($params)
    {
    
    }//end public function displaySaveAll */
    
    /**
     * Das Edit Form der EventType_Exhibition Maske
     *
     * @param int $objid Die Objid der Hauptentity
     * @param BuizCoreAddress_Save_Request $params Flow Control Flags
     *
     */
    public function displayDelete($params)
    {
    
        $data['rowid'] = $params->objid;
        $this->setRawJsonData($data);
    
    }//end public function displayDelete */
    
    /**
     * Das Edit Form der EventType_Exhibition Maske
     *
     * @param int $objid Die Objid der Hauptentity
     * @param BuizCoreAddress_Save_Request $params Flow Control Flags
     *
     */
    public function displaySearch($params)
    {
    
        $manager = new BuizCoreAddress_Manager($this);
        $data = $manager->getAddressList($params->idPerson);
        
        
        $this->setRawJsonData( array('entries' => $data) );
    
    }//end public function displaySearch */
  

}//end class BuizCoreAddress_Ajax_View

