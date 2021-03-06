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
class BuizContact_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/


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
    $this->access = new BuizContact_Table_Access(null, null, $this);
    $this->access->load($user->getProfileName(), $params);

    $params->access = $this->access;

    return $this->access;

  }//end public function loadTableAccess */


  /**
   * @param BuizContact_Save_Request $saveRqt
   * @throws InternalError_Exception
   */
  public function insertContact( $saveRqt )
  {

    $db = $this->getDb();
    $orm = $this->getOrm();

    $db->begin();
    try {

      // speichert sowohl contact als auch person
      $orm->save($saveRqt->contact);

    } catch( LibDb_Exception $exc ) {

      $db->rollback();
      throw new InternalError_Exception( 'Save Failed', $exc->getMessage() );

    }

    $db->commit();

  }//end public function insertContact */


  /**
   * @param TFlag $userRqt
   * @return array
   */
  public function fetchContacts($userRqt)
  {

    $db = $this->getDb();
    $user = $this->getUser();


    /* @var $query BuizContact_List_Query
    $query = $db->newQuery('BuizContact_List');
    $query->userId = $user->getId();

    $query->fetch(
      $this->params->conditions,
      $params
    );

    return $query; */

  }//end public function fetchMessages */

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
  sender.buiz_role_user_rowid as sender_id

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
WHERE
  msg.rowid = {$msgId};

SQL;


    $node = $db->select($sql)->get();

    if ($node) {

      // auf open setzen wenn noch closed
      if ($setOpen && EMessageStatus::IS_NEW == $node['receiver_status'] ) {
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





} // end class BuizMessage_Model

