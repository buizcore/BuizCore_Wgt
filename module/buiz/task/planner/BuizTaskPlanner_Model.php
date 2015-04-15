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
class BuizTaskPlanner_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/
  
  /**
	 *
	 * @var stdClass
	 */
  public $schedule = null;

  /**
	 *
	 * @var array
	 */
  public $monthMap = array(
      
      'jan' => 1, 
      'feb' => 2, 
      'mar' => 3, 
      'apr' => 4, 
      'may' => 5, 
      'jun' => 6, 
      'jul' => 7, 
      'aug' => 8, 
      'sep' => 9, 
      'oct' => 10, 
      'nov' => 11, 
      'dec' => 12
  );

  /**
	 *
	 * @var array
	 */
  public $dayMap = array(
      
      'mo' => 1, 
      'tu' => 2, 
      'we' => 3, 
      'th' => 4, 
      'fr' => 5, 
      'sa' => 6, 
      'su' => 0
  );


/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

	/**
	 *
	 * @return LibDbPostgresqlResult
	 */
  public function getPlans ($where = null)
  {

    $db = $this->getDb();
    
    $sqlWhere = '';
    if ($where) {
      $sqlWhere = <<<SQL
  WHERE {$where}
SQL;
    }
    
    $sql = <<<SQL
  SELECT
    plan.rowid as id,
    plan.title,
    plan.flag_series,
    plan.timestamp_start,
    plan.timestamp_end,
    plan.series_rule,
    plan.actions,
    plan.description,
    task.status,
    userrole.fullname
  FROM
    buiz_task_plan plan
  JOIN
    buiz_planned_task task
      ON plan.rowid = task.vid
  LEFT JOIN
    view_person_role userrole
      ON userrole.buiz_role_user_rowid = plan.id_user
{$sqlWhere}
  ORDER BY
    plan.timestamp_start;

SQL;
      
    return $db->select($sql);
  } // end public function getPlans */
  
  /**
	 *
	 * @param int $objid        	
	 * @return BuizTaskPlan_Entity
	 */
  public function getPlan ($objid)
  {

    $orm = $this->getOrm();
    
    return $orm->get('BuizTaskPlan', $objid);
  } // end public function getPlan */
  
  /**
   *
   * @param int $objid
   * @return BuizTaskPlan_Entity
   */
  public function getTask ($objid)
  {

    $orm = $this->getOrm();
    
    return $orm->getWhere('BuizPlannedTask', "vid=" . $objid);
  }
  
  /**
   *
   * @param int $objid
   * @return array
   */
  public function getTaskAction($objid) {
     
     $db = $this->getDb();
      
     $sql = <<<SQL
SELECT
  plan.rowid as plan_id,
  plan.actions as plan_actions,
  task.rowid as task_id,
  task.actions as task_actions
     
FROM
  buiz_task_plan as plan
     
JOIN
  buiz_planned_task task
    ON plan.rowid = task.vid
WHERE
		plan.rowid = {$objid}
SQL;
     
     return $db->select($sql)->get();
     
  }

  /**
	 *
	 * @param BuizTaskPlanner_Plan_Validator $data        	
	 * @return BuizTaskPlan_Entity
	 */
  public function insertPlan ($data)
  {

    $orm = $this->getOrm();
    
    $planObj = $orm->insert('BuizTaskPlan', $data->getData('buiz_task_plan'));
    
    $id = $planObj->getId();
    
    $this->schedule = json_decode($planObj->series_rule);
    
    Debug::dumpFile('plan-obj', $planObj, true);
    Debug::dumpFile('schedule-type', $this->schedule, true);
    
    if ($this->schedule->flags->is_list) {
      $this->createTaskList($id, $planObj, $this->schedule);
    } elseif ($this->schedule->flags->by_day) {
      $this->createTasksByNamedDays($id, $planObj, $this->schedule);
    } elseif ($planObj->flag_series) {
      if ($this->schedule->flags->advanced) {
        $this->createTasksByDayNumber($id, $planObj, $this->schedule);
      } else {
        $this->createTasksByType($id, $planObj, $this->schedule);
      }
    } else {
      $this->createCustomTask($id, $this->schedule->trigger_time, $planObj, $this->schedule);
    }
    
    return $planObj;
  } // end public function insertPlan */

  
  /**
	 *
	 * @param BuizTaskPlanner_Plan_Validator $data        	
	 * @return BuizTaskPlan_Entity
	 */
  public function updatePlan ($id, $data)
  {

    $orm = $this->getOrm();
    $task = $this->getTask($id);
    
    // Entity BuizTaskPlan
    $planObj = $orm->update('BuizTaskPlan', $id, $data->getData('buiz_task_plan'));
    
    $task = $this->getTask($id);
    
    $this->cleanTasks($id);
    
    $this->schedule = json_decode($planObj->series_rule);
    
    Debug::dumpFile('plan-obj', $planObj, true);
    Debug::dumpFile('schedule-type', $this->schedule, true);
    
    // True wenn die Checkbox angehakt wurde
    $isTaskSetActive = $data->getData('buiz_planned_task', 'status');
    
    if ($task->status == ETaskStatus::OPEN || $task->status == ETaskStatus::DISABLED) {
      if ($isTaskSetActive) {
        $this->schedule->status = ETaskStatus::OPEN;
      } else {
        $this->schedule->status = ETaskStatus::DISABLED;
      }
    }
    
    if ($this->schedule->flags->is_list) {
      $this->createTaskList($id, $planObj, $this->schedule);
    } elseif ($this->schedule->flags->by_day) {
      $this->createTasksByNamedDays($id, $planObj, $this->schedule);
    } elseif ($planObj->flag_series) {
      if ($this->schedule->flags->advanced) {
        $this->createTasksByDayNumber($id, $planObj, $this->schedule);
      } else {
        $this->createTasksByType($id, $planObj, $this->schedule);
      }
    } else {
      $this->createCustomTask($id, $this->schedule->trigger_time, $planObj, $this->schedule);
    }
    
    return $planObj;
  } // end public function updatePlan */

  
  /**
	 *
	 * @param int $id        	
	 */
  protected function cleanTasks ($id)
  {
    // nur tasks löschen die nicht schon ausgeführt wurden
    // Johannes: Tasks können großzügig gelöscht werden und aus dem schedule Objekt wiedergestellt werden
    $orm = $this->getOrm();
    
    $orm->deleteWhere('BuizPlannedTask', "vid=" . $id);
  } // end protected function cleanTasks */

  
  /**
	 *
	 * @param int $planId        	
	 * @param BuizTaskPlanner_Plan_Validator $data        	
	 * @param json:stdClass $schedule        	
	 */
  protected function createTaskList ($planId, $data, $schedule)
  {

  } // end protected function createTaskList */

  
  /**
	 *
	 * @param int $planId        	
	 * @param BuizPlannedTask_Entity $data        	
	 * @param json:stdClass $schedule        	
	 */
  protected function createTasksByNamedDays ($planId, $data, $schedule)
  {

    $endTime = strtotime($data->timestamp_end);
    $startTime = strtotime($data->timestamp_start);
    
    $tmp = explode(',', date('Y,m,d,H,i', $startTime));
    $start['y'] = $tmp[0];
    $start['m'] = $tmp[1];
    $start['d'] = $tmp[2];
    $start['h'] = $tmp[3];
    $start['i'] = $tmp[4];
    $tmp = explode(',', date('Y,m,d,H,i', $endTime));
    $end['y'] = $tmp[0];
    $end['m'] = $tmp[1];
    $end['d'] = $tmp[2];
    $end['h'] = $tmp[3];
    $end['i'] = $tmp[4];
    
    // calc years
    if ($start['y'] !== $end['y'])
      $years = range($start['y'], $end['y'], 1);
    else
      $years = array(
          
          $start['y']
      );
      
      // calc years
    $months = [];
    
    foreach ($schedule->months as $month => $active) {
      if ($active)
        $months[] = (int)$this->monthMap[$month];
    }
    if (! $months)
      $months = range(1, 12, 1);
      
      // weeks
    $weeks = [];
    foreach ($schedule->monthWeeks as $week => $active) {
      if ($active)
        $weeks[] = (int)$week;
    }
    if (! $weeks)
      $weeks = range(1, 4, 1);
      
      // days
    $days = [];
    foreach ($schedule->weekDays as $day => $active) {
      if ($active)
        $days[] = (int)$this->dayMap[$day];
    }
    if (! $days)
      $days = range(1, 7, 1);
      
      // hours
    $hours = [];
    foreach ($schedule->hours as $hour => $active) {
      if ($active)
        $hours[] = $hour;
    }
    if (! $hours)
      $hours = array(
          
          23
      );
      
      // minutes
    $minutes = [];
    foreach ($schedule->minutes as $minute => $active) {
      if ($active)
        $minutes[] = $minute;
    }
    if (! $minutes)
      $minutes = array(
          
          59
      );
    
    foreach ($years as $year) {
      foreach ($months as $month) {
        
        $monthDays = SDate::getFilteredMonthDays($year, $month, $days, $weeks);
        
        foreach ($monthDays as $day) {
          foreach ($hours as $hour) {
            foreach ($minutes as $minute) {
              
              $taskTime = mktime($hour, $minute, 0, $month, $day, $year);
              
              // check the borders
              if ($taskTime < $startTime)
                continue;
              
              if ($taskTime > $endTime)
                continue;
              
              $this->createCustomTask($planId, date('Y-m-d H:i:s', mktime($hour, $minute, 0, $month, $day, $year)), $data, $schedule);
            } // min
          } // hour
        } // day
      } // month
    } // year
  } // end protected function createTasksByNamedDays */

  
  /**
	 *
	 * @param int $planId        	
	 * @param BuizTaskPlanner_Plan_Validator $data        	
	 * @param json:stdClass $schedule        	
	 */
  protected function createTasksByDayNumber ($planId, $data, $schedule)
  {

    $endTime = strtotime($data->timestamp_end);
    $startTime = strtotime($data->timestamp_start);
    
    $tmp = explode(',', date('Y,m,d,H,i', $startTime));
    $start['y'] = $tmp[0];
    $start['m'] = $tmp[1];
    $start['d'] = $tmp[2];
    $start['h'] = $tmp[3];
    $start['i'] = $tmp[4];
    $tmp = explode(',', date('Y,m,d,H,i', $endTime));
    $end['y'] = $tmp[0];
    $end['m'] = $tmp[1];
    $end['d'] = $tmp[2];
    $end['h'] = $tmp[3];
    $end['i'] = $tmp[4];
    
    // calc years
    if ($start['y'] !== $end['y'])
      $years = range($start['y'], $end['y'], 1);
    else
      $years = array(
          
          $start['y']
      );
      
      // calc months
    $months = [];
    
    foreach ($schedule->months as $month => $active) {
      if ($active)
        $months[] = (int)$this->monthMap[$month];
    }
    if (! $months)
      $months = range(1, 12, 1);
      
      // days
    $days = [];
    foreach ($schedule->days as $day => $active) {
      if ($active)
        $days[] = $day;
    }
    if (! $days)
      $days = range(1, 31, 1);
      
      // hours
    $hours = [];
    foreach ($schedule->hours as $hour => $active) {
      if ($active)
        $hours[] = $hour;
    }
    if (! $hours)
      $hours = array(
          
          23
      );
      
      // minutes
    $minutes = [];
    foreach ($schedule->minutes as $minute => $active) {
      if ($active)
        $minutes[] = $minute;
    }
    if (! $minutes)
      $minutes = array(
          
          59
      );
    
    foreach ($years as $year) {
      foreach ($months as $month) {
        
        $numMonthDays = SDate::getMonthDays($year, $month);
        
        foreach ($days as $day) {
          
          if ($day > $numMonthDays)
            continue;
          
          foreach ($hours as $hour) {
            foreach ($minutes as $minute) {
              
              $taskTime = mktime($hour, $minute, 0, $month, $day, $year);
              
              // check the borders
              if ($taskTime < $startTime)
                continue;
              
              if ($taskTime > $endTime)
                continue;
              
              $this->createCustomTask($planId, date('Y-m-d H:i:s', mktime($hour, $minute, 0, $month, $day, $year)), $data, $schedule);
            } // min
          } // hour
        } // day
      } // month
    } // year
  } // end protected function createTasksByDayNumber */

  
  /**
	 *
	 * @param int $planId        	
	 * @param BuizTaskPlanner_Plan_Validator $data        	
	 * @param json:stdClass $schedule        	
	 */
  protected function createTasksByType ($planId, $data, $schedule)
  {

    $orm = $this->getOrm();
    
    $task = $orm->newEntity('BuizPlannedTask');
    $task->vid = $planId;
    // $task->actions = $data->actions;
    // $task->status = ETaskStatus::OPEN;
    $task->status = $schedule->status;
    $task->type = $schedule->type;
    
    Debug::dumpFile('schedule-type', $schedule, true);
    
    $orm->insert($task);
  } // end protected function createTasksByType */

  
  /**
	 *
	 * @param int $planId        	
	 * @param BuizTaskPlanner_Plan_Validator $data        	
	 * @param json:stdClass $schedule        	
	 */
  protected function createCustomTask ($planId, $time, $data, $schedule)
  {

    $orm = $this->getOrm();
    
    $task = $orm->newEntity('BuizPlannedTask');
    $task->vid = $planId;
    $task->task_time = $time;
    // $task->actions = $data->actions;
    // $task->status = ETaskStatus::OPEN;
    $task->status = $schedule->status;
    $task->type = ETaskType::CUSTOM;
    
    $orm->insert($task);
  } // end protected function createCustomTask */

  
  /**
	 *
	 * @param BuizTaskPlanner_Plan_Validator $data        	
	 * @return BuizTaskPlan_Entity
	 */
  public function deletePlan ($id)
  {

    $orm = $this->getOrm();
    
    // Das kann ohne weiteres gelöscht werden
    $orm->delete('BuizTaskPlan', $id);
    
    $db = $this->getDb();
    
    $status = ETaskStatus::DELETED;
    
    // Das löschen einzelner Tasks könnte auch elegant über den ORM passieren, bei Serien nicht!
    $sql = <<<SQL
    UPDATE buiz_planned_task
    SET status = {$status}
    WHERE vid = {$id};
SQL;
    
    $db->update($sql);
  } // end public function delete */

  

/*////////////////////////////////////////////////////////////////////////////*/
// Plan Type
/*////////////////////////////////////////////////////////////////////////////*/

  public function getPlanType ()
  {

    return array(
        
        array(
            
            "id" => "minuten", 
            "value" => "Every Minute"
        )
    );
  }
}//end class Buiz_TaskPlanner_Model */