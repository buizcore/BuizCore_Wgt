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
class BuizContactData_Manager extends Manager
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    
    /**
     * @param BuizAddressItem_Entity $address
     */
    public function saveItem($address)
    {
        $orm = $this->getOrm();
        
        if (!$address->m_version) {
            $address->m_version = 1;
        }
        $orm->save($address);
        
    }//end public function saveItem */
    

    /**
     * @param BuizAddressItem_Entity $items
     */
    public function saveMultiItems($items)
    {
        $orm = $this->getOrm();
        
        foreach ($items as $item) {
            if (!$item->m_version) {
                $item->m_version = 1;
            }
            $orm->save($item);
        }
    
    }//end public function saveMultiItems */
    
    /**
     * @param int $addressId
     */
    public function deleteItem($addressId)
    {
        $orm = $this->getOrm();
        $orm->delete('BuizAddressItem', $addressId );
    
    }//end public function deleteItem */
    
    /**
     * @param int $idPerson
     * @param array $types
     * @return array
     */
    public function getItemList($idPerson, $types = [])
    {
    
        if (!$idPerson) {
            return [];
        }
        
        $where = '';
        
        if ($types) {
            $where = " AND UPPER(addr_type.access_key) IN(UPPER('".implode("'),UPPER('", $types)."')) ";
        }
        
        $db = $this->getDb();
        
        $sql = <<<SQL
SELECT
  item.rowid,
  item.vid,
  item.address_value,
  item.flag_private,
  item.id_type,
  addr_type.access_key as type_key,
  addr_type.name as type
FROM
  buiz_address_item item
LEFT JOIN buiz_address_item_type addr_type
    ON addr_type.rowid = item.id_type
WHERE
  item.vid = {$idPerson} {$where}
ORDER BY
  addr_type.priority,
  addr_type.name,
  item.address_value;
SQL;
    
        return $db->select($sql)->getAll();
    
    }//end public function getItemList */

    /**
     * @return array
     */
    public function getItemTypes()
    {

        $db = $this->getDb();

        $sql = <<<SQL
SELECT
  rowid as id,
  name as value
FROM
  buiz_address_item_type
order by
  priority, 
  name;
SQL;

        return $db->select($sql)->getAll();

    }//end public function getItemTypes */

 
}//end class BuizContactData_Manager

