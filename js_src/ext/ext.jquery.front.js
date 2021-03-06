/* Licence see: /LICENCES/wgt/licence.txt */

;(function($S, undefined){
  
  $S.fn.reverse = Array.reverse;

  /**
  * get on single Parent with a given selector als match
  */
  $S.fn.parentX = function( selector ){
  
    var node = $S(this).parent();
    var level = 0;
  
    while(level <100){
      ++level;
      if(node.is(selector)){
          return node;
      }
      else if( node.is('body') || node.is('html') ){
        return null;
      }
      else{
        node = node.parent();
        if(!node)
          return null;
      }
    }
    
    return null;
    
  };


  /**
   * check if an element has a scroll bar
   */
  $S.fn.hasScrollBar = function() {
    //note: clientHeight= height of holder
    //scrollHeight= we have content till this height
    var _elm = $S(this)[0];
    var _hasScrollBar = false; 
    if ((_elm.clientHeight < _elm.scrollHeight) || (_elm.clientWidth < _elm.scrollWidth)) {
        _hasScrollBar = true;
    }
    return _hasScrollBar;
  };
  
  /**
   * check if an element has a scroll bar
   */
  $S.fn.triggerSearch = function(pos) {
	  
	  var formNode = $S(this);
	  if(!formNode.is('form')){
		  return true;
	  }
	  
	  formNode.submit();
	  
	  return false;
	  
  };
  

  
  /**
   * Den Pfad eines Nodes verfolgen
   */
  $S.fn.getNodePath = function( joinBy, depth ){
    
    if( !joinBy ){
      joinBy = ' ';
    }
    
    if( !depth ){
      depth = 3;
    }
    
    var pos = 0;
    
    var rightArrowParents = [];
    
    var entry = this.get(0).tagName.toLowerCase();
    if ( this.prop('id') ) {
        entry += "#" + this.prop('id');
    }
    rightArrowParents.push(entry);
    
    $S(this.get(0)).parents().not('html').each(function() {
        
        if( pos > depth ){
          return;
        }
      
        entry = this.tagName.toLowerCase();
        if ( $S(this).prop('id') ) {
            entry += "#" + $S(this).prop('id');
        }
        rightArrowParents.push(entry);
        
        ++pos;
    });
    rightArrowParents.reverse();
    
    var currentDate = new Date()
   
    return rightArrowParents.join(joinBy)+' '+currentDate.getMinutes()+'.'+currentDate.getSeconds()+'.'+currentDate.getMilliseconds();
  };
  
  /**
   * add Height
   */
  $S.fn.addHeight = function( height ){
     $S(this).height( ($S(this).height()+height)+'px' );
    return $S;
  };
  
  /**
   * sub Height
   */
  $S.fn.subHeight = function( height ){
     $S(this).height( ($S(this).height()-height)+'px' );
    return $S;
  };
  
  /**
   * add width
   */
  $S.fn.addWidth = function( width ){
     $S(this).width( ($S(this).width()+width)+'px' );
    return $S;
  };
  
  /**
   * sub width
   */
  $S.fn.subWidth = function( width ){
     $S(this).width( ($S(this).width()-width)+'px' );
    return $S;
  };

  /**
   * Disable the textselection
   */
  $S.fn.disableTextSelect = function( ){

    // Disable text selection
    if( $S.browser.mozilla ) {
      $S(this).each( function() { 
        $S(this).css({ 'MozUserSelect' : 'none' });
      });
    } else if( $S.browser.msie ) {
      $S(this).each( function() { 
        $S(this).bind('selectstart.disableTextSelect', function() {
          return false;
        });
      });
    } else {
      $S(this).each(function() { 
        $S(this).bind('mousedown.disableTextSelect', function() {
          return false;
        });
      });
    }
    
    return $S;
  };

 

   
})(jQuery);

/*
* ******************************************************************************
* jquery.mb.components
* file: jquery.mb.browser.js
*
* Copyright (c) 2001-2013. Matteo Bicocchi (Pupunzi);
* Open lab srl, Firenze - Italy
* email: matteo@open-lab.com
* site: http://pupunzi.com
* blog: http://pupunzi.open-lab.com
* http://open-lab.com
*
* Licences: MIT, GPL
* http://www.opensource.org/licenses/mit-license.php
* http://www.gnu.org/licenses/gpl.html
*
* last modified: 17/01/13 0.12
* *****************************************************************************
*/

/*******************************************************************************
*
* jquery.mb.browser
* Author: pupunzi
* Creation date: 16/01/13
*
******************************************************************************/
/*Browser detection patch*/

(function(jQuery){

  if(jQuery.browser) return;
  
  jQuery.browser = {};
  jQuery.browser.mozilla = false;
  jQuery.browser.webkit = false;
  jQuery.browser.opera = false;
  jQuery.browser.msie = false;
  
  var nAgt = navigator.userAgent;
  jQuery.browser.name = navigator.appName;
  jQuery.browser.fullVersion = ''+parseFloat(navigator.appVersion);
  jQuery.browser.majorVersion = parseInt(navigator.appVersion,10);
  var nameOffset,verOffset,ix;
  
  // In Opera, the true version is after "Opera" or after "Version"
  if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
	  jQuery.browser.opera = true;
	  jQuery.browser.name = "Opera";
	  jQuery.browser.fullVersion = nAgt.substring(verOffset+6);
	  if ((verOffset=nAgt.indexOf("Version"))!=-1)
		  jQuery.browser.fullVersion = nAgt.substring(verOffset+8);
  }
  // In MSIE, the true version is after "MSIE" in userAgent
  else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
	  jQuery.browser.msie = true;
	  jQuery.browser.name = "Microsoft Internet Explorer";
	  jQuery.browser.fullVersion = nAgt.substring(verOffset+5);
  }
  // In Chrome, the true version is after "Chrome"
  else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
	  jQuery.browser.webkit = true;
	  jQuery.browser.name = "Chrome";
	  jQuery.browser.fullVersion = nAgt.substring(verOffset+7);
  }
  // In Safari, the true version is after "Safari" or after "Version"
  else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
	  jQuery.browser.webkit = true;
	  jQuery.browser.name = "Safari";
	  jQuery.browser.fullVersion = nAgt.substring(verOffset+7);
	  if ((verOffset=nAgt.indexOf("Version"))!=-1)
		  jQuery.browser.fullVersion = nAgt.substring(verOffset+8);
  }
  // In Firefox, the true version is after "Firefox"
  else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
	  jQuery.browser.mozilla = true;
	  jQuery.browser.name = "Firefox";
	  jQuery.browser.fullVersion = nAgt.substring(verOffset+8);
  }
  // In most other browsers, "name/version" is at the end of userAgent
  else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) <
  (verOffset=nAgt.lastIndexOf('/')) )
  {
  jQuery.browser.name = nAgt.substring(nameOffset,verOffset);
  jQuery.browser.fullVersion = nAgt.substring(verOffset+1);
  if (jQuery.browser.name.toLowerCase()==jQuery.browser.name.toUpperCase()) {
  jQuery.browser.name = navigator.appName;
  }
  }
  // trim the fullVersion string at semicolon/space if present
  if ((ix=jQuery.browser.fullVersion.indexOf(";"))!=-1)
  jQuery.browser.fullVersion=jQuery.browser.fullVersion.substring(0,ix);
  if ((ix=jQuery.browser.fullVersion.indexOf(" "))!=-1)
  jQuery.browser.fullVersion=jQuery.browser.fullVersion.substring(0,ix);
  
  jQuery.browser.majorVersion = parseInt(''+jQuery.browser.fullVersion,10);
  if (isNaN(jQuery.browser.majorVersion)) {
	  jQuery.browser.fullVersion = ''+parseFloat(navigator.appVersion);
	  jQuery.browser.majorVersion = parseInt(navigator.appVersion,10);
  }
  jQuery.browser.version = jQuery.browser.majorVersion;
  
})(jQuery);
