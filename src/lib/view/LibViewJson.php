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
 * @package net.buizcore.wgt
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class LibViewJson extends LibTemplate
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
   *
   * @param array $data
   */
  public function setDataBody($data)
  {
      $this->tpl->setDataBody($data);
  }//end public function setDataBody */
  
  /**
   * @param string $jsonData
   */
  public function setJsonData($jsonData)
  {
  
      $this->tpl->setDataBody(json_decode($jsonData));
  
  }//end public function setJsonData */
  
  /**
   * @param string $jsonData
   */
  public function setRawJsonData($jsonData)
  {

      $this->tpl->setDataBody($jsonData);
  
  }//end public function setRawJsonData */
  
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
    return $this->tpl->loadUi($uiName);

  }//end public function loadUi */

  /**
   * @param array $data
   * @param Context $params
   */
  public function displayData($data, $params = null)
  {
  
      $this->setDataBody($data);
  
  }//end public function displayData */
  
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

} // end class LibViewJson

