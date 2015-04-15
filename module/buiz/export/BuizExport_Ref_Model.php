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
class BuizExport_Ref_Model extends MvcModel_Domain
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param DomainSimpleSubNode $variant
   * @param Context $context
   * @param DomainSimpleSubNode $refNode
   * @return LibAclPermission
   */
  public function injectAccessContainer($variant, $context, $refNode, $refId)
  {

    $user = $this->getUser();

    $classKey = $this->domainNode->domainKey.'_Ref_'.$refNode->mask.'_'.$variant->mask;
    $className = $classKey.'_Access';

    // if the requested access container not exists, we can assume this request
    // was invalid
    if (!BuizCore::classExists($className))
      throw new ServiceNotExists_Exception($className);

    $access = new $className(null, null, $this);
    $access->load($user->getProfileName(), $context, $refId);

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    /*
    if (!$access->listing) {
      $response = $this->getResponse();

      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission to export from {@resource@}',
          'wbf.message',
          array
          (
            'resource' => $response->i18n->l($this->domainNode->label, $this->domainNode->domainI18n.'.label')
          )
        ),
        Response::FORBIDDEN
      );
    }
    */

    // der Access Container des Users für die Resource wird als flag übergeben
    $context->access = $access;

  }//end public function injectAccessContainer */

  /**
   * @param int $refId
   * @param LibAclPermission $access
   * @param string $context
   */
  public function search($refId, $access, $context)
  {

  }//end public function search */

  /**
   * @param int $refId
   * @param LibAclPermission $access
   * @param string $context
   */
  public function searchAll($refId, $access, $context)
  {

  }//end public function searchAll */

  /**
   * @param int $refId
   * @param array $ids
   * @param LibAclPermission $access
   * @param string $context
   */
  public function searchByIds($refId, $ids, $access, $context)
  {

  }//end public function searchByIds

} // end class BuizExport_Model */

