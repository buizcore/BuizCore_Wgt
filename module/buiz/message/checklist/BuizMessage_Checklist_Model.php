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
class BuizMessage_Checklist_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
   * @param BuizMessage_Attachment_Request $userRequest
   * @return BuizEntityAttachment_Entity
   */
  public function save($formData)
  {

    $orm = $this->getOrm();
    $db = $this->getDb();
    $user = $this->getUser();
    $response = $this->getResponse();

    $savedIds = [];

    try {

      // start a transaction in the database
      $db->begin();


      $entityTexts = [];

      foreach ($formData->dataBody as $entityEntry) {

        if ($entityEntry->isNew()) {

          if (!$orm->insert($entityEntry)) {
            $entityText = $entityEntry->text();

            $response->addError("Failed to create entry: {$entityText}" );

          } else {

            $entityTexts[] = $entityEntry->text();
            $savedIds[$entityEntry->getId()] = $entityEntry->tmpId;
          }

        } else {

          if (!$orm->update($entityEntry)) {

            $entityText = $entityEntry->text();
            $response->addError("Failed to save entry: {$entityText}" );

          } else {

            $entityTexts[] = $entityEntry->text();
            $savedIds[$entityEntry->getId()] = $entityEntry->getId();

          }
        }
      }

      $textSaved = implode($entityTexts, ', ');
      $response->addMessage( 'Successfully saved Project: '.$textSaved);

      // everything ok
      $db->commit();

    } catch(LibDb_Exception $e) {

      $db->rollback();
      return $savedIds;

    } catch(BuizSys_Exception $e) {

      return $savedIds;
    }

    // check if there were any errors, if not fine
    return $savedIds;

  }//end public function save */


  /**
   * @param int $delId
   * @param Context $params
   */
  public function delete($delId, $params)
  {

    $orm = $this->getOrm();
    $attachEnt = $orm->delete("BuizChecklistEntry",$delId);

  }//end public function delete */


  /**
   * @param int $msgId
   * @throws DataNotExists_Exception if the message not exists
   */
  public function loadChecklistEntries($ids)
  {

    $db = $this->getDb();

    $where = implode( ', ', $ids );

    $sql = <<<SQL

select
  checklist.rowid as id,
  checklist.label as label,
	checklist.flag_checked as checked

FROM
  buiz_checklist_entry checklist

WHERE
  checklist.rowid IN({$where});

SQL;

    //$references = $db->select($sql)->getAll();

    return $db->select($sql);

  }//end public function loadChecklistEntries */

} // end class BuizMessage_Checklist_Model

