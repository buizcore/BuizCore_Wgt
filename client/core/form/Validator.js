/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */
/* 
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
 * 
 * Dual licensed under the MIT and GPL licenses:
 * @license http://www.opensource.org/licenses/mit-license.php
 * @license http://www.gnu.org/licenses/gpl.html
 */

;(function(window,undefined){

  "use strict";
  
  /**
   * @author dominik bonsch <d.bonsch@buizcore.com>
   * @extends js_wgt/jquery.js
   * @extends js_wgt/wgt.js
   */
  function WgtValidator( ){

    /**
     * 
     */
    this.fn = WgtValidator.prototype;

    
    /**
     * handle required auf dem validator
     */
    this.checkRequired = function(selector){
        
        
        var jNode = $(selector);
        
        console.log('checkRequired:  '+selector+ ' '+jNode.length);
        

        var isEmpty = this.isEmpty(jNode, true);
        
        if (jNode.not('input[type="checkbox"],input[type="radio"]').is('input') || jNode.is('textarea') || jNode.is('select')) {
            
          if (isEmpty) { 
            jNode.addClass( 'state-warn' ).removeClass('state-ok');
          } else {
            jNode.addClass( 'state-ok' ).removeClass( 'state-warn' );
          }
        }
          
        return isEmpty;

    };
    
    /**
     * checken ob es werte für mindestens einen der selectboren gibt
     */
    this.oneIsSet = function(selectorList){
        
        var that = this;
        
        $(selectorList).each(function(key, val){
            
            if (!that.isEmpty(val, false)) {
                return true;
            }
            
        });
        
        return false;

    };
    
    
    /**
     * @selector
     * @isNode
     */
    this.isEmpty = function(selector, isNode){

        var jNode;
         
        if (isNode) {
            jNode = selector;
        } else {
            jNode = $(selector);
        }
        
        if (0==jNode.lenght) {
            console.warn( 'got no matching element in is empty '+selector );
            return true;
        }
        
        
        if ( jNode.is('input[type="checkbox"]')) {
            
            if(!jNode.is(':checked')){
                return false;
            } else {
                return true;
            }
            
        } else if ( jNode.is('input[type="radio"]')) {
            
            if(!jNode.val()){
                return false;
            } else {
                return true;
            }
            
        }  else if( jNode.is('input') || jNode.is('textarea')  ){

   
            if ( '' == ''+jNode.val().trim() ){
              return false;
            } else {
              return true;
            }
            
        }  else if( jNode.is('select')  ){
                
            console.log('IN SELECT');
   
            if ( 0 == jNode.find('option:selected').length || '' == $.trim(jNode.val()) ){
              return false;
            } else {
              console.log( 'find '+jNode.attr('id')+' '+jNode.find('option:selected').length+' val:'+jNode.val() );
              return true;
            }
            
        } else {
            console.error('required on a non supported element '+jNode.prop("tagName"));
            return true;
        }
        
    };
    
  }//end class WgtValidator

  // Expose Wgt to the global object
  window.$VALID = new WgtValidator;

})(window);