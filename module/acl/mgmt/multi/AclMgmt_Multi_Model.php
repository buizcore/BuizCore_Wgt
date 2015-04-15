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
class AclMgmt_Multi_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * multi save action, with this action you can save multiple entries
   * for this model in the database
   * save means create if not exist and update if allready exists
   *
   * @param TFlag $params named parameters
   * @return void
   */
  public function update($params   )
  {

    $orm = $this->getOrm();
    $db = $this->getDb();
    $view = $this->getView();

    try {
      // start a transaction in the database
      $db->begin();

      // for insert there has to be a list of values that have to be saved
      if (!$listBuizSecurityAccess = $this->getRegisterd('listRefBuizSecurityAccess')) {
        throw new BuizSys_Exception(
          'Internal Error',
          'listBuizSecurityAccess was not registered'
        );
      }

      $entityTexts = [];

      foreach ($listBuizSecurityAccess as $entityBuizSecurityAccess) {
        if (!$orm->update($entityBuizSecurityAccess)) {
          $entityText = $entityBuizSecurityAccess->text();
          $this->getResponse()->addError(
            $view->i18n->l(
              'Failed to save Area: '.$entityText,
              'wbf.message',
              array($entityText)
            )
          );
        } else {
          $entityTexts[] = $entityBuizSecurityAccess->text();
        }
      }

      $textSaved = implode($entityTexts,', ');
      $this->getResponse()->addMessage(
        $view->i18n->l(
          'Successfully saved Area: '.$textSaved,
          'wbf.message',
          array($textSaved)
        )
      );

      // everything ok
      $db->commit();

    } catch (LibDb_Exception $e) {
      $this->getResponse()->addError($e->getMessage());
      $db->rollback();
    } catch (BuizSys_Exception $e) {
      $this->getResponse()->addError($e->getMessage());
    }

    // check if there were any errors, if not fine
    return !$this->getResponse()->hasErrors();

  }//end public function update */


  /**
   * fetch the data from the http request object an put it
   * as list in the registry
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchUpdateData($params  )
  {

    $httpRequest = $this->getRequest();
    $orm = $this->getOrm();

    try {

      // if the validation fails report
      $listBuizSecurityAccess = $httpRequest->validateMultiUpdate(
        'BuizSecurityAccess',
        'security_access',
        array('access_level','ref_access_level','meta_level','message_level','priv_message_level')
      );

      $this->register('listRefBuizSecurityAccess',$listBuizSecurityAccess);

      return true;

    } catch (InvalidInput_Exception $e) {

      return false;
    }

  }//end public function fetchUpdateData */

} // end class AclMgmt_Multi_Model */

