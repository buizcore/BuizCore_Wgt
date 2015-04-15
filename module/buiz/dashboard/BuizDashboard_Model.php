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
class BuizDashboard_Model extends MvcModel
{

  /**
   * Laden der Quicklinks für das aktuell geladenen profil
   * @return ArrayIterator
   */
  public function loadProfileQuickLinks()
  {

    $db = $this->getDb();
    $profileKey = $this->getUser()->getProfileName();

    $sql = <<<SQL
SELECT
  ql.rowid as id,
  ql.http_url as url,
  ql.label as label
FROM
  buiz_profile_quicklink ql
JOIN
  buiz_profile profile
    ON profile.rowid = ql.id_profile
WHERE
  UPPER(profile.access_key) = UPPER('{$profileKey}')
ORDER BY
  ql.label;

SQL;

    return $db->select($sql)->getAll();


  }//end public function loadProfileQuickLinks */


  /**
   * Laden der Quicklinks für das aktuell geladenen profil
   * @return ArrayIterator
   */
  public function loadLastVisited()
  {

    $db = $this->getDb();
    $user = $this->getUser();

    $sql = <<<SQL
SELECT
  ac.vid as vid,
  ac.label as label,
  mask.access_url as url,
  ac.m_time_created as visited
FROM
  buiz_protocol_access ac
JOIN
  buiz_mask mask
  ON mask.rowid = ac.id_mask
WHERE
  ac.m_role_created = {$user->getId()}
ORDER BY
  ac.m_time_created desc
LIMIT 10;

SQL;


    $tmp = $db->select($sql)->getAll();

    $data = [];
    foreach ($tmp as $entry) {
      $innerTmp = [];

      $date = DateTime::createFromFormat('Y-m-d H:i:s', $entry['visited']);

      $innerTmp['label'] = $entry['label'].' ('.$date->format('Y-m-d').') ';

      if ($entry['vid'])
        $innerTmp['url'] = 'maintab.php?c='.$entry['url'].'&amp;objid='.$entry['vid'];
      else
        $innerTmp['url'] = 'maintab.php?c='.$entry['url'];

      $data[] = $innerTmp;
    }

    return $data;

  }//end public function loadLastVisited */

  /**
   * Laden der Quicklinks für das aktuell geladenen profil
   * @return ArrayIterator
   */
  public function loadMostVisited()
  {

    $db = $this->getDb();
    $user = $this->getUser();

    $sql = <<<SQL
SELECT
  ac.vid as vid,
  ac.label as label,
  mask.access_url as url,
  ac.counter as counter
FROM
  buiz_protocol_access ac
JOIN
  buiz_mask mask
  ON mask.rowid = ac.id_mask
WHERE
  ac.m_role_created = {$user->getId()}
ORDER BY
  ac.counter desc
LIMIT 10;

SQL;


    $tmp = $db->select($sql)->getAll();

    $data = [];
    foreach ($tmp as $entry) {
      $innerTmp = [];

      $innerTmp['label'] = $entry['label'].' ('.$entry['counter'].' times) ';

      if ($entry['vid'])
        $innerTmp['url'] = 'maintab.php?c='.$entry['url'].'&amp;objid='.$entry['vid'];
      else
        $innerTmp['url'] = 'maintab.php?c='.$entry['url'];

      $data[] = $innerTmp;
    }

    return $data;

  }//end public function loadMostVisited */

  /**
   * Laden der Bookmarks
   * @return ArrayIterator
   */
  public function loadBookmarks()
  {

    $db = $this->getDb();
    $user = $this->getUser();

    $sql = <<<SQL
SELECT
  title as label,
  url
FROM
  buiz_bookmark
WHERE
  id_role = {$user->getId()}
ORDER BY
  m_time_created desc

SQL;


    $tmp = $db->select($sql)->getAll();

    /*
    $data = [];
    foreach ($tmp as $entry) {
      $innerTmp = [];

      $innerTmp['label'] = $entry['label'].' ('.$entry['counter'].' times) ';

      if ($entry['vid'])
        $innerTmp['url'] = 'maintab.php?c='.$entry['url'].'&amp;objid='.$entry['vid'];
      else
        $innerTmp['url'] = 'maintab.php?c='.$entry['url'];

      $data[] = $innerTmp;
    }
    */

    return $tmp;

  }//end public function loadMostVisited */


  /**
   * Laden der System Announcements
   * @param string $type
   * @param int $limit
   * @param int $offset
   * @return ArrayIterator
   */
  public function loadNews(
    $type = EBuizAnnouncementType::ANNOUNCEMENT,
    $limit = 10,
    $offset = 0
  ) {

    $db = $this->getDb();
    $user = $this->getUser();

    $now = date('Y-m-d');

    $sql = <<<SQL
SELECT
  ann.rowid as rowid,
  ann.title,
  ann.message as content,
  ann.date_start,
  ann.type,
  ann.importance,
  ann.m_time_created as created,
  person.fullname as creator

FROM
  buiz_announcement ann

JOIN
  view_person_role person
    ON person.buiz_role_user_rowid = ann.m_role_created

JOIN
  buiz_announcement_channel chan
    ON chan.rowid = ann.id_channel

LEFT JOIN
  buiz_user_announcement uss
    ON ann.rowid = uss.id_announcement
    	AND uss.id_user = {$user->getId()}

WHERE
  UPPER(chan.access_key) = UPPER('wbf_global')
  	AND (NOT uss.visited = '2' OR uss.visited is null)
  	AND ann.type = {$type}
  	AND (ann.date_start <= '{$now}' OR ann.date_start is null)
  	AND (ann.date_end >= '{$now}' OR ann.date_start is null)

ORDER BY
  ann.m_time_created desc

limit {$limit}
offset {$offset};

SQL;

    return $db->select($sql)->getAll();

  }//end public function loadNews */


  /**
   * Laden der System Announcements
   * @return ArrayIterator
   */
  public function loadWallmessage()
  {

    $db = $this->getDb();
    $user = $this->getUser();

    $now = date('Y-m-d');

    $sql = <<<SQL
SELECT
  ann.rowid as rowid,
  ann.title,
  ann.message as content,
  ann.date_start,
  ann.id_type,
  ann.importance,
  ann.m_time_created as created,
  person.fullname as creator

FROM
  buiz_announcement ann

JOIN
  view_person_role person
    ON person.buiz_role_user_rowid = ann.m_role_created

JOIN
  buiz_announcement_channel chan
    ON chan.rowid = ann.id_channel

JOIN
  buiz_announcement_type type
    ON type.rowid = ann.id_type

LEFT JOIN
  buiz_user_announcement uss
    ON ann.rowid = uss.id_announcement
    	AND uss.id_user = {$user->getId()}

WHERE
  UPPER(chan.access_key) = UPPER('wbf_global')
  	AND (NOT uss.visited = '2' OR uss.visited is null)
  	AND type.access_key = UPPER('wallmessage')
  	AND (ann.date_start <= '{$now}' OR ann.date_start is null)
  	AND (ann.date_end >= '{$now}' OR ann.date_start is null)

ORDER BY
  ann.m_time_created desc

limit 1;

SQL;

    return $db->select($sql)->getAll();

  }//end public function loadNews */

} // end class BuizDesktop_Model

