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
class BuizTaskPlanner_Plan_Validator extends ValidStructure
{
  /*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param LibRequestHttp $request
   */
  public function check ($request)
  {
    
    // default values
    $jsonRule = new stdClass();
    $jsonRule->flags = new stdClass();
    $jsonRule->trigger_time = null;
    $jsonRule->flags->advanced = false;
    $jsonRule->flags->by_day = false;
    $jsonRule->flags->is_list = false;
    $jsonRule->months = [];
    $jsonRule->days = [];
    $jsonRule->hours = [];
    $jsonRule->minutes = [];
    $jsonRule->monthWeeks = [];
    $jsonRule->weekDays = [];
    $jsonRule->taskList = [];
    $jsonRule->type = 0;
    $jsonRule->status = 0;
    
    $now = time();
    
    $this->data['buiz_planned_task']['status'] = $request->data('task', Validator::BOOLEAN, 'status');
    
    $this->data['buiz_task_plan']['timestamp_start'] = null;
    $this->data['buiz_task_plan']['timestamp_end'] = null;
    
    $this->data['buiz_task_plan']['flag_series'] = $request->data('plan', Validator::BOOLEAN, 'flag-series');
    
    if ($this->data['buiz_task_plan']['flag_series']) {
      $this->data['buiz_task_plan']['timestamp_start'] = $request->data('plan', Validator::TIMESTAMP, 'timestamp_start');
      
      if (! $this->data['buiz_task_plan']['timestamp_start'])
        $this->data['buiz_task_plan']['timestamp_start'] = date('Y-m-d H:i:s', $now); // default start now
      

      $this->data['buiz_task_plan']['timestamp_end'] = $request->data('plan', Validator::TIMESTAMP, 'timestamp_end');
      
      if (! $this->data['buiz_task_plan']['timestamp_end'])
        $this->data['buiz_task_plan']['timestamp_end'] = date('Y-m-d H:i:s', mktime(0, 0, 0, 1, 1, 38)); // default end
      

      if ($this->data['buiz_task_plan']['timestamp_start']) {
        if ($now > strtotime($this->data['buiz_task_plan']['timestamp_start'])) {
          $this->data['buiz_task_plan']['timestamp_start'] = date("Y-m-d H:i:s");
          $this->addWarning("Start was in the past. That makes no sence. I've set start to now.");
        }
      }
      
      if ($this->data['buiz_task_plan']['timestamp_end']) {
        if ($now > strtotime($this->data['buiz_task_plan']['timestamp_end'])) {
          $this->addError("End was in the past. That makes no sence. Please fix that");
        }
      }
      
      $jsonRule->flags->advanced = $request->data('plan', Validator::BOOLEAN, 'flag-advanced');
      
      if ($jsonRule->flags->advanced) {
        $this->check_advanced($request, $jsonRule);
      } else {
        $jsonRule->type = $request->data('plan', Validator::INT, 'series_rule-id_type');
      }
    } else {
      
      $jsonRule->trigger_time = $request->data('plan', Validator::TIMESTAMP, 'series_rule-trigger_time');
    }
    
    $this->data['buiz_task_plan']['title'] = $request->data('plan', Validator::TEXT, 'title') ?  : $this->addError('Missing Title');
    
    $this->data['buiz_task_plan']['id_user'] = $request->data('plan', Validator::INT, 'id_user');
    if (! $this->data['buiz_task_plan']['id_user']) {
      $orm = $this->env->getOrm();
      $this->data['buiz_task_plan']['id_user'] = $orm->getId('BuizRoleUser', " name='system' ");
    }
    
    $this->data['buiz_task_plan']['description'] = $request->data('plan', Validator::TEXT, 'description');
    $this->data['buiz_task_plan']['actions'] = $request->data('plan', Validator::JSON, 'actions');
    $this->data['buiz_task_plan']['series_rule'] = json_encode($jsonRule);
  } //end public function check */

  
  /**
   * @param LibRequestHttp $request
   * @param TJsonObject $jsonRule
   */
  public function check_advanced ($request, $jsonRule)
  {

    $jsonRule->flags->is_list = $request->data('plan', Validator::BOOLEAN, 'flag-is_list');
    
    if ($jsonRule->flags->is_list) {
      $jsonRule->taskList = $request->data('plan', Validator::TIMESTAMP, 'series_rule-taskp_list');
    } else {
      $jsonRule->flags->by_day = $request->data('plan', Validator::BOOLEAN, 'flag-by_day');
      
      $jsonRule->months = $request->data('plan', Validator::CNAME, 'series_rule-months');
      $jsonRule->hours = $request->data('plan', Validator::BOOLEAN, 'series_rule-hours');
      $jsonRule->minutes = $request->data('plan', Validator::BOOLEAN, 'series_rule-minutes');
      
      if ($jsonRule->flags->by_day) {
        $jsonRule->monthWeeks = $request->data('plan', Validator::INT, 'series_rule-month_weeks');
        $jsonRule->weekDays = $request->data('plan', Validator::CNAME, 'series_rule-week_days');
      } else {
        $jsonRule->days = $request->data('plan', Validator::INT, 'series_rule-days');
      }
    }
  } //end public function check_advanced */
}//end class BuizTaskPlanner_Plan_Validator */