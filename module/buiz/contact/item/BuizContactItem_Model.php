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
class BuizContactItem_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Crud Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param int $userId
   * @param object $data
   *
   * @return BuizAddressItem_Entity
   */
  public function insertItem($userId, $data)
  {

    $orm = $this->getOrm();

    $itemNode = $orm->newEntity("BuizAddressItem");

    $itemNode->vid = $userId;

    $itemNode->use_for_contact = $data->use_for_contact;
    $itemNode->flag_private = $data->flag_private;
    $itemNode->name = $data->name;
    $itemNode->address_value = $data->address_value;
    $itemNode->id_type = $data->id_type;
    $itemNode->description = $data->description;

    $itemNode = $orm->insert($itemNode);

    return $itemNode;

  }//end public function insertItem */

  /**
   * @param int $objid
   * @param object $data
   *
   * @return BuizAddressItem_Entity
   */
  public function updateItem($objid, $data)
  {

    $orm = $this->getOrm();

    $itemNode = $orm->get("BuizAddressItem", $objid);

    $itemNode->use_for_contact = $data->use_for_contact;
    $itemNode->flag_private = $data->flag_private;
    $itemNode->name = $data->name;
    $itemNode->address_value = $data->address_value;
    $itemNode->id_type = $data->id_type;
    $itemNode->description = $data->description;

    $orm->update($itemNode);

  }//end public function updateItem */

  /**
   * @param int $itemId
   * @return BuizAddressItem_Entity
   */
  public function loadItem($itemId)
  {

    $orm = $this->getOrm();

    return $orm->get("BuizAddressItem", $itemId);

  }//end public function loadItem */

  /**
   * @param int $itemId
   * @return int
   */
  public function deleteItem($itemId)
  {

    $orm = $this->getOrm();

    // andere attachments löschen
    $orm->delete('BuizAddressItem', $itemId);

  }//end public function deleteItem */

  /**
   * @param int $refId
   * @param int $entryId
   * @param string $searchString
   *
   * @return LibDbPostgresqlResult
   */
  public function getItemList($refId = null, $entryId = null  )
  {

    $db = $this->getDb();

    $condEntry = '';
    $condAttach = '';

    if ($refId) {
      $condAttach = " item.id_user = {$refId}";
    } elseif ($entryId) {
      $condEntry = " item.rowid = {$entryId}";
    } else {
      return [];
    }

    $sql = <<<SQL
SELECT
  item.rowid as item_id,
  item.address_value as item_address_value,
  item.name as item_name,
  item.use_for_contact as item_use_for_contact,
  item.flag_private as item_flag_private,
  item.description as item_description,

  item.id_type as type_id,
  type.name as type_name,
  type.icon as type_icon,
  type.access_key as type_access_key

FROM
  buiz_address_item item

LEFT JOIN
  buiz_address_item_type type
    on type.rowid = item.id_type

WHERE
  {$condAttach}
  {$condEntry}
ORDER BY
  item.m_time_created desc;

SQL;

    if ($entryId) {
      return $db->select($sql)->get();
    } else {
      return $db->select($sql)->getAll();
    }

  }//end public function getItemList */

  /**
   * @return LibDbPostgresqlResult
   */
  public function getItemTypeList()
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  type.rowid as type_id,
  type.name as type_name,
  type.icon as type_icon

FROM
  buiz_address_item_type type

ORDER BY
  type.name;

SQL;

    return $db->select($sql)->getAll();

  }//end public function getItemTypeList */

/*////////////////////////////////////////////////////////////////////////////*/
// Repository Management Logic
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param int $storageId
   * @return BuizFileAddress_Entity
   * /
  public function loadAddress($storageId)
  {

    $orm = $this->getOrm();

    $storageNode = $orm->get(
      'BuizFileAddress',
      $storageId
    );

    return $storageNode;

  }//end public function loadAddress */

  /**
   *
   * Enter description here ...
   * @param int $refId
   * @param string $name
   * @param string $link
   * @param int $type
   * @param int $confidentiality
   * @param description $description
   *
   * @return BuizEntityAttachment_Entity
   * /
  public function addAddress($refId, $name, $link, $type, $confidentiality, $description)
  {

    $orm = $this->getOrm();

    $storageNode = $orm->newEntity("BuizFileAddress");
    $storageNode->name = $name;
    $storageNode->link = $link;
    $storageNode->id_type = $type;
    $storageNode->id_confidentiality = $confidentiality;
    $storageNode->description = $description;
    $storageNode = $orm->insert($storageNode);


    $refNode = $orm->newEntity("BuizEntityFileAddress");
    $refNode->vid = $refId;
    $refNode->id_storage = $storageNode;

    $refNode = $orm->insert($refNode);

    return $storageNode;

  }//end public function addAddress */

  /**
   * @param int $objid
   * @param string $name
   * @param string $link
   * @param int $type
   * @param int $confidentiality
   * @param description $description
   *
   * @return BuizEntityAttachment_Entity
   * /
  public function saveAddress($objid, $name, $link, $type, $confidentiality, $description)
  {

    $orm = $this->getOrm();

    $storageNode = $orm->get("BuizFileAddress", $objid);
    $storageNode->name = $name;
    $storageNode->link = $link;
    $storageNode->id_type = $type;
    $storageNode->description = $description;
    $storageNode->id_confidentiality = $confidentiality;

    $orm->update($storageNode);

  }//end public function saveAddress */

  /**
   * @param int $itemId
   * @return int
   * /
  public function deleteAddress($storageId)
  {

    $orm = $this->getOrm();

    $orm->delete('BuizFileAddress', $storageId);

    // andere attachments löschen
    $orm->deleteWhere('BuizEntityFileAddress', "id_storage=".$storageId);

  }//end public function deleteAddress */


  /**
   * @param int $refId
   * @param int $entryId
   * @param string $searchString
   *
   * @return LibDbPostgresqlResult
   * /
  public function getAddressList($refId = null, $entryId = null, $searchString = null)
  {

    $db = $this->getDb();

    $condEntry = '';
    $condAttach = '';

    if ($refId) {
      $condAttach = " ref.vid = {$refId}";
    } elseif ($entryId) {
      $condEntry = " storage.rowid = {$entryId}";
    } else {
      return [];
    }

    $condSearch = '';
    if ($searchString) {

      $condSearch = <<<SQL
      and
      (
        upper(storage.name) like upper('%{$searchString}%')
          or upper(storage.link) like upper('%{$searchString}%')
      )
SQL;

    }


    $sql = <<<SQL
SELECT
  storage.rowid as storage_id,
  storage.name  as storage_name,
  storage.link  as storage_link,
  storage.description  as storage_description,
  storage_type.name as type_name,
  confidential.access_key as confidential_level

FROM
  buiz_file_storage storage
JOIN
   buiz_entity_file_storage ref
     ON ref.id_storage = storage.rowid

LEFT JOIN
  buiz_file_storage_type storage_type
    on storage_type.rowid = storage.id_type

LEFT JOIN
  buiz_confidentiality_level confidential
    on confidential.rowid = storage.id_confidentiality

WHERE
  {$condAttach}
  {$condEntry}
  {$condSearch}
ORDER BY
  storage.name;

SQL;

    if ($entryId) {
      return $db->select($sql)->get();
    } else {
      return $db->select($sql)->getAll();
    }

  }//end public function getAddressList */

} // end class BuizAttachment_Model

