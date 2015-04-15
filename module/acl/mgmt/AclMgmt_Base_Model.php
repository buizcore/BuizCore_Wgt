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
 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class AclMgmt_Base_Model extends MvcModel
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
   * request the id of the activ security area
   *
   * @return int
   */
  public function getAreaId()
  {

    if (!$this->areaId) {
      $this->areaId = $this->getAcl()->resources->getAreaId($this->domainNode->aclBaseKey);
    }

    return $this->areaId;

  }//end public function getAreaId */

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
          $this->getResponse()->addError(
            $this->i18n->l(
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
        $this->getResponse()->addError(
          $this->i18n->l(
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



} // end class AclMgmt_Base_Model */

