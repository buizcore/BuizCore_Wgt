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
class AclMgmt_Backpath_Ui extends MvcUi
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * the model
   * @var AclMgmt_Qfdu_Model
   */
  protected $model = null;

  /**
   * @var DomainNode
   */
  public $domainNode = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Listing Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * create a table item for the entity
   *
   * @param LibSqlQuery $data Die Datenbank Query zum befüllen des Listenelements
   * @param int $areaId die ID der Area
   * @param LibAclContainer $access Der Container mit den Zugriffsrechten
   * @param TFlag $params named parameters
   *
   * @return AclMgmt_Qfdu_Treetable_Element
   */
  public function createListItem($data, $areaId, $access, $params  )
  {

    $listObj = new AclMgmt_Backpath_Table_Element(
      $this->domainNode,
      'listingBackpath',
      $this->view
    );

    $listObj->areaId = $areaId;
    $listObj->domainNode = $this->domainNode;

    // use the query as datasource for the table
    $listObj->setData($data);

    // den access container dem listenelement übergeben
    $listObj->setAccess($access);
    $listObj->setAccessPath($params, $params->aclKey, $params->aclNode);

    // set the offset to set the paging menu correct
    $listObj->start = $params->start;

    // set the position for the size menu
    $listObj->stepSize = $params->qsize;

    // check if there is a filter for the first char
    if ($params->begin)
      $listObj->begin = $params->begin;

    // if there is a given tableId for the html id of the the table replace
    // the default id with it
    if ($params->targetId)
      $listObj->setId($params->targetId);

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    if (!$params->searchFormId)
      $params->searchFormId = 'wgt-form-table-'.$this->domainNode->domainName.'-acl-backpath-search';

    $listObj->setPagingId($params->searchFormId);

    // add the id to the form
    if (!$params->formId)
      $params->formId = 'wgt-form-'.$this->domainNode->domainName.'-backpath-ms';

    $listObj->setSaveForm($params->formId);


    if ($params->ajax) {
      // refresh the table in ajax requests
      $listObj->refresh = true;

      // the table should only replace the content inside of the container
      // but not the container itself
      $listObj->insertMode = false;

    } else {
      // create the panel
      $tabPanel = new WgtPanelTable($listObj);

      $tabPanel->title = $this->view->i18n->l(
        'Backpath Access {@label@}',
        'wbf.label',
        array(
          'label' => $this->domainNode->label
        )
      );
      $tabPanel->searchKey = $this->domainNode->domainName.'_acl_backpath';


      $tabPanel->addButton (
        'save',
        array (
          Wgt::ACTION_JS,
          'Save',
          "\$S('#{$listObj->id}-table').grid('save');",
          'fa fa-save',
          'wgt-button',
          'wbf.label'
        )
      );


    }


    if ($params->append) {

      $listObj->setAppendMode(true);
      $listObj->buildAjax();

      $jsCode = <<<WGTJS

  \$S('table#{$listObj->id}-table').grid('update');

WGTJS;

      $this->view->addJsCode($jsCode);

    } else {

      // if this is an ajax request and we replace the body, we need also
      // to change the displayed found "X" entries in the footer
      if ($params->ajax) {
        $jsCode = <<<WGTJS

  \$S('table#{$listObj->id}-table').grid('setNumEntries',{$listObj->dataSize}).grid('update');

WGTJS;

        $this->view->addJsCode($jsCode);

      }

      $listObj->buildHtml();
    }

    return $listObj;

  }//end public function createListItem */


  /**
   * just deliver changed table rows per ajax interface
   *
   * @param string $areaId
   * @param LibAclContainer $access
   * @param array $params named parameters
   * @param boolean $insert
   * @return void
   */
  public function addListEntry($data, $areaId, $access, $params, $insert)
  {

    //$className = $this->domainNode->domainAclMask.'_Qfdu_Treetable_Element';

    $table = new AclMgmt_Backpath_Table_Element(
      $this->domainNode,
      'listingBackpathElement',
      $this->view
    );

    // den access container dem listenelement übergeben
    $table->setAccess($access);
    $table->setAccessPath($params, $params->aclKey, $params->aclNode);
    $table->appendMode = false;
    $table->insertMode = $insert;

    $table->areaId = $areaId;

    $table->setData($data);

    // if a table id is given use it for the table
    if ($params->targetId)
      $table->id = $params->targetId;

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    if (!$params->searchFormId)
      $params->searchFormId = 'wgt-form-table-'.$this->domainNode->domainName.'-acl-backpath-search';

    $table->setPagingId($params->searchFormId);

    // add the id to the form
    if (!$params->formId)
      $params->formId = 'wgt-form-'.$this->domainNode->domainName.'-backpath-ms';

    $table->setSaveForm($params->formId);

    $this->view->setPageFragment('areaPath', $table->buildAjax());

    if ($insert) {

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('incEntries').grid('update');

WGTJS;

    } else {

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('update');

WGTJS;

    }

    $this->view->addJsCode($jsCode);

    return $table;

  }//end public function addListEntry */

} // end class AclMgmt_Backpath_Ui */

