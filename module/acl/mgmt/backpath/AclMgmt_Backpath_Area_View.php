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
class AclMgmt_Backpath_Area_View extends LibTemplateAreaView
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var DomainNode
   */
  public $domainNode = null;

  /**
   * @var AclMgmt_Backpath_Model
   */
  public $model = null;

/*////////////////////////////////////////////////////////////////////////////*/
// display methodes
/*////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * display the Quallified users tab
   *
   * @param int $areaId
   * @param TFlag $params
   *
   * @return boolean
   */
  public function displayTab($areaId, $params)
  {
  
    // create the form action
    $params->searchFormAction = 'index.php?c=Acl.Mgmt_Backpath.search&dkey='
        .$this->domainNode->domainName.'&area_id='.$areaId;
  
    // add the id to the form
    $params->searchFormId = 'wgt-form-table-'.$this->domainNode->aclDomainKey.'-acl-backpath-search';
  
    // fill the relevant data for the search form
    $params->injectSearchFormData($this);
  
    // add the id to the form
    $params->formId = 'wgt-form-'.$this->domainNode->aclDomainKey.'-acl-update';
      
    // create the form action
    $params->formActionCrud = 'ajax.php?c=Acl.Mgmt_Backpath.save&dkey='.$this->domainNode->domainName;
    $params->formIdCrud = 'wgt-form-'.$this->domainNode->aclDomainKey.'-backpath-crud';
  
    // append form actions
    $this->setFormData($params->formActionCrud, $params->formIdCrud, $params, 'Crud');
  
    // set the path to the template
    $this->setTemplate('acl/mgmt/backpath/tab_backpath', true);
  
    $this->addVar('areaId', $areaId);
    $this->addVar('domain', $this->domainNode);
  
    // create the ui helper object
    /* @var $ui AclMgmt_Backpath_Ui */
    $ui = $this->loadUi('AclMgmt_Backpath');
  
    // inject needed resources in the ui object
    $ui->setModel($this->model);
    $ui->setView($this);
    $ui->domainNode = $this->domainNode;
    
    $ui->createListItem(
      $this->model->search($areaId, $params->access, $params),
      $areaId,
      $params->access,
      $params
    );
    
  
  }//end public function displayTab */
  
  /**
   * display the Quallified users tab
   *
   * @param int $areaId
   * @param TFlag $params
   *
   * @return boolean
   */
  public function displayEditForm($areaId, $params)
  {

  
    // add the id to the form
    $params->formId = 'wgt-form-'.$this->domainNode->aclDomainKey.'-acl-update';
  
    // create the form action
    $params->formActionCrud = 'ajax.php?c=Acl.Mgmt_Backpath.save&dkey='.$this->domainNode->domainName;
    $params->formIdCrud = 'wgt-form-'.$this->domainNode->aclDomainKey.'-backpath-crud';
  
    // append form actions
    $this->setFormData($params->formActionCrud, $params->formIdCrud, $params, 'Crud');
  
    // set the path to the template
    $this->setTemplate('acl/mgmt/backpath/area_crud_form', true);
  
    $this->addVar('areaId', $areaId);
    $this->addVar('domain', $this->domainNode);
    
    $this->addVar('entity', $this->model->getEntityBuizSecurityBackpath());
  
  
  
  }//end public function displayTab */


} // end class AclMgmt_Backpath_Area_View */

