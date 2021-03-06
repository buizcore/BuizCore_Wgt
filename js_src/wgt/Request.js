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
 *
 * Dual licensed under the MIT and GPL licenses:
 * @license http://www.opensource.org/licenses/mit-license.php
 * @license http://www.gnu.org/licenses/gpl.html
 */

/**
 * @param window the browser window
 * @param $S the jQuery object
 * @param undefined
 */
(function( window, $S, undefined ){

  "use strict";

  /**
   * @author dominik bonsch <db@webfrap.net>
   */
  var Request = function( ){

    /**
     * the version of the request handler
     */
    this.version = 2.0;

    /**
     * ref to prototype
     */
    this.fn = Request.prototype;

    /**
     * das letzte HTTPRequest object
     */
    this.lastRequest = null;

    /**
     * way to self
     */
    var self = this;

    /**
     * the request handler
     * @var RequestHandler
     */
    var handler = null;

  /*//////////////////////////////////////////////////////////////////////////////
  // ajax request event pools
  //////////////////////////////////////////////////////////////////////////////*/

    /**
     * Eventliste für Funktionen vor dem Ajax Request
     */
    this.beforeAjaxRequest = [];

    /**
     * Eventliste für Funktionen nach dem Ajax Request
     */
    this.afterAjaxRequest = [];

      /**
     * Eventliste für Funktionen nach dem Ajax Request
     */
    this.poolOtPostAray = [];

    /**
     * Eventliste für das erste erstellen einer Seite
     */
    this.initRequest = [];

    /**
     * pool with acttions
     */
    this.actionPool = {};

/*//////////////////////////////////////////////////////////////////////////////
 // getter & setter methodes
//////////////////////////////////////////////////////////////////////////////*/

    /**
     * @param rqHandler RequestHandler
     */
    this.setHandler = function( rqHandler ){

      handler = rqHandler;
    };

    /**
     * @return RequestHandler
     */
    this.getHandler = function(){

      return handler;
    };

    /**
     * Fragen ob der letzte Request ok war
     * @return boolean
     */
    this.ok = function(){

      //console.log( ' status '+self.lastRequest.status );

      return !( -1 ===  $S.inArray( self.lastRequest.status, [200,201,202] ) );
    };
    
    this.handelSuccess = function( xml, params ){
      
      if (!params){
        params = {};
      }
      
      $R.lastResponse = xml;
      var responseData = handler.xml(xml);
      //params.success( responseData );
      $R.eventAfterAjaxRequest( );

      if( params.success ){
        params.success( $R.lastResponse, responseData );
        console.log( "trigger upload sucess" );
      }

      if( params.callback ){
        params.callback();
      }
      
    };

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

    /**
     * Einen GET Request über das Ajax Interface absetzen
     *
     * @param requestUrl string
     * @param params {}
     * @param background boolean
     */
    this.get = function( requestUrl, params, background  ){

      // when the url is empty break here
      if( window.$B.empty( requestUrl ) ){
        return null;
      }

      if( undefined === params ){
        params = {};
      }

      /*
      if( params.check ){
        if( !$S('#'+params.check.input).is(':checked') ){

          $D.errorWindow(
            params.check.title,
            params.check.message,
            'Confirm',
            function (){ $S('#'+formId).submit(); }
          );
          return false;
        }
      }
      */

      params.url = requestUrl;
      params.type = 'get';

      if( undefined !== params.confirm  ){

        var response = null;

        $D.confirmWindow(
          'Confirm',
          params.confirm,
          'Confirm',
          function (){ response = self.wgtRequest(params); }
        );

        return response;

      }
      else{

        return self.wgtRequest( params, background );

      }

    };//end this.get
    
    /**
     * Einen GET Request über das Ajax Interface absetzen
     *
     * @param requestUrl string
     */
    this.getJson = function( requestUrl, handleResponse  ){

        $.getJSON(requestUrl, function(data){
            handleResponse( data );
        });

    };//end this.getJson */


    /**
     * Einen POST Request über das Ajax Interface absetzen
     *
     * @param requestUrl
     * @param requestData
     * @param params
     */
    this.post = function(requestUrl, requestData, params){

      // when the url is empty break here
      if( window.$B.empty(requestUrl) ){
        console.error( "triggert post with an empty url" );
        return null;
      }

      if( undefined === params ){
        params = {};
      }

      params.url = requestUrl;
      params.type = 'post';
      params.data = requestData;

      if( undefined !== params.confirm  ){

        var response = null;

        $D.confirmWindow(
          'Confirm',
          params.confirm,
          'Confirm',
          function (){ response = self.wgtRequest( params ); }
        );

        return response;

      }
      else{

        return self.wgtRequest( params );

      }

    };//end this.post */

    /**
     * Einen PUT Request über das Ajax Interface absetzen
     *
     * @param requestUrl
     * @param requestData
     * @param params
     */
    this.put = function(requestUrl, requestData, params){

      // when the url is empty break here
      if( window.$B.empty(requestUrl) ){
        return null;
      }

      if( undefined === params ){
        params = {};
      }

      params.url = requestUrl;
      params.type = 'put';
      params.data = requestData;

      if( undefined !== params.confirm  ){

        var response = null;

        $D.confirmWindow(
          'Confirm',
          params.confirm,
          'Confirm',
          function (){ response = self.wgtRequest( params ); }
        );

        return response;

      }
      else{

        return self.wgtRequest( params );

      }

    };//end this.put */

    /**
     * Einen DELETE Request über das Ajax Interface absetzen
     * @param  requestUrl
     * @param  params
     * @return Json
     */
    this.del = function( requestUrl, params  ){

      // when the url is empty break here
      if( window.$B.empty(requestUrl) ){
        console.error("Requested del with empty url");
        return null;
      }

      if( undefined === params ){
        params = {};
      }

      params.url = requestUrl+'&request=ajax';
      params.type = 'delete';

      if( undefined !== params.confirm ){

        var response = null;

        $D.confirmWindow(
          params.confirm,
          params.confirm,
          'delete',
          function (){ response = self.wgtRequest(params); }
        );
        return response;
      }
      else{

        return self.wgtRequest(params);
      }

    };//end this.del */

    /**
     * Ein formular abschicken, kein Ajax request!
     * @param formId
     * @param params
     */
    this.submit = function( formId, params ){

      if( undefined === params ){
        params = {};
      }

      if( params.check ){
        if( !$S('#'+params.check.input).is(':checked') ){

          $D.errorWindow(
            params.check.title,
            params.check.message,
            'Confirm',
            function (){ $S('#'+formId).submit(); }
          );
          return false;
        }
      }

      if (undefined !== params.confirm) {

        $D.confirmWindow(
          params.confirm.title,
          params.confirm.message,
          'Confirm',
          function (){ $S('#'+formId).submit(); }
        );
        
      } else {

        $S('#'+formId).submit();
      }

      return false;
    };

    /**
     * Abschicken eines Formulars als ajax request
     * @param string formId
     * @param string formUrl
     * @param Array params
     *  @property boolean search 
     *  @property string check.title 
     *  @property string check.message 
     *  @property function statusCallback
     *  @property function sucess
     *  @property function error
     *  @property boolean clean
     *  @property string append
     *  @property string formNs
     */
    this.form = function(formId, formUrl, params){

      if (undefined === params) {
        params = {};
      }

      console.log( "Request by Form ID "+formId+' found '+$S('#'+formId).length  );

      if (params.search) {
        this.cleanFormParams( formId );
      }
      
      //TODO... sicher dass das so stimmt?
      if( params.check ){
        if( !$S('#'+params.check.input).is(':checked') ){

          $D.errorWindow(
            params.check.title,
            params.check.message,
            'Confirm',
            function (){ $S('#'+formId).submit(); }
          );
          return false;
        }
      }

      var response = null;

      if (undefined !== params.confirm) {

        $D.confirmWindow(
          params.confirm.title,
          params.confirm.message,
          'Confirm',
          function (){ response = self.sendForm(formId, formUrl, params); }
        );
        
      } else {

        response = self.sendForm( formId, formUrl, params );
      }

      return response;
    };

    /**
     * setzen der Reload Flag auf auf einem Form element;
     * @node DomNode
     */
    this.setFormReload = function(node){

      var jqNode = $S(node),
        classes = jqNode.classes(),
        tmpLenght = classes.length,
        checkMe = null;

      for (var index = 0; index < tmpLenght; ++index){

        checkMe = classes[index];

        if( 'asgd-' === checkMe.substring(0,5) ) {

          var pFormId = checkMe.substring(5,checkMe.length);

          $S('#'+pFormId).attr('data-reload','true');
          break;
        }
      }

    };

    this.sendInputs = function(url, inpKey, callback){
        

        var dataBody = $S(inpKey).serialize();
        var params = {};


        console.log('send inputs: '+url+' key: '+inpKey+' '+dataBody );
        
        if(callback){
            params.callback = callback;
        }
        
        $R.post( url, dataBody, params );
        
    };
    
    /**
     * @param formId
     * @param formUrl
     * @param params
     */
    this.sendForm = function( formId, formUrl, params ){

      var form = null;
      var response = null;
      var requestParams = {};

      if( undefined === params ){
        params = {};
      }

      if( params.statusCallback ){
        requestParams.statusCallback = params.statusCallback;
      }

      if( params.success ){
        requestParams.success = params.success;
      }

      if( params.error ){
        requestParams.error = params.error;
      }

      if( typeof formId === 'object'  ){

        form = formId;
        formId = form.attr('id');
        
      } else{

        form = $S("form#"+formId);
      }

      if( !form ){
        console.log( 'Missing form '+formId );
        return;
      }

      var formMethod = '',
        flagReload = '';
      
      if (params.method) {
        
        formMethod = params.method.toLowerCase();
        
      } else {
        
        formMethod = form.attr('method');

        if (!formMethod) {
          console.log( 'Missing method in form '+formId );
          return;
        }

        formMethod = formMethod.toLowerCase();
      }
      
      // clean form data
      if( params.clean === true ){

        this.cleanFormParams(form);
      }

      if( true === params.append ){

        formUrl = form.attr("action")+formUrl+"&request=ajax";
      }
      else if( !formUrl ){

        formUrl = form.attr("action")+"&request=ajax";
      }


      flagReload = form.attr('data-reload');

      // wir gehen davon aus, dass der string wenn vorhanden bereits ein valider
      // url part ist
      if('true'==flagReload){
        formUrl += '&reload=true';
      }

      var formParams = this.appendFormParams( form, params.formNs );

      /*
      if($S.ajaxFileUpload)
      {
        alert('Anzahl files '+formId+' '+$S(":file.asgd-"+formId).length);
      }*/


      // check if there file inputs in the form
      if( ( form.find(":file").length || $S(":file.asgd-"+formId+",:file.dp-"+formId).length  ) && $S.ajaxFileUpload ){

        response = $S.ajaxFileUpload({
          url       :formUrl+formParams.url+'&rqt=ajax'+'&csrf='+$S('#wgt-csrf-token').attr('id'),
          secureuri :false,
          formid    :formId,
          dataType  :'xml',
          success   :function( responseXML ){

            $R.lastResponse = responseXML;
            var responseData = handler.xml(responseXML);
            //params.success( responseData );
            $R.eventAfterAjaxRequest( );

            if( params.success ){
              params.success( $R.lastResponse, responseData );
              console.log( "trigger upload sucess" );
            }

            if( params.callback ){
              params.callback();
            }

          },
          error :function (data, status, e){

            if( params.error ){
              params.error( data, status, e );
            }

            $D.errorWindow( e );

          },
          statusCallback: requestParams.statusCallback
        });

        return response;
        
      } else {

        var formFields = form.find(":input").not(":submit").not(":reset").not(".wgt-ignore").not('.asgd-'+formId).not('.fparam-'+formId).not('.dp-'+formId).not('.up-'+formId);
        var formData = formFields.serialize();
        

        // nullable checkboxen werden nicht mitgeschickt
        formFields.filter('input[type="checkbox"]').not(":checked,.nullable").each( function(){
          formData += '&'+$S(this).attr('name')+'=0';
        });

        if( params.data !== undefined ){
          for( var key in params.data ){

            formData += '&'+key+'='+params.data[key];
          }
        }

        /*
        var externFields = $S('.'+formId+'_asgd');
        if( externFields.length > 0 )
          formData += '&'+externFields.serialize();
        */
        /*
        var externFields = $S('.asgd-'+formId).not('.flag-template');
        if( externFields.length > 0 )
          formData += '&'+externFields.serialize();
        */

        var externFields = $S('.asgd-'+formId+',.dp-'+formId).not('.flag-template'),
            embededValues = externFields.not(':input').not('img'),
            imageValues = externFields.filter('img');
        
        externFields = externFields.filter(':input')
        
        if (externFields.length > 0) {

            formData += '&'+externFields.serialize();
            
            externFields.filter('input[type="checkbox"]').not(":checked").each(function(){
                formData += '&'+$S(this).attr('name')+'=0';
            });
        }
        if (embededValues.length > 0) {
            
            //alert( 'embededValues.length '+embededValues.length );
            
            embededValues.each(function(){
              var tmp = $S(this);
              formData += '&'+tmp.attr('name')+'='+encodeURIComponent(tmp.html());
            });
        }
        if (imageValues.length > 0) {
    
            imageValues.each(function(){
              var tmp = $S(this);
              formData += '&'+tmp.attr('name')+'[src]='+tmp.attr('src');
              formData += '&'+tmp.attr('name')+'[alt]='+tmp.attr('alt');
              formData += '&'+tmp.attr('name')+'[dim]='+tmp.attr('data-dim');
            });
        }
        
        if ('post' === formMethod) {

          response = $R.post(
            formUrl+formParams.url,
            formData+formParams.post,
            requestParams
          );

          if( params.callback ){
            params.callback();
          }

        } else if( 'put' === formMethod ){

          response = $R.put(
            formUrl+formParams.url,
            formData+formParams.post,
            requestParams
          );

          if( params.callback ){
            params.callback();
          }

        } else {

          response = $R.get(
            formUrl+formParams.url+'&'+formData+formParams.post,
            requestParams
          );

          if( params.callback ){
            params.callback();
          }

        }

        return response;

      }

    };//end this.form

    /**
     * @param formId
     */
    this.appendFormParams = function( formId, formNs ){


      var form,
        data = {url:'',post:''};

      ////%5Btitle%5D
      if(typeof formId === 'string'){

        form = $S("form#"+formId);
      }
      else{

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

      
      var formSelect = ".fparam-"+formId+",.up-"+formId;
      
      if (formNs) {
        
        //alert('formNs '+formNs);
        
        formSelect += ",.fparam-"+formNs+",.up-"+formNs;
      }
      
      // felder auslesen, die als zusätzliche parameter an eine form gehängt werden
      var addParams = $S( formSelect );
      if( addParams.length ){

        data.url += '&'+addParams.not('.custom-p-name').serialize();

        addParams.filter('.custom-p-name').each(function(){
          data.url += '&'+$S(this).attr('data-p-name')+'='+$S(this).val();
        });
        
        addParams.filter('input[type="checkbox"]').not(":checked").each(function(){
            data.url += '&'+$S(this).attr('name')+'=0';
        });

      }

      return data;

    };//end this.appendFormParams

    /**
     * @param formId
     */
    this.cleanFormParams = function( formId ){

      var form;

      if( typeof formId === 'string' ){
        form=$S("form#"+formId);
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
     * redirects with post if an array with data is given
     * @param linktarget string
     * @param data array
     */
    this.redirect = function( linktarget, data ){

      if( undefined === data ){

        window.location.href = linktarget ;
      }
      else{

        var form = '<form id="wgt_redirect" class="meta" method="post" action="'+linktarget+'" >';

        $S.each(data,function(key,value){
          form += '<input type="text" name="'+key+'" value="'+value+'" />';
        });
        form += '</form>';

        $S('body').append(form);
        $S('#wgt_redirect').submit();
      }

    };

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

        form = $S("form#"+formId);
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
      var addParams = $S( ".fparam-"+formId+".up-"+formId );
      if( addParams.length ){

        url += '&'+addParams.serialize();

        addParams.filter('input[type="checkbox"]').not(":checked").each(function(){
          url += '&'+$S(this).attr('name')+'=0';
        });

      }

      window.location.href = url;

    };//end this.getFiltered

    /**
     * @param url string
     * @param formId string
     */
    this.getBySelection = function( url, tableId ){

      $S('#'+tableId+' tr.wgt-selected').each(function(){
        url += '&e[]='+$S(this).attr('wgt_eid');
      });

      window.location.href = url;

    };//end this.getBySelection



    /**
     * @param lang the language
     */
    this.redirectLang = function( lang ){
      ///@FIXME multiple languages attached if the url has already a lang attr
      ///@FIXME error when noch scriptname ist giffen, default index.php? or fetch var via conf

      window.location.href = window.location.href+'&lang='+lang ;
    };

    /**
     * @param selector
     * @param redirectUrl
     */
    this.redirectByValue = function( selector , redirectUrl ){

      var value = $S(selector).value();
      window.location.href= str_replace( '{id}', value, redirectUrl );
    };

    /**
     * @param selector
     * @param url
     */
    this.showEntity = function( selector , url ){

      if( $S('#'+selector).length === 0){
        return false;
      }

      var value = $S('#'+selector).val();

      if( undefined === value || trim(value) === '' ){
        return false;
      }

      $R.get(url+value);
      return true;

    };//end this.showEntity

    /**
     * Die Haupt Request methode
     *
     * @param params array
     * @param background boolean
     */
    this.wgtRequest = function( params, background ){


      /**
       * WGT request object including
       * the xrqt object
       * extracted data
       * rendering status
       */
      var callback = null,
        responseData,
        requestData = {
            rqt: null,
            data: null,
            status: null
         };


      if( undefined === background )
        background = false;

      // when the url is empty break here
      if( window.$B.undef(params) || window.$B.undef(params.url) ){
        Console.error('Got empty request');
        return false;
      }

      //window.$B.loadModule('request');

      // setting of default values
      window.$B.dval(params,'type','post');
      window.$B.dval(params,'success',function(data){});

      // per default we want synchron request, as most of the requests
      // are in transactions where the response is required for the next
      // steps.
      // please remember this is a client for business applications and not
      // a webbased content viewer!
      window.$B.dval(params,'async',false);
      window.$B.dval(params,'ctype','xml');

      // events trigger die vor einem ajax request ausgeführt werden
      $R.eventBeforeAjaxRequest( background );

      if( undefined === params.callback ){

        callback = function(){

          // wenn vorhanden original debug consolen content löschen
          $S('#wgt_debug_console-content').remove();

          $R.eventAfterAjaxRequest( background );
        };

      }
      else{

        callback = function(){

          // wenn vorhanden original debug consolen content löschen
          $S('#wgt_debug_console-content').remove();

          params.callback();
          $R.eventAfterAjaxRequest( background );
        };
      }

      if( undefined === params.error ){

        params.error = function( response ){

          callback();

          if( true === params.async ){
            $R.lastResponse = response;
            responseData = handler.xml( response.responseXML, params.statusCallback  );
            requestData.data = responseData;
          }

        };

      }

      if( 'xml' === params.ctype ) {

        if( true === params.async ) { // async

          try{

            self.lastRequest = $S.ajax ({
              type:   params.type,
              url:    params.url+'&rqt=ajax'+'&csrf='+$S('#wgt-csrf-token').attr('content'),
              data:   params.data,
              async:  true,
              success: function( responseXML ) {

                $R.lastResponse = responseXML;
                responseData = handler.xml( responseXML, params.statusCallback  );
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
              $D.requestCloseMenu();
            }
          }
          catch( exc ){

            requestData.rqt = null;
            requestData.status = 1;

            $D.errorWindow( exc );
          }


          return null;

        } else { // sync

          // wann wird die exception geworfen?
          try {


            self.lastRequest = $S.ajax({
              type:   params.type,
              url:    params.url+'&rqt=ajax'+'&csrf='+$S('#wgt-csrf-token').attr('content'),
              data:   params.data,
              async:  false,
              error:  params.error
            });

            if(undefined !== self.lastRequest.responseXML){

                self.lastResponse = self.lastRequest.responseXML;
                responseData = handler.xml( self.lastResponse, params.statusCallback );
                
            } else if(undefined !== self.lastRequest.responseJSON) {
                
                responseData = self.lastRequest.responseJSON;
                
            } else {
             
                responseData = self.lastRequest.responseTEXT;
            }
            

            // schliesen des Menüs nach dem Request
            if( !background ){
              $D.requestCloseMenu();
            }

            if( this.ok() &&  params.success ){
              console.log( 'wgt sync request trigger success' );
              params.success( self.lastRequest, responseData );
            }

            // callback nach dem request
            callback();

            requestData.status = 0;
          }
          catch( exc ){

            requestData.status = 1;
            $D.errorWindow( exc );
          }


          requestData.rqt = self.lastRequest;
          requestData.data = responseData;

          console.log( 'Request 1042: '+requestData.rqt.status );

          return requestData;

        }

      } else {

        try {


          self.lastRequest = $S.ajax({
            type:   params.type,
            url:    params.url,
            data:   params.data,
            async:  false,
            dataType: 'json',
            error:  params.error
          });

          var retVal = handler.json( self.lastRequest.responseText, params.statusCallback );

          // schliesen des Menüs nach dem Request
          if( !background ){
            $D.requestCloseMenu();
          }

          if( params.success ){
            params.success( self.lastRequest, retVal );
          }

          callback();

          requestData.status = 0;

        } catch( exc ){

          // error handling
          console.error( 'Request failed '+exc.message );
          $D.errorWindow( exc );
          requestData.status = 1;
        }

        requestData.rqt = self.lastRequest;
        requestData.data = retVal;

        console.log( 'Request 1088: '+requestData.rqt.status );

        return requestData;

      }

    };//end this.wgtRequest */

/*//////////////////////////////////////////////////////////////////////////////
// the methods for the ajax interface events
//////////////////////////////////////////////////////////////////////////////*/

    /**
    * @param callBack
    */
   this.addBeforeAjaxRequest = function( callBack ) {
     this.beforeAjaxRequest.push(callBack);
   };//end this.addBeforeAjaxRequest

   /**
    * @param callBack
    */
   this.addAfterAjaxRequest = function( callBack ){
     this.afterAjaxRequest.push(callBack);
   };//end this.addAfterAjaxRequest

   /**
    * @param callBack
    */
   this.oneTimePostAjax = function( callBack ){
     this.poolOtPostAray.push(callBack);
   };//end this.oneTimePostAjax


   /**
    * @param key
    * @param callBack
    */
   this.addAction = function( key, callBack ){
     this.actionPool[key] = callBack;
   };//end this.oneTimePostAjax


   /**
    * @param key
    * @return function
    */
   this.getAction = function( key ){
     return this.actionPool[key];
   };//end this.getAction

    /**
    * Eine WCM Action auf einem definierten Node ausführen
    * @param key string
    * @param jNode jQuery
    * @param params Object
    */
    this.callAction = function( key, jNode, params ){

      var call = this.actionPool[key];

      if( call ){
        call( jNode, params );
      }

    };//end this.callAction */

   /**
    *
    */
   this.eventBeforeAjaxRequest = function( background ){

      if( !background ){
        $D.showProgressBar();
      }

      for( var func in this.beforeAjaxRequest ){

        var callback = this.beforeAjaxRequest[func];
        try {
          callback();
        }
        catch( exc ) {
          $D.errorWindow( exc );
        }
      }

    };//end this.eventBeforeAjaxRequest

   /**
    * @param background
    * @param prefix
    */
    this.eventAfterAjaxRequest = function( background, prefix ) {

      var startTime = $DBG.start();
      
      if(!prefix){
        prefix = 'wcm';
      }

      var callback = null,
        length = this.afterAjaxRequest.length,
        allActions = null;

      for (var index = 0; index < length; ++index){

        if( undefined !== this.afterAjaxRequest[index] )
          callback = this.afterAjaxRequest[index];
        else
          continue;

        try{
          callback();
        }
        catch( exc ) {

           //alert(e.message);
           $D.errorWindow( exc );
           //this.desktop.errorWindow( exception.name, exception.message );
        }
      }


      // disable Links and use ajax instead (and remove class)
      allActions = $S("."+prefix);
      allActions.each(function(){


        var node = $S(this),
          classParts = node.classes(),
          tmpLenght = classParts.length;

        for (var index = 0; index < tmpLenght; ++index){

          var callback = classParts[index];

          if( 'wcm_' === callback.substring(0,4) ) {

            var call = $R.actionPool[callback.substring(4,callback.length)];

            try{
              if( typeof call !== 'undefined'){
                call (node );
              }
            }
            catch( exc ) {
               //alert(e.message);
               console.error( 'Error '+exc+' in '+call );
               //$D.errorWindow( exc );
               //this.desktop.errorWindow( exception.name, exception.message );
            }

          }
        }

      });
      allActions.removeClass(prefix);

      length = this.poolOtPostAray.length;
      for (var iter = 0; iter < length; ++iter) {

        callback = this.poolOtPostAray[iter];
        try {

          callback();
        } catch( exc ) {

          //alert(e.message);
          $D.errorWindow( exc );
          //this.desktop.errorWindow( exception.name, exception.message );
        }
      }

      this.poolOtPostAray = [];

      if( !background ){
        $D.hideProgressBar();
      }

      console.log('wcm duration ' + $DBG.duration( startTime ) );

    };//end this.eventAfterAjaxRequest

    /**
     *
     */
    this.eventInitRequest = function( ) {

      for (var index = 0; index < this.initRequest.length; ++index) {

        var callback = this.initRequest[index];
        try {

          callback();
        } catch( e ) {

          //alert(e.message);
          $D.errorWindow( e.name, e.message );
          //this.desktop.errorWindow( exception.name, exception.message );
        }
      }
      
      History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
          var State = History.getState(); // Note: We are using History.getState() instead of event.state
          
          if(State.data.state !== undefined){
              
              $S('.wgt_tabkey_wgt-ui-desktop').click();
              
              /*
              if (window.showMenu !== undefined && typeof window.showMenu == 'Function') {
                  window.showMenu();
              }*/
              
              if (State.data.state == 1) {
                  History.go(2);
              }
          }
          
      });
      
      History.pushState({state:1}, "Dashboard", "?tab=wgt-ui-desktop");
      History.pushState({state:2}, "Dashboard", "?tab=wgt-ui-desktop");
      
      $S('#start-overlay').remove();

    };//end this.eventInitRequest

  };//end function WgtRequest

  // Expose Request to the global object
  window.$R = new Request();
  window.$B.loadModule('debug');

})( window, $S );

