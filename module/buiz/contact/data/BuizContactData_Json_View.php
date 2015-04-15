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
class BuizContactData_Json_View extends LibViewJson
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
    * @param BuizContactData_Save_Request $params Flow Control Flags
    *
    */
    public function displaySave($params)
    {
    
        $data['rowid'] = $params->item->getId();
        $this->setRawJsonData($data);
    
    }//end public function displaySave */
    
    /**
     * Das Edit Form der EventType_Exhibition Maske
     *
     * @param int $objid Die Objid der Hauptentity
     * @param BuizContactData_Save_Request $params Flow Control Flags
     *
     */
    public function displaySaveAll($params)
    {

    
    }//end public function displaySaveAll */
    
    /**
     * Das Edit Form der EventType_Exhibition Maske
     *
     * @param int $objid Die Objid der Hauptentity
     * @param BuizContactData_Save_Request $params Flow Control Flags
     *
     */
    public function displayDelete($params)
    {
    
        $data['rowid'] = $params->objid;
        $this->setDataBody($data);
    
    }//end public function displayDelete */
    
    /**
     * Das Edit Form der EventType_Exhibition Maske
     *
     * @param int $objid Die Objid der Hauptentity
     * @param BuizContactData_Save_Request $params Flow Control Flags
     *
     */
    public function displaySearch($params)
    {
    
        $manager = new BuizContactData_Manager($this);
        $data = $manager->getItemList($params->idPerson, $params->types);
        $this->setRawJsonData( array('entries' => $data) );
    
    }//end public function displaySearch */
  

}//end class BuizContactData_Json_View

