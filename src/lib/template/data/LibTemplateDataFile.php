<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * Data Container für Files die über das Templatesystem verschickt werden
 * @package net.webfrap.wgt
 *
 */
class LibTemplateDataFile
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der Name der zu ladenten Datei
   * @param string
   */
  public $name = null ;

  /**
   * Der Pfad der zu ladenten Datei
   * @param string
   */
  public $path = null;

  /**
   * Mimetype / Contenttype der Datei
   * @param string
   */
  public $type = null;

  /**
   * wenn tmp true ist wird die datei nach dem download gelöscht
   * @param boolean
   */
  public $tmp = false;

  /**
   * wenn tmp auf true ist und in tmpFolder ein valider Pfad vorhanden ist
   * wird der komplette pfad in tmpFolder gelöscht
   *
   * @param string
   */
  public $tmpFolder = null;

  /**
   *
   * @param string
   */
  public $compress = true;

  /**
   * Der Inhalt der Datei
   * @param string
   */
  public $content = true;

/*////////////////////////////////////////////////////////////////////////////*/
// Advanced setter logic
/*////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @return int
   */
  public function getLength()
  {
  
    if ($this->content) {
        return strlen($this->content);
    } else {
        return filesize($this->path);
    }
  
  }//end public function getLength */
  
  /**
   * @return string
   */
  public function getETag()
  {
  
      if ($this->content) {
          return md5($this->content);
      } else {
          return md5_file($this->path);
      }
  
  }//end public function getETag */

  /**
   * Setzen eines Dateinamens als Download Quelle
   *
   * @param string $fileName
   */
  public function setSource($fileName)
  {

    $tmp = explode('/', $fileName  );
    $this->name = $fileName;

    array_pop($tmp);

    $this->path = implode('/', $tmp  );

  }//end public function setSource */

  /**
   * Templatesystem soll den ganzen temporären pfad löschen
   */
  public function dropFolder()
  {

    // wenn kein tmpPfad übergeben wurde wird automatisch der standard pfad
    // als tmpFolder definiert
    $this->tmpFolder = $this->path;

  }//end public function dropFolder */

}//end class LibTemplateDataFile */

