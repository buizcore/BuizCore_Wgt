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
class BuizTag_Ajax_View extends LibViewAjax
{

  /**
   * @var BuizHistory_Model
   */
  public $model = null;

  /**
   * @param TFlag $params
   */
  public function displayOverlay($element, $dKey, $objid)
  {

    $item_Tags = new WgtElementTagCloud();
    $item_Tags->view = $this;
    $item_Tags->label = 'Tags';
    $item_Tags->width = 480;

    /* @var $tagModel BuizTag_Model  */
    $tagModel = $this->loadModel('BuizTag');
    $item_Tags->setData($tagModel->getDatasetTaglist($objid));
    $item_Tags->refId = $objid;
    //$item_Tags->access = $params->accessTags;
    $item_Tags->render();

    $this->setReturnData($item_Tags->render(), 'html');

  }//end public function displayOverlay */

}//end class BuizTag_Ajax_View

