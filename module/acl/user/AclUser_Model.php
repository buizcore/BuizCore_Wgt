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
class AclUser_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * the id of the active area
   * @var int
   */
  protected $areaId = null;

  /**
   * @var DomainNode
   */
  public $domainNode = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Getter & Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * request the id of the activ area
   * @return int
   */
  public function loadAreaId()
  {

    if ($this->areaId)
      return $this->areaId;

    $orm = $this->getOrm();

    $this->areaId = $orm->get('BuizSecurityArea',"access_key=upper('{$this->domainNode->aclBaseKey}')")->getid();

    return $this->areaId;

  }//end public function loadAreaId */

/*////////////////////////////////////////////////////////////////////////////*/
// Getter & Setter for Entities Area
/*////////////////////////////////////////////////////////////////////////////*/

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return BuizSecurityArea_Entity
  */
  public function getEntityBuizSecurityArea($objid = null)
  {

    $entityBuizSecurityArea = $this->getRegisterd('entityBuizSecurityArea');

    //entity buiz_security_area
    if (!$entityBuizSecurityArea) {

      if (!is_null($objid)) {
        $orm = $this->getOrm();

        if (!$entityBuizSecurityArea = $orm->get('BuizSecurityArea', $objid)) {
          $this->getResponse()->addError
          (
            $this->i18n->l
            (
              'There is no buizsecurityarea with this id '.$objid,
              'buiz.security_area.message'
            )
          );

          return null;
        }

        $this->register('entityBuizSecurityArea', $entityBuizSecurityArea);

      } else {
        $entityBuizSecurityArea = new BuizSecurityArea_Entity() ;
        $this->register('entityBuizSecurityArea', $entityBuizSecurityArea);
      }

    } elseif ($objid && $objid != $entityBuizSecurityArea->getId()) {
      $orm = $this->getOrm();

      if (!$entityBuizSecurityArea = $orm->get('BuizSecurityArea', $objid)) {
        $this->getResponse()->addError
        (
          $this->i18n->l
          (
            'There is no buizsecurityarea with this id '.$objid,
            'buiz.security_area.message'
          )
        );

        return null;
      }

      $this->register('entityBuizSecurityArea', $entityBuizSecurityArea);
    }

    return $entityBuizSecurityArea;

  }//end public function getEntityBuizSecurityArea */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param BuizSecurityArea_Entity $entity
  */
  public function setEntityBuizSecurityArea($entity)
  {

    $this->register('entityBuizSecurityArea', $entity);

  }//end public function setEntityBuizSecurityArea */

  /**
   * request all fields that have to be fetched from the request
   * @return array
   */
  public function getEditFields()
  {
    return array
    (
      'security_area' => array
      (
        'id_ref_listing',
        'id_ref_access',
        'id_ref_insert',
        'id_ref_update',
        'id_ref_delete',
        'id_ref_admin',

        'id_level_listing',
        'id_level_access',
        'id_level_insert',
        'id_level_update',
        'id_level_delete',
        'id_level_admin',

        'description'
      ),

    );

  }//end public function getEditFields */

  /**
   * request the id of the activ area
   *
   * @return int
   */
  public function getAreaId()
  {

    $orm = $this->getOrm();

    return $orm->getByKey('BuizSecurityArea', $this->domainNode->aclKey)->getid();

  }//end public function getAreaId */

/*////////////////////////////////////////////////////////////////////////////*/
// Getter & Setter for Entities Access
/*////////////////////////////////////////////////////////////////////////////*/

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return BuizSecurityArea_Entity
  */
  public function getEntityBuizSecurityAccess($objid = null)
  {

    $entityBuizSecurityAccess = $this->getRegisterd('entityBuizSecurityAccess');

    //entity buiz_security_area
    if (!$entityBuizSecurityAccess) {

      if (!is_null($objid)) {
        $orm = $this->getOrm();

        if (!$entityBuizSecurityAccess = $orm->get('BuizSecurityAccess', $objid)) {
          $this->getResponse()->addError
          (
            $this->i18n->l
            (
              'There is no buizsecurityarea with this id '.$objid,
              'buiz.security_area.message'
            )
          );

          return null;
        }

        $this->register('entityBuizSecurityAccess', $entityBuizSecurityAccess);

      } else {
        $entityBuizSecurityAccess = new BuizSecurityAccess_Entity() ;
        $this->register('entityBuizSecurityAccess', $entityBuizSecurityAccess);
      }

    } elseif ($objid && $objid != $entityBuizSecurityAccess->getId()) {
      $orm = $this->getOrm();

      if (!$entityBuizSecurityAccess = $orm->get('BuizSecurityAccess', $objid)) {
        $this->getResponse()->addError
        (
          $this->i18n->l
          (
            'There is no buizsecurityarea with this id '.$objid,
            'buiz.security_area.message'
          )
        );

        return null;
      }

      $this->register('entityBuizSecurityAccess', $entityBuizSecurityAccess);
    }

    return $entityBuizSecurityAccess;

  }//end public function getEntityBuizSecurityAccess */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param BuizSecurityAccess_Entity $entity
  */
  public function setEntityBuizSecurityAccess($entity)
  {

    $this->register('entityBuizSecurityAccess', $entity);

  }//end public function setEntityBuizSecurityAccess */

  /**
   * request all fields that have to be fetched from the request
   * @return array
   */
  public function getEditFieldsAccess()
  {
    return array
    (
      'security_access' => array
      (
        'access_level',
        'description',
        'date_start',
        'date_end'
      ),

    );

  }//end public function getEditFieldsAccess */

  /**
   * just fetch the post data without any required validation
   * @param LibTemplatePresenter $view
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function getEntryDataAccess($view,  $params)
  {

    $orm = $this->getOrm();
    $data = [];

    $data['security_access'] = $this->getEntityBuizSecurityAccess();

    $tabData = [];

    foreach ($data as $tabName => $ent)
      $tabData = array_merge($tabData , $ent->getAllData($tabName));

    $tabData['num_assignments'] = 0;
    $tabData['role_group_rowid'] = $data['security_access']->id_group;

    $tabData['role_group_name'] = $orm->getField
    (
      'BuizRoleGroup',
      $data['security_access']->id_group ,
      'name'
    );

    return $tabData;

  }// end public function getEntryDataAccess */

/*////////////////////////////////////////////////////////////////////////////*/
// Connect Code
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * fetch the update data from the http request object
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchConnectData($params)
  {

    $httpRequest = $this->getRequest();
    $view = $this->getView();
    $response = $this->getResponse();
    $orm = $this->getOrm();

    $entityBuizSecurityAccess = new BuizSecurityAccess_Entity;

    $fields = array
    (
      'id_group',
      'id_area',
      'access_level',
      'date_start',
      'date_end',
    );

    $httpRequest->validateUpdate
    (
      $entityBuizSecurityAccess,
      'security_access',
      $fields,
      array('id_group')
    );

    $entityBuizSecurityAccess->partial = 0;

    // wenn kein access level mit übergeben wurde wird access als standard
    // angenommen
    if (is_null($entityBuizSecurityAccess->access_level))
      $entityBuizSecurityAccess->access_level = 1;

    $this->register('entityBuizSecurityAccess', $entityBuizSecurityAccess);

    // check if there where any errors if not fine
    return !$response->hasErrors();

  }//end public function fetchConnectData */

  /**
   * the update method of the model
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function connect( $params)
  {

    // laden der mvc/utils adapter Objekte
    $db = $this->getDb();
    $orm = $db->getOrm();
    $response = $this->getResponse();

    try {
      if (!$entityBuizSecurityAccess = $this->getRegisterd('entityBuizSecurityAccess')) {
        return new Error
        (
          $response->i18n->l
          (
            'Sorry, something went wrong!',
            'wbf.message'
          ),
          Response::INTERNAL_ERROR,
          $response->i18n->l
          (
            'The expected Entity with the key {@key@} was not in the registry',
            'wbf.message',
            array('key' => 'entityBuizSecurityAccess')
          )
        );
      }

      if (!$orm->insert($entityBuizSecurityAccess)) {
        $entityText = $entityBuizSecurityAccess->text();
        $response->addError
        (
          $response->i18n->l
          (
            'Failed to updated {@key@}',
            'wbf.message',
            array('key'=>$entityText)
          )
        );

      } else {

        // ok jetzt müssen wir noch kurz partiellen zugriff auf die unteren ebene vergeben
        $partialMod = new BuizSecurityAccess_Entity;
        $partialMod->id_area = $orm->getByKey('BuizSecurityArea', $this->domainNode->modAclKey);
        $partialMod->id_group = $entityBuizSecurityAccess->id_group;
        $partialMod->partial = 1;
        $partialMod->access_level = 1;
        $orm->insertIfNotExists($partialMod, array('id_area', 'id_group', 'partial'));


        $partialEntity = new BuizSecurityAccess_Entity;
        $partialEntity->id_area = $orm->getByKey('BuizSecurityArea', $this->domainNode->aclBaseKey);
        $partialEntity->id_group = $entityBuizSecurityAccess->id_group;
        $partialEntity->partial = 1;
        $partialEntity->access_level = 1;
        $orm->insertIfNotExists($partialEntity, array('id_area','id_group','partial'));


        $entityText = $entityBuizSecurityAccess->text();

        $response->addMessage
        (
          $response->i18n->l
          (
            'Successfully updated {@key@}',
            'wbf.message',
            array('key' => $entityText)
          )
        );

        $this->protocol
        (
          'Edited : '.$entityText,
          'edit',
          $entityBuizSecurityAccess
        );

      }
    } catch (LibDb_Exception $e) {
      return new Error($e, Response::INTERNAL_ERROR);
    }

    if ($response->hasErrors()) {
      return new Error
      (
        $response->i18n->l
        (
          'Sorry, something went wrong!',
          'wbf.message'
        ),
        Response::INTERNAL_ERROR
      );
    } else {
      return null;
    }


  }//end public function connect */

/*////////////////////////////////////////////////////////////////////////////*/
// CRUD Code
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * fetch the update data from the http request object
   * @param int $id
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchUpdateData($id, $params)
  {

    $httpRequest = $this->getRequest();
    $orm = $this->getOrm();
    $response = $this->getResponse();

    if (!$entityBuizSecurityArea = $orm->get('BuizSecurityArea',  $id)) {
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'There ist no Security Area with the ID: {@id@}',
          'wbf.message',
          array
          (
            'id' => $id
          )
        ),
        Response::NOT_FOUND
      );
    }

    $fields = $this->getEditFields();

    $httpRequest->validateUpdate
    (
      $entityBuizSecurityArea,
      'security_area',
      $fields['security_area']
    );
    $this->register('entityBuizSecurityArea', $entityBuizSecurityArea);


    // check if there where any errors if not fine
    if ($response->hasErrors()) {
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'Validation failed',
          'wbf.message'
        ),
        Response::BAD_REQUEST
      );
    }

  }//end public function fetchUpdateData */

  /**
   * the update method of the model
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function update($params)
  {

    // fetch the required technical objects
    $db = $this->getDb();
    $orm = $db->getOrm();
    $view = $this->getView();
    $response = $this->getResponse();

    try {
      if (!$entityBuizSecurityArea = $this->getRegisterd('entityBuizSecurityArea')) {
        return new Error
        (
          $response->i18n->l
          (
            'Sorry, something went wrong!',
            'wbf.message'
          ),
          Response::INTERNAL_ERROR,
          $response->i18n->l
          (
            'The expected Entity with the key {@key@} was not in the registry',
            'wbf.message',
            array('key' => 'entityBuizSecurityArea')
          )
        );
      }

      if (!$orm->update($entityBuizSecurityArea)) {
        $entityText = $entityBuizSecurityArea->text();
        $response->addError
        (
          $response->i18n->l
          (
            'Failed to update '.$entityText,
            'wbf.message',
            array($entityText)
          )
        );

      } else {
        $entityText = $entityBuizSecurityArea->text();

        $response->addMessage
        (
          $response->i18n->l
          (
            'Successfully updated '.$entityText,
            'wbf.message',
            array($entityText)
          )
        );

        $this->protocol
        (
          'Edited : '.$entityText,
          'edit',
          $entityBuizSecurityArea
        );

      }
    } catch (LibDb_Exception $e) {
      return new Error($e, Response::INTERNAL_ERROR);
    }

    if ($response->hasErrors()) {
      return new Error
      (
        $response->i18n->l
        (
          'Sorry, something went wrong!',
          'wbf.message'
        ),
        Response::INTERNAL_ERROR
      );
    } else {
      return null;
    }

  }//end public function update */

/*////////////////////////////////////////////////////////////////////////////*/
// Search Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   * @param TArray $params
   */
  public function searchGroupsAutocomplete($key, $params)
  {

    $db = $this->getDb();
    $query = $db->newQuery('AclMgmt');
    /* @var $query AclMgmt_Query  */

    $query->fetchGroupsByKey
    (
      $key,
      $params
    );

    return $query->getAll();

  }//end public function searchGroupsAutocomplete */

  /**
   *
   * @param int $areaId
   * @param LibAclContainer $access
   * @param TFlag $params named parameters
   * @return void
   */
  public function search($areaId, $access, $params)
  {

    $db = $this->getDb();
    $query = $db->newQuery('AclMgmt_Table');
    /* @var $query AclMgmt_Table_Query  */

    $condition = $this->getSearchCondition();

    $query->fetch
    (
      $areaId,
      $condition,
      $params
    );

    return $query;

  }//end public function search */

  /**
   * process userinput and map it to seachconditions that can be injected
   * in the query object
   * @return array
   */
  public function getSearchCondition()
  {

    $condition = [];

    $httpRequest = $this->getRequest();
    $db = $this->getDb();
    $orm = $db->getOrm();

    if ($free = $httpRequest->param('free_search', Validator::TEXT))
      $condition['free'] = $free;

    return $condition;

  }//end public function getSearchCondition */

  /**
   * de:
   * prüfen ob eine derartige referenz nicht bereits existiert
   *
   * @param BuizSecurityAccess_Entity $entity
   * @return boolean false wenn eine derartige verknüpfung bereits existiert
   */
  public function checkUnique($entity = null)
  {

    $orm = $this->getOrm();

    if (!$entity)
      $entity =  $this->getRegisterd('entityBuizSecurityAccess');

    return $orm->checkUnique
    (
      $entity ,
      array
      (
        'id_area',
        'id_group',
        'partial'
      )
    );

  }//end public function checkUnique */


  /**
   * de:
   * prüfen ob eine derartige referenz nicht bereits existiert
   *
   * @param BuizSecurityAccess_Entity $entity
   * @return boolean false wenn eine derartige verknüpfung bereits existiert
   */
  public function checkAccess($domainNode, $params)
  {

    $user = $this->getUser();

    $access = new AclMgmt_Access_Container($this, $domainNode);
    $access->init($params);

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if (!$access->admin) {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception(
        $response->i18n->l(
          'You have no permission for administration in {@resource@}',
          'wbf.message',
          array(
            'resource' => $response->i18n->l($domainNode->label, $domainNode->domainI18n.'.label')
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;

  }//end public function checkAccess */


  /**
   * @param Tflag $params
   * @return Error
   */
  public function pushMgmtConfigurationToEntity($params)
  {

    $db = $this->getDb();
    $orm = $db->getOrm();

    $entityAreaId = $this->getEntityAreaId();
    $areaId = $this->getAreaId();

    /* @var $groupQuery AclMgmt_SyncGroup_Query */
    $groupQuery = $db->newQuery('AclMgmt_SyncGroup');
    $groupQuery->fetch($areaId);

    foreach ($groupQuery as $entry) {
      $partialEntity = new BuizSecurityAccess_Entity;
      $partialEntity->id_area = $entityAreaId;
      $partialEntity->id_group = $entry['security_access_id_group'];
      $partialEntity->partial = 0;
      $partialEntity->access_level = $entry['security_access_access_level'];
      $orm->insertIfNotExists(
        $partialEntity,
        array(
          'id_area',
          'id_group',
          'partial'
        )
      );
    }

    /* @var $assignmentQuery AclMgmt_SyncAssignment_Query */
    $assignmentQuery = $db->newQuery('AclMgmt_SyncAssignment');
    $assignmentQuery->fetch($areaId);

    foreach ($assignmentQuery as $entry) {

      $partUser = new BuizGroupUsers_Entity;
      $partUser->id_user = $entry['group_users_id_user'];
      $partUser->id_group = $entry['group_users_id_group'];

      if ($entry['group_users_vid'])
        $partUser->vid = $entry['group_users_vid'];

      $partUser->id_area = $entityAreaId;
      $partUser->partial = 0;

      $orm->insertIfNotExists(
        $partUser,
        array(
          'id_area',
          'id_group',
          'id_user',
          'vid',
          'partial'
        )
      );

    }

  }//end public function pushMgmtConfigurationToEntity */

  /**
   * @param Tflag $params
   * @return Error
   */
  public function pullMgmtConfigurationfromEntity($params)
  {

    $db = $this->getDb();
    $orm = $db->getOrm();

    $entityAreaId = $this->getEntityAreaId();
    $areaId = $this->getAreaId();

    /* @var $groupQuery AclMgmt_SyncGroup_Query */
    $groupQuery = $db->newQuery('AclMgmt_SyncGroup');
    $groupQuery->fetch($entityAreaId);

    foreach ($groupQuery as $entry) {
      $partialEntity = new BuizSecurityAccess_Entity;
      $partialEntity->id_area = $areaId;
      $partialEntity->id_group = $entry['security_access_id_group'];
      $partialEntity->partial = 0;
      $partialEntity->access_level = $entry['security_access_access_level'];
      $orm->insertIfNotExists(
        $partialEntity,
        array(
          'id_area',
          'id_group',
          'partial'
        )
      );
    }

    /* @var $assignmentQuery AclMgmt_SyncAssignment_Query */
    $assignmentQuery = $db->newQuery('AclMgmt_SyncAssignment');
    $assignmentQuery->fetch($entityAreaId);

    foreach ($assignmentQuery as $entry) {

      $partUser = new BuizGroupUsers_Entity;
      $partUser->id_user = $entry['group_users_id_user'];
      $partUser->id_group = $entry['group_users_id_group'];

      if ($entry['group_users_vid'])
        $partUser->vid = $entry['group_users_vid'];

      $partUser->id_area = $areaId;
      $partUser->partial = 0;

      $orm->insertIfNotExists(
        $partUser,
        array(
          'id_area',
          'id_group',
          'id_user',
          'vid',
          'partial'
        )
      );

    }

  }//end public function pullMgmtConfigurationfromEntity */

} // end class AclMgmt_Model */

