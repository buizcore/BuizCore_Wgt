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
class BuizMenu_Query extends LibSqlQuery
{
/*////////////////////////////////////////////////////////////////////////////*/
// queries
/*////////////////////////////////////////////////////////////////////////////*/

 /**
   * Loading the tabledata from the database
   * @param string/array $entityKey conditions for the query
   * @param string/array $params how should the query be orderd
   * @return void
   *
   * @throws LibDb_Exception
   */
  public function fetchMenuEntries($menuKey , $params = null)
  {

    $this->sourceSize = null;
    $db = $this->getDb();

    $query = <<<CODE

select
  entry.rowid ,
  entry.label ,
  entry.icon  ,
  entry.url   ,
  entry.access_key,
  entry.id_parent
from
  buiz_menu_entry entry
where
  entry.id_menu = {$menuKey}
order by
  entry.id_parent

CODE;

    // Run Query und save the result
    $this->result = $db->select($query);

  }//end public function fetchMenuEntries */

}//end class BuizMenu_Query

