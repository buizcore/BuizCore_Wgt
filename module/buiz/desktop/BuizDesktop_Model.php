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
class BuizDesktop_Model extends MvcModel
{

  /**
   * @param int $profileId
   * @return array[rowid, label, icon, http_url]
   */
  public function getProfileMenu( $profileId )
  {

    $db = $this->getDb();

    $sql = <<<SQL

SELECT
  rowid,
  label,
  icon,
  http_url
FROM
  buiz_menu_entry
JOIN
  buiz_profile
    ON buiz_profile.id_profile_menu = buiz_menu_entry.id_menu
WHERE
  buiz_profile.rowid = {$profileId};

SQL;

    $db->select($sql)->getAll();


  }//end public function getProfileMenu */

  /**
   * @param int $profileId
   * @return array[rowid, label, icon, http_url]
   */
  public function getMainMenu( $profileId )
  {

    $db = $this->getDb();

    $sql = <<<SQL

SELECT
  rowid,
  label,
  icon,
  http_url,
  m_parent
FROM
  buiz_menu_entry
JOIN
  buiz_profile
    ON buiz_profile.id_main_menu = buiz_menu_entry.id_menu
WHERE
  buiz_profile.rowid = {$profileId};

SQL;

    $db->select($sql)->getAll();


  }//end public function getProfileMenu */

} // end class BuizDesktop_Model

