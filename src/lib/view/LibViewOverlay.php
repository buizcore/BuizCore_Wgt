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
 * @lang de:
 *
 * Basis klasse für alle Maintabs Views
 * @package net.buizcore.wgt
 */
class LibViewOverlay extends LibTemplatePublisher
{
/*////////////////////////////////////////////////////////////////////////////*/
// Public Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de
   * Die HTML id des Tab Elements im Browser
   * @var int
   */
  public $id = null ;

  /**
   * @lang de:
   * Der Inhalt des Title Panels
   * @var string
   */
  public $title = null ;

  /**
   * Die Absoluten Positionen des Overlays
   * @var string
   */
  public $styles = [];

  /**
   * @var string
   */
  public $type = 'overlay';

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
  public function __construct($env = null)
  {

    $this->var = new TDataObject();
    $this->object = new TDataObject();
    $this->url = new TDataObject();
    $this->funcs = new TTrait();

    if ($env)
      $this->env = $env;
    else
      $this->env = BuizCore::getActive();

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
  public function getId()
  {

    // wenn keine id existiert fällt das objekt automatisch auf einen generiert
    // unique id zurück
    if (!is_null($this->id)) {
      return $this->id;
    } else {
        
        return $this->id = 'wgt-overlay-'.uniqid();
    }
      

  }//end public function getId */

  /**
   * Den ID key der view
   *
   */
  public function getIdKey()
  {

    return substr( $this->getId(), 10 );

  }//end public function getIdKey */

  /**
   * Laden einer vorgefertigten Konfiguration für das Modal Element
   *
   * @param string $confKey
   */
  public function loadUiConf($confKey)
  {

  }

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
  * @param string/array $key
  */
  public function addJsItem($key  )
  {

    if (is_array($key)) {
      $this->jsItems = array_merge($this->jsItems, $key);
    } else {
      $this->jsItems[] = $key;
    }

  }//end public function addJsItem */


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


    ///TODO xml entitie replacement auslager
    $title = str_replace(array('&','<','>','"'), array('&amp;','&lt;','&gt;','&quot;'), $this->title);

    if (defined('DEBUG_MARKUP')) {
      ob_start();
      $checkXml = new DOMDocument();

      if ($this instanceof LibTemplateAjax)
        $checkXml->loadHTML($this->compiled);

      $errors = ob_get_contents();
      ob_end_clean();

      // wenn xml fehler dann dumpen
      if ('' !== trim($errors)) {
        $this->getResponse()->addWarning('Invalid XML response');
        SFiles::write(PATH_GW.'log/overlay_xml_errors.html', $errors.'<pre>'.htmlentities("{$content}").'</pre>');
        SFiles::write(PATH_GW.'log/overlay_xml_errors-'.date('Y-md-H-i_s').'.html', $errors.'<pre>'.htmlentities("{$content}").'</pre>');
      }

    }
   
    $styleData = '';
    foreach($this->styles as $posKey => $posData ){
        $styleData .= $posKey.':'.$posData.';';
    }
    
    $id = $this->getId();

    return <<<CODE
      <htmlArea
        selector="body"
        action="append"
        check="#{$id}"
        not="true"
        select_else="#{$id}"
        else="replace" ><![CDATA[
        <div class="wgt-overlay-container" id="{$id}" style="{$styleData}" >
        {$content}
        </div>
     ]]></htmlArea>

CODE;


  }//end public function build */

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

} // end class LibViewOverlay

