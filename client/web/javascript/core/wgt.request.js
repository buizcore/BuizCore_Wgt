/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */

/**
 * WGT Web Gui Toolkit
 *
 * http://webfrap.net/WGT
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
 * bcp Request widget
 * @author dominik alexander bonsch <db@webfrap.net>
 *
 */
(function( jQuery) {

  "use strict";
  
  jQuery.widget( "bcp.request", {

    // These options will be used as defaults
    options: {
    },
    
    version: '1.0',
    
    lastRequest : null,
    lastResponse : null,
    
    handler : null,
    
    /**
     * Eventliste für Funktionen vor dem Ajax Request
     */
    rqt_events :{
        'before' : [],
        'after' : [],
        'init' : [],
        'next' : [],
    },

    /**
     * pool with acttions
     */
    actionPool : {},


    // Set up the widget
    _create: function() {
        window.$R = this;
    },

    

    /**
     * Fragen ob der letzte Request ok war
     * @return boolean
     */
    ok: function(lastRequest){

      //console.log( ' status '+self.lastRequest.status );

        if (lastRequest) {
            return !( -1 ===  $.inArray( lastRequest.status, [200,201,202] ) );
        } else {
            return !( -1 ===  $.inArray( this.lastRequest.status, [200,201,202] ) );
        }
      
    },
    
    get: function(requestUrl, params, background){
        
        return this.baseRequest('get',requestUrl, params, background);
    },
    
    put: function(requestUrl, data, params, background){
        if(params === undefined){
            params = {};
        }
        params.data = data;
        return this.baseRequest('put',requestUrl, params, background);
    },
    
    post: function(requestUrl, data, params, background){
        if(params === undefined){
            params = {};
        }
        params.data = data;
        return this.baseRequest('post',requestUrl, params, background);
    },
    
    del: function(requestUrl, data, params, background){
        return this.baseRequest('delete',requestUrl, params, background);
    },

    /**
     * Einen GET Request über das Ajax Interface absetzen
     *
     * @param requestUrl string
     * @param params {}
     * @param background boolean
     */
    baseRequest: function( type, requestUrl, params, background ){
        
        var response = null,
            self = this;

        if( undefined === params ){
            params = {};
        }

        if( undefined !== params.confirm  ){

            $D.confirmWindow(
                'Confirm',
                params.confirm,
                'Confirm',
                function () { 
                    response = self.executeRequest(type, requestUrl, params, background); 
                }
            );

            return response;

        } else {

            return self.executeRequest(type, requestUrl, params, background );

        }

    },
    

    /**
     * Die Haupt Request methode
     *
     * @param params array
     * @param background boolean
     */
    executeRequest: function( type, rqtUrl, params, background ){

        /**
         * WGT request object including
         * the xrqt object
         * extracted data
         * rendering status
         */
        var callback = null,
            self = this,
            responseData,
            requestData = {
                rqt: null,
                data: null,
                status: null
            },
            defParams = {
                  'type': 'post',
                  'async': true,
                  'ctype': 'xml',
                  'before': function(data){},
                  'after': function(data){},
                  'success': function(data){},
                  'error': function(data){},
            };
      
        params = $.extend({}, defParams, params);


        if ( undefined === background ) {
            background = false;
        }


        // events trigger die vor einem ajax request ausgeführt werden
        self.eventBeforeAjaxRequest( background );

        if( undefined === params.callback ){

            callback = function(){

                // wenn vorhanden original debug consolen content löschen
                self.eventAfterAjaxRequest( background );
            };

        } else {

            callback = function(){
                params.callback();
                self.eventAfterAjaxRequest( background );
            };
        }

        if( undefined === params.error ){

            params.error = function( response ){
                callback();
                if( true === params.async ){
                    self.lastResponse = response;
                    responseData = self.handler.xml( response.responseXML, params.statusCallback  );
                    requestData.data = responseData;
                }

            };
        }

        if( true === params.async ) { // async

            try{
                console.log('async request: '+rqtUrl+'&rqt=ajax'+'&csrf='+$('#wgt-csrf-token').attr('content') );
                self.lastRequest = $.ajax ({
                    type: type,
                    url: rqtUrl+'&rqt=ajax'+'&csrf='+$('#wgt-csrf-token').attr('content'),
                    data: params.data,
                    async: true,
                    success: function( responseXML ) {

                        self.lastResponse = responseXML;
                  
                        
                        responseData = self.handler.xml( responseXML, params.statusCallback  );
                        requestData.data = responseData;
                        requestData.rqt = responseXML;
                        requestData.status = 0;
                        console.log( 'Request 995: '+requestData.rqt.status );

                        params.success( responseXML, responseData );

                        callback();

                    },
                    error:  params.error
                });


                // schliesen des Menüs nach dem Request
                if( !background ){
                  //$D.requestCloseMenu();
                }
                
          } catch( exc ) {

            requestData.rqt = null;
            requestData.status = 1;

            $D.errorWindow( exc );
          }


          return null;

      } else { // sync

          // wann wird die exception geworfen?
          try {
              
              console.log('async request: '+rqtUrl+'&rqt=ajax'+'&csrf='+$('#wgt-csrf-token').attr('content') );

              self.lastRequest = $.ajax({
                  type:   type,
                  url:    rqtUrl+'&rqt=ajax&csrf='+$('#bcp-csrf-token').attr('content'),
                  data:   params.data,
                  async:  false,
                  error:  params.error
              });

              if (undefined !== self.lastRequest.responseXML) {

                  self.lastResponse = self.lastRequest.responseXML;
                  responseData = handler.xml( self.lastResponse, params.statusCallback );
                
              } else if (undefined !== self.lastRequest.responseJSON) {
                
                  responseData = self.lastRequest.responseJSON;
                
              } else {
             
                  responseData = self.lastRequest.responseTEXT;
              }

            if( this.ok() &&  params.success ){
                console.log( 'wgt sync request trigger success' );
                params.success( self.lastRequest, responseData );
            }

            // callback nach dem request
            callback();

            requestData.status = 0;
            
          } catch( exc ){

            requestData.status = 1;
            $D.errorWindow( exc );
          }


            requestData.rqt = self.lastRequest;
            requestData.data = responseData;

            console.log( 'Request 1042: '+requestData.rqt.status );

            return requestData;

        }
    },
    
    /**
     * @param formId
     * @param params
     */
    form: function( formId, params ){

        var form = null,
            formMethod = '',
            formUrl,
            data;

        if ( undefined === params ) {
            params = {};
        }

        // check ob wir ein object oder eine id bekommen
        if( typeof formId === 'object'  ){
            form = formId;
            formId = form.attr('id');
        } else {
            form = $("form#"+formId);
        }

        if ( !form ) {
            console.error( 'Missing the form node '+formId );
            return;
        }

        // methode
        if (params.method) {
        
            formMethod = params.method.toLowerCase();
        
        } else {
        
            formMethod = form.attr('method');

            if (!formMethod) {
                formMethod = 'post';
            }

            formMethod = formMethod.toLowerCase();
        }
      

        if( params.custom_url ){
            formUrl = params.custom_url;
        } else {
            formUrl = form.attr("action");
        }
      
        // form data
        params.data = this.extractFormData(form, formId, params.addition_data);

        return this.baseRequest( formMethod, formUrl, params, false );

    },
    
    /**
     * @param formNode
     * @param formId
     * @param additionData
     */
    extractFormData: function( formNode, formId, additionData ) {
        
        var 
            self = this,
            formData = '',
            formFields = formNode
                .find(":input")
                .not(":submit").not(":reset")
                .not(".wgt-ignore").not('.asgd-'+formId).not('.fparam-'+formId), 
            externFields = $('.asgd-'+formId).not('.flag-template'), // keine templates
            embededValues = externFields.not(':input').not('img'), // nicht :input form felder
            imageValues = externFields.filter('img'), // img als input element
            externFields = externFields.filter(':input'); // extern field hat nur noch inputs
        
        formData = formFields.serialize();
          

        // nicht gecheckte checkboxen mitschicken auser wenn nullable
        formFields.filter('input[type="checkbox"]').not(":checked,.nullable").each( function(){
            formData += '&'+$(this).attr('name')+'=0';
        });

        // custom addition data fields
        if( additionData !== undefined ){
            for ( var key in additionData ) {
                formData += '&'+key+'='+params.data[key];
            }
        } 

        // einfügen der externen felder
        if (externFields.length > 0) {

            formData += '&'+externFields.serialize();
  
            externFields.filter('input[type="checkbox"]').not(":checked").each(function(){
                formData += '&'+$(this).attr('name')+'=0';
            });
        }
        
        // einbinden der not :input values
        if (embededValues.length > 0) {

            embededValues.each(function(){
                var tmp = $(this),
                    cleaned = tmp.html();
                
                var cleanedNode = $('<div>'+cleaned+'</div>');
                cleanedNode.find('.state-editor-initialized').removeClass('state-editor-initialized');
                cleaned = cleanedNode.html();
                
                formData += '&'+tmp.attr('data-key')+'='+encodeURIComponent(cleaned);
            });
        }
        
        if (imageValues.length > 0) {
            var imgNode = null;
            imageValues.each(function(){
     
                imgNode = $(this);
                formData += '&'+imgNode.attr('data-key')+'='+imgNode.attr('src');
                
                if (imgNode.attr('data-key-alt')) {
                    formData += '&'+imgNode.attr('data-key-alt')+'='+imgNode.attr('alt');
                }   
                if (imgNode.attr('data-key-name')) {
                    formData += '&'+imgNode.attr('data-key-name')+'='+imgNode.attr('data-img-name');
                }
                if (imgNode.attr('data-key-key')) {
                    formData += '&'+imgNode.attr('data-key-key')+'='+imgNode.attr('data-img-key');
                }
                /*
                if (imgNode.attr('data-key-dim')) {
                    formData += '&'+data[imgNode.attr('data-key-dim')] = imgNode.attr('alt');
                }
                formData += '&'+tmp.attr('name')+'[src]='+tmp.attr('src');
                formData += '&'+tmp.attr('name')+'[alt]='+tmp.attr('alt');
                formData += '&'+tmp.attr('name')+'[dim]='+tmp.attr('data-dim');
                */
            });
         }
        
        return formData;
        
    },
    

    isHtml: function (testString) {
        var htmlRegex = new RegExp("<([A-Za-z][A-Za-z0-9]*)\\b[^>]*>(.*?)</\\1>");
        return htmlRegex.test(testString);
    },
    
    /**
     * @param formId
     * @param params
     */
    searchForm: function( formId, pagePos, submit ){

        var form = null,
            formMethod = '',
            formUrl,
            data;

        if ( undefined === params ) {
            params = {};
        }

        // check ob wir ein object oder eine id bekommen
        if( typeof formId === 'object'  ){
            form = formId;
            formId = form.attr('id');
        } else {
            form = $("form#"+formId);
        }

        if ( !form ) {
            console.error( 'Missing the form node '+formId );
            return;
        }

        // methode
        if (params.method) {
        
            formMethod = params.method.toLowerCase();
        
        } else {
        
            formMethod = form.attr('method');

            if (!formMethod) {
                formMethod = 'post';
            }

            formMethod = formMethod.toLowerCase();
        }
      

        if( params.custom_url ){
            formUrl = params.custom_url;
        } else {
            formUrl = form.attr("action");
        }
      
        // form data
        params.data = this.extractFormData(form, formId, params.addition_data);

        return this.baseRequest( formMethod, formUrl, params, false );

    },
    
    /**
     * @param formId
     * 
     * @todo implement me
     */
    updateFormUrl: function( formId, formNameSpace ){


      var form,
        data = {url:'',post:''};

  
      if (typeof formId === 'string') {
        form = $("form#"+formId);
      } else {
        form = formId;
        formId = form.attr('id');
      }
      
      var start = form.data('start');
      if( start !== undefined && start !== null ){
        data.url += '&start='+start;
      }

      var size = form.data('qsize');
      if( size !== undefined && size !== null ){
        data.url += '&qsize='+size;
      }

      var begin = form.data('begin');
      if( begin !== undefined && begin !== null ){
        data.url += '&begin='+begin;
      }

      var next = form.data('next');
      if( next !== undefined && next !== null ){
        data.url += '&next='+next;
      }

      
      var formSelect = ".fparam-"+formId;
      
      if(formNs){

        formSelect += ",.fparam-"+formNs;
      }
      
      // felder auslesen, die als zusätzliche parameter an eine form gehängt werden
      var addParams = $( formSelect );
      if( addParams.length ){

        data.url += '&'+addParams.serialize();

        addParams.filter('input[type="checkbox"]').not(":checked").each(function(){
          data.url += '&'+$(this).attr('name')+'=0';
        });

      }

      return data;

    },
    
    /**
     * Ein formular abschicken, kein Ajax request!
     * @param formId
     * @param params
     */
    submit: function( formId, search, params ){

      if( undefined === params ){
        params = {};
      }

      if( params.check ){
        if( !$('#'+params.check.input).is(':checked') ){

          $D.errorWindow(
            params.check.title,
            params.check.message,
            'Confirm',
            function (){ $('#'+formId).submit(); }
          );
          return false;
        }
      }

      if (undefined !== params.confirm) {

        $D.confirmWindow(
          params.confirm.title,
          params.confirm.message,
          'Confirm',
          function (){ $('#'+formId).submit(); }
        );
        
      } else {

        $('#'+formId).submit();
      }

      return false;
    },
    
    /**
     * @param callBack
     */
    addBeforeAjaxRequest: function( callBack ) {
      this.addEvent( 'before', callBack )
    },
    
    /**
     * @param callBack
     */
    addAfterAjaxRequest: function( callBack ){
        this.addEvent( 'after', callBack );
    },
    
    /**
     * @param callBack
     */
    addNextRequest: function( callBack ) {
        this.addEvent( 'next', callBack );
    },
    
    /**
     * @param callBack
     */
    addInitRequest: function( callBack ) {
        this.addEvent( 'init', callBack );
    },
    
    /**
     * @param callBack
     */
    addEvent: function( type, callBack ) {
        this.rqt_events[type].push(callBack);
    },

    /**
     * @param key
     * @param callBack
     */
    addAction: function( key, callBack ) {
        this.actionPool[key] = callBack;
    },


    /**
     * @param key
     * @return function
     */
    getAction: function( key ) {
      return this.actionPool[key];
    },
    

    /**
    * Eine WCM Action auf einem definierten Node ausführen
    * @param key string
    * @param jNode jQuery
    * @param params Object
    */
    callAction: function( key, jNode, params ){

      var call = this.actionPool[key];

      if( call ){
        call( jNode, params );
      }

    },
    
   /**
    *
    */
    eventBeforeAjaxRequest: function( background ){

      if ( !background ) {
        //$D.showProgressBar();
      }

      this.triggerEvents('before');

    },

    
   /**
    * @param background
    * @param prefix
    */
    eventAfterAjaxRequest: function( background, prefix ) {

        var self = this;
        
        this.triggerEvents('after');
        
        this.handleWcm();

        this.triggerEvents('next');

        this.rqt_events['next'] = [];

        if( !background ){
            //$D.hideProgressBar();
        }

    },
   
   /**
    * @param prefix
    */
    handleWcm: function( prefix ) {
        
        var self = this;
        
        if (!prefix) {
            prefix = 'wcm';
        }

        // disable Links and use ajax instead (and remove class)
        var allActions = $("."+prefix);
        
        allActions.each(function(){

        var node = $(this),
            classParts = node.classes(),
            tmpLenght = classParts.length;

            for (var index = 0; index < tmpLenght; ++index){

              var callback = classParts[index];

              if( 'wcm_' === callback.substring(0,4) ) {

                var call = self.actionPool[callback.substring(4,callback.length)];

                try{
                  if( typeof call !== 'undefined'){
                    call (node );
                  }
                } catch( exc ) {
                   console.error( 'Error '+exc+' in '+call );
                }

              }
            }

          });
          allActions.removeClass(prefix);
    },
        
   /**
    *
    */
    eventInitRequest: function( ) {

        this.triggerEvents('init');

    },
        
    /**
    *
    */
    triggerEvents: function( key ) {
    
        var events = this.rqt_events[key];
        
        for (var index = 0; index < events.length; ++index) {
    
            var callback = events[index];
            try {

                callback();
            } catch( e ) {

                $D.errorWindow( e.name, e.message );
            }
        }
    
    },
    
    
    /**
     * redirects with post if an array with data is given
     * @param linktarget string
     * @param data array
     */
    redirect: function( linktarget, data ){

        if( undefined === data ){

            window.location.href = linktarget ;
            
        } else {

            var form = '<form id="wgt-form-redirect" class="meta" method="post" action="'+linktarget+'" >';

            $.each(data,function(key,value){
                form += '<input type="text" name="'+key+'" value="'+value+'" />';
            });
            form += '</form>';

            $('body').append(form);
            $('#wgt-form-redirect').submit();
        }

    },
    
    /**
     * @param rqHandler RequestHandler
     */
    setHandler: function( rqHandler ){
        this.handler = rqHandler;
    },
    
    /**
     * @param rqHandler RequestHandler
     */
    getHandler: function( ){
        return this.handler;
    },
    
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

$(document).request();

/**
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

/**
 * @param window the browser window
 * @param $ the jQuery object
 * @param undefined
 */
(function( window, $, undefined ){

  "use strict";

  /**
   * @author dominik bonsch <db@webfrap.net>
   */
  var Request = function( ){




/*//////////////////////////////////////////////////////////////////////////////
 // getter & setter methodes
//////////////////////////////////////////////////////////////////////////////*/




    /**
     * setzen der Reload Flag auf auf einem Form element;
     * @node DomNode
     */
    this.setFormReload = function(node){

      var jqNode = $(node),
        classes = jqNode.classes(),
        tmpLenght = classes.length,
        checkMe = null;

      for (var index = 0; index < tmpLenght; ++index){

        checkMe = classes[index];

        if( 'asgd-' === checkMe.substring(0,5) ) {

          var pFormId = checkMe.substring(5,checkMe.length);

          $('#'+pFormId).attr('data-reload','true');
          break;
        }
      }

    };

    this.sendInputs = function(url, inpKey, callback){
        

        var dataBody = $(inpKey).serialize();
        var params = {};


        console.log('send inputs: '+url+' key: '+inpKey+' '+dataBody );
        
        if(callback){
            params.callback = callback;
        }
        
        $R.post( url, dataBody, params );
        
    };
    




    /**
     * @param formId
     */
    this.cleanFormParams = function( formId ){

      var form;

      if( typeof formId === 'string' ){
        form=$("form#"+formId);
      }
      else{
        form=formId;
      }

      form.data('order',null);
      form.data('start',null);
      //form.data('qsize',null);
      form.data('next',null);
      form.data('begin',null);

      return this;

    };//end this.cleanFormParams



    /**
     * @param url string
     * @param formId string
     */
    this.getFiltered = function( url, formId ){


      var form = null,
        begin = null,
        addParams = null;

      ////%5Btitle%5D
      if( typeof formId === 'string' ){

        form = $("form#"+formId);
      }
      else{

        form = formId;
        formId = form.attr('id');
      }

      var begin = form.data('begin');
      if( begin !== undefined && begin !== null ){
        url += '&begin='+begin;
      }

      // felder auslesen, die als zusätzliche parameter an eine form gehängt werden
      var addParams = $( ".fparam-"+formId );
      if( addParams.length ){

        url += '&'+addParams.serialize();

        addParams.filter('input[type="checkbox"]').not(":checked").each(function(){
          url += '&'+$(this).attr('name')+'=0';
        });

      }

      window.location.href = url;

    };//end this.getFiltered


  };//end function WgtRequest

})( window, $ );

