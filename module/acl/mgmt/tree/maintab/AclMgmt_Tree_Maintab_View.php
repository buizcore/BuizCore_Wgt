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
class AclMgmt_Tree_Maintab_View extends LibViewMaintab
{/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

   /**
    * @var AclMgmt_Tree_Model
    */
    public $model = null;

   /**
    * @var AclMgmt_Tree_Ui
    */
    public $ui = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * add the table item
  * add the search field elements
  *
  * @param TFlag $params
  * @return boolean
  */
  public function displayGraph($groupId, $params)
  {

    // set the path to the template
    // the system search in all modules for the template
    // the tpl ending is assigned automatically
    $this->setTemplate('acl/mgmt/tree/maintab/acl_tree', true);


    // fetch the i18n text only one time
    $i18nText = $this->i18n->l
    (
      'Access Inheritance for {@label@}',
      'wbf.label',
      array('label' => $this->model->domainNode->pLabel)
    );

    // set browser title
    $this->setTitle($i18nText);
    // the label is displayed in the maintab as text
    $this->setLabel($i18nText);

    $params->viewType = 'maintab';

    // the tabid that is used in the template
    // this tabid has to be placed in the class attribute of all subtasks

    $areaId = $this->model->getAreaId($this->model->domainNode->aclBaseKey);

    $this->addVar('params', $params);
    $this->addVar('treeData', $this->model->getReferences($areaId, $groupId, $params));
    $this->addVar('groups', $this->model->getAreaGroups($areaId, $groupId, $params));


    $this->addVar('areaId', $areaId);
    $this->addVar('groupId', $groupId);
    $this->addVar('group', $this->model->getGroup($groupId));

    $this->addVar('domain', $this->model->domainNode);


    // create form elements
    $selectAccess = new AclMgmt_Selectbox_Access('inputAccess', $this);
    $selectAccess->addAttributes(array(
      'id' => 'wgt-input-'.$this->model->domainNode->aclDomainKey.'-acl-path-access_level',
      'class' => 'medium',
      'name' => 'security_path[access_level]',
    ));


    // inject the menu in the view object
    $this->createMenu($areaId, $params);

    return null;

  }//end public function displayGraph */

  /** inject the menu in the activ view object
   *
   *
   * @param int $objid
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function createMenu($objid, $params)
  {

    $menu = $this->newMenu
    (
      $this->id.'_dropmenu',
      $this->model->domainNode->domainAclMask.'_Path'
    );

    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu($objid, $params);

    $menu->addMenuLogic($this, $objid, $params);

    return true;

  }//end public function createMenu */

} // end class AclMgmt_Tree_Maintab_View */

