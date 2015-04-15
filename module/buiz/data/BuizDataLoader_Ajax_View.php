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
class BuizDataLoader_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param string $key the search key from the autocomplete field
   * @param TArray $context useriput / control flags
   *
   * @return void
   */
  public function displayEntityAutocomplete($key, $context)
  {

    $view = $this->getTplEngine();
    $view->setRawJsonData($this->model->getEntityByKey($key, $context));

    return null;

  }//end public function displayEntityAutocomplete */

} // end class BuizData_Loader_Ajax_View */

