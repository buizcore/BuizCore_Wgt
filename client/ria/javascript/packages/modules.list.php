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

//$jsconf = PATH_GW.'js_conf/conf.js';

$files[] = PATH_WGT.'js_src/i18n/i18n.de.js';


// basis codes
$files[] =   PATH_WGT.'client/core/form/Validator.js';


// jquery ui extensions
$files[] =   PATH_WGT.'js_src/ext/jquery.ui/accordion.js';

// add wgt jquery plugins
$files[] =   PATH_WGT.'js_src/wgt/jquery/Menuselector.js'; // deprecated
$files[] =   PATH_WGT.'js_src/wgt/jquery/Ajaxfileupload.js';

// add widgets
$files[] =   PATH_WGT.'js_src/wgt/widget/DataGrid.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/grid/Editmode.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/grid/Formula.js';

$files[] =   PATH_WGT.'js_src/wgt/widget/I18nInputList.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/I18nInputTab.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/Dropmenu.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/ContentContainer.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/ContextBox.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/TabHead.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/WindowSelection.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/TagCloud.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/CommentTree.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/KvList.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/SearchBuilder.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/MainOverlay.js';
$files[] =   PATH_WGT.'js_src/wgt/widget/EditList.js';
    
// add wgt core
$files[] =  PATH_WGT.'js_src/wgt/jquery/ui/WgtTip.js';

// add wgt core
$files[] =   PATH_WGT.'js_src/wgt/Request.js';
$files[] =   PATH_WGT.'js_src/wgt/request/Handler.js';
$files[] =  PATH_WGT.'js_src/wgt/request/handler/HandlerTab.js';
$files[] =   PATH_WGT.'js_src/wgt/request/handler/HandlerArea.js';
$files[] =   PATH_WGT.'js_src/wgt/request/handler/HandlerModal.js';

/// WCM WAS HERE
$files[] =  PATH_WGT.'js_src/wgt/Desktop.js';
$files[] =   PATH_WGT.'js_src/wgt/desktop/Message.js';
$files[] =   PATH_WGT.'js_src/wgt/desktop/Workarea.js'; // deprecated

  // add ui
$files[] =   PATH_WGT.'js_src/wgt/Ui.js';
  //PATH_WGT.'js_src/wgt/ui/ActivInput.js';
$files[] =   PATH_WGT.'js_src/wgt/ui/Tab.js';       // deprecated
$files[] =   PATH_WGT.'js_src/wgt/ui/tab/TabContainerList.js'; 
$files[] =   PATH_WGT.'js_src/wgt/ui/Form.js';
$files[] =   PATH_WGT.'js_src/wgt/ui/Footer.js';      // deprecated
//PATH_WGT.'js_src/wgt/ui/Calendar.js';  // deprecated

// mini Menu; deprecated?
$files[] =   PATH_WGT.'js_src/wgt/jquery/MiniMenu.js';
$files[] =   PATH_WGT.'js_src/wgt/jquery/minimenu/ActivInput.js';
$files[] =   PATH_WGT.'js_src/wgt/jquery/minimenu/Callback.js';
$files[] =   PATH_WGT.'js_src/wgt/jquery/minimenu/Checklist.js';
$files[] =   PATH_WGT.'js_src/wgt/jquery/minimenu/Html.js';
$files[] =   PATH_WGT.'js_src/wgt/jquery/minimenu/ListItem.js';
$files[] =   PATH_WGT.'js_src/wgt/jquery/minimenu/Reload.js';
$files[] =   PATH_WGT.'js_src/wgt/jquery/minimenu/Sep.js';
$files[] =   PATH_WGT.'js_src/wgt/jquery/minimenu/Sortbox.js';
$files[] =   PATH_WGT.'js_src/wgt/jquery/minimenu/Url.js';
$files[] =   PATH_WGT.'js_src/wgt/jquery/minimenu/Dom.js';

// Compatibility check
$files[] =   PATH_WGT.'js_src/wgt/wgt/Compatibility.js';

// add init components
$files[] =   PATH_WGT.'js_src/wgt/wgt/init/Request.js';
$files[] =   PATH_WGT.'js_src/wgt/wgt/init/Windowtabs.js';
$files[] =   PATH_WGT.'js_src/wgt/wgt/init/CheckCompatibility.js';


