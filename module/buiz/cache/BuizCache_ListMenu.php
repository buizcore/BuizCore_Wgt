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
class BuizCache_ListMenu
{

  /**
   * @param array $cDir
   */
  public function renderDisplay($cDir)
  {

    $code = [];

    if (isset($cDir->display)) {
      foreach ($cDir->display as $action) {
        switch ($action) {
          case 'created': {
            $code[] = "Updated: ".SFilesystem::timeChanged(PATH_GW.'cache/'.$cDir->dir);
            break;
          }
          case 'size': {
            $code[] = "Size: ".SFilesystem::getFolderSize(PATH_GW.'cache/'.$cDir->dir);
            break;
          }
          case 'num_files': {
            $code[] = "Files: ".SFilesystem::countFiles(PATH_GW.'cache/'.$cDir->dir);
            break;
          }
        }
      }
    }

    return implode('<br />', $code);
  }

  /**
   * @param array $cDir
   */
  public function renderActions($cDir)
  {

    $code = [];

    if (isset($cDir->actions)) {
      foreach ($cDir->actions as $action) {
        switch ($action->type) {
          case 'request': {
            $code[] = <<<CODE

<button
  class="wgt-button"
  onclick="\$R.{$action->method}('{$action->service}');" >{$action->label}</button>

CODE;
            break;
          }
        }
      }
    }

    return implode('<br />', $code);

  }//end public renderActions */

}//end class BuizCache_ListMenu

