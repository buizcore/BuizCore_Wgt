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
class BuizContactData_Crud_Request extends Context
{
    
    /**
     * @var int
     */
    public $idPerson = null;
    
    /**
     * @var int
     */
    public $objid = null;
    
    /**
     * @var Entity
     */
    public $item = null;
    
    /**
     * @var boolean
     */
    public $isNew = false;
    
    /**
     * @var array
     */
    public $fields = array(
        'address_value',
        'id_type',
        'flag_private',
        'description'
    );
    
    /**
     * @param LibRequestHttp $request
     */
    public function interpretCustom($request)
    {

        $this->objid = $this->getOID();
        $this->idPerson = $request->param('refid',Validator::EID);


    }//end public function interpretCustom */
    
    /**
     * interpretieren der formdata
     * @param LibRequestHttp $request
     * 
     * @throws InvalidRequest_Exception
     */
    public function fetchFormData($request)
    {

        $reqfields = array(
            'address_value'
        );
        
        $orm = $this->env->getOrm();
        $response = $this->env->getResponse();
        
        if ($this->objid) {
        
            $addrItem = $orm->get('BuizAddressItem',$this->objid);
            $request->validateUpdate(
                $addrItem,
                'cdata',
                $this->fields,
                $reqfields
            );
        
        } else {
        
            $addrItem = $orm->newEntity('BuizAddressItem');
            $request->validateInsert(
                $addrItem,
                'cdata',
                $this->fields,
                $reqfields
            );
            $this->isNew = true;
        }
        
        if (!$addrItem->id_type) {
            $typeKey = $request->data('cdata',Validator::CKEY,'type_key');
            
            if ($typeKey) {
                $addrItem->id_type = $orm->getIdByKey('BuizAddressItemType', $typeKey);
            }
        }
        
        $addrItem->vid = $this->idPerson;
        $this->item = $addrItem;
        
        if ($response->hasErrors()) {
            throw new InvalidRequest_Exception('Fehler in der Anfrage');
        }
        
    }//end public function fetchFormData */
    
    /**
     * interpretieren der formdata
     * @param LibRequestHttp $request
     *
     * @throws InvalidRequest_Exception
     */
    public function fetchMultiFormData($request)
    {
    
        $reqfields = array(
            'id_type',
            'address_value'
        );
    
        $orm = $this->env->getOrm();
        $response = $this->env->getResponse();
        
        $this->item = $request->validateMultiSave(
            'BuizAddressItem',
            'cdata',
            $this->fields,
            $reqfields
        );
        
        foreach($this->item as $addrItem){
            $addrItem->vid = $this->idPerson;
        }
    
    
        if ($response->hasErrors()) {
            throw new InvalidRequest_Exception('Fehler in der Anfrage');
        }
    
    }//end public function fetchMultiFormData */
    
}//end BuizContactData_Save_Request

