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
class AclMgmt_Qfdu_Multi_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// getter & setter methodes
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
    $response = $this->getResponse();

    try {
      // start a transaction in the database
      $db->begin();

      // for insert there has to be a list of values that have to be saved
      $listBuizGroupUsers = $this->getRegisterd('listBuizGroupUsers');

      if (is_null($listBuizGroupUsers)) {
        throw new BuizSys_Exception
        (
          'Internal Error',
          'listBuizGroupUsers was not registered'
        );
      }

      $entityTexts = [];

      foreach ($listBuizGroupUsers as $entityBuizGroupUsers) {
        if (!$orm->update($entityBuizGroupUsers)) {
          $entityText = $entityBuizGroupUsers->text();
          $response->addError
          (
            $view->i18n->l
            (
              'Failed to save Area: '.$entityText,
              'enterprise.employee.message',
              array($entityText)
            )
          );
        } else {
          $text = $entityBuizGroupUsers->text();
          if (trim($text) == '') {
            $text = 'Assignment: '.$entityBuizGroupUsers->getid();
          }

          $entityTexts[] = $text;
        }
      }

      $textSaved = implode($entityTexts,', ');
      $this->getResponse()->addMessage
      (
        $view->i18n->l
        (
          'Successfully saved: '.$textSaved,
          'enterprise.employee.message',
          array($textSaved)
        )
      );

      // everything ok
      $db->commit();

    } catch (LibDb_Exception $e) {
      $response->addError($e->getMessage());
      $db->rollback();
    } catch (BuizSys_Exception $e) {
      $response->addError($e->getMessage());
    }

    // check if there were any errors, if not fine
    return !$this->getResponse()->hasErrors();

  }//end public function update */

  /**
   * fetch the data from the http request object for an insert
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchUpdateData($params  )
  {

    $httpRequest = $this->getRequest();
    $orm = $this->getOrm();

    try {

      // if the validation fails report
      $listBuizGroupUsers = $httpRequest->validateMultiUpdate
      (
        'BuizGroupUsers',
        'group_users',
        array('date_start', 'date_end')
      );

      $this->register('listBuizGroupUsers', $listBuizGroupUsers);

      return true;

    } catch (InvalidInput_Exception $e) {
      return false;
    }

  }//end public function fetchUpdateData */

} // end class AclMgmt_Qfdu_Multi_Model */

