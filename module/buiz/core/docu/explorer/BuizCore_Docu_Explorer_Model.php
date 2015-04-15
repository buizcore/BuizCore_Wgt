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
class BuizCore_Docu_Explorer_Model extends MvcModel
{

  /**
   * @param string $key
   * @return array
   */
  public function getModules()
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  access_key,
  id_security_area,
  description,
  revision,
  rowid,
  copyright,
  short_desc,
  docu
  licence
FROM buiz_module
  order by access_key
SQL;


    return $db->select($sql);


  }//end public function getModules */

  /**
   * @param string $key
   * @return array
   */
  public function getEntities($modId)
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  access_key,
  id_security_area,
  description,
  revision,
  rowid,
  copyright,
  short_desc,
  docu
  licence
FROM buiz_module
  order by access_key
SQL;

    return $db->select($sql);

  }//end public function getEntities */

}//end class BuizCore_Docu_Menu_Model

