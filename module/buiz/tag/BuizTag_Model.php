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
class BuizTag_Model extends MvcModel
{

  /**
   * @param int $tagId
   * @return BuizTag_Entity
   */
  public function getTag($tagId)
  {

    $orm = $this->getOrm();

    return $orm->get("BuizTag",  $tagId);

  }//end public function getTag */

  /**
   * @param string $tagName
   * @return BuizTag_Entity
   */
  public function addTag($tagName)
  {

    $orm = $this->getOrm();
    $tagNode = $orm->getWhere("BuizTag",  "name ilike '".$orm->escape($tagName)."' ");

    if ($tagNode) {
      return $tagNode;
    } else {
      $tagNode = $orm->newEntity("BuizTag");
      $tagNode->name = $tagName;
      $tagNode->access_key = SFormatStrings::nameToAccessKey($tagName);
      $tagNode = $orm->insertIfNotExists($tagNode, array('name'));

      return $tagNode;
    }

  }//end public function addTag */

  /**
   * @param BuizTag_Entity|int $tagId
   * @param int $objid
   *
   * @return BuizTagReference_Entity | null gibt null zurück wenn die Verbindung bereits existiert
   */
  public function addConnection($tagId, $objid)
  {

    $orm = $this->getOrm();
    $tagRef = $orm->newEntity('BuizTagReference');

    $tagRef->id_tag = (string) $tagId;
    $tagRef->vid = $objid;

    if (!$tagRef->id_tag) {
      throw new LibDb_Exception("FUUU");
    }

    return $orm->insertIfNotExists($tagRef, array('id_tag', 'vid'));

  }//end public function addConnection */

  /**
   * @param int $objid
   * @return int
   */
  public function cleanDsetTags($objid)
  {

    $orm = $this->getOrm();
    $orm->deleteWhere('BuizTagReference', "vid=".$objid);

  }//end public function cleanDsetTags */

  /**
   * @param int $objid
   * @return int
   */
  public function disconnect($objid)
  {

    $orm = $this->getOrm();
    $orm->delete('BuizTagReference', $objid);

  }//end public function disconnect */

  /**
   * @param string $key
   * @param int $refId
   *
   * @return LibDbPostgresqlResult
   */
  public function autocompleteByName($key, $refId  )
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  tag.name as label,
  tag.name as value,
  tag.rowid as id
FROM
  buiz_tag tag
WHERE
  NOT tag.rowid IN(select ref.id_tag from buiz_tag_reference ref where ref.vid = {$refId})
  AND upper(tag.name) like upper('{$db->escape($key)}%')
ORDER BY
  tag.name
LIMIT 10;
SQL;

    return $db->select($sql)->getAll();

  }//end public function autocompleteByName */

  /**
   * @param string $key
   * @param int $refId
   *
   * @return LibDbPostgresqlResult
   */
  public function getDatasetTaglist($refId  )
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  tag.name as label,
  tag.rowid as tag_id,
  ref.rowid as ref_id
FROM
  buiz_tag tag
JOIN
  buiz_tag_reference ref
    ON tag.rowid = ref.id_tag
WHERE
  ref.vid = {$refId}
ORDER BY
  tag.name;
SQL;

    return $db->select($sql)->getAll();

  }//end public function getDatasetTaglist */

} // end class BuizTag_Model

