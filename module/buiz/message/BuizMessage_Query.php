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
class BuizMessage_Query extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   * Loading the tabledata from the database
   * @param string $key
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchAutocomplete($key)
  {

    $this->sourceSize = null;
    $db = $this->getDb();

    $sql = <<<SQL
  SELECT
    buiz_role_user_rowid as id,
    buiz_role_user_name || ' <' || core_person_lastname || ', ' || core_person_firstname || '>'  as value

  FROM
    view_person_role

  WHERE
    UPPER(buiz_role_user_name) like UPPER('{$db->escape($key)}%')
      OR UPPER(core_person_lastname) like UPPER('{$db->escape($key)}%')
      OR UPPER(core_person_lastname) like UPPER('{$db->escape($key)}%')

  LIMIT 10

SQL;

    $this->result = $db->select($sql);

  }//end public function BuizMessage_Query */

}//end class Example_Query

