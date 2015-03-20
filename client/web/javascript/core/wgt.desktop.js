/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */
/**
 * WGT Web Gui Toolkit
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
 * Dropmenu Widget
 * @author dominik alexander bonsch <db@webfrap.net>
 *
 * @todo mit der Contextbox verheiraten
 *
 */
(function( jQuery) {

  "use strict";
  jQuery.widget( "bcp.desktop", {

    // These options will be used as defaults
    options: {
    	tpl_cache: {},
    	js_files: {},
    	css_files: {}
    },


    // Set up the widget
    _create: function() {
    	window.$D = this;
    },
    
    /**
     * @return object
     */
    getInstance: function(  ){
        return this;
	},
    
    /**
     * @param title string
     */
    setTitle: function( title ){
        window.document.title = title;
	},

    /**
     * @param message string
     * @param type string
     */
    addMessage: function( message, valType ){
    	
    	/**
    	 * types:
    	 * info
    	 * success
    	 * warning
    	 * error
    	 */
    	if (undefined === valType) {
    		valType = 'info';
    	}
    	var valSticky = false;
    	
    	if(valType =='error'){
    		valSticky = true;
    	}
    	
    	$().toastmessage('showToast',{
    	    text     : message,
    	    sticky   : valSticky,
    	    position : 'bottom-left',
    	    type     : valType
    	});
	},	
	
	/**
	 * @param tplId string
	 * @param vars mixed
	 * @param isContent boolean
	 * @param cache boolean
	 */
	renderTpl: function(tplId, vars, isContent, cache){
		
		var tplCache = this.options.tpl_cache;
		if (cache) {
			if(undefined !== tplCache[tplId] ){
				return tplCache(vars);
			}
		}
		
		var nodeSource = null;
		if (isContent) {
			nodeSource = tplId;
		} else {
			nodeSource = $(tplId).html();
		}
        
        var nodeTemplate = Handlebars.compile(nodeSource);
        
        if (cache) {
        	tplCache[tplId] = nodeTemplate;
		}
        
        return nodeTemplate(vars);
	},
	
    /**
     * @param title the title for the dialog
     * @param message the message content for the dialog
     * @param Confirm
     * @param callBack function to be called on confirm
     */
    confirmWindow: function( title, message, Confirm, callBack ){

      var templateNode = this.renderTpl(
    	"#bcp-tpl-dialog",
        {'title':title,'message':message},
        false, true
      );

      $(templateNode).dialog({
        bgiframe  : false,
        resizable : true,
        height    : 200,
        modal     : true,
        overlay   :{
          backgroundColor: '#000',
          opacity: 0.5
        },
        buttons:{
          Confirm : function(){
            callBack();
            $(this).dialog('close');
          },
          Cancel : function(){
            $(this).dialog('close');
          }
        }
      });

    },
    
    /**
     * create an error window
     * use this function instead of ulgy alert windows
     * @param title
     * @param message
     */
    errorWindow: function( title, message ){

    	if( console.trace ){
    		console.trace();
    	}

    	if( typeof title === 'string' ){
    		// den 2ten parameter optional machen we
    		if( !message ){
    			message = title;
    			title = 'Error';
    		}
    	} else if( undefined === message ) {

    		// ok sieht so aus als ob wir eine exception bekommen haben
    		message = title.message;
    		title = title.name;
    	}

    	var templateNode = this.renderTpl(
    			"#bcp-tpl-dialog",
    			{'title':title,'message':message},
    			false, true
    	);

    	$(templateNode).dialog({
    		bgiframe: false,
    		resizable: true,
    		height:200,
    		modal: true,
    		overlay:{
    			backgroundColor: '#000',
    			opacity: 0.5
    		},
    		buttons:{
    			confirm : function(){$(this).dialog('close');}
    		}
    	});

    },
    
    /*
     * JS File Logik
     ********************/
        
    /**
     * @param key string der key für das zu ladente Modul
     */
	jsFileLoaded: function( file ){
          
    	if( this.options['js_files'][file] === undefined ){
    		return false;
    	} else{
    		return true;
    	}
          
	}, //end jsFileLoaded 
        
	/**
	 * @param file string der key für das zu ladente Modul
	 */
	loadJsFile: function( file, isList ){
	  
		if( this.options['js_files'][file] === undefined ){
    
			this.options['js_files'][file] = true;
			
			if (isList) {
				$S('head').append( '<script type="text/javascript" src="/js.php?l=list.'+file+'" ></script>' );
			} else {

	    		$S('head').append( '<script type="text/javascript" src="'+file+'" ></script>' );
			}
		}
	},//end loadJsFile
        
    /*
     * Style Logik
     ********************/
          
    /**
     * @param key string der key für das zu ladente Modul
     */
    cssFileLoaded: function( file ){
      
      if( this.options['css_files'][file] === undefined ){
        return false;
      } else{
        return true;
      }
      
    },//end cssFileLoaded
        
    /**
     * @param key string der key für das zu ladente Modul
     */
    loadCssFile: function( file, isList ){
      
      if ( this.options['css_files'][file] === undefined ) {
        this.options['css_files'][file] = true;
        if( isList ){
          $S('head').append( '<link type="text/css" href="css.php?l=list.'+file+'" rel="stylesheet" />' );
        } else{
          $S('head').append( '<link type="text/css" href="'+file+'" rel="stylesheet" />' );
        }
      }
      
    },//end loadCssFile

    /*
     * Use the destroy method to clean up any modifications your
     * widget has made to the DOM
     */
    destroy: function() {

      // remove the overlay
      this.remove();
      jQuery.Widget.prototype.destroy.call( this );
    }

  });

}( jQuery ) );

$(document).desktop();


;(function( $, window,undefined){

  "use strict";

  /**
   * @author dominik alexander bonsch <db@webfrap.net>
   */
  var WgtDesktop = function( ){

    /**
     * make it extendable
     */
    this.fn = WgtDesktop.prototype;

    /**
     * timestamp
     */
    this.timestamp = Date.now();

    /**
     * Array mit Closures welche clear funktionen implementieren
     */
    this.clearCall = {};

    /**
     * Der aktive Maincontainer
     */
    this.actMainCont = null;

    /**
     * self reference
     */
    var self = this;

    /**
     * Schliesen des aktiven Menüs
     * Wird gesetzt um alle möglichen menüs
     */
    this.requestCloseMenu = function(){};

    /**
     * Schliesen des aktiven Menüs
     * Wird gesetzt um alle möglichen menüs
     */
    this.globalCloseMenu = function(){};

    /**
     */
    this.scrollEvents = {};

    /**
     * Actions für einen globalen klick
     * Nur on demand befüllen wenn etwas aktiv ist
     * ansonsten muss geleert werden.
     *
     * Key muss ein valider Selector sein.
     * Es wird regelmäßig gecheckt ob die elemente noch vorhanden sind ansonsten
     * wird die action rausgeworfen
     */
    this.globalClick = {};

    /**
     * global click triggern
     */
    this.triggerGlobalClick = function( event ){

      for (var prop in this.globalClick) {
        if( this.globalClick.hasOwnProperty( prop ) ) {
          if( undefined !== this.globalClick[prop] && this.globalClick[prop] ){
            this.globalClick[prop]( event );
          }
        }
      }

      return true;

    };//end this.triggerGlobalClick */

    /**
     * global click triggern
     * @var event
     */
    this.scrollTrigger = function( ){

      for ( var prop in this.scrollEvents ) {

        if( this.scrollEvents.hasOwnProperty( prop ) ) {
          if( undefined !== this.scrollEvents[prop] ){
            this.scrollEvents[prop]( );
          }
        }

      }

      this.scrollEvents = {};

      return true;

    };//end scrollTrigger */


    /**
     * Shortcut für Save on Strg + S
     */
    this.shortCutSave = function(){};


    /**
     * Den Desktop neu laden
     */
    this.refresh = function( ){
      
      // nur wenn der desktop da ist
      if($('#desktop-panel-message').is('a')){
        var tmp = this.timestamp;
        this.timestamp = Date.now();
        $R.get( 'ajax.php?c=Buiz.Desktop.refresh&timestamp='+tmp, {}, true );
      }

    };



    /**
     * @param title the title for the dialog
     * @param message the message content for the dialog
     * @param Confirm
     * @param callBack function to be called on confirm
     */
    this.confirmWindow = function( title, message, Confirm, callBack ){

      var templateNode = this.template(
        $("#wgt-template-dialog").html(),
        {'title':title,'message':message}
      );

      $(templateNode).dialog({
        bgiframe  : false,
        resizable : true,
        height    : 200,
        modal     : true,
        overlay   :{
          backgroundColor: '#000',
          opacity: 0.5
        },
        buttons:{
          Confirm : function(){
            callBack();
            $(this).dialog('close');
          },
          Cancel : function(){
            $(this).dialog('close');
          }
        }
      });

    };


    /**
     * open a new dialog window
     * @param content
     * @param params
     */
    this.openWindow = function( content , params ){

      // umschreiben auf extends
      if( params === undefined  ){
        params = {};
      }
      if( params.resizable === undefined  ){
        params.resizable = true;
      }
      if( params.height === undefined  ){
        params.height = 300;
      }
      if( params.width === undefined ){
        params.width = 400;
      }

      $(content).dialog(params);

    };//end this.openWindow

    /**
     * open an new browser window / popup
     * @param params
     * @return
     */
    this.openBrowserWindow = function( params ){

      // check for required parameters
      if( typeof params === 'undefined' || typeof params.src === 'undefined'  ){
        throw new WgtException('Tried to open Windows without source');
      }

      // check optional Parameters
      if( typeof params.title === 'undefined' ){
        params.title = 'WebFrap Wgt Window';
      }
      if( typeof params.width === 'undefined' ){
        params.width = 1000;
      }
      if( typeof params.height === 'undefined' ){
        params.height = 600;
      }

      var windowParam = "width="+params.width+",height="+params.height;
      windowParam += ",scrollbars=yes,locationbar=false,menubar=false";

      var newWindow = window.open(params.src, params.title, windowParam );
      newWindow.focus();

    };//end this.openBrowserWindow



    /**
     * Dateidownload über ein popup initialisieren
     * @param params
     * @return
     */
    this.startDownload = function( fileName ){


      var windowParam = "width=100,height=100,scrollbars=false,locationbar=false,menubar=false";

      var newWindow = window.open(fileName, 'Download', windowParam );
      newWindow.focus();

    };//end this.startDownload

    /**
    *
    * @param params
    * @return
    */
   this.openImageWindow = function( params ) {

     // check for required parameters
     if( typeof params === 'undefined' || typeof params.src === 'undefined'  ){
       throw new WgtException('Tried to open Windows without source');
     }

     // check optional Parameters
     if ( typeof params.title === 'undefined' ){
       params.title = 'Image Viewer';
     }
     if ( typeof params.width === 'undefined' ){
       params.width = 1000;
     }
     if ( typeof params.height === 'undefined' ){
       params.height = 600;
     }
     if ( typeof params.alt === 'undefined' ){
       params.alt = 'Some Image';
     }

     var windowParam = "width="+params.width+",height="+params.height;
       windowParam += ",scrollbars=yes,locationbar=false,menubar=false";

     var newWindow = window.open('', params.title, windowParam );
     newWindow.document.writeln('<html><head><title>'+params.title+'</title></head><body><img onclick="window.close()" src="'+params.src+'" alt="'+params.src+'" /></body></html>');
     newWindow.focus();

   };//end this.openBrowserWindow

    /**
     * show the progress bar
     */
    this.showProgressBar = function(){


      // sicher stellen, dass der z-index auch ganz oben ist
      var zIndex = window.$B.getNextHighestZindex();

      var progBar = $('#bcp-progress-bar');
      progBar.show();

      progBar.css( 'z-index', zIndex );

    };//end this.showProgressBar

    /**
     * hide the pogress bar
     */
    this.hideProgressBar = function(){

      $('#bcp-progress-bar').hide();
    };


    
    /**
     * aktivieren und deaktivieren der lightbox
     * @param boolean activate
     */
    this.resetForm = function( formId ){
      
      // reset also assigned elements
      var elements = $('.asgd-'+formId+',.fparam-'+formId).not('input[type="checkbox"],input[type="radio"]');
      elements.val('');
      $R.cleanFormParams( formId );
      
      elements.each(function(){
    	  var iNode = $(this);
    	  
    	  if (iNode.is('input[type="checkbox"]')) {
    		  
    		  iNode.attr('checked',false);
    		  
    	  } else if (iNode.is('input[type="radio"]')) {

    		  iNode.attr('selected',false);

    	  } else if (iNode.attr('data-def-value')) {
    		  iNode.val(iNode.attr('data-def-value'));
    	  }
    	  

    	  
      });
      
      $('form#'+formId).each(function(){
        this.reset();
      });
      
    };

   


  };//end function WgtDesktop( )

  // create instance
  //window.$D = new WgtDesktop();

  // short cuts
  $(window).keypress(function(event) {

    //console.log( "pressed "+event.which );

    /*
    if ( (event.which === 115 && event.ctrlKey) || (event.which === 19) ){
      // context element speichern
      alert("Ctrl-S pressed");
      event.preventDefault();
      return false;
    }
    else if ( (event.which === 110 && event.ctrlKey) || (event.which === 19) ){
      // context element new
      alert("Ctrl-N pressed");
      event.preventDefault();
      return false;
    }
    else if ( (event.which === 101 && event.ctrlKey) || (event.which === 19) ){
      // soll globales event sein
      alert("Ctrl-E pressed");
      event.preventDefault();
      return false;
    }
    */

    return true;
  });

  // global click
  /*
  $(window).mouseup(function(event) {
    return $D.triggerGlobalClick(event);
  });
  */
  
  // refresh auf den desktop
  //setInterval( function(){ $D.refresh(); }, 150000  );

})( jQuery, window);
