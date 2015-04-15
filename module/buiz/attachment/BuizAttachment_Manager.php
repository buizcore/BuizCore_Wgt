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
class BuizAttachment_Manager extends Manager
{


  /**
   * Ein Dokument an einen Datensatz hängen
   * @param LibDocument_Letter $document
   * @param int $vid
   * @param int $type
   * @param string $description
   * @param int $confidentiality
   *
   * @throws InternalError_Exception
   */
  public function attachDocumentToDataset(
    $document,
    $vid,
    $type,
    $description = null,
    $confidentiality = null
  ) {

    $orm = $this->getOrm();


    $fileNode = $orm->newEntity("BuizFile");
    $fileNode->name = $document->getFileName();
    $fileNode->file_hash = $document->getChecksum();
    $fileNode->file_size = $document->getSize();
    $fileNode->mimetype = $document->getMimeType();
    $fileNode->id_type = $type;
    $fileNode->flag_versioning = false;
    $fileNode->description = $description;
    $fileNode->id_confidentiality = $confidentiality;

    $fileNode = $orm->insert($fileNode);

    if (!$fileNode)
      throw new InternalError_Exception('Failed to upload file');

    $fileId = $fileNode->getId();

    $filePath = PATH_UPLOADS.'attachments/buiz_file/name/'.SParserString::idToPath($fileId);
    $document->copy($fileId, $filePath);

    $attachmentNode = $orm->newEntity("BuizEntityAttachment");
    $attachmentNode->vid = $vid;
    $attachmentNode->id_file = $fileNode;

    $attachmentNode = $orm->insert($attachmentNode);

    return $fileNode;

  }//end public function attachDocumentToDataset */

  /**
   * Ein Dokument an einen Datensatz hängen
   * @param BuizFile_Entity $fileNode
   * @param int $vid
   *
   * @throws InternalError_Exception
   */
  public function linkFileToDataset(
    $fileNode,
    $vid
  ) {

    $orm = $this->getOrm();


    $attachmentNode = $orm->newEntity("BuizEntityAttachment");
    $attachmentNode->vid = $vid;
    $attachmentNode->id_file = $fileNode;

    $attachmentNode = $orm->insert($attachmentNode);


  }//end public function attachDocumentToDataset */

  /**
   *
   */
  public function attachFileToDataset()
  {

  }//end public function attachFileToDataset */


} // end class BuizAttachment_Manager

