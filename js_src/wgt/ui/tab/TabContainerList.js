/* Licence see: /LICENCES/wgt/licence.txt */

/**
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 *
 */
;(function($UI,undefined){
/*
 * ////////////////////////////////////////////////////////////////////////////// //
 * First extend UI
 * //////////////////////////////////////////////////////////////////////////////
 */

  /**
   * @author dominik alexander bonsch <db@webfrap.net>
   */
    $UI.fn.tab.container = function( tabId, _settings ){

      /**
       * @param string
       */
      var container = $S('#'+tabId),

      /**
       * head container
       *
       * @param string
       */
      headContainer = $S('#'+tabId+'-head'),

      /**
       * head container
       *
       * @param string
       */
      bodyContainer = $S('#'+tabId+'-body'),

      /**
       * @param string
       */
      contId = tabId,

      /**
       * @param tabs
       */
      tabs = new Array(),

      /**
       * @var settings Settings
       */
      settings = $S.extend(
        {},
        {"reFocus":true},
        _settings
      ),

      /**
       * @param string
       */
      self = this,

      /**
       *
       */
      clicked = [];

      //console.log( "refocus "+settings.reFocus );

      // constructor block

      if( !headContainer.length )
        headContainer = container.find('.wgt_tab_head').first();

      if( !bodyContainer.length )
        bodyContainer = container.find('.wgt_tab_body').first();

      // Methodes
      
      /**
      *
      */
     this.init = function() {

       if (this.hasTabs()) {
         this.loadTabs();
         this.appendTabbingEvents();
         this.setActiv(0);
       }
       
     };//end this.init */

      /**
       * @lang de:
       *
       * Methode zum erstellen der Tabs
       *
       */
      this.loadTabs = function(){



        // New Style Tabs
        bodyContainer.find('div.wgt_tab').each(function( ) {

          var tabObj = $S(this);

          // only use tabs that have the tabid as class
          if (!tabObj.hasClass(contId)){
            console.log('found non tab subtab '+tabObj.attr('id') );
            return;
          } else {
              console.log('found maintab '+tabObj.attr('id') );
          }

          tabObj.addClass('wgt_tab_content');

          var tabData = {};

          tabData.text = '';
          var tabIcon = tabObj.attr("wgt_icon");
          if( tabIcon )
            tabData.text += '<i class="'+tabIcon+'" ></i>';

          tabData.text += tabObj.attr("title");

          // das title attribute entfernen, sonst nervt der browser mit den titles
          tabObj.removeAttr("title");

          // flags laden
          tabData.disabled = tabObj.hasClass('tab_disabled');
          tabData.closeable = tabObj.hasClass('tab_close_able');


          tabData.id = tabObj.attr("id");
          tabData.init = true;

          console.log( 'TAB id '+tabData.id );

          // if there is a on
          if( tabObj.find("a.wgt_ref").is("a.wgt_ref") ){
            tabData.initLoad = tabObj.find("a.wgt_ref").attr('href');
          }

          self.addTab( tabData );


        });

      };// end this.loadTabs

      /**
       * Prüfen ob es überhaupt Tabs im Container gibt
       * Nötig für Elemente die Standardmäßig einen Tabcontainer haben
       * wie Maintabs oder Subwindows
       */
      this.hasTabs = function(){

        console.log( 'length '+bodyContainer.find('div.wgt_tab').length );

        // New Style Tabs
        if (bodyContainer.find('div.wgt_tab').length > 0)
          return true;
        else
          return false;

      };// end this.hasTabs


      /**
       * Dem Container einen neuen Tab hinzufügen
       *
       * @param tab object
       *   id:
       *   text:
       *   closeable:
       *   disabled:
       *   content:
       *   script:
       *
       * @return int the index of the new tab
       */
      this.addTab = function( tab ){

        var newTab = $S('#'+tab.id);

        console.log('add tab TabContainerList '+tab.id);
        
        if( newTab.length && !tab.init ){

          $UI.tab.removeonadd(contId,tab.id);
        }
        console.log('add tab '+tab.id);

        var tab_size = tabs.length;
        tabs[tab_size] = tab;

        newTab = $S($D.getTemplate('wgt_template_tab-list-head').html());

        var tabLink = newTab.find( "a" );

        tabLink.html(tab.text);
        newTab.attr( "id", contId+"_tab_"+tab.id );

        tabLink.addClass( "wgt_tabkey_"+tab.id );

        if( tab.initLoad != undefined  ){
          tabLink.attr('href',tab.initLoad);
        }

        // dem tab ein close action icon hinzufügen
        if( tab.closeable ){
        	newTab.find('.action').append(
            '<i class="icon-remove icon-2x cursor" '
              +'onclick="$UI.tab.remove(\''+contId+'\',\''+tab.id+'\');"></i>'
          );
        }


        if( tab.disabled ){
          newTab.addClass( 'tab_disabled' );
        }
        
        console.log('append tab '+"wgt_tabkey_"+tab.id);
        headContainer.find( ".tab_container" ).append(newTab);

        // check for visibility

        if( tab.content !== undefined ){
          bodyContainer.append( '<div id="'+tab.id+'" class="wgt_tab_content '+contId+'" >'+tab.content+'</div>' );
        }

        var tabObj = new $UI.fn.tab.tab(contId, tab.id);
        $S('#'+tab.id).data('wgt-tab-obj',tabObj);


        if( tab.check_valid ){
          tabObj.addOnClose( 'check_valid', function(){

            var jObj = tabObj.getObject();
            if( jObj.find('.state-invalid').length )
              throw new WgtUserException("Please recheck your data. It seams that some of the given informations were invalid.");

          });
        }

        try{

          if( tab.script !== undefined ){
            (new Function("self",tab.script))(tabObj);
          }
        } catch( err ) {
          console.error( 'Tab code Failed Code: '+tab.script+' '+err );
        }

        var position = headContainer.find(".tab_container .tab").length-1;

        clicked.push(contId+"_tab_"+tab.id);

        //console.log("Added tab");

        // fokus auf das erste inputelement
        if( 'false' !== settings.reFocus ){
          $S('#'+tab.id).find('input:first').focus();
        }

        // potentiell offenen menü schliesen
        $D.requestCloseMenu();
        // schliesen des Menüs nach dem Request
        $D.requestCloseMenu = function(){};

        return position;

      };// end this.addTab

      /**
       * prüfen ob ein bestimmter Tab existiert
       *
       * @param tabKey
       * @return boolean
       */
      this.tabExists = function( tabKey ){

        return headContainer.find('#'+contId+"_tab_"+tabKey).length;

      };// end tabExists


      /**
       * removes a tab from the container
       *
       * @param tabKey
       */
      this.removeTab = function( tabKey ){

        var toRemove = headContainer.find('#'+contId+"_tab_"+tabKey);
        var indexKey = headContainer.find(".tab_container .tab").index(toRemove);
        var wasActive = toRemove.hasClass('ui-state-active');
        var tabCont = bodyContainer.find("#"+tabKey);

        if( !tabCont.data('wgt-tab-obj').onClose() ){
          return false;
        }


        toRemove.remove();
        tabCont.remove();

        if( wasActive ){

          while( clicked.length > 0 ){

            var prevTabId = clicked.pop();
            var findTab = headContainer.find(".tab_container").find("#"+prevTabId);

            if( findTab.length > 0 ){

              findTab.click();
              break;
            }
          }
        }

        for(var i=0; i< clicked.length; i++){

          if(clicked[i]==toRemove.prop('id')){

              clicked.splice(i,1);
              break;
          }
        }

        if( wasActive ){
          this.setActiv( (indexKey-1) );
        }

      };// end this.removeTab
      
      /**
       * trigger the save function on the tab
       *
       * @param tabKey
       */
      this.saveTab = function( tabKey ){

        var tabCont = bodyContainer.find("#"+tabKey);
        return tabCont.data('wgt-tab-obj').save();
          
      };// end this.saveTab

      /**
       * @param tabKey
       */
      this.removeTabOnAdd = function( tabKey ){

        //alert("remove "+tabKey );
          
        var toRemove = headContainer.find('#'+contId+"_tab_"+tabKey);
        var indexKey = headContainer.find(".tab_container .tab").index(toRemove);
        var wasActive = toRemove.hasClass('ui-state-active');
        toRemove.remove();

        var tabCont = bodyContainer.find("#"+tabKey);
        tabCont.data('wgt-tab-obj').onClose();
        tabCont.remove();

        for(var i=0; i< clicked.length; i++){
          if(clicked[i]==toRemove.prop('id')){
            clicked.splice(i,1);
            break;
          }
        }

      };// end this.removeTabOnAdd


      /**
       * append the events to the tabs, to be able to switch the tabs
       */
      this.appendTabbingEvents = function(){

        // / TAB Wechsel

        var tabs = headContainer.find(".tab_container .tab").not('.initialized');

        tabs.click( function(){

          var tabNode = $S(this);

          if( tabNode.hasClass('tab_disabled') ){
            return false;
          }

          var tabLink = tabNode.find('a').first();
          var classNames = tabLink.classes();
          var tabId = null;

          for( var i=0; i<classNames.length; i++ ){

            var tmp = classNames[i];

            if( tmp.indexOf("wgt_tabkey_") !== -1 ){

              tabId = classNames[i].substr(11);
              break; // break after the first match

            }
          }

          // if there is a url on the tab send a get request
          var tabUrl = tabLink.prop( 'href' );

          if( tabUrl !== undefined ){

            if( !tabLink.hasClass('wgt_loaded') ){

              $R.get( tabUrl, {async:true} );
              tabLink.addClass('wgt_loaded');
            }

          }

          var children = headContainer.find(".tab_container .tab");
          var index = children.index(this);
          children.removeClass("ui-state-active");

          for( var i=0; i< clicked.length; i++ ){
            if( clicked[i]===$S(this).prop('id') ){

              clicked.splice(i,1);
              break;
            }
          }

          clicked.push(tabNode.prop('id'));

          

          var thisTab = children.eq(index);
          thisTab.addClass("ui-state-active");


          var newActiveTab = null;

          // show/hide the tab contentboxes
          if( tabId == null ){

            bodyContainer.find('div.'+contId).hide();
            newActiveTab = bodyContainer.find('div.'+contId).eq(index);

          }
          else {

            bodyContainer.find('div.'+contId).hide();
            newActiveTab = bodyContainer.find('#'+tabId);

          }
          newActiveTab.show().trigger('tabactivate');
          if( 'false' !== settings.reFocus )
            newActiveTab.find('input:first').focus();

          tabNode.addClass('initialized');


          return false;

        });

      };// end this.appendTabbingEvents */


      /**
       * @param index
       */
      this.setActiv = function(index){

        headContainer.find(".tab_container .tab").eq(index).click();

        //console.log( "set tab active "+index );
        if( 'false' !== settings.reFocus )
          bodyContainer.find("div.wgt_tab").eq(index).find('input').not(':hidden,button').first().focus();
      };

      /**
       * Anzahl der Tabs des Tabcontainers auslesen
       * @return int
       */
      this.getTabsNumber = function(){

        return headContainer.find(".tab_container .tab").length;
      };// end this.getTabsNumber

    };// end function WgtTabContainer



})($UI);