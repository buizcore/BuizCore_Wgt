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
class LibViewMaintab extends LibTemplatePublisher
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
   * Die ID des Tabs
   * @var string
   */
  public $tabId = null ;

  /**
   * Die ID des Tabs
   * @var string
   */
  public $tabCId = null ;
  
  /**
   * @lang de:
   * Das Label welches später im Tab / fürs tabbing verwendet wird
   * @var string
   */
  public $label = null ;

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
   * Flag was mit nicht passenden inhalt passieren soll.
   * Bei Grids brauchen wir z.B Hidden
   * @var string
   */
  public $overflowY = 'hidden';

  /**
   * @var string
   */
  public $type = 'tab';

  /**
   * Key um einen Subtab im Haupttab zu öffnen
   * @var string
   */
  public $subTab = null;

  /**
   * @lang de:
   * Liste mit Buttons die links in der Tab Bar des Maintabs angezeigt werden
   * @var array
   */
  public $buttons = [];

  /**
   * Mask Actions
   * @var array
   */
  public $maskActions = [];

  /**
   * Panel, dass links neben dem close button (auf der rechten seite) platziert wird
   * @var WgtPanelButtonLine
   */
  public $rightPanel = null;

  /**
   * data for bookmarking this tab
   * @var array
   */
  public $bookmark = [];

  /**
   * Suche
   * @var WgtPanelElementSearch
   */
  public $searchElement = null;

  /**
   * Suche
   * @var WgtPanelElementFilter
   */
  public $filterElement = null;

  /**
   * @var WgtControlCrumb
   */
  public $crumbs = null;

  /**
   * @var []
   */
  public $items = [];

  /**
   * Liste mit Sub Controller Boxen,
   * werden rechst von den Buttons angezeigt
   * @var array
   */
  public $subControllBoxes = [];
  
  /**
   * @var string
   */
  public $panelRow2 = null;

  /**
   * Variable zum anhängen von Javascript Code
   * Aller Inline JS Code sollte am Ende der Html Datei stehen
   * Also sollte der Code nicht direkt in den Templates stehen sondern
   * in die View geschrieben werden können, so dass das Templatesystem den Code
   * am Ende der Seite einfach anhängen kann
   * @var string
   */
  protected $jsCode = [];

  /**
   * @var string
   */
  protected $assembledJsCode = null;

  /**
   * @var []
   */
  protected $jsItems = [];

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
    $this->crumbs = new WgtControlCrumb();
    $this->crumbs->style = 'width:97%;min-width:940px;';

    if ($env)
      $this->env = $env;
    else
      $this->env = Webfrap::getActive();
    
    $this->getAcl();
    $this->getI18n();
    $this->getCache();

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
            $this->id = 'wgt-tab-'.uniqid();
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

    return substr( $this->getId(), 8 );

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
   * get the id of the wgt object
   * @param string $label
   * @param int $size
   * @param string $append
   */
  public function setLabel($label, $size = 35, $append = '...')
  {
    $this->label = SParserString::shortLabel($label, $size, $append);

    if(!$this->title){
      $this->title = $this->label;
    }

  }//end public function setLabel */

  /**
   * @param string $tabId
   */
  public function setTabId($tabId)
  {
    $this->tabId = $tabId;
  }//end public function setTabId */

  /**
   * Ein Suchfeld in injecten
   * @param WgtPanelElementSearch $element
   * @return WgtPanelElementSearch
   */
  public function setSearchElement($element)
  {
    $this->searchElement = $element;

    return $element;
  } // end public function setSearchElement */

  /**
   * Ein Suchfeld in injecten
   * @param WgtPanelElementFilter $element
   * @return WgtPanelElementFilter
   */
  public function setFilterElement($element)
  {
    $this->filterElement = $element;

    return $element;
  } // end public function setFilterElement */

  /**
   *
   * @param string $name
   * @param string $button
   * @return void
   */
  public function setBookmark($title, $url, $role = null)
  {

    $this->bookmark = array(
      'title' => $title,
      'url' => $url,
      'role' => $role,
    );

  }//end public function newButton */

  /**
   *
   * @param string $name
   * @param string $button
   * @return WgtButton
   */
  public function addButton($button)
  {
    $this->buttons[$button->name] = $button;

    return $button;
  }//end public function addButton */

  /**
   *
   * @param string $name
   * @param string $button
   * @return WgtButton
   */
  public function newButton($name, $type = null)
  {

    $button = new WgtButton;
    $button->name = $name;

    $this->buttons[$button->name] = $button;

    return $button;

  }//end public function newButton */
  
  
  /**
   * Der Menu Key
   * @param string $menuKey 
   * @param Context $params 
   */
  public function addMenuByKey($menuKey, $params = null)
  {
      
      if(!$params)
          $params = new TArray();
  
      try {
          
          $menu = $this->newMenu(
              $this->id.'_dropmenu',
              $menuKey
          );
          $menu->id = $this->id.'_dropmenu';
          $menu->buildMenu($params);
          
      } catch (WebfrapSys_Exception $exc) {
        
          // TODO was passiert hier?
	  }

  }//end public function addMenuByKey */

  /**
   * @param string $name
   * @param string $type
   *
   * @return WgtDropmenu
   */
  public function newMenu($name, $type = null)
  {

    if ($type) {

      $className = ucfirst($type).'_Maintab_Menu';

      if (!Webfrap::classExists($className)) {
        throw new LibTemplate_Exception('requested nonexisting menu '.$type);
      }

      $button = new $className($this);
    } else {
      $button = new WgtDropmenu($this);
    }

    $button->name = $name;

    // ACLs und die view werden direkt übergeben
    // Bei einer sauberen Implementierung der Architektur werden beide Objekte
    // in ca. 99% der Fälle benötigt (+1% fehlerquote)
    $button->setAcl($this->getAcl());
    $button->setView($this);

    $this->buttons[$button->name] = $button;

    return $button;

  }//end public function newMenu */

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
   *
   * @return string
   */
  public function buildButtons()
  {

    // if empty we need no Buttons
    if (!$this->buttons)
      return '';

    $html = '<div class="buttons left" >';

    foreach ($this->buttons as /* @var $button WgtButton */ $button)
      $html .= $button->buildMaintab();

    $html .= '</div>';

    return $html;

  }//end public function buildButtons */

  /**
   *
   * @return string
   */
  public function renderSubControls()
  {

    // if empty we need no Buttons
    if (!$this->subControllBoxes)
      return '';

    $html = '';

    foreach ($this->subControllBoxes as /* @var $subControl WgtSubControlBox */ $subControl)
      $html .= $subControl->render($this);

    return $html;

  }//end public function renderSubControls */

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
        
        if(!$this->tabCId){
            $this->tabCId = $id.'-acc';
        }
    
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
    
        $buttons = '';
    
        foreach ($this->buttons as /* @var $button WgtButton */ $button)
            $buttons .= $button->buildMaintab();
    
        $maskActions = '';
    
        foreach ($this->maskActions as /* @var $maskAction WgtButton */ $maskAction)
            $maskActions .= $maskAction->buildAction();
    
        /*
         $this->rightPanel = new WgtPanelButtonLine_Dset($this);
        $this->rightPanel->flags->comments = true;
        $this->rightPanel->flags->history = true;
        $this->rightPanel->flags->tags = true;
        $this->rightPanel->flags->messages = true;
        */
    
        if ($this->rightPanel) {
    
            if ($this->var->entity)
                $this->rightPanel->entity = $this->var->entity;
    
            if ($this->rightPanel)
                $maskActions .= $this->rightPanel->render($this);
        }
    
    
        $tabs = '';
    
        $tabTitle = '';
        $tabSearch = '';
        if ($this->title || $this->searchElement) {
            if ($this->title) {
                if ($this->searchElement) {
                    $tabTitle = '<div class="inline third" style="min-width:130px;text-align:center;" >'
                        .'<h2>'.$this->title.'</h2>'
                        .'</div>';
                    $tabSearch = $this->searchElement->render().'<!-- end search element -->';
                } else {
                    $tabTitle = '<div class="inline third" style="min-width:130px;text-align:center;" >'
                        .'<h2>'.$this->title.'</h2></div><!-- end wgt-panel title left -->';
                }
            } else {
                $tabSearch = $this->searchElement->render().'<!-- end wgt-panel left -->';
            }
        }
    
        $buttonClose = '';
        if (!$this->closeCustom) {
            $buttonClose = <<<HTML
          <button
            class="wcm wcm_ui_tip-left wgt-button icon-only wgtac_close"
            tabindex="-1"
            data-tooltip="{$this->i18n->l('Close the active tab','wbf.label')}"  ><i class="fa fa-times" ></i></button>
HTML;
        }

        
        $tabsCode = '';
        
        $active = ' active ';
        foreach( $this->tabs as $tab ){
        
            $srcC = '';
            if($tab->src){
                $srcC = ' data-src="'.$tab->src.'" ';
            }
        
            $tabClass = '';
            if($tab->class){
                $tabClass = ' class="'.$tab->class.' tab" ';
            } else {
                $tabClass = ' class="tab" ';
            }
        
            $tabsCode .= <<<CODE
    <li class="{$active}" ><a data-tab="{$tab->key}" {$tabClass} {$srcC} >{$tab->label}</a></li>

CODE;
            
            $active = '';
        }
        
    $tabIcon = '';
        
    if ($this->icon) {
        $tabIcon = "<i class=\"{$this->icon}\" ></i>";
    }
    
    $singleLineClass = $this->panelRow2 ? ' is-single-line ':'' ;
    $panelRowCode = '';
    $panelTabsCode = '';
    
    if ($this->panelRow2) {
        $panelRowCode = <<<HTML
<div class="wgt-maintab-second-panel" >
    {$this->panelRow2}
</div>   
HTML;
    } else {
        $panelTabsCode = <<<HTML
<ul
    id="{$this->tabCId}"
    data-tab-body="{$this->tabCId}-content"
    class="wcm wcm_ui_tab_head wgt-tab-head bottom-open" >
    {$tabsCode}
</ul>
HTML;
    }
        
    $panel = <<<HTML
<div class="wgt-panel maintab" >
  <div class="wgt-panel crumb"  >
    <div class="left" style="width:96%;min-width:950px;" >
      {$this->crumbs->buildCrumbs()}
    </div>
  </div>
</div>
<div class="wgt-maintab-head">
    <div class="wgt-maintab-label{$singleLineClass}"  >
        <h2>{$tabIcon} {$this->title}</h2>
    </div>
    <div class="wgt-maintab-subtabs-panel{$singleLineClass}" >
        {$panelTabsCode}
        <div class="tab-controls"  >
            {$buttons}
            <div class="right wgt-panel-menu"  style="min-width:400px;" >
              <div class="right wgt-panel-control c-set" >
                {$maskActions}
              </div>
              {$tabSearch}
            </div>
        </div>

    </div>
    
{$panelRowCode}
                  
    <div 
        class="right wgt-panel-menu" 
        style="width:30px;position:absolute;right:10px;top:8px;z-index:10;" >
      {$buttonClose}
    </div>
          
</div>
HTML;
    
    
              $bottom = <<<HTML
    <div class="wgt_footer maintab" >
      footer
    </div>
HTML;
    
      $bottom = '';
    
      ///TODO xml entitie replacement auslager
      $title = str_replace(array('&','<','>','"',"'"), array('&amp;','&lt;','&gt;','&quot;','&#039;'), $this->title);
      $label = str_replace(array('&','<','>','"',"'"), array('&amp;','&lt;','&gt;','&quot;','&#039;'), $this->label);
    
      $this->reportXMLErrors($panel, $content, $bottom);
    
      $subTab = '';
    
      if ($this->subTab) {
          $subTab = ' sub_tab="'.$this->subTab.'" ';
      }
    
      return <<<CODE
    
    <tab id="{$id}" label="{$label}" title="{$title}" {$closeAble} {$subTab} >
      <body><![CDATA[{$panel}<section class="wgt-content maintab p1" style="overflow-y:{$this->overflowY};" ><div class="wrapper" >{$content}</div><div class="do-clear" > </div></section>{$bottom}]]></body>
      {$jsCode}
    </tab>
    
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

} // end class LibViewMaintab

