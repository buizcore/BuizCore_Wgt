/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */
/**
 * WGT Web Gui Toolkit
 * 
 * Copyright (c) 2014 BuizCore GmbH
 * 
 * http://buizcore.net/WGT
 * 
 * @author Dominik Bonsch <db@webfrap.net>
 * 
 * Depends: 
 *   - jQuery 1.7.2
 * 
 * Dual licensed under the MIT and GPL licenses:
 * @license http://www.opensource.org/licenses/mit-license.php
 * @license http://www.gnu.org/licenses/gpl.html
 */

/**
 * @author dominik bonsch <db@webfrap.net>
 * 
 * WCM zum ein oder ausblenden von Elementen in abhängigkeit vom Checkstatus
 * einer Selectbox
 * 
 */
$R.addAction( 'control_hover', function( jNode ){
  
  jNode.hoverIntent(function(){
    jNode.addClass('hover');
    $D.requestCloseMenu(); // menüs schliesen... hover öffnet etwas neues
    $S.fn.miniMenu.close();
  },function(){
    jNode.removeClass('hover');
  });
    
  jNode.removeClass( "wcm_control_hover" );

});