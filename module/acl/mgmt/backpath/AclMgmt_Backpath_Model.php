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
class AclMgmt_Backpath_Model extends AclMgmt_Base_Model
{
/*////////////////////////////////////////////////////////////////////////////*/
// Getter & Setter for Group Users
/*////////////////////////////////////////////////////////////////////////////*/

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param int $objid
  * @return BuizSecurityArea_Entity
  */
  public function getEntityBuizSecurityBackpath($objid = null)
  {

    $response = $this->getResponse();

    $entityBuizSecurityBackpath = $this->getRegisterd('entityBuizSecurityBackpath');

    //entity buiz_security_area
    if (!$entityBuizSecurityBackpath) {

      if (!is_null($objid)) {
        $orm = $this->getOrm();

        if (!$entityBuizSecurityBackpath = $orm->get('BuizSecurityBackpath', $objid)) {
          $response->addError(
            $this->i18n->l(
              'There is no backpath with this id '.$objid,
              'buiz.security_backpath.message'
            )
          );

          return null;
        }

        $this->register('entityBuizSecurityBackpath', $entityBuizSecurityBackpath);

      } else {
        $entityBuizSecurityBackpath = new BuizSecurityBackpath_Entity() ;
        $this->register('entityBuizSecurityBackpath', $entityBuizSecurityBackpath);
      }

    } elseif ($objid && $objid != $entityBuizSecurityBackpath->getId()) {
      $orm = $this->getOrm();

      if (!$entityBuizSecurityBackpath = $orm->get('BuizSecurityBackpath', $objid)) {
        $response->addError(
          $this->i18n->l(
            'There is no backpath with this id '.$objid,
            'buiz.security_backpath.message'
          )
        );

        return null;
      }

      $this->register('entityBuizSecurityBackpath', $entityBuizSecurityBackpath);
    }

    return $entityBuizSecurityBackpath;

  }//end public function getEntityBuizSecurityBackpath */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param BuizSecurityBackpath_Entity $entity
  */
  public function setEntityBuizSecurityBackpath($entity)
  {

    $this->register('entityBuizSecurityBackpath', $entity);

  }//end public function setEntityBuizSecurityBackpath */

/*////////////////////////////////////////////////////////////////////////////*/
// CRUD code
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   *
   * @param int $areaId
   * @param LibAclContainer $access
   * @param TFlag $params named parameters
   * @return void
   */
  public function search($areaKeys, $access, $params)
  {
  
    $db = $this->getDb();
    $query = $db->newQuery('AclMgmt_Backpath_Table');
    /* @var $query AclMgmt_Backpath_Table_Query  */
  
    $condition = $this->getSearchCondition();
  
    $query->fetch(
      $areaKeys,
      $condition,
      $params
    );
  
    return $query;
  
  }//end public function search */

  /**
   * @param int $areaId
   * @param int $dsetId
   * @param LibAclContainer $access
   * @param TFlag $params named parameters
   * @return void
   */
  public function searchById($areaKeys, $dsetId, $access, $params)
  {
  
    $db = $this->getDb();
    $query = $db->newQuery('AclMgmt_Backpath_Table');
    /* @var $query AclMgmt_Backpath_Table_Query  */
  
    //$condition = $this->getSearchCondition();
  
    $query->fetchById(
      $areaKeys,
      $dsetId,
      [],
      $params
    );
  
    return $query;
  
  }//end public function searchById */
  
  
  /**
   * de:
   * Extrahieren und validieren der Daten zum erstellen einer Verknüpfung,
   * aus dem Userrequest
   *
   * @param TFlag $params named parameters
   * @return null/Error im Fehlerfall
   */
  public function fetchInsertData($params)
  {

    $httpRequest = $this->getRequest();
    $orm = $this->getOrm();
    $acl = $this->getAcl();
    $response = $this->getResponse();

    $entityBuizSecurityBackpath = new BuizSecurityBackpath_Entity;

    $fields = array(
      'id_area',
      'id_target_area',
      'ref_field',
      'groups',
      'set_groups',
    );

    $httpRequest->validateInsert(
      $entityBuizSecurityBackpath,
      'path',
      $fields,
      $fields
    );

    // aus sicherheitsgründen setzen wir die hier im code
    $entityBuizSecurityBackpath->id_area = $this->getAreaId();
    
    // setzen des keys, ist zwar denormalisiert macht es aber einfacher
    $entityBuizSecurityBackpath->target_area_key = $orm->getField(
      'BuizSecurityArea', 
      $entityBuizSecurityBackpath->id_target_area, 
      'access_key'
    );
    
    $levels = $acl->getRoleAreaLevels(
      $entityBuizSecurityBackpath->target_area_key, 
      explode(',', $entityBuizSecurityBackpath->groups)
    );
    
    foreach ($levels as $lKey => $lValue) {
      $entityBuizSecurityBackpath->$lKey = $lValue;
    }
    
    $this->register('entityBuizSecurityBackpath', $entityBuizSecurityBackpath);
  
    if ($response->hasErrors())
      throw new InvalidRequest_Exception('One or more Fields contain invalid values');

  }//end public function fetchInsertData */
  
  /**
   * de:
   * Extrahieren und validieren der Daten zum erstellen einer Verknüpfung,
   * aus dem Userrequest
   *
   * @param TFlag $params named parameters
   * @return null/Error im Fehlerfall
   */
  public function fetchUpdateData($objid,$params)
  {
  
    $httpRequest = $this->getRequest();
    $orm = $this->getOrm();
    $response = $this->getResponse();
  
    $entityBuizSecurityBackpath = $this->getEntityBuizSecurityBackpath($objid);
  
    $fields = array(
      'id_target_area',
      'ref_field',
      'groups',
      'set_groups'
    );
  
    $httpRequest->validateUpdate(
      $entityBuizSecurityBackpath,
      'path',
      $fields,
      $fields
    );
  
    $this->register('entityBuizSecurityBackpath', $entityBuizSecurityBackpath);
  
    if ($response->hasErrors())
      throw new InvalidRequest_Exception('One or more Fields contain invalid values');
  
  }//end public function fetchUpdateData */

  /**
   * de:
   * prüfen ob der benutzer nicht schon unter diesen bedingungen der
   * gruppe zugeordnet wurde
   *
   * @param BuizSecurityBackpath_Entity $entity
   * @return boolean false wenn doppelten einträge vorhanden sind
   */
  public function checkUnique($entity = null)
  {

    $orm = $this->getOrm();

    if (!$entity)
      $entity =  $this->getRegisterd('entityBuizSecurityBackpath');

    return $orm->checkUnique(
      $entity,
      array(
        'id_area',
        'id_target_area',
        'ref_field'
      )
    );

  }//end public function checkUnique */

  /**
   * Create thew new Backpath
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function insert($params)
  {

    // erst mal die nötigen resourcen laden
    $db = $this->getDb();
    $orm = $db->getOrm();
    $response = $this->getResponse();

    try {
      
      $entityBuizSecurityBackpath = $this->getRegisterd('entityBuizSecurityBackpath');

      if (!$orm->insert($entityBuizSecurityBackpath)) {
        
        $response->addError(
          $response->i18n->l(
            'Failed to create the path',
            'wbf.message'
          )
        );

      } else {

        $response->addMessage(
          $response->i18n->l(
            'Successfully created new path',
            'wbf.message'
          )
        );
        $this->protocol(
          'Created new Backpath',
          'insert',
          $entityBuizSecurityBackpath
        );

      }
      
    } catch (LibDb_Exception $e) {
      
      return new Error($e, Response::INTERNAL_ERROR);
    }

  }//end public function insert */
  
  /**
   * Create thew new Backpath
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function update($params)
  {
  
    // erst mal die nötigen resourcen laden
    $db = $this->getDb();
    $orm = $db->getOrm();
    $response = $this->getResponse();
  
    try {
  
      $entityBuizSecurityBackpath = $this->getRegisterd('entityBuizSecurityBackpath');
  
      if (!$orm->update($entityBuizSecurityBackpath)) {
        $response->addError(
            $response->i18n->l(
                'Failed to update the path',
                'wbf.message'
            )
        );
  
      } else {
  
        $response->addMessage(
            $response->i18n->l(
                'Successfully created new path',
                'wbf.message'
            )
        );
        $this->protocol(
            'Created new Backpath',
            'insert',
            $entityBuizSecurityBackpath
        );
  
      }
  
    } catch (LibDb_Exception $e) {
  
      return new Error($e, Response::INTERNAL_ERROR);
    }
  
  }//end public function insert */
  
  /**
   * Create thew new Backpath
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function delete($delId, $params)
  {
  
    // erst mal die nötigen resourcen laden
    $db = $this->getDb();
    $orm = $db->getOrm();
    $response = $this->getResponse();
    
    try {
  
      if (!$orm->delete('BuizSecurityBackpath',$delId )) {
        $response->addError(
          $response->i18n->l(
            'Failed to delete the path',
            'wbf.message'
          )
        );
  
      } else {
  
        $response->addMessage(
          $response->i18n->l(
            'Successfully deleted the path',
            'wbf.message'
          )
        );
        $this->protocol(
          'Deleted a backpath',
          'delete',
          $delId
        );
  
      }
  
    } catch (LibDb_Exception $e) {
  
      return new Error($e, Response::INTERNAL_ERROR);
    }
  
  }//end public function insert */

/*////////////////////////////////////////////////////////////////////////////*/
// Search Methodes
/*////////////////////////////////////////////////////////////////////////////*/



  /**
   * process userinput and map it to seachconditions that can be injected
   * in the query object
   *
   * @return array
   */
  public function getSearchCondition($filterFree = null)
  {

    $condition = [];

    $httpRequest = $this->getRequest();
    $db = $this->getDb();
    $orm = $db->getOrm();

    if ($filterFree)
      $condition['free'] = $filterFree;
    else if ($free = $httpRequest->param('free_search' , Validator::TEXT))
      $condition['free'] = $free;

    return $condition;

  }//end public function getSearchCondition */





} // end class AclMgmt_Backpath_Model */

