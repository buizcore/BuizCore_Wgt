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
class BuizContact_List_SubPanel_Filter extends WgtPanelElementFilter
{
/*////////////////////////////////////////////////////////////////////////////*/
// Render Methode
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function render()
  {

    $i18n = $this->getI18n();
    $acl = $this->getAcl();
    $user = $this->getUser();
    $access = $this->access;

    $controlsMsg = '';
    $controlsTask = '';
    $hiddenControls = '';

    // Message filters

    // new
    ++$this->numFilter;
    $checkedNew = '';
    if ($this->filterStatus->status->new) {
      $checkedNew = 'checked="checked"';
      ++$this->numFilterActive;
    }

    $controlsMsg .= <<<HTML
        <li><input
          type="checkbox"
          name="status[new]"
          {$checkedNew}
          class="fparam-wgt-form-buiz-groupware-search"  /> New Posts</li>
HTML;

    // important
    ++$this->numFilter;
    $checkedImportant = '';
    if ($this->filterStatus->status->important) {
      $checkedImportant = 'checked="checked"';
      ++$this->numFilterActive;
    }

    $controlsMsg .= <<<HTML
        <li><input
          type="checkbox"
          name="status[important]"
          {$checkedImportant}
          class="fparam-wgt-form-buiz-groupware-search" /> Important Posts</li>
HTML;

    // urgent
    ++$this->numFilter;
    $checkedUrgent = '';
    if ($this->filterStatus->status->urgent) {
      $checkedUrgent = 'checked="checked"';
      ++$this->numFilterActive;
    }

    $controlsMsg .= <<<HTML
    <li><input
      type="checkbox"
      name="status[urgent]"
      {$checkedUrgent}
      class="fparam-wgt-form-buiz-groupware-search" /> Urgent Posts</li>
HTML;

    // overdue

    ++$this->numFilter;
    $checkedOverdue = '';
    if ($this->filterStatus->status->overdue) {
      $checkedOverdue = 'checked="checked"';
      ++$this->numFilterActive;
    }

    $controlsMsg .= <<<HTML
      <li><input
        type="checkbox"
        name="status[overdue]"
        {$checkedOverdue}
        class="fparam-wgt-form-buiz-groupware-search" /> Overdue Posts</li>
HTML;

    /////////////////////////////////
    // Tasks

    // overdue

    ++$this->numFilter;
    $checkedAll = '';
    if ( 1 == $this->filterStatus->taskStatus) {
      $checkedAll = 'checked="checked"';
      ++$this->numFilterActive;
    }
    $checkedOpen = '';
    if ( 2 == $this->filterStatus->taskStatus) {
      $checkedOpen = 'checked="checked"';
      ++$this->numFilterActive;
    }
    $checkedCompleted = '';
    if ( 3 == $this->filterStatus->taskStatus) {
      $checkedCompleted = 'checked="checked"';
      ++$this->numFilterActive;
    }

    $controlsTask .= <<<HTML
	<li><input
    type="radio"
    name="task_status"
    value="1"
    {$checkedAll}
    class="fparam-wgt-form-buiz-groupware-search"
     /> All</li>
  <li><input
    type="radio"
    name="task_status"
    value="2"
    {$checkedOpen}
    class="fparam-wgt-form-buiz-groupware-search"
     /> Open</li>
  <li><input
    type="radio"
    name="task_status"
    value="3"
    {$checkedCompleted}
    class="fparam-wgt-form-buiz-groupware-search"
     /> Completed</li>
HTML;


    // required

    ++$this->numFilter;
    $checkedRequired = '';
    if ($this->filterStatus->taskAction->required) {
      $checkedRequired = 'checked="checked"';
      ++$this->numFilterActive;
    }

    $controlsTask .= <<<HTML
    <li><input
      type="checkbox"
      name="task_action[required]"
      {$checkedRequired}
      class="fparam-wgt-form-buiz-groupware-search"
      /> Action Required</li>
HTML;


    // required

    ++$this->numFilter;
    $checkedWaiting = '';
    if ($this->filterStatus->taskAction->waiting) {
      $checkedWaiting = 'checked="checked"';
      ++$this->numFilterActive;
    }

    $controlsTask .= <<<HTML
  <li><input
    type="checkbox"
    name="task_action[waiting]"
    {$checkedWaiting}
    class="fparam-wgt-form-buiz-groupware-search"
    /> Waiting for Action</li>
HTML;


    $html = '';
    if ('' != $controlsMsg) {

      $html = <<<CODE

	<div class="left half" >
		<label>Message</label>
  	<ul class="wgt-tree" >
{$controlsMsg}
    </ul>
  </div>

	<div class="inline half" >
		<label>Tasks</label>
  	<ul class="wgt-tree" >
{$controlsTask}
    </ul>
	</div>

CODE;

    }


    $html .= $hiddenControls;

    return $html;

  }//end public function render */

} // end class BuizContact_SubPanel_Filter */

