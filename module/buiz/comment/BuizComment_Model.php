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
class BuizComment_Model extends MvcModel
{

  /**
   * @param string $commentName
   * @param string $commentName
   * @param int $refId
   * @param int $parent
   * @return BuizComment_Entity
   */
  public function addComment( $title, $comment, $refId, $parent)
  {

    $orm = $this->getOrm();

    $commentNode = $orm->newEntity("BuizComment");
    $commentNode->title = $title;
    $commentNode->content = $comment;
    $commentNode->vid = $refId;
    $commentNode->m_parent = $parent;
    $commentNode = $orm->insert($commentNode);

    return $commentNode;

  }//end public function addComment */

  /**
   * @param string $commentName
   * @param string $commentName
   * @param int $refId
   * @param int $parent
   * @return BuizComment_Entity
   */
  public function saveComment($rowid, $title, $comment)
  {

    $orm = $this->getOrm();

    $commentNode = $orm->get("BuizComment", $rowid);
    $commentNode->title = $title;
    $commentNode->content = $comment;
    $commentNode = $orm->update($commentNode);

    return $commentNode;

  }//end public function saveComment */

  /**
   * @param int $refId
   * @return int
   */
  public function cleanComments($refId)
  {

    $orm = $this->getOrm();
    $orm->deleteWhere('BuizComment', "vid=".$refId);

  }//end public function cleanDsetTags */

  /**
   * @param int $objid
   * @return int
   */
  public function delete($objid)
  {

    $orm = $this->getOrm();
    $orm->delete('BuizComment', $objid);

  }//end public function delete */

  /**
   * @param string $key
   * @param int $refId
   *
   * @return LibDbPostgresqlResult
   */
  public function getCommentTree($refId  )
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  comment.rowid as id,
  comment.title as title,
  comment.rate as rate,
  comment.content as content,
  comment.m_time_created as time_created,
  comment.m_parent as parent,
  comment.m_role_created as creator_id,
  person.core_person_rowid as person_id,
  person.core_person_firstname as firstname,
  person.core_person_lastname as lastname,
  person.buiz_role_user_name as user_name

FROM
  buiz_comment comment

JOIN
  view_person_role person
    ON person.buiz_role_user_rowid = comment.m_role_created

WHERE
  comment.vid = {$refId}

ORDER BY
  comment.m_time_created desc;

SQL;

    $comments = [];

    $tmp = $db->select($sql)->getAll();

    foreach ($tmp as $com) {
      $comments[(int) $com['parent']][] = $com;
      //$comments[0][] = $com; // erst mal kein baum
    }

    return $comments;

  }//end public function getCommentTree */

  /**
   * @param int $entryId
   *
   * @return array
   */
  public function getCommentEntry($entryId  )
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  comment.rowid as id,
  comment.title as title,
  comment.rate as rate,
  comment.content as content,
  comment.m_time_created as time_created,
  comment.m_parent as parent,
  person.core_person_firstname as firstname,
  person.core_person_lastname as lastname,
  person.buiz_role_user_name as user_name

FROM
  buiz_comment comment

JOIN
  view_person_role person
    ON person.buiz_role_user_rowid = comment.m_role_created

WHERE
  comment.rowid = {$entryId};
SQL;

    // es wird nur ein Eintrag erwartet
    return $db->select($sql)->get();

  }//end public function getCommentTree */

  /**
   *
   * @param BuizComment_Context $context
   * @param int $refId
   *
   * @return LibAclPermission
   */
  public function loadAccessContainer($context)
  {

     $domainNode = DomainNode::getNode($context->refMask);

     if (!$domainNode)
       throw new InvalidRequest_Exception('Requested invalid mask rights');

     if (!$context->refId)
       throw new InvalidRequest_Exception('Missing refid');

     $className = SFormatStrings::subToCamelCase($domainNode->aclDomainKey).'_Crud_Access_Dataset';

     if (!BuizCore::classExists($className))
       throw new InvalidRequest_Exception('Requested invalid mask rights');

     $refId = $context->refId;

     if ($context->refField) {
       $orm = $this->getOrm();

       $entity = $orm->get($domainNode->srcKey,  $context->refField." = '{$refId}'");

       if (!$entity)
         throw new InvalidRequest_Exception('Requested invalid mask rights');

       $refId = $entity->getId();
     }

     $this->access = new $className($this);
     $this->access->loadDefault(new TFlag(), $refId);

     return $this->access;

  }//end public function loadAccessContainer */

} // end class BuizComment_Model

