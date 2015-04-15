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
class CorePerson_Data_Provider extends Provider
{

  /**
   *
   */
  public function getAddress($idPerson)
  {

  }//end public function getAddress */

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
  core_address addr
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
  buiz_address_item item
LEFT JOIN
  buiz_address_item_type type
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
      
      Log::debug(Debug::dumpToString($items));
  
      return $items;
  
  }//end public function getTypedContactItems */


}// end class CorePerson_Data_Provider

