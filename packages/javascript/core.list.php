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

$jsconf = PATH_GW.'js_conf/conf.js';

$files = array(
  // extend javascript
  PATH_WGT.'js_src/ext/ext.js.js',

  PATH_WGT.'js_src/vendor/jquery/jquery.js',
  PATH_WGT.'js_src/ext/ext.jquery.js',
  PATH_WGT.'js_src/vendor/bootstrap/bootstrap-custom.js',
    
  PATH_WGT.'js_src/vendor/handlebars/handlebars.js', // templates
  PATH_WGT.'js_src/vendor/dropzone.js/dropzone-amd-module.js', // upload

  // underscore
  //PATH_WGT.'js_src/vendor/underscore.js/underscore.js',

  PATH_WGT.'js_src/vendor/moment.js/moment.js',
  //PATH_WGT.'js_src/vendor/numeral.js/numeral.js',
    
  PATH_WGT.'js_src/Wgt.js',
  PATH_WGT.'js_src/wgt/Debug.js',

  // add i18n data
  PATH_WGT.'js_src/wgt/I18n.js',
);

