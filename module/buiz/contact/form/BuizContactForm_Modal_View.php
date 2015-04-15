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
class BuizContactForm_Modal_View extends LibViewModal
{

  /**
   * Die Breite des Modal Elements
   * @var int in px
   */
  public $width = 800 ;

  /**
   * Die Höhe des Modal Elements
   * @var int in px
   */
  public $height = 550 ;

  /**
   * @var BuizMessage_Model
   */
  public $model = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Display Methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * the default edit form
  * @param int $refId
  * @param int $userId
  * @param string $dataSrc
  * @param string $elementId
  * @param TFlag $params
  * @return void
  */
  public function displayUser($refId, $userId, $dataSrc, $elementId, $params = null)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Send Message';

    // set the window title
    $this->setTitle($i18nText);

    // set the from template
    $this->setTemplate('buiz/contact/form/modal/form_user', true);

    $this->addVars(array(
      'refId' => $refId,
      'userId' => $userId,
      'dataSrc' => $dataSrc,
      'elementKey' => $elementId,
      'userData' => $this->model->getUserData($userId)
    ));


  }//end public function displayUser */

 /**
  * the default edit form
  * @param int $refId
  * @param string $groupKey
  * @param int $dataSrc
  * @param string $elementId
  * @param TFlag $params
  * @return void
  */
  public function displayGroup($refId, $groupKey, $dataSrc, $elementId, $params = null)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Send Message';

    // set the window title
    $this->setTitle($i18nText);

    $this->height = 650;

    // set the from template
    $this->setTemplate('buiz/contact/form/modal/form_group', true);

    $this->addVars(array(
      'refId' => $refId,
      'userId' => $groupKey,
      'dataSrc' => $dataSrc,
      'elementKey' => $elementId,
      'groupData' => $this->model->getGroupUsers($groupKey, null, $refId)
    ));

  }//end public function displayGroup */


 /**
  * the default edit form
  * @param int $refId
  * @param string $elementId
  * @param TFlag $params
  * @return void
  */
  public function displayDset($refId, $dataSrc, $elementId, $params = null)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Send Message';

    // set the window title
    $this->setTitle($i18nText);

    $this->height = 650;


    $domainNode = DomainNode::getNode($dataSrc);
    $entity = $this->getOrm()->get($domainNode->srcKey, $refId  );


    // set the from template
    $this->setTemplate('buiz/contact/form/modal/form_dataset', true);

    $this->addVars(array(
      'refId' => $refId,
      'dataSrc' => $dataSrc,
      'dNode' => $domainNode,
      'entity' => $entity,
      'elementKey' => $elementId,
      'users' => $this->model->getDsetUsers($refId)
    ));

  }//end public function displayDset */

}//end class BuizAttachment_Link_Modal_View

