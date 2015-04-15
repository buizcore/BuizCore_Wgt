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
class LibCodePackerPhp
{
/*////////////////////////////////////////////////////////////////////////////*/
// Public Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @var string
   */
  public $fileName = 'BuizCore';

  /**
   * Enter description here...
   *
   * @var array
   */
  public $files = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Protected Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $commentOpen = false;

  /**
   *
   * @var unknown_type
   */
  protected $ignoreSecCheck = false;

  /**
   * Enter description here...
   *
   * @var resource
   */
  protected $writer = null;

  /**
   * Enter description here...
   *
   * @var resource
   */
  protected $reader = null;

  /**
   *
   * @var unknown_type
   */
  protected $allreadPacked = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param filename $fileName
   * @param files $files
   */
  public function pack($fileName = null, $files = [])
  {
    //return;

    if (!$fileName) {
      $fileName = $this->fileName ;
    }

    if (!$files) {
      $files = $this->files;
    }

    $this->writer = fopen($fileName , 'w');

    fwrite($this->writer , '<?php'.NL , strlen('<?php'.NL));

    foreach ($files as $file) {
      $this->packFromFile($file);
      fwrite($this->writer , NL , strlen(NL));
    }

    fwrite($this->writer , '?>'.NL , strlen('?>'.NL));
    fclose($this->writer);

  }//end public function pack */

  /**
   * Enter description here...
   *
   * @param string $files
   */
  public function setFilesAsClasses($files)
  {

    $classIndex = [];

    $plainClasses = [];
    $childClasses = [];
    $interfaces = [];

    $dependecies = [];

    foreach ($files as $class) {
      $reflector = new LibReflectorClass($class);
      $classIndex[$class] =  $reflector->getFilename();

      if ($reflector->isInterface()) {
        $interfaces[] =  $reflector->getFileName();
      } elseif ($parentClass = $reflector->getParentClass()) {
        $childClasses[$class] =  $reflector->getFilename();
        $dependecies[] = array($class , $parentClass->getName());
      } else {
        $plainClasses[] =  $reflector->getFilename();
      }

    }

    $resolver = new LibDependency($dependecies);
    $resolver->solveDependencies();

    $resolvedDeps = [];
    foreach ($resolver->getCombined() as $dep) {
      $resolvedDeps[] = $classIndex[$dep];
    }

    $fileIndex = [];

    foreach ($interfaces as $file) {
      $fileIndex[] = $file;
    }

    foreach ($plainClasses as $file) {
      $fileIndex[] = $file;
    }

    foreach ($resolvedDeps as $file) {
      if (!in_array($file , $fileIndex  )) {
        $fileIndex[] = $file;
      }
    }

    $this->files = $fileIndex;

  }//end  public function setFilesAsClasses */

  /**
   * Enter description here...
   *
   * @param string $filename
   */
  protected function packFromFile($filename)
  {

    if (!$read = fopen($filename , 'r'  )) {
      Controller::addWarning('Failed to open: '.$filename);

      return;
    }

    $rows = [];

    while (!feof($read)) {
      $row = fgets($read, 4096);
      if (!$this->isComment($row)) {
        if (!$this->ignore($row)) {
          $rows[] = $row;
        }
      }
    }

    /*
    while (!feof($read)) {
      $row = fgets($read, 4096);
      if (!$this->isComment($row)) {
        $rows[] = $row;
      }
    }*/

    // hope to remove <?php and ? >
    array_pop($rows);
    array_shift($rows);

    foreach ($rows as $row) {
      fwrite($this->writer , $row , strlen($row));
    }

    fclose($read);

  }//end protected function packFromFile */

  /**
   *
   */
  protected function isComment($row)
  {

    $row = trim($row);
    $lenght = strlen($row);

    if ($this->commentOpen) {
      if ( substr($row , -2  ) == '*/') {
        $this->commentOpen = false;
      }

      return true;
    } elseif ($lenght == 0) {
      // ignore whitespace
      return true;
    } elseif ($row[0] ==  '#' || $row[0] ==  '*' || substr($row , 0 , 2  ) == '//') {
      // must be a comment
      return true;
    } elseif (substr($row , 0 , 2  ) == '/*') {
      // start a multiline comment
      $this->commentOpen = true;

      return true;
    }

    // everything else is no comment
    return false;

  }//end protected function isComment */

  /**
   * Enter description here...
   *
   * @param unknown_type $row
   * @return unknown
   */
  protected function ignore($row)
  {

    $row = str_replace(' ' , '', trim($row));

    if ($row == 'Debug::addLoc(__LINE__+1);' || $row == 'Debug::addLoc(__LINE__+1);') {
      return true;
    }

    return false;

  }//end protected function ignore */

} // end class LibCodePacker

