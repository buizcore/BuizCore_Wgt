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
class LibTemplateHtml extends LibTemplatePublisher
{

    /**
    * array with ajax javascript code
    * this code will be executed per eval on the client
    * no eval is not evil, it definitly doens't care anymore if i execute
    * this code with eval, or the code will be executed as i write it somewhere
    * in the browser
    *
    * @var array
    */
    public $ajaxActions = [];
    
    /**
    * @var string
    */
    public $type = 'html';
    
    /**
    * @var string
    */
    public $keyCss = null;
    
    /**
    * @var string
    */
    public $keyTheme = null;
    
    /**
    * @var string
    */
    public $keyJs = null;
    
    /**
    * @var string
    */
    public $output = '';
    
    /**
    * flag ob die template engine html/head|body etc mitgenerieren soll oder ob
    * der content seinen eigene sceleton mitbringt
    * @var boolean
    */
    public $renderPlain = false;
    
    /**
     * Die Meta Description für die Seite
     * @var string
     */
    public $metaDesc = null;
    
    /**
    *
    * @var array
    */
    protected $jsItems = [];
    
    /**
    * doctype of the page
    * @var string
    */
    protected $doctype = null;
    
    /**
    * @var array
    */
    protected $defMetas = true;
    
    /**
    * @var array
    */
    protected $metas = [];
    
    /**
    * Flag ob die Ausgabe Gzip komprimiert wurde
    * @var boolean
    */
    public $compressed = false;
    
    /**
    * @var array
    */
    protected $fileJs = [];
    
    /**
    * dynamic generated js files
    * @var array
    */
    protected $dynJs = [];
    
    /**
    * @var string
    */
    protected $assembledJsCode = null;
    
    /**
    * zusätzliche einzelne CSS Dateien einbinden
    * diese dateien werden direkt über einen absoluten pfade eingebunden
    * und nicht über den minimizer
    * @var array
    */
    protected $fileStyles = [];
    
    /**
    * Liste mit themedateien die über theme.php eingebunden werden sollen
    * @var array
    */
    protected $themesLists = [];
    
    /**
    * Liste mit Css Dateien die über css.php eingebunden werden sollen
    * @var array
    */
    protected $cssLists = [];
    
    /**
    * Liste mit Js Dateien die über js.php eingebunden werden sollen
    * @var array
    */
    protected $jsLists = [];
    
    
    /**
    * @var array
    */
    protected $embeddedStyles = [];
    
    /**
    * @var array
    */
    protected $rssFeed = [];
    
    /**
    * @var int
    */
    protected $httpStatus = '200';
    
    /**
    * @var array
    */
    protected $urlIcon = null;
    
    /**
    * resource address for a window that should be open
    * @var string
    */
    protected $openWindow = null;
    
    /**
    * wall message
    * @var string
    */
    protected $wallMessage = null;
    
    /**
    * Soll die Debug Console ausgegeben werden können?
    * @var boolean
    */
    public $debugConsole = true;
    
    /**
    * implement me
    * @var string
    */
    public $csrfToken = 'm2h34kdqwPd96k2pu5ma1kta';
    
    /**
    * Eine Renderobjekt welches beliebige manipulationen am inhalt der Seite vornehmen kann
    * wird vor allem beim cms benötigt
    * @var 
    */
    public $cmsRenderer = null;
    
    /**
     * Eine Renderobjekt welches beliebige manipulationen am inhalt der Seite vornehmen kann
     * wird vor allem beim cms benötigt
     * @var
     */
    public $cmsCompilers = [];

/*////////////////////////////////////////////////////////////////////////////*/
// magic methodes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * the contstructor
    * @param array $conf the configuration loaded from the conf
    */
    public function __construct($conf = [])
    {
    
        // Wenn es keinen neuen gibt bleibt alles beim alten
        $this->contentType = isset($conf['contentType'])
            ? $conf['contentType']
            : $this->contentType;
        
        parent::__construct($conf);
    
    }// end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter Methodes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * Methode zum deaktivieren bzw aktivieren der Defaultmetas
    *
    * @param bool $Aktiv Sollen die Defaultmetas ausgegeben werden
    * @return void
    */
    public function setDefaultMetas($activ = false)
    {
        $this->defMetas = $activ;
    } // end public function setDefaultMetas($activ = false)


    /**
    * Neuen Metatag hinzufügen
    * @param string Content Inhalt der Metadaten falls vorhanden
    * @return
    */
    public function addMeta(array $content)
    {
    
        $metaContent = '';
        foreach($content as $key => $value){
            $metaContent .= ' '.$key.'="'.addslashes($value).'"';
        }
        
        $this->metas[] = '<meta '.$metaContent.' />'.NL;
        
    } // end public function addMeta */
    
   /**
    * Funktion zum hinzufügen von Metadaten in die Seite
    *
    * @return
    */
    public function addDefaultMetas()
    {
    
        $session = $this->getSession();
        
        $contentTyp = $this->tplConf['contenttype'];
        $charset = $this->tplConf['charset'];
        $language = $session->getStatus('activ_lang');
        $generator = $session->getStatus('sys_generator');
        
        $metas = '<meta http-equiv="content-type" content="'.$contentTyp.'; charset='.$charset.'" />'.NL;
        $metas .= '<meta http-equiv="content-script-type" content="application/javascript" />'.NL;
        $metas .= '<meta http-equiv="content-style-type" content="text/css" />'.NL;
        $metas .= '<meta http-equiv="content-language" content="'.$language.'" />'.NL;
        $metas .= '<meta name="generator" content="'.$generator.'" />'.NL;
        
        // ms header
        $metas .= '<meta http-equiv="X-UA-Compatible" value="IE=edge" />'.NL;
        $metas .= '<meta name="msapplication-config" content="none"/>'.NL;
        $metas .= '<link rel="shortcut icon" href="./static/images/logo/favicon.ico" type="image/vnd.microsoft.icon" />'.NL;
        
        if ($this->metaDesc) {

            $metas .= '<meta name="description" content="'.$this->metaDesc.'" />'.NL;
        }
        
        return $metas;
    
    } //end public function addDefaultMetas  */
    
   /**
    * Hinzufügen einer JS Datei die als Datei in die Seite eingebunden wird
    *
    * @param string $name Name der Js Datei die eingebunden werden soll
    * @return void
    */
    public function addJsFile($name)
    {
        $this->fileJs[$name] = $name;
    } // end public function addJsFile */

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
 
   /**
    * @param string $jsCode
    * @return void
    */
    public function addJsCode($jsCode)
    {
        $this->jsCode[] = $jsCode;
    }//end public function addJsCode */

   /**
    * path to a css file to embed
    *
    * @param string Name Name der CSS Datei die eingebunden werden soll
    * @return void
    */
    public function addCssFile($name)
    {
        $this->fileStyles[] = $name;
    } // end public function addCssFile */

  /**
   * Hinzufügen einer JS Liste
   *
   * @param string $name key der einzubindenten Js Liste
   * @return void
   */
  public function addJsList($name)
  {
    $this->jsLists[$name] = $name;
  } // end public function addJsList */

  /**
   * Hinzufügen einer Theme Liste
   *
   * @param string $name key der einzubindenten Theme Liste
   * @return void
   */
  public function addThemeList($name)
  {
    $this->themesLists[$name] = $name;
  } // end public function addThemeList */

  /**
   * Hinzufügen einer Css Liste
   *
   * @param string $name key der einzubindenten Css Liste
   * @return void
   */
  public function addCssList($name)
  {
    $this->cssLists[$name] = $name;
  } // end public function addCssList */

  /**
   * add a news feed
   *
   * @param string Url eines Rss Feed
   * @return void
   */
  public function addNewsfeed($url)
  {
    $this->rssFeed[] = $url;
  } // end public function addNewsfeed */


  /**
   * @param string $title ErrorTitle
   * @param string $message ErrorMessage
   * @param int $errorCode ErrorCode
   * @return void
   */
  public function setErrorPage($title , $message , $httpCode = 500)
  {

    $this->setTemplate('error/message');
    $this->var->content['errorTitle'] = $title;
    $this->var->content['errorMessage'] = $message;
    ///TODO implement Http Error Codes

  }//end public function setErrorPage */


  /**
   * set the html content
   *
   * @param string $html
   * @return void
   */
  public function setHtml($html)
  {
    $this->compiled = $html;
  }//end public function setHtml */

  /**
   * request an icon
   * @return string
   */
  public function icon($name , $alt)
  {
    return Wgt::icon($name,'xsmall',$alt);
  }//end public function icon */

  /**
   *
   * @param $status
   */
  public function setHttpStatus($status)
  {
    $this->httpStatus = $status;
  }//end public function setHttpStatus */

  /**
   *
   * @param $status
   */
  public function openWindow($resource)
  {
    $this->openWindow = $resource;
  }//end public function openWindow */

  /**
   *
   * @param string $message
   */
  public function setWallMessage($message)
  {
    $this->wallMessage = $message;
  }//end public function setWallMessage */


/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function buildBody()
  {

    if (is_null($this->subView)) {
      Log::warn('NO SUBVIEW!!!!');
    }

    if ($this->subView && 'page' == $this->subView->type) {
      $this->assembledBody = $this->subView->buildBody();

      return $this->assembledBody;
    }

    if (!empty($this->assembledMainContent) && !$this->indexTemplate) {
      $this->assembledBody = $this->assembledMainContent;

      return $this->assembledBody;
    }

    if ($this->assembledBody)
      return $this->assembledBody;

    if ($filename = $this->templatePath($this->indexTemplate , 'index')) {

      $VAR = $this->var;
      $ITEM = $this->object;
      $ELEMENT = $this->object;
      $AREA = $this->area;
      $FUNC = $this->funcs;
      $CONDITION = $this->condition;

      $MESSAGES = $this->buildMessages();
      $TEMPLATE = $this->template;
      $CONTENT = $this->assembledMainContent;

      $JS_CODE = null;
      if ($this->jsCode) {

        $this->assembledJsCode = '';

        foreach ($this->jsCode as $jsCode) {
          if (is_object($jsCode))
            $this->assembledJsCode .= $jsCode->getJscode();
          else
            $this->assembledJsCode .= $jsCode;
        }

        $JS_CODE = $this->assembledJsCode;
      }

      $I18N = $this->i18n;
      $user = $this->user;
      $CONF = $this->getConf();

      if (Log::$levelVerbose)
        Log::verbose("Load Index Template: $filename ");

      ob_start();
      include $filename;
      $content = ob_get_contents();
      ob_end_clean();

    } else {

      Error::report('Index Template does not exist: '.$this->indexTemplate);

      
      $trace = Debug::backtrace(false);
      
      ///TODO add some good error handler here
      if (Log::$levelDebug)
        $content = '<p class="wgt-box error">Wrong Index Template: '.$this->indexTemplate.' ('.$filename.')  </p><pre>'.$trace.'</pre>';
      else
        $content = '<p class="wgt-box error">Wrong Index Template '.$this->indexTemplate.' </p>';

    }

    $this->assembledBody .= $content;

    return $this->assembledBody;

  }//end public function buildBody */

  /**
   * Ausgabe Komprimieren
   */
  public function compress()
  {

    $this->compressed = true;
    $this->output = gzencode($this->output);

  }//end public function compress */

  /**
   * ETag für den Content berechnen
   * @return string
   */
  public function getETag()
  {
    return md5($this->output);
  }//end public function getETag */

  /**
   * Länge des Contents berechnen
   * @return int
   */
  public function getLength()
  {

    if ($this->compressed)
      return strlen($this->output);
    else
      return mb_strlen($this->output);

  }//end public function getLength */

  /**
   * flush the page
   *
   * @return void
   */
  public function compile()
  {

    $this->buildPage();

    if (defined('DEBUG_MARKUP') && DEBUG_MARKUP) {
      ob_start();
      $checkXml = new DOMDocument();

      if ($this instanceof LibTemplateAjax)
        $checkXml->loadXML($this->compiled);
      else
        $checkXml->loadHTML($this->compiled);

      $errors = ob_get_contents();
      ob_end_clean();

      // nur im fehlerfall loggen
      if ('' !== trim($errors)) {

        $this->getResponse()->addWarning('Invalid XML response');

        SFiles::write(PATH_GW.'log/tpl_xml_errors.html', $errors.'<pre>'.htmlentities($this->compiled).'</pre>');
        SFiles::write(PATH_GW.'log/tpl_xml_errors_'.date('Y-md-H-i_s').'.html', $errors.'<pre>'.htmlentities($this->compiled).'</pre>');
      }
    }

    if ($this->keyCachePage) {
      $this->writeCachedPage($this->keyCachePage , $this->compiled);
    }

    $this->output = $this->compiled;


  }//end public function compile */

  /**
   * flush the page
   *
   * @return void
   */
  public function build()
  {

    $this->buildPage();

    return $this->compiled;

  }//end public function build */

  /**
   *
   * @return void
   */
  public function publish()
  {
    //View::$blockHeader = true;
    //echo $this->compiled;
  }

 /**
   * @param string $errorMessage
   */
  public function publishError($errorTitle, $errorMessage = null)
  {

    $user = $this->getUser();

    if (! $this->compiled) {
      if (!$contentTyp = $this->tplConf['contenttype'])
        $contentTyp = 'text/html';

      if (!$charset = $this->tplConf['charset'])
        $charset = 'utf-8';

      $this->getResponse()->sendHeader('Content-Type:'.$contentTyp.'; charset='.$charset);
    }


    $this->object = [];

    $this->setIndex('error');
    $this->setTemplate('error/message');


    if (Log::$levelDebug)
      $message = $errorMessage;
    else
      $message = 'An Error Occured';


    $this->addVar(array(
      'errorMessage' => $errorMessage,
      'errorTitle' => $errorTitle,
    ));

    $this->compile();

    View::$blockHeader = true;
    echo $this->compiled;

  }//end public function publishError */

/*////////////////////////////////////////////////////////////////////////////*/
// Parser Functions
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * Einfaches bauen der Seite ohne Caching oder sonstige Rücksicht auf
    * Verluste
    *
    * @return void
    */
    public function buildPage()
    {
    
      
        if (trim($this->compiled) == '') {
            if ($this->cmsRenderer) {
                $this->compiled = $this->cmsRenderer->render();
            }
        }

        if (trim($this->compiled) != '' && $this->cmsCompilers) {
            foreach($this->cmsCompilers as $compiler){
                $this->compiled = $compiler->compile($this->compiled);
            }
        }
        
        if (trim($this->compiled)  != '' ){
            return;
        }


        // Parsing Data
        try {
            $this->buildBody();
        } catch (Exception $e) {
        
            $content = ob_get_contents();
            ob_end_clean();
            
            $this->assembledBody = '<h2>'.$e->getMessage().'</h2><pre>'.$e.'</pre>';
        }
        
        if ($this->renderPlain) {
            $this->compiled = $this->assembledBody;
            return;
        }

    $this->assembledMessages = $this->buildMessages();

    $this->compiled = <<<HTML
<!DOCTYPE html>
<!--[if lt IE 8 ]><html class="ie crap" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"  > <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" lang="en"  > <![endif]-->
<!--[if !(IE)]><!--><html lang="en"  > <!--<![endif]-->
<head>
<!-- get ie > 9 -->
<!--[if !IE]><!--><script>
if (/*@cc_on!@*/false) {
    document.documentElement.className+=' ie iemodern';
}
</script><!--<![endif]-->

HTML;

    // Den Titel auslesen oder generieren
    if (!is_null($this->title)) {
      $title = $this->title;
    } else {
      $title = Session::status('default_title');
    }

    $this->compiled .= '<title>'.$title.'</title>'.NL;
    
    if ($this->scope && isset($this->scopeData['base'])) {
    
        $bTarget = '';
        if (isset($this->scopeData['kill_frame']) || isset($this->tplConf['kill_frame']))
            $bTarget = ' target="_top" ';
    
        $this->compiled .= '<base href="'.$this->scopeData['base'].'"  '.$bTarget.' />'.NL;
    } else if (isset($this->tplConf['base'])  ) {
    
        $bTarget = '';
        if (isset($this->tplConf['kill_frame']))
            $bTarget = ' target="_top" ';
    
        $this->compiled .= '<base href="'.$this->tplConf['base'].'" '.$bTarget.' />'.NL;
    } else {
    
        if (isset($this->tplConf['kill_frame']))
            $this->compiled .= '<base target="_top" />'.NL;
    }

    // Testen ob die Defaultmetas gesetzt werden sollen
    if ($this->defMetas)
      $this->compiled .= $this->addDefaultMetas();

    $this->compiled .= <<<HTML
  <meta content="{$this->csrfToken}" name="csrf-token" id="wgt-csrf-token" />

HTML;

    $this->compiled .= implode('', $this->metas);

    $wgt = WEB_WGT;

    if ($this->scope && isset($this->scopeData['css'])) {

      foreach ($this->scopeData['css'] as $css) {
        $this->compiled .= <<<HTML
<link type="text/css" href="{$css}" rel="stylesheet" />

HTML;
      }
    }

    // Einbinden von eventuel embeded styles
    if ($this->embeddedStyles) {
      $this->compiled .= '<style type="text/css" >'.NL;
      $this->compiled .= implode('',$this->embeddedStyles);
      $this->compiled .= '</style>'.NL;
    }

    // Hinzufügen von Newsfeed Angaben
    foreach ($this->rssFeed as $feed)
      $this->compiled .= '<link rel="alternate" type="application rss+xml" title="'.$feed['title'].'" href="'.$feed['url'].'" />'.NL;

    // Setzen des Urlicons
    if ($this->urlIcon)
      $this->compiled .= '<link rel="shortcut icon" href="'.$this->urlIcon.'" type="image/x-icon" />'.NL;

    // Verhindern das die Seite in einem Framset geladen werden kann.


    $this->compiled .= '</head>'.NL;
    $this->compiled .= '<body>'.NL;

    $this->compiled .= $this->assembledBody.NL;

    // debug Output anhängen
    if (DEBUG_CONSOLE && $this->debugConsole)
      $this->compiled .= $this->debugConsole(DEBUG_CONSOLE);

    if ($this->scope && isset($this->scopeData['css'])) {

      foreach ($this->scopeData['javascript'] as $js) {
        $this->compiled .= <<<HTML
<script src="{$js}" ></script>

HTML;
      }
    }

    // platzieren des Javascript Codes
    if ($this->jsCode) {

      $this->assembledJsCode = '';

      foreach ($this->jsCode as $jsCode) {

        if (is_object($jsCode)) {
          $this->assembledJsCode .= $jsCode->getJsCode();
        } else {
            
            
          if ('<script' == substr(trim($jsCode), 0, 7)) {
              $this->assembledJsCode .= '</script>'.$jsCode.'<script type="application/javascript" >';
          } else {
              $this->assembledJsCode .= $jsCode;
          }
            
        }
      }

      $this->compiled .= '<script type="application/javascript" >'.NL.$this->assembledJsCode.'</script>'.NL;
    }

    if ($this->openWindow)
      $this->compiled .= <<<CODE
<script type="application/javascript"  >\$S(document).ready(function() {\$R.get('{$this->openWindow}');});</script>
CODE;

    $this->compiled .= '</body>'.NL;
    $this->compiled .= '</html>';

  } // end public function buildPage */

  /**
   * @param string $type
   * @return string
   */
  public function debugConsole($type = null)
  {

    $console = new WgtDebugConsole();

    return $console->build($type);

  }//end public function debugConsole */

  /**
   * bauen bzw generieren der System und der Fehlermeldungen
   *
   * @return
   */
  protected function buildMessages()
  {

    $messageObject = Message::getActive();

    $html = '';

    // Gibet Fehlermeldungen? Wenn ja dann Raus mit
    if ($errors = $messageObject->getErrors()) {

      $html .= '<div id="wgt-box_error" class="wgt-box error">'.NL;

      foreach ($errors as $error)
        $html .= $error.'<br />'.NL;

      $html .= '</div>';

    } else {

      $html .= '<div style="display:none;" id="wgt-box_error" class="wgt-box error"></div>'.NL;
    }


    // Gibet Systemmeldungen? Wenn ja dann Raus mit
    if ($warnings = $messageObject->getWarnings()) {

      $html .= '<div  id="wgt-box_warning" class="wgt-box warning">'.NL;

      foreach ($warnings as $warn)
        $html .= $warn."<br />".NL;

      $html .= '</div>';
    } else {

      $html .= '<div style="display:none;" id="wgt-box_warning" class="wgt-box warning"></div>'.NL;
    }

    // Gibet Systemmeldungen? Wenn ja dann Raus mit
    if ($messages = $messageObject->getMessages()) {
      $html .= '<div id="wgt-box_message" class="wgt-box message" >'.NL;

      foreach ($messages as $message)
        $html .= $message."<br />".NL;

      $html .= '</div>';
    } else {

      $html .= '<div style="display:none;" id="wgt-box_message" class="wgt-box message"></div>'.NL;
    }

    // Meldungen zurückgeben
    return $html;

  } // end protected function buildMessages */

  /**
   *
   * @param $errorMessage
   * @param $errorCode
   * @param $toDump
   * @return unknown_type
   */
  public function printErrorPage($errorMessage, $errorCode, $toDump = null)
  {

    if (!$filename = $this->templatePath('error/default')) {
      Error::addError('failed to load the body error/default');

      $dump = Debug::dumpToString($toDump);

      $fbMessage = <<<CODE
<h2>Error: $errorCode</h2>
<p>$errorMessage</p>
<p>$dump</p>
CODE;

      echo $fbMessage;

      return;

    }

    $VAR = $this->var;
    $VAR->errorMessage = $errorMessage;
    $VAR->errorDump = Debug::dumpToString($toDump);
    $VAR->errorCode = $errorCode;
    $TITLE = 'Error';
    $TEMPLATE = 'errors/http_'.$errorCode;

    ob_start();
    include $filename;
    $content = ob_get_contents();
    ob_end_clean();

    echo $content;

  }//end public function printErrorPage */

} // end class LibTemplateHtml

