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
class BuizTaskPlanner_TaskList_Modal_View extends LibViewModal
{

  /**
   * @var array
   */
  public $plan = null;

  /**
   * @var int
   */
  public $width = 850;

  /**
   * @var int
   */
  public $height = 600;

/*////////////////////////////////////////////////////////////////////////////*/
// form export methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param int $objid
  * @param TFlag $params
  */
  public function displayListing($objid, $params)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      'Tasks',
      'wbf.label'
    );

    // set the window title
    $this->setTitle($i18nText);

    // set the window status text
    $this->setLabel($i18nText);

    $this->tasks = $this->model->getPlanTasks($objid);

    // set the from template
    $this->setTemplate('buiz/task/planner/modal/plan_task_list', true);

    // kein fehler aufgetreten
    return null;

  }//end public function displayListing */

}//end class BuizTaskPlanner_TaskList_Modal_View

