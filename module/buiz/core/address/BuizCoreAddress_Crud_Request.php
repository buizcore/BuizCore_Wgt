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
class BuizCoreAddress_Crud_Request extends Context
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
    public $address = null;
    
    /**
     * @var boolean
     */
    public $isNew = false;
    
    /**
     * @var array
     */
    public $fields = array(
        'name',
        'street',
        'street_no',
        'zip',
        'city',
        'id_country',
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
            'street',
            'zip',
            'city',
        );
        
        $orm = $this->env->getOrm();
        $response = $this->env->getResponse();
        
        if ($this->objid) {
        
            $coreAddress = $orm->get('CoreAddress',$this->objid);
            $request->validateUpdate(
                $coreAddress,
                'address',
                $this->fields,
                $reqfields
            );
        
        } else {
        
            $coreAddress = $orm->newEntity('CoreAddress');
            $request->validateInsert(
                $coreAddress,
                'address',
                $this->fields,
                $reqfields
            );
            $this->isNew = true;
        }
        
        $coreAddress->vid = $this->idPerson;
        $this->address = $coreAddress;
        
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

        $orm = $this->env->getOrm();
        $response = $this->env->getResponse();
    
        $reqfields = array(
            'street',
            'zip',
            'city',
        );
    
        $this->address = $request->validateMultiSave(
            'CoreAddress',
            'address',
            $this->fields,
            $reqfields
        );
        
        foreach($this->address as $address){
            $address->vid = $this->idPerson;
        }

        if ($response->hasErrors()) {
            throw new InvalidRequest_Exception('Fehler in der Anfrage');
        }
    
    }//end public function fetchMultiFormData */
    
}//end BuizCoreAddress_Save_Request

