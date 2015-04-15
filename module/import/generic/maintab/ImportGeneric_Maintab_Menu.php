<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
* @projectUrl  : http://buizcore.com
*
* @licence     : Conias
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/


/**
 * @package com.buizcore.conias
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class ImportGeneric_Maintab_Menu extends WgtDropmenu
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function buildMenu($params)
  {


    $entries = new TArray();
    //$entries->support = $this->entriesSupport($params);

    $this->content = <<<HTML

  <div class="wgt-panel-control" >
    <button
      class="wgt-button"
      onclick="\$R.get('ajax.php?c=Import.Generic.upload');"  ><i class="icon-certificate " ></i> Import</button>
  </div>


HTML;


  }//end public function buildMenu */




}//end class AdminBase_Maintab_Menu

