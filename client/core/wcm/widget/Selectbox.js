/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */
/**
 * WGT Web Gui Toolkit
 *
 * Copyright (c) 2009 webfrap.net
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
 *   codelang: english
 *   identStyle: camel case
 *
 */

  /**
   * @author dominik alexander bonsch <db@webfrap.net>
   */
  $R.addAction( 'widget_selectbox', function( jNode ){

    var active = jNode.attr('data-active'),
        settings = {}
        placeholder = jNode.attr('placeholder');
    
    if (active) {
        jNode.find("option").filter(function() {
            return $(this).attr('value') == active; 
        }).prop('selected', true);
    } 
    
    // placeholder
    /*
    if(placeholder){
        settings.placeholder_text = placeholder;
    }*/
      
    jNode.appear(function(){
        jNode.chosen(settings);
    });

    jNode.removeClass( "wcm_widget_selectbox" );

  });


