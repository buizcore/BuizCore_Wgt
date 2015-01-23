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

$files = array(

  PATH_WGT.'js_src/i18n/i18n.de.js',

  // add thirdparty jquery plugins
  PATH_WGT.'js_src/vendor/jquery.appear/jquery.appear.js',
  PATH_WGT.'js_src/vendor/jquery.toaster/jquery.toaster.js',
  PATH_WGT.'js_src/vendor/jquery.colorpicker/jquery.colorpicker.js',
  PATH_WGT.'js_src/vendor/jquery.star_rating/jquery.star_rating.js',
  PATH_WGT.'js_src/vendor/jquery.cookie/jquery.cookie.js',
  PATH_WGT.'js_src/vendor/jquery.mousewheel/jquery.mousewheel.js',
  PATH_WGT.'js_src/vendor/jquery.modal/jquery.modal.js',
  PATH_WGT.'js_src/vendor/jquery.hoverIntent/jquery.hoverIntent.js',
  PATH_WGT.'js_src/vendor/jquery.srcoll_to/jquery.scroll_to.js',
    
  PATH_WGT.'js_src/vendor/jquery.browserstate/history.js',
  PATH_WGT.'js_src/vendor/jquery.browserstate/history.adapter.jquery.js',

    
    
  // soon deprecated
  //PATH_WGT.'js_src/vendor/jquery.treetable/jquery.treeTable.js',
  //PATH_WGT.'js_src/vendor/jquery.context_menu/jquery.context_menu.js',

  // add jquery ui components
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.core.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.widget.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.mouse.js',

  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.draggable.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.droppable.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.resizable.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.position.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.selectable.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.sortable.js',

  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.button.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.dialog.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.progressbar.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.datepicker.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.slider.js',

  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.accordion.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.autocomplete.js',
  PATH_WGT.'js_src/vendor/jquery.ui/jquery.ui.menu.js',

  // jquery ui extensions
  PATH_WGT.'js_src/ext/jquery.ui/accordion.js',

  // auf ui basierende jquery plugins
  PATH_WGT.'js_src/vendor/jquery.timepicker/jquery.timepicker.js',
//  PATH_WGT.'js_src/vendor/jquery.dynatree/jquery.dynatree.js',
  PATH_WGT.'js_src/vendor/jquery.ui.datetimepicker/jquery.ui.datetimepicker.js',
  PATH_WGT.'js_src/vendor/jquery.ui.datetimepicker/jquery.ui.sliderAccess.js',
  PATH_WGT.'js_src/vendor/jquery.ui.multiselect/jquery.ui.multiselect.js',
  PATH_WGT.'js_src/vendor/jquery.fullcalendar/fullcalendar.js',
  PATH_WGT.'js_src/vendor/jquery.sparkline/jquery.sparkline.js',
//  PATH_WGT.'js_src/vendor/jquery.scrollbar/jquery.mCustomScrollbar.js',
  PATH_WGT.'js_src/vendor/jquery.chosen/chosen.jquery.js',
    
  PATH_WGT.'vendor/jquery.month/jquery.monthpicker.js',
    

  // add wgt jquery plugins
  PATH_WGT.'js_src/wgt/jquery/Menuselector.js', // deprecated
  PATH_WGT.'js_src/wgt/jquery/Ajaxfileupload.js',

  // add widgets
  PATH_WGT.'js_src/wgt/widget/DataGrid.js',
  PATH_WGT.'js_src/wgt/widget/grid/Editmode.js',
  PATH_WGT.'js_src/wgt/widget/grid/Formula.js',

  PATH_WGT.'js_src/wgt/widget/I18nInputList.js',
  PATH_WGT.'js_src/wgt/widget/I18nInputTab.js',
  PATH_WGT.'js_src/wgt/widget/Dropmenu.js',
  PATH_WGT.'js_src/wgt/widget/ContentContainer.js',
  PATH_WGT.'js_src/wgt/widget/ContextBox.js',
  PATH_WGT.'js_src/wgt/widget/TabHead.js',
  PATH_WGT.'js_src/wgt/widget/WindowSelection.js',
  PATH_WGT.'js_src/wgt/widget/TagCloud.js',
  PATH_WGT.'js_src/wgt/widget/CommentTree.js',
  PATH_WGT.'js_src/wgt/widget/KvList.js',
  PATH_WGT.'js_src/wgt/widget/SearchBuilder.js',
  PATH_WGT.'js_src/wgt/widget/MainOverlay.js',
  PATH_WGT.'js_src/wgt/widget/EditList.js',
    
    
  // add wgt core
  PATH_WGT.'js_src/wgt/jquery/ui/WgtTip.js',

  // add wgt core
  PATH_WGT.'js_src/wgt/Request.js',
  PATH_WGT.'js_src/wgt/request/Handler.js',
  PATH_WGT.'js_src/wgt/request/handler/HandlerTab.js',
  PATH_WGT.'js_src/wgt/request/handler/HandlerArea.js',
  PATH_WGT.'js_src/wgt/request/handler/HandlerModal.js',

  /// WCM WAS HERE
    
  PATH_WGT.'js_src/wgt/Desktop.js',
  PATH_WGT.'js_src/wgt/desktop/Message.js',
  PATH_WGT.'js_src/wgt/desktop/Workarea.js', // deprecated

  // add ui
  PATH_WGT.'js_src/wgt/Ui.js',
  //PATH_WGT.'js_src/wgt/ui/ActivInput.js',
  PATH_WGT.'js_src/wgt/ui/Tab.js',       // deprecated
  PATH_WGT.'js_src/wgt/ui/tab/TabContainerList.js', 
  PATH_WGT.'js_src/wgt/ui/Form.js',
  PATH_WGT.'js_src/wgt/ui/Footer.js',      // deprecated
  //PATH_WGT.'js_src/wgt/ui/Calendar.js',  // deprecated

  // mini Menu, deprecated?
  PATH_WGT.'js_src/wgt/jquery/MiniMenu.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/ActivInput.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Callback.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Checklist.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Html.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/ListItem.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Reload.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Sep.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Sortbox.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Url.js',
  PATH_WGT.'js_src/wgt/jquery/minimenu/Dom.js',

  // Compatibility check
  PATH_WGT.'js_src/wgt/wgt/Compatibility.js',

  // add init components
  PATH_WGT.'js_src/wgt/wgt/init/Request.js',
  PATH_WGT.'js_src/wgt/wgt/init/Windowtabs.js',
  PATH_WGT.'js_src/wgt/wgt/init/CheckCompatibility.js',
    
  // Tags Input
  PATH_WGT.'js_src/vendor/bootstrap.tagsinput/bootstrap-tagsinput.js',

);

