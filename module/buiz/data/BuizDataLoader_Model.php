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
class BuizDataLoader_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function getStructure()
  {

    $db = $this->getDb();

    $stats = [];

    $query = <<<SQL
SELECT
  ent.name ent_name,
  ent.access_key ent_key,
  mod.name as mod_name

FROM
  buiz_entity ent

LEFT JOIN
  buiz_module mod
    ON mod.rowid = ent.id_module;

SQL;

    return $db->select($query)->getAll();

  }//end public function getStats */

  /**
   * @return void
   */
  public function getModules()
  {
    return [];

  }//end public function getModules */

}//end class BuizMaintenance_DataIndex_Model */

