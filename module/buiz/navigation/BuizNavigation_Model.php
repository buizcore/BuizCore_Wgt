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
class BuizNavigation_Model extends MvcModel
{

  /**
   * @param string $key
   * @param TArray $params
   */
  public function searchEntriesAutocomplete($key, $params)
  {

    $db = $this->getDb();
    $query = $db->newQuery('BuizNavigation');

    $query->fetchEntriesByKey
    (
      $key,
      $params
    );

    return $query->getAll();

  }//end public function searchEntriesAutocomplete */

}//end class BuizNavigation_Model

