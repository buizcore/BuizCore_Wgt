<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : Buiz Developer Network <contact@buiz.net>
* @project     : Buiz Web Frame Application
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
class LibCleanerDset_Action extends Action
{

  /**
   * Löschen aller möglicherweise vorhandenen vid links
   *
   * @param LibDbConnection $db
   * @param int $id
   */
  public function cleanDefault($id)
  {

    $db = $this->getDb();

    if (is_object($id) && $id instanceof Entity)
      $id = $id->getId();

    if (!ctype_digit($id) || ! (int) $id > 0) {

      $devMsg = <<<ERRMSG
Tried to clean the Dataset resources with an empty ID.
That should not happen. You need to check if you got a valid ID before you
use it to clean reference datasets.
ERRMSG;

      throw new BuizSys_Exception
      (
        $devMsg,
        Error::INTERNAL_ERROR_MSG,
        Response::INTERNAL_ERROR,
        true,
        null,
        $id
      );
    }

    $sql = [];

    // bookmarks
    $sql[] = <<<SQL
DELETE FROM buiz_bookmark where vid = {$id};
SQL;

    //// Calendar
    // calendar refs
    $sql[] = <<<SQL
DELETE FROM buiz_calendar_vref where vid = {$id};
SQL;

    // Appointment mit dem Bezug auf diesen Datensatz
    /*
    $sql[] = <<<SQL
DELETE FROM buiz_appointment_vref where vid = {$id};
SQL;
    */

    //// TAGGING löschen

    // Tags auf einen Datensatz
    $sql[] = <<<SQL
DELETE FROM buiz_tag_reference where vid = {$id};
SQL;

    //// COMMENT daten löschen

    // comment ratings löschen
    $sql[] = <<<SQL
DELETE FROM buiz_comment_rating where id_comment IN(
  SELECT rowid from buiz_comment where vid =  {$id}
);
SQL;

    // comments
    $sql[] = <<<SQL
DELETE FROM buiz_comment where vid = {$id};
SQL;

    //// PROZESS bezogenen Daten löschen
    // Prozess history leeren
    $sql[] = <<<SQL
DELETE FROM buiz_process_step where id_process_instance IN(
  SELECT rowid from buiz_process_status where vid =  {$id}
);
SQL;

    // Prozess status leeren
    $sql[] = <<<SQL
DELETE FROM buiz_process_status where vid = {$id};
SQL;

    //// ACCESS / GROUP USERS
    // Group Users mit der VID löschen
    $sql[] = <<<SQL
DELETE FROM buiz_group_users where vid = {$id};
SQL;

    //// INDEX
    // links auf Datensätze löschen
    $sql[] = <<<SQL
DELETE FROM buiz_data_link where id_link = {$id};
SQL;
    // Datensätze aus dem Index Löschen
    $sql[] = <<<SQL
DELETE FROM buiz_data_index where vid = {$id};
SQL;

    $db->multiDelete($sql);

  }//end public function cleanDefault */

  /**
   * Calendar und alle darauf verweisenden Appointments usw löschen
   */
  public function cleanCalendar()
  {

  }//end public function cleanCalendar */

} // end class LibCleanerDb

