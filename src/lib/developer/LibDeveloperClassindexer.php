<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : Buiz Developer Network <contact@buiz.net>
* @project     : Buiz Web Frame Application
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
class LibDeveloperClassindexer
{

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  protected $folder = '';

  /**
   *
   * @var unknown_type
   */
  protected $classIndex = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter
/*////////////////////////////////////////////////////////////////////////////*/

  public function __construct($folder = null)
  {
    $this->folder = $folder;
  }//end public function __construct */

  /**
   * @param string $folder
   * @return void
   */
  public function setFolder($folder)
  {
    $this->folder = $folder;
  }//end public function setFolder */

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
  * Hauptfunktion zum generieren des Baums
  *
  * Diese Funktion generiert die Rootordner und Rootbookmarks der kompletten
  * Bookmarkstruktur.
  * @return string
  */
  public function build()
  {

    $this->genSubTree(new LibFilesystemFolder($this->folder)  );

    return $this->classIndex;

  } //end public function build */

  /**
  * Hauptfunktion zum generieren des Baums
  *
  * Diese Funktion generiert die Rootordner und Rootbookmarks der kompletten
  * Bookmarkstruktur.
  * @var LibFilesystemFolder
  * @return void
  */
  public function genSubTree($fObject)
  {

    foreach ($fObject->getFiles() as $file) {
      $this->classIndex[$file->getPlainFilename()] =
        "PATH_WBF.'". str_replace(PATH_WBF,'',$file->getName(true))."'" ;
    }

    foreach ($fObject->getFolders() as $folder) {
      $this->genSubTree($folder);
    }

  } //end public function genSubTree */

}//end class LibDeveloperClassindexer

