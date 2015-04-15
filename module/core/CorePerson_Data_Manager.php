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
 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class CorePerson_Data_Manager extends Manager
{

  /**
   * @param int $idPerson
   */
  public function getPersonMainAddress($idPerson)
  {
      if(!$idPerson)
        return null;

      $orm = $this->getOrm();
      
      return $orm->get('CoreAddress'," rowid IN( select id_address from core_person where rowid = {$idPerson} ) ");
      
  }//end public function getPersonMainAddress */

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
  type.name as type
FROM
  core_address_r addr
LEFT JOIN
  core_address_type type
  ON type.rowid = addr.id_type
WHERE
  vid = {$idPerson}
order by
  addr.name
SQL;

    return $db->select($sql)->getAll();

  }//end public function getAddressList */
  

  /**
   * @param int $idPerson
   * @param string $filter
   * @param string $value
   * @return array
   */
  public function addContactItem($idPerson, $type, $value)
  {
      
    /*
        mail
        message
        phone
        mobile
        icq
        xmmp
        google_xmmp
        skype
        msn
        sip
        else
        google_plus
        twitter
        facebook
        git_hub
        nick_name
        fax
        web
        xing,
        linked_in
    */
    
    $orm = $this->getOrm();
    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  count(item.rowid) as num_items
FROM
  buiz_address_item_r item
LEFT JOIN
  buiz_address_item_type type
    ON type.rowid = item.id_type
WHERE
  item.vid = {$idPerson}
  and UPPER(type.access_key) = upper('{$type}') 
  and UPPER(item.address_value) = upper('{$value}') 
  
SQL;
    
    $numItems = $db->select($sql)->getField('num_items');
    
    if (!$numItems) {
        $item = new BuizAddressItem_Entity();
        $item->id_type = $orm->getByKey('BuizAddressItemType', $type);
        $item->address_value = $value;
        $item->vid = $idPerson;
        $item->m_version = 1;
        
        $orm->insert($item);
    }


  }//end public function addContactItem */
  
  /**
   * @param string $type
   * @param string $value
   * 
   * @return CorePerson_Entity
   */
  public function getPersonByContactItem($type, $value)
  {
      
      $orm = $this->getOrm();
      
      $check = <<<SQL
  rowid IN(
      SELECT
          item.vid
      FROM
          buiz_address_item_r item
      LEFT JOIN
            buiz_address_item_type_r type
          ON type.rowid = item.id_type
      WHERE
          UPPER(type.access_key) = upper('{$type}')
            AND UPPER(item.address_value) = upper('{$value}')
  )

SQL;
      
      return $orm->get('CorePerson', $check);
      
  }//end public function getPersonByContactItem */
  
  /**
   * @param int $idPerson
   * @param array $filter
   * @return array
   */
  public function getTypedContactItems($idPerson, $filter = [])
  {
  
      $db = $this->getDb();
      
      $sqlFilter = '';
      if($filter){
          $sqlFilter = " AND type.access_key IN('".implode("', '",$filter)."') ";
      }
  
      $sql = <<<SQL
SELECT
  item.rowid,
  item.address_value,
  type.access_key as type
FROM
  buiz_address_item_r item
LEFT JOIN
  buiz_address_item_type_r type
    ON type.rowid = item.id_type
WHERE
  item.vid = {$idPerson} 
  {$sqlFilter};

SQL;
    
      $result = $db->select($sql)->getAll();
      
      $items = [];
      
      foreach( $result as $item){
          $items[$item['type']] = $item['address_value'];
      }

      return $items;
  
  }//end public function getTypedContactItems */


}// end class CorePerson_Data_Manager

