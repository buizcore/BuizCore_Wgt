<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore
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
 *
 */
class BuizAvatar_Controller extends MvcController_Domain
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options = array
  (
    'upload' => array(
      'method' => array('POST'),
      //'views' => array('document')
    ),
  );

/*////////////////////////////////////////////////////////////////////////////*/
// Listing Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_upload($request, $response)
  {

      // resource laden
      $user = $this->getUser();
      
      $userRqt = new BuizAvatar_Upload_Request($request);
      
      // Die ID ist Plicht.
      // Ohne diese können wir keinen Datensatz identifizieren und somit auch
      // auf Anfage logischerweise nicht bearbeiten
      if ($userRqt->isInvalid) {
          // Ok wir haben keine id bekommen, also ist hier schluss
          throw new InvalidRequest_Exception(
              $response->i18n->l(
                  'The Request for {@service@} was invalid. ID was missing!',
                  'wbf.message',
                  array(
                      'service' => 'upload'
                  )
              ),
              Response::BAD_REQUEST
          );
      }
      
      
      // erst mal brauchen wir das passende model
      $manager = new BuizAvatar_Manager($this);
      $entity = $manager->getTargetEntity($userRqt);
   
      
      // wenn null zurückgegeben wurde existiert der datensatz nicht
      // daher muss das System eine 404 Meldung zurückgeben
      if (!$entity) {
          // if not this request is per definition invalid
          throw new InvalidRequest_Exception(
              $response->i18n->l(
                  'The requested {@resource@} for ID {@id@} not exists!',
                  'wbf.message',
                  array(
                      'resource' => $response->i18n->l('page', 'cms.page.label'),
                      'id' => $userRqt->objid
                  )
              ),
              Response::NOT_FOUND
          );
      }

      //$manager->checkAccess($userRqt);
      $manager->uploadImage($userRqt, $entity);

  }//end public function service_upload */



} // end class BuizExport_Controller */

