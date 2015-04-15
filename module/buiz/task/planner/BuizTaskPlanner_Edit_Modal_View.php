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
class BuizTaskPlanner_Edit_Modal_View extends LibViewModal
{

  /**
   * @var array BuizTaskPlan_Entity
   */
  public $plan = null;

  /**
   * 
   * @var array BuizPlannedTask_Entity
   */
  public $task = null;

  /**
   * @var array
   */
  public $schedule = null;

  public $width = 850;

  public $height = 600;
  
  /*////////////////////////////////////////////////////////////////////////////*/
// form export methodes
/*////////////////////////////////////////////////////////////////////////////*/
  
  /**
  * @param TFlag $params
  */
  public function displayForm ($objid, $params)
  {
    
    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l('Taskplanner', 'wbf.label');
    
    // set the window title
    $this->setTitle($i18nText);
    
    // set the window status text
    $this->setLabel($i18nText);
    
    $this->plan = $this->model->getPlan($objid);
    $this->task = $this->model->getTask($objid);
    $this->schedule = json_decode($this->plan->series_rule);
    
    // set the from template
    $this->setTemplate('buiz/task/planner/modal/plan_form_edit', true);
    
    // kein fehler aufgetreten
    return null;
  } //end public function displayList */
}//end class BuizTaskPlanner_Edit_Maintab_View
