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
class BuizMessage_MiniList_Query extends LibSqlQuery
{

 /**
   * Leider gibt num_cols nur die Anzahl der tatsächlich gefundenen
   * Datensätze zurück. Wenn Limit in der Query verwendet
   * bringt diese Zahl dann nichtsmehr, wenn man eigentlich wissen
   * möchte wieviele denn ohne limit gefunden worden wären.
   *
   * Setzen der query mit der die anzahl der gefundenen datensätze ohne
   * limit ermittelt wird
   *
   * @param LibSqlCriteria $criteria
   * @param TFlag $params
   * @return void
   */
  public function setCalcQuery($criteria, $params)
  {

    if ($params->loadFullSize)
      $this->calcQuery = $criteria->count('count(buiz_message.rowid) as '.Db::Q_SIZE);

  }//end public function setCalcQuery */

/*////////////////////////////////////////////////////////////////////////////*/
// query elements table
/*////////////////////////////////////////////////////////////////////////////*/

 /**
   * Vollständige Datenbankabfrage mit allen Filtern und Formatierungsanweisungen
   * ACLs werden nicht beachtet
   *
   * @param string/array $condition conditions for the query
   * @param TFlag $params
   *
   * @return void wird im bei Fehlern exceptions, ansonsten war alles ok
   *
   * @throws LibDb_Exception bei technischen Problemen wie zB. keine Verbindung
   *   zum Datenbank server, aber auch fehlerhafte sql queries
   */
  public function fetch($condition = null, $params = null)
  {

    if (!$params)
      $params = new TFlag();

    $user = $this->getUser();

    $this->sourceSize = null;
    $db = $this->getDb();

    if (!$this->criteria) {
      $this->criteria = $db->orm->newCriteria();
    }

    $this->setCols($this->criteria);

    $this->setTables($this->criteria);
    $this->appendConditions($this->criteria, $condition, $params);
    $this->checkLimitAndOrder($this->criteria, $condition, $params);
    $this->appendFilter($this->criteria, $condition, $params);

    // Run Query und save the result
    $this->result = $db->orm->select($this->criteria);

    if ($params->loadFullSize)
      $this->calcQuery = $this->criteria->count('count(buiz_message.'.Db::PK.') as '.Db::Q_SIZE);

  }//end public function fetch */


 /**
   * Injecten der zu ladenden Columns in die SQL Query
   * Wenn bereits Colums vorhanden waren werden diese komplett
   * überschrieben
   * Wenn Columns ergänzt werden sollen, dann können diese mit
   * $criteria->selectAlso('additional.column');
   * übergeben werden
   *
   * @param LibSqlCriteria $criteria
   *
   * @return void
   */
  public function setCols($criteria)
  {

    $cols = array(
      'buiz_message.rowid as "buiz_message_rowid"',
      'buiz_message.title as "buiz_message_title"',
      'buiz_message.message as "buiz_message_message"',
      'buiz_message.priority as "buiz_message_priority"',
      'buiz_message.stack_id as "buiz_message_stack_id"',
      'buiz_message.spam_level as "buiz_message_spam_level"',
      'buiz_message.message_id as "buiz_message_message_id"',
      'buiz_message.main_aspect as "buiz_message_main_aspect"',
      'buiz_message.id_sender as "buiz_message_id_sender"',
      'buiz_message.id_sender_status as "buiz_message_id_sender_status"',
      'buiz_message.m_role_created as "buiz_message_m_role_created"',
      'buiz_message.m_time_created as "buiz_message_m_time_created"',
      'task.flag_urgent',
      'task.deadline',
      'task.rowid as task_id',
      'appoint.rowid as appoint_id',
      'sender.core_person_lastname',
      'sender.core_person_firstname',
      'sender.buiz_role_user_name'
    );

    $criteria->select($cols, true);

  }//end public function setCols */

  /**
   * Injecten der Zieltabelle, sowie
   * aller nötigen Joins zum laden der Daten
   *
   * Es werden jedoch nicht sofort alle möglichen Joins injiziert
   * Die Filter Methode hängt selbständig optionale Joins an, wenn
   * diese nicht schon geladen wurden jedoch zum filtern der Daten
   * benötigt werden
   *
   * @param LibSqlCriteria $criteria
   *
   * @return void
   */
  public function setTables($criteria)
  {

    $criteria->from('buiz_message');

    // der sender
    $criteria->joinOn(
      'buiz_message', 'id_sender',
      'view_person_role', 'buiz_role_user_rowid',
      null,
      'sender'
    );

    // der receiver
    $criteria->joinOn(
      'buiz_message', 'rowid',
      'buiz_message_receiver', 'id_message',
      null,
      'buiz_message_receiver'
    );

    // action
    $criteria->leftJoinOn(
      'buiz_message', 'rowid',
      'buiz_task', 'id_message',
      null,
      'task'
    );

    $criteria->leftJoinOn(
      'buiz_message', 'rowid',
      'buiz_appointment', 'id_message',
      null,
      'appoint'
    );

    // aspekt zum filtern
    $criteria->joinOn(
      'buiz_message', 'rowid',
      'buiz_message_aspect', 'id_message',
      null,
      'buiz_message_aspect'
    );


  }//end public function setTables */

  /**
   * Loading the tabledata from the database
   *
   * @param LibSqlCriteria $criteria
   * @param array $condition the conditions
   * @param TFlag $params
   * @return void
   */
  public function appendConditions($criteria, $condition, $params)
  {

    // append codition if the query has a default filter
    if ($this->condition) {

      if (is_string($this->condition)) {

        if (ctype_digit($this->condition)) {
          $criteria->where('buiz_message.rowid = '.$this->condition);
        } else {
          $criteria->where($this->condition);
        }

      } elseif (is_array($this->condition)) {
        $this->checkConditions($criteria, $this->condition);
      }

    }

    if ($condition) {

      if (is_string($condition)) {
        if (ctype_digit($condition)) {
          $criteria->where('buiz_message.rowid = '.$condition);
        } else {
          $criteria->where($condition);
        }
      } elseif (is_array($condition)) {
        $this->checkConditions($criteria, $condition);
      }
    }

    if ($params->begin) {
      $this->checkCharBegin($criteria, $params);
    }

  }//end public function appendConditions */

 /**
   * Loading the tabledata from the database
   * @param LibSqlCriteria $criteria
   * @param array $condition the conditions
   *
   * @return void
   */
  public function checkConditions($criteria, array $condition)
  {

    $db = $this->getDb();

    if (isset($condition['free']) && trim($condition['free']) != '') {

       if (ctype_digit($condition['free'])) {

          $part = $condition['free'];

          $criteria->where('( buiz_message.rowid = \''.$part.'\' )');
       } else {

          // prüfen ob mehrere suchbegriffe kommagetrennt übergeben wurden
          if (strpos($condition['free'], ',')) {

            $parts = explode(',', $condition['free']);

            foreach ($parts as $part) {

              $part = trim($part);

              // prüfen, dass der string nicht leer ist
              if ('' ==  $part)
                continue;

              $safePart = $db->escape($part);

              if ('@' == $safePart[0]) {
                $safePart = substr($safePart, 1);
                $criteria->where
                ('(
                  UPPER(sender.core_person_lastname) = UPPER(\''.$safePart.'\')
                    OR UPPER(sender.core_person_firstname) = UPPER(\''.$safePart.'\')
                    OR UPPER(sender.buiz_role_user_name) = UPPER(\''.$safePart.'\')
                )');
              } else {
                $criteria->where
                ('(

                  UPPER(buiz_message.title) like UPPER(\'%'.$safePart.'%\')
                    OR UPPER(buiz_message.message) like UPPER(\'%'.$safePart.'%\')
                )');
              }

           }

         } else {
           $safePart = $db->escape($condition['free']) ;

           if ('@' == $safePart[0]) {
             $safePart = substr($safePart, 1);
             $criteria->where
             ('(
                UPPER(sender.core_person_lastname) = UPPER(\''.$safePart.'\')
                  OR UPPER(sender.core_person_firstname) = UPPER(\''.$safePart.'\')
                  OR UPPER(sender.buiz_role_user_name) = UPPER(\''.$safePart.'\')
             )');
           } else {
             $criteria->where
             ('(
                UPPER(buiz_message.title) like UPPER(\'%'.$safePart.'%\')
                  OR UPPER(buiz_message.message) like UPPER(\'%'.$safePart.'%\')
             )');
           }

         }

       }

    }//end if


  }//end public function checkConditions */

  /**
   * Loading the tabledata from the database
   *
   * @param LibSqlCriteria $criteria
   * @param TFlag $params
   *
   * @return void
   */
  public function checkCharBegin($criteria, $params)
  {

    // filter for a beginning char
    if ($params->begin) {

      if ('?' == $params->begin) {
        $criteria->where("buiz_message.title ~* '^[^a-zA-Z]'");
      } else {
        $criteria->where("upper(substr(buiz_message.title,1,1)) = '".strtoupper($params->begin)."'");
      }

    }

  }//end public function checkCharBegin */

  /**
   * Limit, Offset und Order By daten in die Query injizieren
   *
   * @param LibSqlCriteria $criteria
   * @param TFlag $params
   *
   * @return void
   */
  public function checkLimitAndOrder($criteria, $condition, $params)
  {

    // check if there is a given order
    if ($condition['order']) {
      $criteria->orderBy($condition['order']);

    } else { // if not use the default
      $criteria->orderBy('buiz_message.m_time_created desc');

    }

    // Check the offset
    if ($params->start) {
      if ($params->start < 0)
        $params->start = 0;
    } else {
      $params->start = null;
    }
    $criteria->offset($params->start);

    // Check the limit
    if (-1 == $params->qsize) {
      // no limit if -1
      $params->qsize = null;
    } elseif ($params->qsize) {
      // limit must not be bigger than max, for no limit use -1
      if ($params->qsize > Wgt::$maxListSize)
        $params->qsize = Wgt::$maxListSize;
    } else {
      // if limit 0 or null use the default limit
      $params->qsize = Wgt::$defListSize;
    }

    $criteria->limit($params->qsize);

  }//end public function checkLimitAndOrder */

  /**
   * Nur die sortierung in die Query injizieren
   *
   * @param LibSqlCriteria $criteria
   * @param $params
   *
   * @return void
   */
  public function injectOrder($criteria, $params)
  {

    $criteria->orderBy('buiz_message.m_time_created asc');

    return;

    // check if there is a given order
    if ($params->order) {
      $criteria->orderBy($params->order);
    } else { // if not use the default
      $criteria->orderBy('buiz_message.m_time_created desc');
    }

  }//end public function injectOrder */

  /**
   * Mit dieser Methode werden alle Filter, zB. aus einem Suchformular
   * bearbeitet und in die Query eingebaut
   *
   * Es werden nur Parameter verwendet die in der Logik definiert wurden
   * Weitere Parameter werden einfach ignoriert, so dass der Anwender
   * nicht einfach neue Filter hinzufügen kann
   *
   * @param LibSqlCriteria $criteria
   * @param $params
   *
   * @return void
   */
  public function appendFilter($criteria, $condition, $params)
  {

    $db = $this->getDb();
    $user = $this->getUser();
    $userId = $user->getId();

    $criteria->where(' buiz_message.spam_level < 51 ');

    $criteria->where('buiz_message.flag_draft = false');

    // nur inbox
    $filterReceiver = ' AND buiz_message_receiver.status < '.EMessageStatus::ARCHIVED;
    $criteria->where(
    	"( buiz_message_receiver.vid = ".$userId
        ." AND buiz_message_aspect.id_receiver = ".$userId
        ." AND NOT buiz_message_receiver.flag_deleted = true {$filterReceiver} )"
    );


  }//end public function appendFilter */

}// end class BuizMessage_Widget_Query_Postgresql

