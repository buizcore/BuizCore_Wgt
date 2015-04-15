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
class BuizUserImport_Manager extends Import_Manager
{
    
    /**
     * Flag ob das Passwort plaintext ist und erst noch encodiert werden soll
     * @var boolean
     */
    public $flagEncodePassword = true;
    
    /**
     * Flag ob der neue User per Mail benachrichtig werden soll
     * @var boolean
     */
    public $flagNotifyNew = false;

    /**
     * Das Standard Passwort
     * @var string
     */
    public $defaultPassword = 'PleaseChangeAsap!';
    
    /**
     * Die vorhandene Datenbank Struktur
     * @var array
     */
    public $availableStructure = array(
    	
        'user' => array(
            'label' => 'User',
            'fields' => array(
                'name' => array(
                   'Name', // label
                   true // required
                ),
                'employee_number' => array(
                   'Employee Number', // label
                   false // required
                ),
                'firstname' => array(
                   'Firstname', // label
                   true // required
                ),
                'lastname' => array(
                   'Lastname', // label
                   true // required
                ),
                'password' => array(
                   'Password', // label
                   false // required
                ),
                'type' => array(
                   'Type', // label
                   false // required
                ),
                'level' => array(
                   'level', // label
                   false // required
                ),
                'profile' => array(
                   'profile', // label
                   false // required
                ),
                'phone' => array(
                    'Phone', // label
                    false // required
                ),
                'mobile' => array(
                    'Phone', // label
                    false // required
                ),
                'fax' => array(
                    'Telefax', // label
                    false // required
                ),
                'email' => array(
                    'E-Mail', // label
                    false // required
                ),
                'comment' => array(
                    'Comment', // label
                    false // required
                ),
            )
        ),
        'address' => array(
            'label' => 'Address',
            'fields' => array(
                'street' => array(
                    'Street', // label
                    false // required
                ),
                'street_no' => array(
                    'Street No.', // label
                    false // required
                ),
                'postbox' => array(
                    'Postbox', // label
                    false // required
                ),
                'zip' => array(
                    'ZIP', // label
                    false // required
                ),
                'city' => array(
                    'City', // label
                    false // required
                ),
                'country' => array(
                    'Country Name', // label
                    false // required
                ),
                'country-iso3166_2' => array(
                    'Country ISO 3166 2', // label
                    false // required
                ),
                'country-iso3166_3' => array(
                    'Country ISO 3166 3', // label
                    false // required
                ),
                'country-iso3166_num' => array(
                    'Country ISO 3166 Num.', // label
                    false // required
                ),
            )
        ),
        
    );
    
    public $importKey = 'buiz-user';
    
    /**
     * @param LibHttpRequest $request
     * @throws Io_Exception
     */
    public function executeImport($request)
    {
        
        $orm = $this->getOrm();
        $db = $orm->db;
        $this->openImportFile();
        
        $personManager = new CorePerson_Data_Manager($this);
        
        $this->stats['internal-user'] = 0;
        
        foreach ($this->fileReader as $row) {

           $this->importInternalUser($orm,$personManager,$row);

        }
    
    }//end public function executeImport */
    

    
    /**
     * einen Privatkunden importieren
     * wir gehen davon aus, dass es ein privatkunde ist wenn keine Firmeninformationen vorhanden sind
     * oder es expliziet angegeben wurde
     */
    protected function importInternalUser($orm,$personManager,$row)
    {
        
        $userName = $orm->db->addSlashes($this->readColByKey($row,'user.name'));
        
        $userNode = $orm->get('BuizRoleUser'," UPPER(name) = UPPER('".$userName."')" );
        
        if (!$userNode) {
        
            $userNode = new BuizRoleUser_Entity();
            $userNode->name = $userName;
        
            // person anhand der kontaktdaten suchen
            if ($this->colExists($row, 'user.email'))
                $person = $personManager->getPersonByContactItem('email', $this->readColByKey($row,'user.email'));
            
            if (!$person && $this->colExists($row, 'user.phone'))
                $person = $personManager->getPersonByContactItem('phone', $this->readColByKey($row,'user.phone'));
            
            if (!$person && $this->colExists($row, 'user.email'))
                $person = $personManager->getPersonByContactItem('email', $this->readColByKey($row,'user.email'));
            
            if (!$person && $this->colExists($row, 'user.phone'))
                $person = $personManager->getPersonByContactItem('phone', $this->readColByKey($row,'user.phone'));
            
            if (!$person && $this->colExists($row, 'user.mobile'))
                $person = $personManager->getPersonByContactItem('mobile', $this->readColByKey($row,'user.mobile'));
            
            if (!$person && $this->colExists($row, 'user.fax'))
                $person = $personManager->getPersonByContactItem('mobile', $this->readColByKey($row,'user.fax'));
            
            // hier wird noch ein abgleich des namens benötigt
            if(!$person){
                $person = new CorePerson_Entity();
                $person->type = EPersonType::LEGAL_PERSON;
            }

            $userNode->id_person = $person;
        
        } else {
        
            $person = $userNode->followLink('id_person');
        
        }
        
        $userNode->type = EUserType::USER;
        $userNode->relation = EBuizUserRelation::INTERNAL;
        
        ///TODO rolle, profile
        

        // company data
        if ($this->colExists($row, 'user.comment'))
            $userNode->description = $this->readColByKey($row,'user.comment');

        
        // person data
        if ($this->colExists($row, 'user.firstname'))
            $person->firstname = $this->readColByKey($row,'user.firstname');
        
        if ($this->colExists($row, 'user.lastname'))
            $person->firstname = $this->readColByKey($row,'user.lastname');
        
        // save
        $orm->save($userNode);
        $orm->save($person);
        
        $this->importPersonAddress($row, $person, $personManager);
        
        // person contact items
        if ($this->colExists($row, 'user.phone'))
            $personManager->addContactItem($customer->id_person, 'phone', $this->readColByKey($row,'user.phone'));
        
        if ($this->colExists($row, 'user.mobile'))
            $personManager->addContactItem($customer->id_person, 'mobile', $this->readColByKey($row,'user.mobile'));
        
        if ($this->colExists($row, 'user.email'))
            $personManager->addContactItem($customer->id_person, 'email', $this->readColByKey($row,'user.email'));
        
        if ($this->colExists($row, 'user.fax'))
            $personManager->addContactItem($customer->id_person, 'phone', $this->readColByKey($row,'user.fax'));
        
    
    }
    
    /**
     * 
     */
    protected function importPersonAddress($row, $person, $personManager)
    {
        
        $orm = $this->getOrm();
        
        // company address
        if( $this->colExists(
            $row,
            array(
                'address.street',
                'address.postbox',
                'address.zip',
                'address.city',
                'address.country'
            )
        )){
        
            $address = $personManager->getPersonMainAddress($person->getId());
        
            $newAddress = false;
            if(!$address){
                $newAddress = true;
        
                $address = $orm->newEntity('CoreAddress');
                $address->name = 'Main address';
            }
        
            if ($this->colExists($row, 'address.street'))
                $address->street = $this->readColByKey($row,'address.street');
        
            if ($this->colExists($row, 'address.street_no'))
                $address->street_no = $this->readColByKey($row,'address.street_no');
        
            if ($this->colExists($row, 'address.zip'))
                $address->postalcode = $this->readColByKey($row,'address.zip');
        
            if ($this->colExists($row, 'address.city'))
                $address->city = $this->readColByKey($row,'address.city');
        
        
            $country = null;
        
            if ($this->colExists($row, 'address.country'))
                $country = $orm->get( 'CoreCountry', " name = '".$db->escape($this->readColByKey($row,'address.city'))."'"  );
        
            if (!$country && $this->colExists($row, 'address.country-iso3166_2'))
                $country = $orm->get( 'CoreCountry', " iso3166_2 = '".$db->escape($this->readColByKey($row,'address.country-iso3166_2'))."'"  );
        
            if (!$country && $this->colExists($row, 'address.country-iso3166_3'))
                $country = $orm->get( 'CoreCountry', " iso3166_3 = '".$db->escape($this->readColByKey($row,'address.country-iso3166_3'))."'"  );
        
            if (!$country && $this->colExists($row, 'address.country-iso3166_num'))
                $country = $orm->get( 'CoreCountry', " iso3166_num = '".$db->escape($this->readColByKey($row,'address.country-iso3166_num'))."'"  );
        
            if($country){
                $address->id_country = $country;
            }
        
            $orm->save($address);
        
            if($newAddress){
                $person->id_address = $address;
                $orm->save($person);
            }
        
        }
    
    }//end protected function importPersonAddress */
    
    protected function checkMappingConsistency()
    {
        
    }
    

}//end BuizUserImport_Manager

