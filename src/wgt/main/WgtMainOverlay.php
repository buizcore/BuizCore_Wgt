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
 * @lang de:
 *
 * Basis klasse für alle Maintabs Views
 *
 *
 * @package net.webfrap.wgt
 */
class WgtMainOverlay extends LibTemplatePublisher
{
/*////////////////////////////////////////////////////////////////////////////*/
// Public Attributes
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   * @lang de
   * Die HTML id des Tab Elements im Browser
   * @var int
   */
  public $id = null;
  
  /**
   * @lang de:
   * Der Inhalt des Title Panels
   * @var string
   */
  public $title = null ;

  /**
   * @lang de:
   * Kann das Tab Element vom User in Client später geschlossen werden
   * @var boolean
   */
  public $closeable = true ;

  /**
   * Wenn true wird der close button rechts oben nicht mit generiert
   * @var boolean
   */
  public $closeCustom = false;

  /**
   * Variable zum anhängen von Javascript Code
   * Aller Inline JS Code sollte am Ende der Html Datei stehen
   * Also sollte der Code nicht direkt in den Templates stehen sondern
   * in die View geschrieben werden können, so dass das Templatesystem den Code
   * am Ende der Seite einfach anhängen kann
   * @var string
   */
  protected $jsCode = array();

  /**
   * @var string
   */
  protected $assembledJsCode = null;

  /**
   * @var array
   */
  protected $jsItems = array();

/*////////////////////////////////////////////////////////////////////////////*/
// Constructors and Magic Functions
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct($name, $env = null)
  {

    $this->name = $name;

    $this->var = new TDataObject();
    $this->object = new TDataObject();
    $this->url = new TDataObject();
    $this->funcs = new TTrait();

    if ($env)
      $this->env = $env;
    else
      $this->env = Webfrap::getActive();

    // overwriteable empty init method
    $this->init();

  }//end public function __construct */

  /**
   * the to string method
   * @return string
   */
  public function __toString()
  {
    return $this->build();
  }// end public function __toString */

/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * get the id of the wgt object
   *
   */
  public function getId($check = false)
  {

    // wenn keine id existiert fällt das objekt automatisch auf einen generiert
    // unique id zurück
    if (is_null($this->id)){

        if(!$check){
            $this->id = 'wgt-overlay-'.uniqid();
        }
    }
   
    return $this->id;

  }//end public function getId */
  
  public function setId( $id )
  {
      $this->id = $id;
  }//end public function setId */

  /**
   * Den ID key der view
   *
   */
  public function getIdKey()
  {

    return substr( $this->getId(), 11 );

  }//end public function getIdKey */

  /**
   * setzen des HTML Titels
   * @param string $title Titel Der in der HTML Seite zu zeigende Titel
   * @param int $size
   * @param string $append
   * @return void
   */
  public function setTitle($title, $size = 75, $append = '...')
  {
    $this->title = SParserString::shortLabel($title, $size, $append);
  } // end public function setTitle */


  /**
   * @param string $tabId
   */
  public function setTabId($tabId)
  {
    $this->tabId = $tabId;
  }//end public function setTabId */



  /**
  * @param string/array $key
  */
  public function addJsItem($key)
  {

    if (is_array($key)) {
      $this->jsItems = array_merge($this->jsItems, $key);
    } else {
      $this->jsItems[] = $key;
    }

  }//end public function addJsItem */



  /**
   * @param string $name
   * @param string $code
   */
  public function addEvent($name, $code)
  {

  }//end public function addEvent */


/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /** the buildr method
   * @return string
   */
  public function build()
  {

    $id = $this->getId();

    $content = $this->includeTemplate($this->template);

    $jsCode = '';
    if ($this->jsCode) {

      $this->assembledJsCode = '';

      foreach ($this->jsCode as $jsCode) {
        if (is_object($jsCode))
          $this->assembledJsCode .= $jsCode->getJsCode();
        else
          $this->assembledJsCode .= $jsCode;
      }

      $jsCode = '<script><![CDATA['.NL.$this->assembledJsCode.']]></script>'.NL;
    }

    $closeAble = $this->closeable?' closeable="true" ':'';


    ///TODO xml entitie replacement auslager
    $title = str_replace(array('&','<','>','"',"'"), array('&amp;','&lt;','&gt;','&quot;','&#039;'), $this->title);

    $this->reportXMLErrors('', $content, '');

    return <<<CODE

    <overlay id="{$id}" title="{$title}" {$closeAble} >
      <body><![CDATA[<section id="wgt-main-overlay"  >{$content}</section>]]></body>
      {$jsCode}
    </overlay>

CODE;

//<body><![CDATA[{$panel}<div class="wgt-content maintab" ><div class="body" >{$content}</div></div>]]></body>

  }//end public function build */

  /**
   *
   * @param string $panel
   * @param string $content
   * @param string $bottom
   */
  protected function reportXMLErrors($panel, $content, $bottom)
  {
      if (DEBUG) {
          ob_start();
          $checkXml = new DOMDocument();
  
          if ($this instanceof LibTemplateAjax)
              $checkXml->loadHTML($this->compiled);
  
          $errors = ob_get_contents();
          ob_end_clean();
  
          if ('' !== trim($errors)) {
  
              $this->getResponse()->addWarning('Invalid XML Response');
  
              SFiles::write(
              PATH_GW.'log/maintab_xml_errors.html',
              $errors.'<pre>'.htmlentities("{$panel}<div class=\"wgt-content maintab\" >{$content}</div>{$bottom}").'</pre>'
                  );
              SFiles::write(
              PATH_GW.'log/maintab_xml_errors_'.date('Y-md-H-i_s').'.html',
              $errors.'<pre>'.htmlentities("{$panel}<div class=\"wgt-content maintab\" >{$content}</div>{$bottom}").'</pre>'
                  );
          }
      }
  }
  
/*////////////////////////////////////////////////////////////////////////////*/
// emppty default methodes, more or less optional
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return void
   */
  public function compile() {}

  /**
   *
   * @return void
   */
  public function init() {}

  /**
   *
   * @return void
   */
  public function publish() {}

  /**
   *
   */
  protected function buildMessages() {}

} // end class WgtMainOverlay

