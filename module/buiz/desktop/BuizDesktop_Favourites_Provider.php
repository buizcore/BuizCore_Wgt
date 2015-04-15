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
class BuizDesktop_Favourites_Provider extends Provider
{

  /**
   * @param int $userId
   * @return array[title, url, description]
   */
  public function getFavs( $userId )
  {

    $db = $this->getDb();

    $sql = <<<SQL

SELECT
  title,
  url,
  description
FROM
  buiz_bookmark
WHERE
  id_role = {$userId}
ORDER BY
title;

SQL;

    return $db->select($sql)->getAll();


  }//end public function getFavs */


} // end class BuizDesktop_Favourites_Provider

