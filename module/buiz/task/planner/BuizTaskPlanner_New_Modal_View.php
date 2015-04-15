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
class BuizTaskPlanner_New_Modal_View extends LibViewModal
{

  /**
   * @var array
   */
  public $plan = null;

  /**
   * @var int
   */
  public $width = 880;

  /**
   * @var int
   */
  public $height = 600;

/*////////////////////////////////////////////////////////////////////////////*/
// form export methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param TFlag $params
  */
  public function displayForm($params)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      'Taskplanner',
      'wbf.label'
    );

    // set the window title
    $this->setTitle($i18nText);

    // set the window status text
    $this->setLabel($i18nText);

    // set the from template
    $this->setTemplate('buiz/task/planner/modal/plan_form_new', true);

    // kein fehler aufgetreten
    return null;

  }//end public function displayList */

}//end class BuizTaskPlanner_New_Modal_View

