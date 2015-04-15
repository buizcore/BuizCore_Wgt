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
class BuizCalendar_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var object
   */
  protected $messageNode = null;

  /**
   * Conditions für die Query
   * @var array
   */
  public $conditions = [];

/*////////////////////////////////////////////////////////////////////////////*/
// getter & setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return
   */
  public function getMessageNode()
  {
    return $this->messageNode;
  }//end public function getMessageNode */

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return BuizMessage_List_Access
   */
  public function loadTableAccess($params)
  {

    $user = $this->getUser();

    // ok nun kommen wir zu der zugriffskontrolle
    $this->access = new BuizMessage_Table_Access(null, null, $this);
    $this->access->load($user->getProfileName(), $params);

    $params->access = $this->access;

    return $this->access;

  }//end public function loadTableAccess */

  /**
   * @param BuizMessage_Table_Search_Request $params
   * @return array
   */
  public function searchEvents($params)
  {

    $db = $this->getDb();


    /* @var $query BuizCalendar_Query */
    $query = $db->newQuery('BuizCalendar');

    //$query->extSearch($params->searchFieldsStack, $params->extSearch);

    $query->fetch(
      $this->params->conditions,
      $params
    );

    $entries = [];

    foreach( $query as $entry ){

      $entry['id'] = (int)$entry['id'];

      if(  $entry['deadline'] ){

        $entry['allDay'] = true;
        $entry['start'] = $entry['deadline'];
        $entry['backgroundColor'] = '#FFDCA8';
        $entry['textColor'] = '#661212';
        $entry['editable'] = false;

      } else {
        if('t'==$entry['allday'])
          $entry['allDay'] = true;
        else
          $entry['allDay'] = false;
      }


      $entries[] = $entry;
    }

    return $entries;

  }//end public function searchEvents */

  /**
   * @param int $msgId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function loadMessage($msgId, $setOpen = true)
  {

    $db = $this->getDb();
    $user = $this->getUser();

    $sql = <<<SQL

select
  msg.rowid as msg_id,
  msg.title,
  msg.message,
  msg.priority,
  msg.m_time_created,
  msg.id_sender_status,
  msg.confidential,
  task.deadline as task_deadline,
  task.progress as task_progress,
  task.status as task_status,
  task.flag_urgent as task_urgent,
  task.rowid as task_id,
  appoint.timestamp_start as appoint_start,
  appoint.timestamp_end as appoint_end,
  appoint.flag_all_day as appoint_all_day,
  appoint.id_category as appoint_category,
  appoint.rowid as appoint_id,
  appoint.location_text as appoint_location,
  receiver.status as receiver_status,
  receiver.rowid as receiver_id,
  receiver.flag_participation_required,
  receiver.flag_action_required,
  receiver.flag_editable,
  sender.fullname as sender_name,
  sender.core_person_rowid as sender_pid,
  sender.buiz_role_user_rowid as sender_id,
  receiver_name.fullname as receiver_name

FROM
  buiz_message msg

JOIN
	buiz_message_receiver receiver
		ON receiver.id_message = msg.rowid

LEFT JOIN
	buiz_task task
		ON task.id_message = msg.rowid

LEFT JOIN
	buiz_appointment appoint
		ON appoint.id_message = msg.rowid

JOIN
  view_person_role sender
    ON sender.buiz_role_user_rowid = msg.id_sender

JOIN
  view_person_role receiver_name
    ON receiver_name.buiz_role_user_rowid = receiver.vid

WHERE
  msg.rowid = {$msgId};

SQL;


    $node = $db->select($sql)->get();

    if ($node) {

      // auf open setzen wenn noch closed
      if ($setOpen && EMessageStatus::OPEN > $node['receiver_status'] ) {
        $db->update("UPDATE buiz_message_receiver set status =".EMessageStatus::OPEN." WHERE rowid = ".$node['receiver_id'] );
        $node['receiver_status'] = EMessageStatus::OPEN;
      }

      $this->messageNode = new TDataObject($node);

    }

    if (!$this->messageNode)
      throw new DataNotExists_Exception('The requested message not exists.');

    $this->loadMessageAspects($msgId);

    return $this->messageNode;

  }//end public function loadMessage */


  /**
   * @param int $msgId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function loadMessageAspects($msgId)
  {

    $db = $this->getDb();
    $user = $this->getUser();

    $sql = <<<SQL

select
  aspect
FROM
  buiz_message_aspect asp
WHERE
  asp.id_receiver = {$user->getId()}
  	AND asp.id_message = {$msgId};

SQL;

    $aspects = $db->select($sql)->getAll();

    if (!$this->messageNode)
      throw new DataNotExists_Exception('You have to load a message first');

    $aspStack = [];

    foreach ($aspects as $aspect) {
      $aspStack[$aspect['aspect']] = true;
    }

    $this->messageNode->aspects = $aspStack;

  }//end public function loadMessageAspects */

  /**
   * @param int $msgId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function loadMessageAttachments($msgId)
  {

    $db = $this->getDb();

    $sql = <<<SQL

select
  file.rowid as file_id,
  file.name as file_name,
	attach.rowid as attach_id
FROM
  buiz_file file

JOIN
	buiz_entity_attachment attach
		ON attach.id_file = file.rowid

WHERE
  attach.vid = {$msgId};

SQL;

    //$references = $db->select($sql)->getAll();

    return $db->select($sql);

  }//end public function loadMessageAttachments */


  /**
   * de:
   * datenquelle für einen autocomplete request
   * @param string $key
   * @param TArray $params
   */
  public function getUserListByKey($key, $params)
  {

    $db = $this->getDb();
    $query = $db->newQuery('BuizMessage');
    /* @var $query BuizMessage_Query  */

    $query->fetchAutocomplete(
      $key,
      $params
    );

    return $query->getAll();

  }//end public function getUserListByKey */

  /**
   * (non-PHPdoc)
   * @see BaseChild::getUser()
   */
  public function getUserData($userId)
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  core_person_rowid as person_id,
  core_person_firstname as firstname,
  core_person_lastname as lastname,
  buiz_role_user_name as user_name
FROM
  view_person_role
WHERE
  buiz_role_user_rowid = {$userId}

SQL;

    // gleich den Datensatz zurückgeben
    return $db->select($sql)->get();

  }//end public function getUserData */


  /**
   * @param string $groupKey
   * @param string $areaKey
   * @param int $vid
   *
   * @return LibMessageReceiver
   */
  public function getGroupUsers($groupKey, $areaKey = null, $vid = null)
  {

    $messages = new LibMessagePool($this);

    return $messages->getGroupUsers(
      array($groupKey),
      array('message'),
      $areaKey,
      $vid,
      true
    );

  }//end public function getUserData */

  /**
   * @param string $groupKey
   * @param string $areaKey
   * @param int $vid
   *
   * @return LibMessageReceiver
   */
  public function getDsetUsers($vid, $areaKey = null)
  {

    $messages = new LibMessagePool($this);

    return $messages->getGroupUsers(
      null,
      array('message'),
      $areaKey,
      $vid,
      true
    );

  }//end public function getDsetUsers */

  /**
   * Versenden der Nachricht an den Benutzer
   * @param int $userId
   * @param int $dataSrc
   * @param int $refId
   * @param TDataObject $mgsData
   */
  public function sendUserMessage($userId, $dataSrc, $refId, $mgsData)
  {

    $message = new BuizContactForm_User_Message();

    $message->addReceiver(
      new LibMessage_Receiver_User($userId)
    );

    if ($dataSrc && $refId) {

      $domainNode = DomainNode::getNode($dataSrc);

      $orm = $this->getOrm();

      $entity = $orm->get($domainNode->srcKey, $refId  );
      $message->entity = $entity;

    }

    $message->setChannels($mgsData->channels);
    $message->subject = $mgsData->subject;
    $message->userContent = $mgsData->message;
    $message->confidential = $mgsData->confidential;

    $msgProvider = $this->getMessage();
    $msgProvider->send($message);

  }//end public function sendUserMessage */

  /**
   * @param int $messageId
   * @param BuizMessage_Save_Request $rqtData
   * @throws Per
   */
  public function saveMessage($messageId, $rqtData)
  {

    $orm = $this->getOrm();
    $db = $this->getDb();
    $user = $this->getUser();

    foreach ($rqtData->aspects as $aspect) {
      $msgAspect = $orm->newEntity('BuizMessageAspect');
      $msgAspect->id_receiver = $user->getId();
      $msgAspect->id_message = $messageId;
      $msgAspect->aspect = $aspect;
      $orm->insertIfNotExists($msgAspect, array('id_receiver','id_message','aspect'));
    }

    // die anderen löschen
    $orm->deleteWhere(
    	'BuizMessageAspect',
    	" id_receiver={$user->getId()} AND id_message={$messageId} AND NOT aspect IN(".implode(', ',$rqtData->aspects).") "
    );

    $msgNode = $orm->get('BuizMessage',$messageId);



    // task data speichern
    if ($rqtData->hasTask) {

      if($rqtData->taskId) {

        $entTask = $orm->get('BuizTask', $rqtData->taskId);

      } else {

        $entTask = $orm->newEntity('BuizTask');
        $entTask->id_message = $messageId;
      }

      $entTask->addData($rqtData->taskData);

      $orm->save($entTask);

    } else if($rqtData->taskId) {

      $orm->delete('BuizTask',$rqtData->taskId);
      $rqtData->receiverData['flag_action_required'] = false;

    }

    // appointment data speichern
    if ($rqtData->hasAppointment) {

      if($rqtData->appointId) {

        $entAppoint = $orm->get('BuizAppointment', $rqtData->appointId);

      } else {

        $entAppoint = $orm->newEntity('BuizAppointment');
        $entAppoint->id_message = $messageId;
      }

      $entAppoint->addData($rqtData->appointData);

      $orm->save($entAppoint);

    } else if ($rqtData->appointId) {

      // wenn id vorhanden dann löschen
      $orm->delete('BuizAppointment',$rqtData->appointId);
      $rqtData->receiverData['flag_participation_required'] = false;
    }


    // task data speichern
    $entRecv = $orm->get('BuizMessageReceiver', $rqtData->receiverId);
    $entRecv->addData($rqtData->receiverData);
    $orm->save($entRecv);

    $mainAspect = 0;

    if( in_array(EMessageAspect::MESSAGE, $rqtData->aspects) )
      $mainAspect = EMessageAspect::MESSAGE;
    elseif ( in_array(EMessageAspect::DOCUMENT, $rqtData->aspects) ) {
      $mainAspect = EMessageAspect::DOCUMENT;
    } else {
      $mainAspect = EMessageAspect::DISCUSSION;
    }

    if( $msgNode->main_aspect != $mainAspect ) {
      $msgNode->main_aspect = $mainAspect;
      $msgNode->id_sender_status = EMessageStatus::UPDATED;

      $orm->save($msgNode);
    }

    $tmpUSt = EMessageStatus::UPDATED;
    $tmpASt = EMessageStatus::ARCHIVED;

    // alle nicht archivierten oder gelöschten receiver updaten
    $sql = <<<SQL
UPDATE buiz_message_receiver
	set status = {$tmpUSt}
WHERE
	id_message = {$messageId}
	AND ( NOT status = {$tmpASt} OR flag_deleted = true );
SQL;

    $db->update($sql);

  }//ebnd public function saveMessage

  /**
   * @param int $messageId
   */
  public function deleteMessage($messageId)
  {

    $db = $this->getDb();
    $orm = $this->getOrm();
    $user = $this->getUser();

    // erst mal eventuelle receiver & aspekte des users löschen
    $orm->deleteWhere( 'BuizMessageReceiver', 'vid = '.$user->getId().' and id_message = '.$messageId );
    $orm->deleteWhere('BuizMessageAspect', 'id_message='.$messageId.' and id_receiver = '.$user->getId() );

    $sql = <<<SQL
SELECT
	msg.flag_sender_deleted,
	msg.id_sender,
	count(recv.rowid) as num_receiver
FROM
	buiz_message msg
LEFT JOIN
	buiz_message_receiver recv
		ON recv.id_message = msg.rowid AND recv.vid = {$user->getId()}
WHERE
 	msg.rowid = {$messageId}
 		AND NOT recv.flag_deleted = true
GROUP BY
	msg.id_sender,
	msg.flag_sender_deleted
SQL;

    $tmpData = $db->select($sql)->get();

    if (!$tmpData) {
      // ok sollte nicht passieren
      return;
    }

    if( $tmpData['id_sender'] == $user->getId() ) {

      // nur löschen wenn keine receiver mehr da sind
      if( $tmpData['num_receiver'] ) {
        $orm->update( 'BuizMessage', $messageId, array('flag_sender_deleted'=>true) );
        return;
      }

    } else {

      // löschen wenn deleted flag
      if( 't' != $tmpData['flag_sender_deleted'] ) {
        return;
      }

    }

    $orm->delete('BuizMessage', $messageId);

    // referenz tabellen leeren
    $orm->deleteWhere('BuizMessageAspect', 'id_message='.$messageId); // aspekt flags
    $orm->deleteWhere('BuizTask', 'id_message='.$messageId); // eventueller task aspekt
    $orm->deleteWhere('BuizAppointment', 'id_message='.$messageId); // eventueller appointment aspekt
    $orm->deleteWhere('BuizMessageReceiver', 'vid='.$messageId); // alle receiver
    $orm->deleteWhere('BuizDataIndex', 'vid='.$messageId); // fulltext index der db
    $orm->deleteWhere('BuizDataLink', 'vid='.$messageId); // referenzen
    $orm->deleteWhere('BuizEntityAttachment', 'vid='.$messageId); // attachments

  }//ebnd public function deleteMessage

  /**
   * @param int $messageId
   */
  public function deleteAllMessage()
  {

    $db = $this->getDb();
    $user = $this->getUser();
    $userID = $user->getId();
    $orm = $this->getOrm();

    $queries = [];
    $queries[] = 'UPDATE buiz_message set flag_sender_deleted = true WHERE id_sender = '.$userID.';';
    $queries[] = 'DELETE FROM buiz_message_receiver WHERE vid = '.$userID.';';
    $queries[] = 'DELETE FROM buiz_message_aspect WHERE id_receiver = '.$userID.';';

    foreach ($queries as $query) {
      $db->exec($query);
    }

    // alle
    $sql = <<<SQL
SELECT
	msg.rowid as msg_id
FROM
	buiz_message msg
JOIN
	buiz_message_receiver recv
		ON recv.id_message = msg.rowid
having count(recv.rowid) = 0
WHERE
	msg.id_sender = {$userID}
SQL;


    $messages = $db->select($sql);

    $msgIds = [];

    foreach ( $messages as $msg ) {
      $msgIds[] = $msg['msg_id'];
    }

    $whereString = implode(', ', $msgIds);

    $orm->deleteWhere('BuizMessageAspect', 'id_message IN('.$whereString.')'); // aspekt flags
    $orm->deleteWhere('BuizTask', 'id_message IN('.$whereString.')'); // eventueller task aspekt
    $orm->deleteWhere('BuizAppointment', 'id_message IN('.$whereString.')'); // eventueller appointment aspekt
    $orm->deleteWhere('BuizMessageReceiver', 'id_message IN('.$whereString.')'); // alle receiver
    $orm->deleteWhere('BuizDataIndex', 'id_message IN('.$whereString.')'); // fulltext index der db
    $orm->deleteWhere('BuizDataLink', 'id_message IN('.$whereString.')'); // referenzen
    $orm->deleteWhere('BuizEntityAttachment', 'id_message IN('.$whereString.')'); // attachments

  }//end public function deleteAllMessage */

  /**
   *
   * @param int $messageId
   * @throws Per
   */
  public function deleteSelection($msgIds)
  {

    $db = $this->getDb();
    $user = $this->getUser();
    $userID = $user->getId();
    $orm = $this->getOrm();

    if (!$msgIds)
      return;

    $sqlIds = implode(', ', $msgIds);

    $queries = [];
    $queries[] = 'UPDATE buiz_message set flag_sender_deleted = true WHERE id_sender = '.$userID.' AND rowid IN('.$sqlIds.');';
    $queries[] = 'DELETE FROM buiz_message_receiver WHERE vid = '.$userID.' AND id_message IN('.$sqlIds.');';
    $queries[] = 'DELETE FROM buiz_message_aspect WHERE id_receiver = '.$userID.' AND id_message IN('.$sqlIds.');';

    foreach ($queries as $query) {
      $db->exec($query);
    }

    // alle
    $sql = <<<SQL
SELECT
	msg.rowid as msg_id
FROM
	buiz_message msg
JOIN
	buiz_message_receiver recv
		ON recv.id_message = msg.rowid
having count(recv.rowid) = 0
WHERE
	msg.id_sender = {$userID} AND msg.rowid IN({$sqlIds})
SQL;


    $messages = $db->select($sql);

    $msgIds = [];

    foreach ( $messages as $msg ) {
      $msgIds[] = $msg['msg_id'];
    }

    // wenn keine msg ids dann sind wir fertig
    if(!$msgIds)
      return;

    $whereString = implode(', ', $msgIds);

    $orm->deleteWhere('BuizMessageAspect', 'id_message IN('.$whereString.')'); // aspekt flags
    $orm->deleteWhere('BuizTask', 'id_message IN('.$whereString.')'); // eventueller task aspekt
    $orm->deleteWhere('BuizAppointment', 'id_message IN('.$whereString.')'); // eventueller appointment aspekt
    $orm->deleteWhere('BuizMessageReceiver', 'id_message IN('.$whereString.')'); // alle receiver
    $orm->deleteWhere('BuizDataIndex', 'id_message IN('.$whereString.')'); // fulltext index der db
    $orm->deleteWhere('BuizDataLink', 'id_message IN('.$whereString.')'); // referenzen
    $orm->deleteWhere('BuizEntityAttachment', 'id_message IN('.$whereString.')'); // attachments

  }//end public function deleteSelection */

  /**
   * Alle Nachrichten des Users Archivieren
   */
  public function archiveAllMessage()
  {

    $db = $this->getDb();
    $user = $this->getUser();
    $userID = $user->getId();

    $queries = [];
    $queries[] = 'UPDATE buiz_message set id_sender_status = '.EMessageStatus::ARCHIVED.' WHERE id_sender = '.$userID.';';
    $queries[] = 'UPDATE buiz_message_receiver set status = '.EMessageStatus::ARCHIVED.' WHERE vid = '.$userID.';';

    foreach ($queries as $query) {
      $db->exec($query);
    }

  }//end public function archiveAllMessage */

  /**
   * Eine Auswahl von Nachrichten Archivieren
   * @param int $msgIds
   */
  public function archiveSelection($msgIds)
  {

    $db = $this->getDb();
    $user = $this->getUser();
    $userID = $user->getId();

    if (!$msgIds)
      return;

    $sqlIds = implode(', ', $msgIds);

    $queries = [];
    $queries[] = 'UPDATE buiz_message set id_sender_status = '.EMessageStatus::ARCHIVED.' WHERE id_sender = '.$userID.' AND rowid IN('.$sqlIds.')';
    $queries[] = 'UPDATE buiz_message_receiver set status = '.EMessageStatus::ARCHIVED.' WHERE vid = '.$userID.' AND rowid IN('.$sqlIds.')';

    foreach ($queries as $query) {
      $db->exec($query);
    }

  }//end public function archiveSelection */

  /**
   * @param int $messageId
   * @param boolean $archive archive or reopen
   */
  public function archiveMessage($messageId, $archive)
  {

    $db = $this->getDb();
    $orm = $this->getOrm();
    $user = $this->getUser();


    $msgNode = $orm->get( 'BuizMessage', $messageId );

    if( $msgNode->id_sender == $user->getId() ) {

      if( $archive )
        $msgNode->id_sender_status = EMessageStatus::ARCHIVED;
      else
        $msgNode->id_sender_status = EMessageStatus::OPEN;

      $orm->save($msgNode);

    } else {

      $queries = [];

      if( $archive )
        $queries[] = 'UPDATE buiz_message_receiver set status = '.EMessageStatus::ARCHIVED.' WHERE vid = '.$user->getId().' AND rowid = '.$messageId;
      else
        $queries[] = 'UPDATE buiz_message_receiver set status = '.EMessageStatus::OPEN.' WHERE vid = '.$user->getId().' AND rowid = '.$messageId;

      foreach ($queries as $query) {
        $db->exec($query);
      }

    }

  }//ebnd public function archiveMessage


  /**
   *
   * @param User $user
   * @return int
   */
  public function countNewMessages($user)
  {

    $status = EMessageStatus::IS_NEW;

    $sql = <<<SQL

  select count(buiz_message.rowid) as num_new
    FROM buiz_message
    JOIN buiz_message_receiver ON buiz_message.rowid = buiz_message_receiver.id_message
    WHERE buiz_message_receiver.vid = {$user->getId()} AND buiz_message_receiver.status = {$status};

SQL;

    $value = (int) $this->getDb()->select($sql)->getField('num_new');

    if (0 === $value)
      $value = '0';
    elseif (99 < $value)
      $value = '99+';

    return $value;

  }//end public function countNewMessages */

  /**
   *
   * @param User $user
   * @return BuizMessage_Table_Search_Settings
   */
  public function loadSettings()
  {

    $db = $this->getDb();
    $user = $this->getUser();
    $cache = $this->getL1Cache();

    $settingsLoader = new LibUserSettings($db, $user, $cache);

    return $settingsLoader->getUserSetting(EUserSettingType::MESSAGES);

  }//end public function countNewMessages */

  /**
   * @param BuizMessage_Table_Search_Settings $settings
   */
  public function saveSettings($settings)
  {

    $db = $this->getDb();
    $user = $this->getUser();
    $cache = $this->getL1Cache();

    $settingsLoader = new LibUserSettings($db, $user, $cache);
    $settingsLoader->saveUserSetting(EUserSettingType::MESSAGES, $settings);

  }//end public function countNewMessages */

  /**
   * @param int $msgId
   * @param boolean $flagSpam
   * @param TFlag $params
   */
  public function setSpam($msgId, $flagSpam, $params)
  {

    $orm = $this->getOrm();

    $orm->update( 'BuizMessage', $msgId, array( 'spam_level' => $flagSpam ) );

  }//end public function setSpam */

////////////////////////////////////////////////////////////////////////////////
// References
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param int $msgId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function loadMessageReferences($msgId)
  {

    $db = $this->getDb();

    $sql = <<<SQL

select
  link.rowid as link_id,
  idx.vid,
  idx.title,
  ent.name,
  ent.default_edit as edit_link

FROM
  buiz_data_link link

JOIN
	buiz_data_index idx
		ON idx.vid = link.id_link

JOIN
	buiz_entity ent
		ON ent.rowid = idx.id_vid_entity

WHERE
  link.vid = {$msgId};

SQL;

    //$references = $db->select($sql)->getAll();

    return $db->select($sql);

  }//end public function loadMessageReferences */

  /**
   * @param int $linkId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function loadRefById($linkId)
  {

    $db = $this->getDb();

    $sql = <<<SQL

select
  link.rowid as link_id,
  idx.vid,
  idx.title,
  ent.name,
  ent.default_edit as edit_link

FROM
  buiz_data_link link

JOIN
	buiz_data_index idx
		ON idx.vid = link.id_link

JOIN
	buiz_entity ent
		ON ent.rowid = idx.id_vid_entity

WHERE
  link.rowid = {$linkId};

SQL;

    return $db->select($sql)->get();

  }//end public function loadRefById */


  /**
   * @param int $msgId
   * @param int $refId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function addRef($msgId, $refId)
  {

    $orm = $this->getOrm();

    $link = $orm->newEntity('BuizDataLink');
    $link->vid = $msgId;
    $link->id_link = $refId;

    $orm->save($link);

    return $link;

  }//end public function loadMessageReferences */

  /**
   * @param int $linkId
   */
  public function delRef($linkId)
  {

    $this->getOrm()->delete('BuizDataLink',$linkId);

  }//end public function delRef */

////////////////////////////////////////////////////////////////////////////////
// Checklist
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param int $msgId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function loadMessageChecklist($msgId)
  {

    $db = $this->getDb();

    $sql = <<<SQL

select
  checklist.rowid as id,
  checklist.label as label,
	checklist.flag_checked as checked

FROM
  buiz_checklist_entry checklist

WHERE
  checklist.vid = {$msgId};

SQL;

    //$references = $db->select($sql)->getAll();

    return $db->select($sql);

  }//end public function loadMessageChecklist */


} // end class BuizMessage_Model

