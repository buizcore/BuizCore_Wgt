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
class BuizExport_Model extends MvcModel_Domain
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param DomainSimpleSubNode $variant
   * @param Context $context
   * @return LibAclPermission
   */
  public function injectAccessContainer($variant, $context)
  {

    $user = $this->getUser();

    $className = $this->domainNode->domainKey.'_'.$variant->mask.'_Access';

    // if the requested access container not exists, we can assume this request
    // was invalid
    if (!BuizCore::classExists($className))
      throw new ServiceNotExists_Exception($this->domainNode->domainKey.'_'.$variant->mask);

    $access = new $className($this);
    $access->init($context);

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if (!$access->listing) {
      $response = $this->getResponse();

      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception(
        $response->i18n->l(
          'You have no permission to export from {@resource@}',
          'wbf.message',
          array(
            'resource' => $response->i18n->l($this->domainNode->label, $this->domainNode->domainI18n.'.label')
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $context->access = $access;

  }//end public function injectAccessContainer */

  /**
   * @param LibAclPermission $access
   * @param string $context
   */
  public function search($access, $context)
  {

  }//end public function search */

  /**
   * @param LibAclPermission $access
   * @param string $context
   */
  public function searchAll($access, $context)
  {

  }//end public function searchAll */

  /**
   * @param array $ids
   * @param LibAclPermission $access
   * @param string $context
   */
  public function searchByIds($ids, $access, $context)
  {

  }//end public function searchByIds

} // end class BuizExport_Model */

