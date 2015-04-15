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
class BuizMessage_Attachment_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  public $file = null;

  public $attachment = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
   * @param BuizMessage_Attachment_Request $userRequest
   * @return BuizEntityAttachment_Entity
   */
  public function insert($userRequest)
  {

    $orm = $this->getOrm();

    $checkSum = $userRequest->file->getChecksum();
    $fileSize = $userRequest->file->getSize();

    $fileNode = $orm->newEntity("BuizFile");
    $fileNode->name = $userRequest->file->getFileName();
    $fileNode->file_hash = $checkSum;
    $fileNode->file_size = $fileSize;
    $fileNode->id_type = $userRequest->data['id_type'];
    $fileNode->mimetype = $userRequest->file->getFiletype();
    $fileNode->flag_versioning = $userRequest->data['flag_versioning'];
    $fileNode->id_confidentiality = $userRequest->data['id_confidentiality'];
    $fileNode->description = $userRequest->data['description'];

    $fileNode = $orm->insert($fileNode);

    $this->file = $fileNode;

    if (!$fileNode)
      throw new LibUploadException('Failed to upload file');

    $fileId = $fileNode->getId();

    $filePath = PATH_UPLOADS.'attachments/buiz_file/name/'.SParserString::idToPath($fileId);
    $userRequest->file->copy($fileId, $filePath);

    $attachmentNode = $orm->newEntity("BuizEntityAttachment");
    $attachmentNode->vid = $userRequest->msgId;
    $attachmentNode->id_file = $fileNode;

    $attachmentNode = $orm->insert($attachmentNode);

    $this->attachment = $attachmentNode;

    return $attachmentNode;

  }//end public function insert */

    /**
   * @param BuizMessage_Attachment_Request $userRequest
   * @return BuizEntityAttachment_Entity
   */
  public function update($userRequest)
  {

    $orm = $this->getOrm();

    $checkSum = $userRequest->file->getChecksum();
    $fileSize = $userRequest->file->getSize();

    $fileNode = $orm->newEntity("BuizFile");
    $fileNode->name = $userRequest->file->getFileName();
    $fileNode->file_hash = $checkSum;
    $fileNode->file_size = $fileSize;
    $fileNode->id_type = $userRequest->data['id_type'];
    $fileNode->mimetype = $userRequest->file->getFiletype();
    $fileNode->flag_versioning = $userRequest->data['flag_versioning'];
    $fileNode->id_confidentiality = $userRequest->data['id_confidentiality'];
    $fileNode->description = $userRequest->data['description'];

    $fileNode = $orm->insert($fileNode);

    $this->file = $fileNode;

    if (!$fileNode)
      throw new LibUploadException('Failed to upload file');

    $fileId = $fileNode->getId();

    $filePath = PATH_UPLOADS.'attachments/buiz_file/name/'.SParserString::idToPath($fileId);
    $userRequest->file->copy($fileId, $filePath);

    $attachmentNode = $orm->newEntity("BuizEntityAttachment");
    $attachmentNode->vid = $userRequest->msgId;
    $attachmentNode->id_file = $fileNode;

    $attachmentNode = $orm->insert($attachmentNode);

    $this->attachment = $attachmentNode;

    return $attachmentNode;

  }//end public function update */

    /**
   * @param BuizMessage_Attachment_Request $userRequest
   * @return BuizEntityAttachment_Entity
   */
  public function delete($delId, $params)
  {

    $orm = $this->getOrm();

    $attachEnt = $orm->get("BuizEntityAttachment",$delId);
    $fileId = $attachEnt->id_file;

    $orm->delete($attachEnt);

    if( !$orm->countRows("BuizEntityAttachment","id_file=".$fileId) ) {
      $orm->delete("BuizFile",$fileId);
      $filePath = PATH_UPLOADS.'attachments/buiz_file/name/'.SParserString::idToPath($fileId).'/'.$fileId;
      SFiles::delete($filePath);
    }

  }//end public function delete */

} // end class BuizMessage_Attachment_Model

