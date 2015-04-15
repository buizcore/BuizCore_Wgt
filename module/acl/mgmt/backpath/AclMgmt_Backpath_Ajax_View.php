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
class AclMgmt_Backpath_Ajax_View extends LibViewAjax
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
   * search pushes a rendered listing element body to the client, that replaces
   * the existing body
   *
   * @param int $areaId the rowid of the activ area
   * @param TArray $context control flags
   */
  public function displaySearch($areaId, $context)
  {
  
    /* @var $ui AclMgmt_Backpath_Ui */
    $ui = $this->tplEngine->loadUi('AclMgmt_Backpath');
    $ui->domainNode = $this->domainNode;
    $ui->setModel($this->model);
    $ui->setView($this->getView());
  
    // ok it's definitly an ajax request
    $context->ajax = true;
  
    $ui->createListItem(
      $this->model->search($areaId, $context->access, $context),
      $areaId,
      $context->access,
      $context
    );
  
    return null;
  
  }//end public function displaySearch */

  /**
   * append a new user in relation to an area / entity to a group
   *
   * on connect the server pushes a new table row via ajax area to the client
   * the ajax area appends automatically at the end of the listing element body
   *
   * @param BuizAreaAssignment_Entity $eAssignment
   * @param TArray $context useriput / control flags
   */
  public function displayInsert($eAssignment, $context)
  {

    /* @var $ui AclMgmt_Backpath_Ui */
    $ui = $this->tplEngine->loadUi('AclMgmt_Backpath');
    $ui->domainNode = $this->domainNode;
    $ui->setModel($this->model);
    $ui->setView($this->getView());

    $areaKeys = $this->model->getAreaId();
    
    // ok it's definitly an ajax request
    $context->ajax = true;

    $ui->addListEntry(
      $this->model->searchById($areaKeys, $eAssignment->getId(), $context->access, $context),
      $context->areaId,
      $context->access,
      $context,
      true
    );

    return null;

  }//end public function displayInsert */
  
  /**
   * append a new user in relation to an area / entity to a group
   *
   * on connect the server pushes a new table row via ajax area to the client
   * the ajax area appends automatically at the end of the listing element body
   *
   * @param BuizAreaAssignment_Entity $eAssignment
   * @param TArray $context useriput / control flags
   */
  public function displayUpdate($eAssignment, $context)
  {
    
    /* @var $ui AclMgmt_Backpath_Ui */
    $ui = $this->tplEngine->loadUi('AclMgmt_Backpath');
    $ui->domainNode = $this->domainNode;
    $ui->setModel($this->model);
    $ui->setView($this->getView());

    $areaKeys = $this->model->getAreaId();
    
    // ok it's definitly an ajax request
    $context->ajax = true;

    $ui->addListEntry(
      $this->model->searchById($areaKeys, $eAssignment->getId(), $context->access, $context),
      $context->areaId,
      $context->access,
      $context,
      false
    );

    return null;
  
  }//end public function displayUpdate */
  
  /**
   * append a new user in relation to an area / entity to a group
   *
   * on connect the server pushes a new table row via ajax area to the client
   * the ajax area appends automatically at the end of the listing element body
   *
   * @param BuizAreaAssignment_Entity $eAssignment
   * @param TArray $context useriput / control flags
   */
  public function displayDelete($delId, $context)
  {
  
    $rowId = 'wgt-table-'.$this->domainNode->domainName.'-backpath_row_'.$delId;

    $code = <<<JSCODE
  
    \$S('#{$rowId}').fadeOut(100,function() {
      \$S('#{$rowId}').remove();
    });
  
JSCODE;
  
    $this->view->addJsCode($code);
  
  }//end public function displayDelete */

  /**
   * @param string $key
   * @param TArray $params
   */
  public function displayAutocompleteRefField($key, $params)
  {
  
    $view = $this->getTplEngine();
    $view->setRawJsonData($this->model->searchRefFieldsAutocomplete($key, $params));
  
  }//end public function displayAutocompleteRefField */
 

} // end class AclMgmt_Backpath_Ajax_View */

