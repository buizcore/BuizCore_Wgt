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
 * Das Ausgabemodul für die Seite
 * @package net.buizcore.wgt
 */
class View
{
/*////////////////////////////////////////////////////////////////////////////*/
// Konstantes
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   * @param string
   */
  const AJAX = 'ajax';

  /**
   * @param string
   */
  const JSON = 'json';

  /**
   * @param string
   */
  const HTML = 'html';

  /**
   * @param string
   */
  const FRONTEND = 'frontend';

  /**
   * @param string
   */
  const AREA = 'area';

  /**
   * @param string
   */
  const WINDOW = 'window';

  /**
   * @param string
   */
  const SUBWINDOW = 'window';

  /**
   * @param string
   */
  const MAINTAB = 'maintab';

  /**
   * @param string
   */
  const MAINWINDOW = 'mainwindow';

  /**
   * @param string
   */
  const MODAL = 'modal';

  /**
   * @param string
   */
  const OVERLAY = 'overlay';

  /**
   * @param string
   */
  const DOCUMENT = 'document';

  /**
   * @param string
   */
  const SERVICE = 'service';

  /**
   * @param string
   */
  const BINARY = 'binary';

  /**
   * @param string
   */
  const PLAIN = 'plain';

  /**
   * @param string
   */
  const CLI = 'cli';

  /**
   * @param string
   */
  const CMS = 'cms';

  /**
   * the default text content type
   * @var string
   */
  const CONTENT_TYPE_TEXT = 'text/html';

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * soll die komplette Seite geschickt werden
   *
   * @var boolean
   */
  public static $sendIndex = false;

  /**
   * soll der ajax Body gesendet werden
   *
   * @var boolean
   */
  public static $sendBody = true;

  /**
   * soll der ajax Body gesendet werden
   *
   * @var boolean
   */
  public static $published = false;

  /**
   * name des aktiven icon themes
   * @var string
   */
  public static $iconTheme = null;

  /**
   * der pfad zum aktuellen theme
   *
   * @var string
   */
  public static $themePath = null;

  /**
   * the web theme path for the browser / client
   * @var string
   */
  public static $themeWeb = null;

  /**
   * the web theme path for the browser / client
   * @var string
   */
  public static $iconsWeb = null;

  /**
   * Web-Client Pfad zu den Icons im Icon Projekt
   * @var string
   */
  public static $webIcons = null;

  /**
   * Web-Client Pfad zu den Bildern im Theme Projekt
   * @var string
   */
  public static $webImages = null;

  /**
   * Mögliche Pfade in denen nach einem Template gesucht werden muss
   * @var array
   */
  public static $templatePath = array();

  /**
   * should headers be blocked?
   *
   * @var boolean
   */
  public static $blockHeader = false;

  /**
   * der typ der zu erstellenden template klasse
   *
   * @var string
   */
  public static $type = null;

  /**
   * der typ der zu erstellenden template klasse
   *
   * @var boolean
   */
  public static $searchPathTemplate = array();

  /**
   * der typ der zu erstellenden template klasse
   *
   * @var array
   */
  public static $searchPathIndex = array();

  /**
   * Erzwingen eines Doctypes soweit nötig
   * @var int
   */
  public static $docType = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Instance
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * ein Template Objekt der aktiven Template Klasse
   * @var LibTemplate
   */
  private static $instance = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Magic and Magicsimulation
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public static function init()
  {
      
      if (defined('WBF_NO_VIEW')) {
          return;
      }

    $conf = Conf::get('view');

    self::$templatePath = PATH_GW.'templates/';

    self::$themePath = Session::status('path_theme');

    self::$themeWeb = Session::status('web_theme');
    self::$iconsWeb = Session::status('web_icons');

    self::$webIcons = Session::status('web_icons');
    self::$webImages = Session::status('web_theme').'/images/';

    if (!defined('PLAIN')) {

      self::$type = self::$type?:'Html';
      $className = 'LibTemplate'.ucfirst(self::$type);

      self::$instance = new $className($conf);

      if(isset($conf['def_scope']))
        self::$instance->setScope($conf['def_scope']);

    }

  } //end public function init */

  /**
   * @param string $type
   *
   */
  public static function rebase($type)
  {
      
      if (defined('WBF_NO_VIEW')) {
          return;
      }

    $conf = Conf::get('view');
    self::$templatePath = PATH_GW.'templates/';

    self::$themePath = Session::status('path_theme');

    self::$themeWeb = Session::status('web_theme');
    self::$iconsWeb = Session::status('web_icons');

    self::$webIcons = Session::status('web_icons');
    self::$webImages = Session::status('web_theme').'images/';

    $className = 'LibTemplate'.$type;
    self::$instance = new $className($conf);

    BuizCore::$env->setView(self::$instance);
    BuizCore::$env->setTpl(self::$instance);
    BuizCore::$env->getResponse()->setTpl(self::$instance);

  } //end public function init */

  /**
   * clean closedown of the view
   *
   */
  public static function shutdown()
  {
      
      if (defined('WBF_NO_VIEW')) {
          return;
      }
      
    self::$instance->shutdown();
    self::$instance = null;
  } //end public static function shutdown */

  /**
   * request the active template engine
   * @return LibTemplateAjax
   */
  public static function getActive(  )
  {
    return self::$instance;
  }//end public function getActive */

/*////////////////////////////////////////////////////////////////////////////*/
// application logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Setzen Aktiv Setzen einer neuen View sowie sofortige Rückgabe dieser View
   *
   * @param string $type
   * @return void
   */
  public static function setType($type)
  {
    self::$type = ucfirst($type);
  } // end public static function setType */

  /**
   * @param $file
   * @param $folder
   * @param $params
   * @return unknown_type
   */
  public static function includeTemplate($file, $folder = null , $params = array())
  {
    echo self::$instance->includeTemplate($file, $folder , $params);
  }//end public static function includeTemplate */

  /**
   * @param string $file ein einfacher filename
   * @param mixed $object irgend ein Object für das potentielle template
   * @return string
   */
  public static function includeFile($file, $object = null)
  {

    ob_start();
    include $file;
    $content = ob_get_contents();
    ob_end_clean();

    return $content;

  }//end public static function includeFile */

  /**
   * @param $errorMessage
   * @param $errorCode
   * @return unknown_type
   */
  public static function printErrorPage($errorMessage , $errorCode ,$toDump = null)
  {
    if (self::$instance) {
      self::$instance->printErrorPage($errorMessage , $errorCode ,$toDump);
    } else {
      echo $errorMessage.'<br />';
      echo Debug::dumpToString($toDump);
    }

  }//end public static function printErrorPage */

}//end class View

