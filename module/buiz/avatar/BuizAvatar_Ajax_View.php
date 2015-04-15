<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore
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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class BuizAvatar_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param int $taskId
   * @param string $key
   * @param TArray $params
   */
  public function displayAutocomplete($taskId, $key, $params)
  {

    $view = $this->getTpl();
    $view->setRawJsonData($this->model->getVisitorAutolistByKey($taskId, $key, $params));

  }//end public function displayAutocomplete */

}//end class MarketingCampaign_Page_Ajax_View

