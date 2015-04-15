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
class BuizCoreAddress_Manager extends Manager
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    
    /**
     * @param CoreAddress_Entity $address
     */
    public function saveAddress($address)
    {
        $orm = $this->getOrm();
        $orm->save($address);
        
    }//end public function saveAddress */
    
    /**
     * @param [CoreAddress_Entity] $addresses
     */
    public function saveMultiAddresses($addresses)
    {
        $orm = $this->getOrm();
        
        foreach($addresses as $address){
            $orm->save($address);
        }
       
    
    }//end public function saveMultiAddresses */
    
    
    /**
     * @param int $addressId
     */
    public function deleteAddress($addressId)
    {
        $orm = $this->getOrm();
        $orm->delete('CoreAddress', $addressId );
    
    }//end public function deleteAddress */
    
    /**
     * @param int $refId
     */
    public function deleteAllAddresses($refId)
    {
        $orm = $this->getOrm();
        $orm->deleteWhere('CoreAddress', 'vid = '.$refId );
    
    }//end public function deleteAllAddresses */
    
    /**
     * @param int $idPerson
     * @return array
     */
    public function getAddressList($idPerson)
    {
    
        $db = $this->getDb();
    
        $sql = <<<SQL
SELECT
  addr.rowid,
  addr.name,
  addr.vid,
  addr.street,
  addr.street_no,
  addr.city,
  addr.zip,
  addr.id_country,
  country.name as country,
  addr.id_type,
  addr_type.name as type,
  addr.flag_private
FROM
  core_address addr
LEFT JOIN core_address_type addr_type
    ON addr_type.rowid = addr.id_type
LEFT JOIN core_country country
    ON country.rowid = addr.id_country
WHERE
  addr.vid = {$idPerson}
ORDER BY
  addr_type.name;
SQL;
    
        return $db->select($sql)->getAll();
    
    }//end public function getAddressList */


    /**
     * @return array
     */
    public function getAddressTypes()
    {

        $db = $this->getDb();

        $sql = <<<SQL
SELECT
  rowid as id,
  name as value
FROM
  core_address_type
order by
  name;
SQL;

        return $db->select($sql)->getAll();

    }//end public function getAddressTypes */


    /**
     * @return array
     */
    public function getCountries()
    {

        $db = $this->getDb();

        $sql = <<<SQL
SELECT
  rowid as id,
  name as value,
  flag_main as cat_key
FROM
  core_country
order by
  flag_main,
  name;
SQL;

        return $db->select($sql)->getAll();

    }//end public function getCountries */
 
}//end class BuizCoreAddress_Manager

