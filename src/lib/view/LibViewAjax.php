<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH
* @project     : BuizCore - The Business Core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * empty implementation
 * @package net.buizcore.wgt
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class LibViewAjax extends LibTemplate
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * what type of view ist this object, html, ajax, document...
   * @var string
   */
  public $type = 'plain';

  /**
   * serialized json data
   * @var string
   */
  public $jsonData = null;

  /**
   * @var string
   */
  public $returnType = 'json';

/*////////////////////////////////////////////////////////////////////////////*/
// not implemented check
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * de:
   * methode zum abfagen von nicht implementierted display aufrufen
   *
   * @param $name
   * @param $values
   * /
  public function __call($name, $values)
  {

    if ('display' == substr($name, 0,7))
      throw new LibTemplateNoService_Exception("$name is not implemented");

    throw new LibTemplate_Exception("You Tried to Call non existing Method: ".__CLASS__."::{$name}");

  }//end public function __call */

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $jsCode
   */
  public function addJsCode($jsCode)
  {
    $this->tplEngine->addJsCode($jsCode);
  }//end public function addJsCode */

  /**
   * @param string $index
   */
  public function setIndex($index = 'default')
  {
    $this->tplEngine->setIndex($index);
  }//end public function setIndex */

  /**
   * @param string $template
   * @param boolean $inCode
   */
  public function setTemplate($template, $inCode = false)
  {
    $this->tplEngine->setTemplate($template, $inCode);
  }//end public function setTemplate */

  /**
   * @param string $key
   * @param mixed $data
   */
  public function addVar($key, $data = null)
  {
    $this->tplEngine->addVar($key, $data);
  }//end public function addVar */

  /**
   * @param array $vars
   */
  public function addVars($vars)
  {
    $this->tplEngine->addVars($vars);
  }//end public function addVars */

  /**
   * @param string $key
   * @param LibTemplateAreaView $area
   */
  public function newArea($key, $area = null)
  {
    return $this->tplEngine->newArea($key, $area);
  }//end public function newArea */

  /**
   * @param string $key
   * @param string $content
   * @return LibTemplatePhp
   */
  public function setArea($key , $content)
  {

    $this->tplEngine->setArea($key , $content);

  }//end public function setArea */

  /**
   * @param array $key
   * @param array $type
   * @return LibTemplatePhp
   */
  public function setAreaContent($key, $type = null)
  {
    return $this->tplEngine->setAreaContent($key, $type);
  }//end public function setAreaContent */

  /**
   * @param string $key
   * @return LibTemplate
   */
  public function getArea($key)
  {
  
      return $this->tplEngine->getArea($key);
  
  } // end public function getArea  */

  /**
   * @param string $key
   * @param string $content
   */
  public function setPageFragment($key, $content)
  {
      $this->tplEngine->setPageFragment($key, $content);
  }//end public function setPageFragment */
  
  /**
   *
   * @param string $jsonData
   * @param string $type
   */
  public function setReturnData($jsonData, $type)
  {

    $this->tplEngine->setReturnData($jsonData, $type);

  }//end public function setReturnData */
  
  /**
   *
   * @param string $jsonData
   * @param string $type
   */
  public function setJsonData($jsonData)
  {

    $this->tplEngine->setJsonData($jsonData);

  }//end public function setReturnData */
  
  /**
   *
   * @param string $jsonData
   * @param string $type
   */
  public function setRawJsonData($jsonData)
  {

    $this->tplEngine->setRawJsonData($jsonData);

  }//end public function setRawJsonData */

/*////////////////////////////////////////////////////////////////////////////*/
//
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * de:
   * loadUi muss überschrieben werden, da die ajax view nur eine hilfsklasse
   * dür das Templatesystem ist.
   * Die UI Klassen müssen daher dem aktive AJAX Templae Element zugewiesen werden
   *
   * @see LibTemplate::loadUi
   *
   * @param string $uiName
   * @return Ui ein UI Container
   * @throws LibTemplate_Exception
   */
  public function loadUi($uiName)
  {
    return $this->tplEngine->loadUi($uiName);

  }//end public function loadUi */

  /**
   *
   * @return void
   */
  public function build() { return ''; }

  /**
   *
   * @return void
   */
  public function compile() {}

  /**
   *
   */
  protected function buildMessages() {}

} // end class LibViewAjax

