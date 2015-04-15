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
class CoreAddress_Provider extends Provider
{

  /**
   *
   */
  public function getAddress()
  {

  }//end public function getAddress */

  /**
   * @param int $idPerson
   * @return array
   */
  public function getAddressList($idPerson)
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  addr.rowid,
  addr.name,
  type.name as type
FROM
  core_address addr
LEFT JOIN
  core_address_type type
  ON type.rowid = addr.id_type
WHERE
  vid = {$idPerson}
order by
  addr.name
SQL;

    return $db->select($sql)->getAll();

  }//end public function getAddressList */


}// end class CoreAddress_Provider

