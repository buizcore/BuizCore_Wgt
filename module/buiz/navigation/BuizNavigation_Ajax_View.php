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
class BuizNavigation_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// display methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   * @param TArray $params
   */
  public function displayAutocomplete($key, $params)
  {

    $view = $this->getTplEngine();
    $view->setRawJsonData($this->model->searchEntriesAutocomplete($key, $params));

  }//end public function displayAutocomplete */

  /**
   * @param string $key
   * @param LibSqlQuery $data
   * @param TArray $params
   */
  public function displayNavlist($key, $data, $params)
  {

  }//end public function displayNavlist */

} // end class Buiz_Navigation_Ajax_View */

