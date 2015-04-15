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
class BuizDms_File_Manager extends Manager
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param BuizDms_File_Save_Request $params
   * @return array
   */
  public function uploadFiles($userRqt)
  {

    $orm = $this->getOrm();
    $user = $this->getUser();

    $files = [];

    foreach ( $userRqt->files as /* @var $file LibUploadFile */ $file ) {

      $fileEntity = $this->saveUploadFile($file, $userRqt->folder);
      $fileId = $fileEntity->getId();

      $dmsPath = $this->getDmsFilepath($fileEntity->getId(), $user->mandantId);

      $file->copy($fileId, $dmsPath);

      /* - ct : Content Type
       * - n: name
       * - cs: checksum
       * - s: size in bytes
       * - m: timestamp last modified
       * - c: timestamp created
       */
      $now = time();
      $meta = array(
        'ct' => $fileEntity->mimetype,
        'n' => $fileEntity->name,
        'cs' => $fileEntity->file_hash,
        's' => $fileEntity->file_size,
        'm' => $now,
        'c' => $now,
        'o' => $user->getId(),
      );

      $this->writeFileMetadata($dmsPath.$fileId, $meta);

      $files[] = $fileId;

    }

    return $files;

  }//end public function uploadFiles */

  /**
   * @param LibUploadFile $file
   * @param int $folderId
   */
  protected function saveUploadFile( $file, $folderId )
  {

    $orm = $this->getOrm();

    $entityFile = $orm->newEntity('BuizFile');

    $entityFile->name = $file->getOldname();
    $entityFile->activ = true;
    $entityFile->flag_local = true;
    $entityFile->flag_versioning = false;
    $entityFile->mimetype = $file->getFiletype();
    $entityFile->file_size = $file->getSize();
    $entityFile->file_hash = $file->getChecksum();
    $entityFile->id_folder = $folderId;

    $entityFile = $orm->save($entityFile);

    return $entityFile;


  }//end protected function saveUploadFile */

  /**
   * @param LibUploadFile $file
   * @param int $mandantId
   */
  public function delete($fileId, $mandantId = null)
  {

    $orm = $this->getOrm();
    $user = $this->getUser();

    if ($user->mandantId) {
      $mandantId = $user->mandantId;
    }

    $orm->delete('BuizFile', $fileId);

    if (ctype_digit((string)$fileId)) {
      $fileName = $this->getDmsFilepath($fileId, $mandantId).$fileId;
    } else {
      $fileName = $fileId;
    }

    SFiles::delete($fileName);
    SFiles::delete($fileName.'.meta');


  }//end public function delete */

  /**
   * @param int $fileId
   * @param int $mandatId
   * @param string $basePath
   */
  public function getDmsFilepath($fileId, $mandatId, $basePath = null)
  {

    if (!$basePath)
      $basePath = PATH_UPLOADS.'root/'.$mandatId;

    return $basePath.SParserString::idToDeepPath($fileId);

  }//end public function getDmsFilepath */

  /**
   * @param int $fileId
   * @param boolean $forceDownload
   *
   * @stout
   */
  public function readFile($fileId, $forceDownload = false )
  {

    $user = $this->getUser();

    if ($user->mandantId) {
      $mandantId = $user->mandantId;
    } else {
      /* @var $mdmgr BuizMandant_Manager  */
      $mdmgr = Manager::get('BuizMandant');
      $mandantId = $mdmgr->getDefaultMandant();
    }

    $filePath = $this->getDmsFilepath($fileId, $mandantId);
    $fileName = $filePath.$fileId;

    ///TODO fehlerseite auslagern
    if (!file_exists($fileName)) {
      header("HTTP/1.0 404 Not Found");
      header('Content-Type: text/html');
      echo <<<ERROR
<html>
<head><title>Missing File</title></head>
<body>
<h1>Sorry, can't find this file.</h1>
</body>
</html>
ERROR;
      return;
    }

    $metaData = $this->getFileMetadata($fileName);
    $contentType = $metaData->ct;
    $name = $metaData->n;
    $hash = $metaData->cs;
    $size = $metaData->s;
    $lastMod = $metaData->m;

    header('Content-Type: '.$contentType, true, 200);
    header('Content-Disposition: attachment;filename="'.urlencode($name).'"');
    header('ETag: '.$hash);
    header('Content-Length: '.$size);
    header('Cache-Control: max-age=31622400, must-revalidate'); // ein jahr
    header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastMod).' GMT');

    if ($forceDownload) {
      header("Content-Transfer-Encoding: binary\n");
    }

    readfile($fileName);

  }//end protected function readFile */

  /**
   * @param int $fileId
   * @param int $mandantId required when fileId is just an ID
   * @return array
   */
  public function getFileMetadata($fileId, $mandantId = null)
  {

    if(ctype_digit((string)$fileId)){
      $fileName = $this->getDmsFilepath($fileId, $mandantId).$fileId;
    } else {
      $fileName = $fileId;
    }

    $data = file_get_contents($fileName.'.meta');

    /* - ct : Content Type
     * - n: name
     * - cs: checksum
     * - s: size in bytes
     * - m: timestamp last modified
     * - c: timestamp created
     * - o: id of the creator / owner
     */
    return json_decode($data);

  }//end public function getFileMetadata */

  /**
   * @param int $fileId
   * @param array $metaData
   * @param int $mandantId
   */
  public function writeFileMetadata($fileId, $metaData, $mandantId = null)
  {

    if(ctype_digit((string)$fileId)){
      $fileName = $this->getDmsFilepath($fileId, $mandantId).$fileId;
    } else {
      $fileName = $fileId;
    }

    ///TODO error handling

    SFiles::write($fileName.'.meta', json_encode($metaData));

  }//end public function writeFileMetadata */



} // end class BuizDms_File_Manager

