<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
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
class BuizCache_Model extends MvcModel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  public $cacheDirs = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return [{label,folder,description}]
   */
  public function getCaches()
  {

    if ($this->cacheDirs)
      return $this->cacheDirs;

    // can be done native with php 5.4
    $caches = <<<JSON

[
  {
    "label":"CSS Cache",
    "dir": "css",
    "description": "Die Basis Struktur fürs UI",
    "display": [ "created", "size", "num_files" ],
    "actions": [
      {
        "type" : "request",
        "label": "Rebuild",
        "method": "put",
        "service": "ajax.php?c=Buiz.Cache.rebuildAllCss"
      },{
        "type" : "request",
        "label": "Delete",
        "method": "del",
        "service": "ajax.php?c=Buiz.Cache.cleanCss"
      }
    ]
  },
  {
    "label":"App Theme Cache",
    "dir": "app_theme",
    "description": "Application Themes",
    "display": [ "created", "size", "num_files" ],
    "actions": [
      {
        "type" : "request",
        "label": "Rebuild",
        "method": "put",
        "service": "ajax.php?c=Buiz.Cache.rebuildAllAppTheme"
      },{
        "type" : "request",
        "label": "Delete",
        "method": "del",
        "service": "ajax.php?c=Buiz.Cache.cleanAppTheme"
      }
    ]
  },
  {
    "label":"Web Theme Cache",
    "dir": "web_theme",
    "description": "Website Themes",
    "display": [ "created", "size", "num_files" ],
    "actions": [
      {
        "type" : "request",
        "label": "Rebuild",
        "method": "put",
        "service": "ajax.php?c=Buiz.Cache.rebuildAllWebTheme"
      },{
        "type" : "request",
        "label": "Delete",
        "method": "del",
        "service": "ajax.php?c=Buiz.Cache.cleanWebTheme"
      }
    ]
  },
  {
    "label":"Js Cache",
    "dir": "javascript",
    "description": "Themes",
    "display": [ "created", "size", "num_files" ],
    "actions": [
      {
        "type" : "request",
        "label": "Rebuild",
        "method": "put",
        "service": "ajax.php?c=Buiz.Cache.rebuildAllJs"
      },{
        "type" : "request",
        "label": "Delete",
        "method": "del",
        "service": "ajax.php?c=Buiz.Cache.cleanJs"
      }
    ]
  },
  {
    "label":"Autoload Index",
    "dir": "autoload",
    "description": "Autoload Index",
    "display": [ "created", "size", "num_files" ],
    "actions": [
      {
        "type" : "request",
        "label": "Clean",
        "method": "del",
        "service": "ajax.php?c=Buiz.Cache.clean&key=autoload"
      }
    ]
  },
  {
    "label":"I18n",
    "dir": "i18n",
    "description": "I18n Index",
    "display": [ "created", "size", "num_files" ],
    "actions": [
      {
        "type" : "request",
        "label": "Clean",
        "method": "del",
        "service": "ajax.php?c=Buiz.Cache.clean&key=i18n"
      }
    ]
  },
  {
    "label":"Web",
    "dir": "web",
    "description": "web",
    "display": [ "created", "size", "num_files" ],
    "actions": [
      {
        "type" : "request",
        "label": "Clean",
        "method": "del",
        "service": "ajax.php?c=Buiz.Cache.clean&key=web"
      }
    ]
  }
]

JSON;

    $this->cacheDirs = json_decode($caches);

    return $this->cacheDirs;

  }//end public function getCaches */

  /**
   * leeren des cache folders
   * @return void
   */
  public function cleanCache()
  {

    $response = $this->getResponse();

    // now we just to have to clean the code folder :-)
    $toClean = array(
      'App Cache' => PATH_GW.'cache/'
    );

    foreach ($toClean as $name => $folder) {
      if (SFilesystem::cleanFolder($folder)) {
        $response->addMessage($response->i18n->l(
          'Successfully cleaned {@name@}',
          'wbf.message',
          array('name' => $name)
        ));
      } else {
        $response->addError($response->i18n->l(
          'Failed to cleane {@name@}',
          'wbf.message',
          array('name' => $name)
        ));
      }
    }
  }//end public function cleanCache */

  /**
   * neu bauen des JS Caches
   */
  public function rebuildJs($key)
  {

    $cache = new LibCacheRequestJavascript();
    $cache->rebuildList($key);

  }//end public function rebuildJs */

  /**
   * neu bauen des JS Caches
   */
  public function rebuildCss($key)
  {

    $cache = new LibCacheRequestCss();
    $cache->rebuildList($key);

  }//end public function rebuildCss */

  /**
   * neu bauen des Theme Caches
   */
  public function rebuildWebTheme($key)
  {

    $cache = new LibCacheRequestWebTheme();
    $cache->rebuildList($key);

  }//end public function rebuildTheme */

  /**
   * neu bauen des Theme Caches
   */
  public function rebuildAppTheme($key)
  {

    $cache = new LibCacheRequestAppTheme();
    $cache->rebuildList($key);

  }//end public function rebuildAppTheme */

  /**
   * neu bauen des JS Caches
   */
  public function rebuildAllJs()
  {

    $response = $this->getResponse();
    $cache = new LibCacheRequestJavascript();

    $folderIterator = new IoFileIterator(
      PATH_GW.'conf/include/javascript/',
      IoFileIterator::RELATIVE,
      false
    );

    foreach ($folderIterator as $fileName) {
      $key = str_replace('.list.php', '', basename($fileName));
      try {
        $cache->rebuildListBulk($key);
        $response->addMessage("Successfully rebuild list: ".$key  );
      } catch (Buiz_Exception $e) {
        $response->addError("Failed to render js: ".$key." ".$e->getMessage()  );
      }
    }

  }//end public function rebuildAllJs */

  /**
   * neu bauen des JS Caches
   */
  public function rebuildAllCss()
  {

    $response = $this->getResponse();
    $cache = new LibCacheRequestCss();
    $folderIterator = new IoFileIterator(
      PATH_GW.'conf/include/css/',
      IoFileIterator::RELATIVE,
      false
    );

    foreach ($folderIterator as $fileName) {
      $key = str_replace('.list.php', '', basename($fileName));
      try {
        $cache->rebuildList($key);
        $response->addMessage("Successfully rebuild CSS: ".$key  );
      } catch (Buiz_Exception $e) {
        $response->addError("Failed to render CSS: ".$key." ".$e->getMessage()  );
      }
    }

  }//end public function rebuildAllCss */

  /**
   * neu bauen des Theme Caches
   */
  public function rebuildAllWebTheme()
  {

    $response = $this->getResponse();
    $cache = new LibCacheRequestWebTheme();

    $folderIterator = new IoFileIterator(
      PATH_GW.'conf/include/web_theme/',
      IoFileIterator::RELATIVE,
      false
    );

    foreach ($folderIterator as $fileName) {
      $key = str_replace('.list.php', '', basename($fileName));
      try {
        $cache->rebuildList($key);
        $response->addMessage("Successfully rebuild theme: ".$key  );
      } catch (Buiz_Exception $e) {
        $response->addError("Failed to render theme: ".$key." ".$e->getMessage()  );
      }
    }

  }//end public function rebuildAllWebTheme */

  /**
   * neu bauen des Theme Caches
   */
  public function rebuildAllAppTheme()
  {

    $response = $this->getResponse();
    $cache = new LibCacheRequestAppTheme();

    $folderIterator = new IoFileIterator(
      PATH_GW.'conf/include/app_theme/',
      IoFileIterator::RELATIVE,
      false
    );

    foreach ($folderIterator as $fileName) {
      $key = str_replace('.list.php', '', basename($fileName));
      try {
        $cache->rebuildList($key);
        $response->addMessage("Successfully rebuild theme: ".$key  );
      } catch (Buiz_Exception $e) {
        $response->addError("Failed to render theme: ".$key." ".$e->getMessage()  );
      }
    }

  }//end public function rebuildAllAppTheme */

  /**
   * leeren des cache folders
   * @return void
   */
  public function clean($toClean)
  {

    $response = $this->getResponse();

    foreach ($toClean as $name => $folder) {
      if (SFilesystem::cleanFolder($folder)) {
        $response->addMessage($response->i18n->l(
          'Successfully cleaned {@name@}',
          'wbf.message',
          array('name' => $name)
        ));
      } else {
        $response->addError($response->i18n->l(
          'Failed to cleane {@name@}',
          'wbf.message',
          array('name' => $name)
        ));
      }
    }
  }//end public function cleanCss */

}//end class MaintenanceCache_Model */

