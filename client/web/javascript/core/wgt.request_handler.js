/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */
/*
 * WGT Web Gui Toolkit
 *
 * Copyright (c) 2009 webfrap.net
 *
 * http://webfrap.net/WGT
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


;(function($R,$,undefined){

  /**
   * @author dominik alexander bonsch <db@webfrap.net>
   */
  var RequestHandler = function( ){

    /**
     * ref to prototype
     */
    this.fn = RequestHandler.prototype;

    /**
     * array with handlers for rich elements
     */
    var elementHandler = [];

    /**
     * @param key:string
     * @param callBack:function
     */
    this.addElementHandler = function( key, callBack ) {
        elementHandler[key]=callBack;
    };

    /**
     * @param xmlData
     * @param statusCallbacks
     */
    this.xml = function( xmlData, statusCallbacks ){

      var rXML = $(xmlData).children("wgt");

      //Error Handling
      if( rXML.get().length === 0 ){
        $D.errorWindow(
          'Sorry, the System was not able to process the server response.'
           +' This can happen when your Browser is in the Offline Mode, or when an internal Server Error occures.'
           +' Please report if this problem persists.'
        );
        console.dir( xmlData );
        return null;
      }


      // interpret head
      var rHead = rXML.find("gui>head");
      if( rHead.get().length > 0 ){
        this.interpretHead( rHead );
      }


      // interpret body
      var rBody = rXML.find("gui>body");
      if( rBody.get().length > 0){
        this.interpretBody( rBody );
      }

      // handle messages
      var messages = rXML.find("gui>messages");
      if( messages.get().length > 0)
        this.processMessages( messages );

      // Global code, is directly executed via eval
      var responseCode = rXML.children("code");
      if ( responseCode.get().length > 0) {
        try {
          (new Function( "$" ,responseCode.text()))( $ );
        } catch( exc ) {
          console.error( 'Failed to execute response code! '+exc.message+' '+responseCode.text() );
        }
      }

      // den status callback ausführen
      var status = rXML.children("status").text();

      console.log( "Request Status "+status );

      if ( statusCallbacks  ) {
        if( undefined !== statusCallbacks[status] ){
          statusCallbacks[status]();
        }
      }

      //Data Tag contains json data
      var responseData = rXML.children("data").text();

      // wenn responsedata reines html ist, einfach zurückgeben
      if ( rXML.children("data").attr('type') == 'html' ) { 
        return responseData;
      }

      try {
          
        if ( '' !== responseData ) {
          var pData = $.parseJSON(responseData);
          return pData;
        } else {
          return null;
        }

      } catch( e ) {
        ///TODO some better error handling
        return null;
      }


    };//end this.handleWGTResponse */

    /**
     * Handler für das Head Tag
     */
    this.interpretHead = function( rXML ){

      // setting new page title
      /*
      if( rXML.children("title").get().length > 0 ){

        var titleVar = rXML.children("title").text();

        if( titleVar ){
          document.title = titleVar;
        }
        else if( $C.windowTitle != undefined ) {
          document.title = $C.windowTitle;
        }
        else{
          document.title = 'Desktop';
        }
      }*/

 

      // follow a redirect
      if(rXML.children("redirect").get().length > 0) {

        rXML.children("redirect").each(function() {
          $R.redirect($(this).text());
        });
      }//end if

    };//end this.interpretHead = function( rXML )

    /**
     * @param rXML
     * process messages
     */
    this.processMessages = function( rXML ){

        // add and delete CSS Files
        if( rXML.children("error").get().length > 0 ){
            $D.addMessage(rXML.children("error").text(), 'error');
        }

        // eine wall message
        if( rXML.children("wall_message").get().length > 0 ){
            $D.confirmWindow(
                    'System Message',
                    rXML.children("wall_message").text()
            );
        }

        // add a warning toast
        if( rXML.children("warning").get().length > 0 ){
            $D.addMessage(rXML.children("warning").text(), 'warning');
        }

        // add a message toast
        if( rXML.children("message").get().length > 0 ){
            $D.addMessage(rXML.children("message").text(), 'success');
        }

    };//end this.processMessages */

    /**
     * @param XMLNode rXML
     */
    this.interpretBody = function( rXML ){

      // the handlers are in wgt/request/handler
      // to add a handler inlcude the handler file after this class
      for( var key in elementHandler ){
        elementHandler[key](rXML.children(key));
      }

    };//end this.interpretBody = function( rXML )

  };//end function WgtRequest

  //set the request handler
  $R.setHandler( new RequestHandler );

})($R,$);

