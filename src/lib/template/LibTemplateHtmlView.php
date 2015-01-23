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
class LibTemplateHtmlView extends LibTemplate
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * what type of view ist this object, html, ajax, document...
   * @var string
   */
  public $type = 'html';

/*////////////////////////////////////////////////////////////////////////////*/
// not implemented check
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * de:
   * Der Konstruktor initialisier die View mit dem minimal notwendigen
   * Resourcen zum arbeiten
   *
   * @param array $conf der Konfigurationsabschnitt der View aus der Conf File
   * @param Base $env Die Aktive Environment für die View
   */
  public function __construct($conf = array(), $env = null)
  {

    $this->var = new TDataObject();
    $this->object = new TDataObject();
    $this->area = new TDataObject();
    $this->funcs = new TTrait();

    $this->tplConf = $conf;

    if (!$env) {
      $env = BuizCore::getActive();
    }

    $this->env = $env;
    $this->getI18n();
    $this->getAcl();
    $this->getCache();

    $this->getTplEngine();
    $this->init();

  }// end public function __construct */

  /**
   * Init methode die immer ausgeführt wird
   */
  public function init()
  {

  }//end public function init */

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
   * @param array $vars
   */
  public function newArea($key, $type = null)
  {
    return $this->tplEngine->newArea($key, $type);
  }//end public function newArea */

  /**
   *
   * @param string $jsonData
   * @param string $type
   */
  public function setReturnData($jsonData, $type  )
  {

    $this->tplEngine->setReturnData($jsonData, $type  );

  }//end public function setReturnData */

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
  public function compile() {}

  /**
   *
   * @return void
   */
  public function publish() {}

  /**
   *
   */
  protected function buildMessages() {}

} // end class LibTemplateDocument

