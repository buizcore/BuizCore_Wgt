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
class BuizProtocol_Ajax_View extends LibViewAjax
{

  /**
   * @var BuizProtocol_Model
   */
  public $model = null;

  /**
   * @param TFlag $params
   */
  public function displayOverlay($dKey, $objid)
  {

    $history = new WgtElementProtocol();
    $history->view = $this;

    $history->setData($this->model->loadDsetProtocol($dKey, $objid)) ;

    $this->setReturnData
    (
      '<div class="wgt-scroll-y" style="max-height:600px;margin-top:-5px;" >'.$history->render().'</div>',
      'html'
    );

  }//end public function displayOverlay */

}//end class BuizHistory_Ajax_View

