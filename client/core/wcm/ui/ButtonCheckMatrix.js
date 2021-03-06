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
 *   - jQuery UI 1.8 widget factory
 *   - WGT 0.9
 * 
 * License:
 * Dual licensed under the MIT and GPL licenses:
 * @license http://www.opensource.org/licenses/mit-license.php
 * @license http://www.gnu.org/licenses/gpl.html
 * 
 * Code Style:
 *   indent: 2 spaces
 *   code lang: english
 *   naming style: camel case
 * 
 */

/**
 * @author dominik bonsch <db@webfrap.net>
 * @param jNode the jQuery Object of the target node
 */
$R.addAction( 'ui_button_check_matrix', function( jNode ){

  console.log("bin da");
  
  jNode.removeClass("wcm_ui_button_check_matrix");

  jNode.find('button').bind( 'click', function(){    
    
    console.log( "clicked " );
    
    var evntNode = $S(this);

    if( evntNode.hasClass('ui-state-active') ){
      jNode.find('input[name="'+evntNode.attr('wgt_key')+'"]').removeAttr('checked');
      evntNode.removeClass('ui-state-active');
    }else{
      jNode.find('input[name="'+evntNode.attr('wgt_key')+'"]').attr('checked','checked');
      evntNode.addClass('ui-state-active');
    }
    
  });

});