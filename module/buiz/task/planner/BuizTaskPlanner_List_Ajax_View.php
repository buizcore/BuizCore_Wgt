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
class BuizTaskPlanner_List_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var BuizTaskPlanner_Model
   */
  public $model = null;

  /**
   * @var WgtSimpleListmenu
   */
  public $listMenu = null;

  /**
   * @var array
   */
  public $plans = [];

  /**
   * @var array
   */
  public $plan = [];

/*////////////////////////////////////////////////////////////////////////////*/
// form export methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param TFlag $params
  */
  public function displayAdd($id, $params)
  {

    $this->plan = $this->model->getPlans('plan.rowid='.$id)->get();
    $this->listMenu = new BuizTaskPlanner_List_Menu($this);

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'table#wgt-grid-taskplanner-table>tbody';
    $pageFragment->action = 'prepend';

    $pageFragment->setContent
    (
      $this->includeContentTemplate('buiz/task/planner/maintab/plan_list_entry', true)
    );

    $this->setArea('le', $pageFragment);

    //.grid('incEntries')

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-taskplanner-table').grid('renderRowLayout');

WGTJS;

    $this->addJsCode($jsCode);


  }//end public function displayList */

 /**
  * @param TFlag $params
  */
  public function displayUpdate($id, $params)
  {

    $this->plan = $this->model->getPlans('plan.rowid='.$id)->get();
    $this->listMenu = new BuizTaskPlanner_List_Menu($this);

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-table-taskplanner-'.$id;
    $pageFragment->action = 'replace';

    $pageFragment->setContent
    (
      $this->includeContentTemplate('buiz/task/planner/maintab/plan_list_entry', true)
    );

    $this->setArea('le', $pageFragment);


    //.grid('incEntries')

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-taskplanner-table').grid('renderRowLayout');

WGTJS;

    $this->addJsCode($jsCode);


  }//end public function displayUpdate */

 /**
  * @param TFlag $params
  */
  public function displayDelete($id, $params)
  {

    $this->plan = $this->model->getPlans('plan.rowid='.$id)->get();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-table-taskplanner-'.$id;
    $pageFragment->action = 'remove';

    $this->setArea('le', $pageFragment);


    //.grid('incEntries')

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-taskplanner-table').grid('renderRowLayout');

WGTJS;

    $this->addJsCode($jsCode);

  }//end public function displayUpdate */

}//end class BuizTaskPlanner_List_Ajax_View

