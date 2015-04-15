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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>

 */
class AclMgmt_Dset_Maintab_View extends LibViewMaintab
{/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

   /**
    * @var AclMgmt_Path_Model
    */
    public $model = null;

   /**
    * @var AclMgmt_Path_Ui
    */
    public $ui = null;

   /**
    * @var DomainNode
    */
    public $domainNode = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * add the table item
  * add the search field elements
  *
  * @param Entity $domainEntity
  * @param int $areaId
  * @param Context $params
  * @return boolean
  */
  public function displayListing($domainEntity, $areaId, $params)
  {

    // set the path to the template
    // the system search in all modules for the template
    // the tpl ending is assigned automatically
    $this->setTemplate('acl/mgmt/dset/maintab/main_dset_treetable', true);

    // fetch the entity object an push it in the view
    $this->addVar('entityObj', $domainEntity);

    // fetch the i18n text only one time
    $i18nText = $this->i18n->l(
      'Dataset Access for {@label@}',
      'wbf.label',
      array('label' => $this->domainNode->label.' '.$domainEntity->text())
    );

    // set browser title
    $this->setTitle($i18nText);
    // the label is displayed in the maintab as text
    $this->setLabel($i18nText);

    // set param values
    $params->viewType = 'maintab';

    $params->targetId = 'wgt-treetable-'.$this->domainNode->aclDomainKey.'-acl-dset';

    // set search form & action id
    $params->searchFormId = 'wgt-form-table-'.$this->domainNode->aclDomainKey.'-acl-dset-search';
    $params->searchFormAction = 'ajax.php?c=Acl.Mgmt_Dset.search&amp;objid='.$domainEntity.'&amp;dkey='.$this->domainNode->domainName;

    // fill the relevant data for the search form
    $params->injectSearchFormData($this);

    // create the form action & action id
    $params->formAction = 'index.php?c=Acl.Mgmt_Dset.update&amp;dkey='.$this->domainNode->domainName;
    $params->formId = 'wgt-form-'.$this->domainNode->aclDomainKey.'-acl-dset-update';
    // append form actions
    $this->setSaveFormData($params);

    // check graph type
    if (!$params->graphType)
      $params->graphType = 'spacetree';

    $this->addVar('graphType', $params->graphType);
    $this->addVar('domain', $this->domainNode);

    // create the form action
    $params->formActionAppend = 'ajax.php?c=Acl.Mgmt_Dset.appendUser&dkey='.$this->domainNode->domainName;
    $params->formIdAppend = 'wgt-form-'.$this->domainNode->aclDomainKey.'-acl-dset-append';

    // append form actions
    $this->setFormData($params->formActionAppend, $params->formIdAppend, $params, 'Append');

    // the tabid that is used in the template
    // this tabid has to be placed in the class attribute of all subtasks
    //$this->setTabId('wgt-tab-'.$this->domainNode->aclDomainKey.'-acl-dset');

    //add selectbox
    $selectboxGroups = new WgtSelectbox('selectboxGroups', $this);
    $selectboxGroups->setData($this->model->getGroups($areaId, $params));
    $selectboxGroups->addAttributes(array(
      'id' => 'wgt-input-'.$this->domainNode->aclDomainKey.'-acl-dset-id_group',
      'name' => 'group_users[id_group]',
      'class' => 'medium asgd-'.$params->formIdAppend
    ));

    // create the list element
    // create the ui helper object
    $ui = $this->loadUi('AclMgmt_Dset');

    // inject needed resources in the ui object
    $ui->setModel($this->model);
    $ui->domainNode = $this->domainNode;
    $ui->setView($this);

    $ui->createListItem(
      $this->model->searchQualifiedUsers($domainEntity, $areaId, $params),
      $domainEntity,
      $areaId,
      $params->access,
      $params
    );

    // inject the menu in the view object
    $this->createMenu($domainEntity, $params);

    return null;

  }//end public function displayGraph */

  /** inject the menu in the activ view object
   *
   *
   * @param EnterpriseEmployee_Entity $domainEntity
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function createMenu($domainEntity, $params)
  {

    $menu = $this->newMenu(
      $this->id.'_dropmenu',
      'AclMgmt_Dset'
      // $this->domainNode->domainAclMask.'_Dset'
    );
    $menu->domainNode = $this->domainNode;
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu($domainEntity, $params);

    $menu->addMenuLogic($this, $domainEntity, $params);

    return true;

  }//end public function createMenu */

} // end class AclMgmt_Dset_Maintab_View */

