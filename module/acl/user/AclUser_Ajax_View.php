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
class AclUser_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var DomainNode
   */
  public $domainNode = null;

/*////////////////////////////////////////////////////////////////////////////*/
// display methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * automcomplete for the user roles
   *
   * inject the search result from the autocomplete request as json in the view
   * the view will answer as a normal ajax / xml request but embed the
   * json data as data package, which will be returned in the browser from the
   * calling request method
   *
   * @param string $areaId the rowid of the activ area
   * @param string $key the search key from the autocomplete field
   * @param TArray $context useriput / control flags
   *
   * @return void
   */
  public function displayAutocomplete($areaId, $key, $context)
  {

    $view = $this->getTplEngine();
    $view->setRawJsonData($this->model->getUsersByKey($areaId, $key, $context));

    return null;

  }//end public function displayAutocomplete */

  /**
   * automcomplete for the Employee entity
   *
   * inject the search result from the autocomplete request as json in the view
   * the view will answer as a normal ajax / xml request but embed the
   * json data as data package, which will be returned in the browser from the
   * calling request method
   *
   * @param string $areaId the rowid of the activ area
   * @param string $key the search key from the autocomplete field
   * @param TArray $context useriput / control flags
   */
  public function displayAutocompleteEntity($areaId, $key, $context)
  {

    $view = $this->getTplEngine();
    $view->setRawJsonData($this->model->getEntitiesByKey($areaId, $key, $context));

    return null;

  }//end public function displayAutocompleteEntity */

  /**
   * append a new user in relation to an area / entity to a group
   *
   * on connect the server pushes a new table row via ajax area to the client
   * the ajax area appends automatically at the end of the listing element body
   *
   * @param string $areaId the rowid of the activ area
   * @param TArray $context useriput / control flags
   */
  public function displayConnect($areaId, $context)
  {

    $ui = $this->tplEngine->loadUi('AclMgmt_Qfdu');
    $ui->setModel($this->model);
    $ui->domainNode = $this->domainNode;

    $ui->listEntry($areaId, $context->access, $context, true);

    return null;

  }//end public function displayConnect */

  /**
   * search pushes a rendered listing element body to the client, that replaces
   * the existing body
   *
   * @param int $areaId the rowid of the activ area
   * @param TArray $context control flags
   */
  public function displaySearch($areaId, $context)
  {

    $ui = $this->tplEngine->loadUi('AclMgmt_Qfdu');
    $ui->domainNode = $this->domainNode;
    $ui->setModel($this->model);
    $ui->setView($this->getView());

    // add the id to the form
    if (!$context->searchFormId)
      $context->searchFormId = 'wgt-form-table-'.$this->domainNode->domainName.'-acl-tuser-search';

    // ok it's definitly an ajax request
    $context->ajax = true;

    $ui->createListItem
    (
      $this->model->searchQualifiedUsers($areaId, $context),
      $areaId,
      $context->access,
      $context
    );

    return null;

  }//end public function displaySearch */

  /**
   * search pushes a rendered listing element body to the client, that replaces
   * the existing body
   *
   * @param int $areaId the rowid of the activ area
   * @param TArray $context control flags
   */
  public function displayLoadGridGroups($userId, $dsetId, $context)
  {

    /* @var $ui AclMgmt_User_Qfdu_Ui  */
    $ui = $this->tplEngine->loadUi('AclMgmt_Qfdu_User');
    $ui->domainNode = $this->domainNode;
    $ui->setModel($this->model);
    $ui->setView($this->getTpl());

    // add the id to the form
    if (!$context->searchFormId)
      $context->searchFormId = 'wgt-form-table-'.$this->domainNode->domainName.'-acl-tuser-search';

    // ok it's definitly an ajax request
    $context->ajax = true;

    $ui->listBlockGroups
    (
      $userId,
      $dsetId,
      $context
    );

    return null;

  }//end public function displayLoadGridGroups */

  /**
   * search pushes a rendered listing element body to the client, that replaces
   * the existing body
   *
   * @param int $groupId
   * @param int $userId
   * @param TArray $context control flags
   */
  public function displayLoadGridDsets($userId, $context)
  {

    /* @var $ui  AclMgmt_Qfdu_Ui  */
    $ui = $this->tplEngine->loadUi('AclMgmt_Qfdu_User');
    $ui->domainNode = $this->domainNode;
    $ui->setModel($this->model);
    $ui->setView($this->getTpl());

    // add the id to the form
    if (!$context->searchFormId)
      $context->searchFormId = 'wgt-form-table-'.$this->domainNode->domainName.'-acl-tuser-search';

    // ok it's definitly an ajax request
    $context->ajax = true;

    $ui->listBlockDsets
    (
      $userId,
      $context
    );

    return null;

  }//end public function displayLoadGridDsets */

} // end class AclMgmt_Qfdu_User_Ajax_View */

