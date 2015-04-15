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
class BuizDesktop_Menu_Provider extends Provider
{

  /**
   * @param int $profileId
   * @return array[rowid, label, icon, http_url]
   */
  public function getProfileMenu( $profileKey )
  {

    $db = $this->getDb();

    $codeWhere = null;
    if (is_numeric($profileKey)) {
      $codeWhere = "  buiz_profile.rowid = {$profileKey} ";
    } else {
      $codeWhere = "  buiz_profile.access_key = '{$profileKey}' ";
    }


    $sql = <<<SQL

SELECT
  buiz_menu_entry.rowid,
  buiz_menu_entry.label,
  buiz_menu_entry.icon,
  buiz_menu_entry.http_url
FROM
  buiz_menu_entry
JOIN
  buiz_profile
    ON buiz_profile.id_profile_menu = buiz_menu_entry.id_menu
WHERE
  {$codeWhere}
order by m_order;

SQL;

    return $db->select($sql)->getAll();


  }//end public function getProfileMenu */

  /**
   * @param int $profileId
   * @return array[rowid, label, icon, http_url]
   */
  public function getMainMenu( $profileKey )
  {

    $db = $this->getDb();

    $codeWhere = null;
    if (is_numeric($profileKey)) {
      $codeWhere = "  buiz_profile.rowid = {$profileKey} ";
    } else {
      $codeWhere = "  buiz_profile.access_key = '{$profileKey}' ";
    }

    $sql = <<<SQL

SELECT
  buiz_menu_entry.rowid,
  buiz_menu_entry.label,
  buiz_menu_entry.icon,
  buiz_menu_entry.http_url,
  buiz_menu_entry.m_parent,
  buiz_menu_entry.type,
  buiz_menu_entry.access_key
FROM
  buiz_menu_entry
JOIN
  buiz_profile
    ON buiz_profile.id_main_menu = buiz_menu_entry.id_menu
WHERE
  {$codeWhere}
ORDER BY m_order;

SQL;

    $tmp = $db->select($sql)->getAll();

    $entries = array('root'=> []);

    foreach( $tmp as $entry ){

      if (!$entry['m_parent']) {
        $entries['root'][] = $entry;
      } else {

        if(!isset($entries[$entry['m_parent']])){
          $entries[$entry['m_parent']] = [];
        }

        $entries[$entry['m_parent']][] = $entry;

      }
    }

    return $entries;


  }//end public function getMainMenu */

} // end class BuizDesktop_Menu_Provider

