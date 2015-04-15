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
class AclMgmt_Query extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// fetch methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
   * Loading the tabledata from the database
   * @param int $areaId
   * @param string $key
   * @param TFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchGroupsByKey($areaId, $key, $params = null)
  {

    if (!$params)
      $params = new TFlag();

    $this->sourceSize = null;
    $db = $this->getDb();

    $sql = <<<SQL

  SELECT
    rowid as id,
    name as value,
    name as label
  FROM
    buiz_role_group
  where
    UPPER(name) like UPPER('{$db->escape($key)}%')
    AND NOT rowid IN(SELECT id_group FROM buiz_security_access WHERE id_area = {$areaId})
  LIMIT 10;

SQL;

    $this->result = $db->select($sql)->getAll();

  }//end public function fetchGroupsByKey */

  /**
   * Loading the tabledata from the database
   * @param int $areaId
   * @param string $key
   * @param TFlag $params
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchAreasByKey($areaId, $key, $params = null)
  {

    if (!$params)
      $params = new TFlag();

    $this->sourceSize = null;
    $db = $this->getDb();

    $sql = <<<SQL

  SELECT
    buiz_security_area.rowid as id,
    buiz_security_area.access_key as value,
    buiz_security_area.access_key as label
  FROM
    buiz_security_area
  JOIN
      buiz_security_area_type
    ON
      buiz_security_area_type.rowid = buiz_security_area.id_type
  WHERE
    LOWER(buiz_security_area.access_key) like LOWER('{$db->escape($key)}%')
    AND NOT rowid IN( SELECT id_group FROM buiz_security_area WHERE buiz_security_area.rowid = {$areaId} )
    AND buiz_security_area_type.access_key IN('module','module_category','mgmt')
  ORDER BY buiz_security_area.access_key asc
  LIMIT 12;

SQL;

    $this->result = $db->select($sql)->getAll();

  }//end public function fetchAreasByKey */

} // end class AclMgmt_Query */

