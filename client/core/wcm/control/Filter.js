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

$R.addAction( 'radio_filter', function( jNode ){
  
    var filterPreFix = jNode.attr('data-filter-prefix'), 
        filterPostFix = jNode.attr('data-filter-postfix'), 
        parent = jNode.attr('data-filter-parent'),
        parentNode;
    
    if (parent) {
        parentNode = $(parent);
    }
    
    // render function
    var render = function( selectorAll, selectorShow, parentNode ){
        
        
        if (parentNode) {
            
            parentNode.find(selectorAll).hide();
            parentNode.find(selectorShow).show();
            
        } else {

            $(selectorAll).hide();
            $(selectorShow).show();
        }
        
    };
 
    jNode.find('input[type="radio"]').each(function(){
        $(this).on('click.radio_filter',function(){
          
            var 
                keyShow = '.'+(filterPreFix?filterPreFix+'-':'')+'filter-'+$(this).val()+(filterPostFix?'-'+filterPostFix:''),
                keyAll = '.'+(filterPreFix?filterPreFix+'-':'')+'filter-row'+(filterPostFix?'-'+filterPostFix:'');
            
            render(keyAll,keyShow,parentNode);
        });
    });
    
    jNode.removeClass( "wcm_radio_filter" );

});

