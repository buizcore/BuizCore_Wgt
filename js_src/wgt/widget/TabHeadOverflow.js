/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */
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
 * Tab Head Implementierung
 * @author dominik alexander bonsch <db@webfrap.net>
 */
(function( $S, $WGT ) {
  
  "use strict";

  $S.widget( "wgt.tabHead", {
 
    
    // These options will be used as defaults
    options: { 
      align : 'right',
      triggerEvent : 'click',
      vertical : false,
      
      // persistent
      contentBox: null,
      tabHead: null
    },
 

    // Set up the widget
    _create: function() {

      this.init();

    },

    // Set up the widget
    init: function(  ){
        
      var el = this.element,
        self = this,
        opts = this.options;

      // per data binden, dass ichs wieder finde...
      $S('#'+el.attr('id')).data('tabhead',this);

      var ctbId = el.attr('data-tab-body');
      var ctB = $S('#'+ctbId);
      opts.contentBox = ctB;
      
      if(el.hasClass('wgt-tab-head')){
          opts.tabHead = el;
      } else {
          // ansonsten den ersten der nicht bei drei auf den bäumen ist
          opts.tabHead = el.find('.wgt-tab-head:first'); 
      }
      
      if (!opts.vertical) {
    	  opts.vertical = el.is('.vert');
      }
      
      /* kopf nicht auto befüllen
      if( !el.find( 'a.tab' ).length  ){
        var tabhead = el.find('.tab_head');
        
        ctB.find( '.content,.tab-content' ).each(function(){
          var contCon = $S(this);
          tabhead.append( '<li><a class="tab" data-tab="'+contCon.attr('data-tab')+'" >'+contCon.attr('title')+'</a></li>' );
        });
      }
      */

      // das tabbing event
      el.find( 'a.tab' ).bind( 'click.tab_head', function(){

        var tabNode = $S(this);
        
        var tmpSrc = tabNode.attr('data-src');
        
        if( tmpSrc &&  !tabNode.is('.loaded') ){
            tabNode.dblclick(function(){
            $R.get(tmpSrc, {async:true});
          });
        }
        
        if ( tmpSrc && ( tabNode.is('.reload_able') || !tabNode.is('.loaded')) ) {
          tabNode.addClass('loaded');
          $R.get( tmpSrc, {async:true} );
        }
        
        self.activateTab( tabNode.attr('data-tab') );

      });
      
      el.find( 'a.tab' ).each( function(){
        $S(this).addClass('tab_'+$S(this).attr('data-tab'));
      });
        
      // overflow deaktivieren
      //el.find('.tab_overflow button').dropdown( {align:'right'} );
      
      var activeTab = el.find( 'a.tab.active:first' ); // wer wird schon mehrere aktiv setzen?... dont ask
      if( activeTab.length ){
        
          this.activateTab( activeTab.attr('data-tab') );
      } else {
          
          this.activateTab( el.find( 'a.tab:first' ).attr('data-tab') );
      }


    },//end init: function
    

    // Set up the widget
    open: function(  ){

     

    },//end open: function

    // Set up the widget
    handleOverflow: function(  ){
      
      if (this.options.vertical) {
        return;
      }

      var el = this.element,
        self = this,
        hiddenTabs = {},
        allTabWidth = 0;

      var headSize = el.innerWidth()-5;
      var tabHeadSize = el.innerWidth()-30;
      
      var activeTab = el.find( 'a.tab.active' );
      activeTab.show();
      allTabWidth += activeTab.outerWidth()+3;

      el.find( 'a.tab' ).not('.active').each( function(){
        
        var actTab = $S(this);
        allTabWidth += actTab.outerWidth( )+3;
        
        //console.log( "tab "+actTab.attr('data-tab')+" width "+allTabWidth+' > '+tabHeadSize +' '+(actTab.outerWidth( )+3) );
        
        if( tabHeadSize < allTabWidth ){
          
          hiddenTabs[actTab.attr('data-tab')] = actTab;
          actTab.hide();
          
        } else {
          
          actTab.show();
        }
        
      });

      
      if( headSize < allTabWidth ){

        var oOFl = el.find('.tab_overflow');
        
        var oOFlMenu = $S( '#'+oOFl.find('button').attr('data-drop-box')+'-init ul' ) ;
        var oTh = el.find('.tab_head').not('.hidden');// keine versteckten tab heads verwenden
        var oOFlw = oOFl.outerWidth();

        oTh.width( headSize - oOFlw  );

        oOFlMenu.find('li').remove();

        for( var tabKey in hiddenTabs ) {
          
          var newTabEntry = $S('<li><a class="'+tabKey+'" wgt_tab="'+tabKey+'" >'+hiddenTabs[tabKey].html()+'</a></li>');

          oOFlMenu.append( newTabEntry );
          oOFlMenu.find('a.'+tabKey).bind( 'click', function(){
            //self.activateTab( ''+tabKey );
            self.activateTab( $S(this).attr('wgt_tab') );
            $S('.wgt-dropdownbox.opened').removeClass('opened').hide();
          });
          
        }
   
        oOFl.show();
      }

      //console.log( 'headSize '+headSize+' allTabWidth '+allTabWidth ) ;

    },//end handleOverflow: function
      
    /**
     * Den Index eines Tabs über die ID auslesen
     * @param tabId string
     * @return int
     */
    getTabIndex: function( tabId ){
      
      return this.element.find( 'a.tab' ).index( this.element.find( 'a.tab_'+tabId ) );
    },//end getTabIndex: function
    
    /**
     * Die TabId über den Index auslesen
     */
    getIdByIndex: function( idx ){
      
      return $S(this.element.find( 'a.tab' ).get(idx)).attr('data-tab');
    },//end getIdByIndex: function
    
    /**
     * einen neuen tab hinzufügen
     */
    addTab: function( tabData ){
        
      /**
       * key
       * label
       * content 
       */
        
      alert('add tab');
        
      var el = this.element,
        self = this,
        opts = this.options;
      
      var tabHeadCode = '<li><a data-tab="'+tabData.key+'" class="tab tab_'+tabData.key+'" >'+tabData.label+'</a></li>';
      var tabContentCode = '<div class="container" data-tab="'+tabData.key+'" id="'+opts.contentBox.attr('id')+'-'+tabData.key+'">'+tabData.content+'</div>';
      
      opts.tabHead.append( tabHeadCode );
      
      // das tabbing event
      el.find( 'a.tab.tab_'+tabData.key ).bind( 'click.tab_head', function(){

        var tabNode = $S(this);
        self.activateTab( tabNode.attr('data-tab') );
      });
      
      opts.contentBox.append( tabContentCode );
      this.activateTab( tabData.key );
      
    },//end addTab: function
    
    /**
     * Einen Tab Löschen
     */
    removeTab: function( tabId ){
        
      var el = this.element,
        nextActiveId = null,
        opts = this.options;
      
      var tabIndex = this.getTabIndex( tabId ); 

      el.find( 'a.tab_'+tabId ).remove();
      $S('#'+opts.contentBox.attr('id')+'-'+ tabId ).remove();
      
      if( 0 == tabIndex ){
        nextActiveId = this.getIdByIndex(tabIndex);
      } else {
        nextActiveId = this.getIdByIndex((tabIndex-1));
      }
      
      this.activateTab( nextActiveId );

    },//end removeTab: function
    
    /**
     * Einen versteckten Tab sichtbar machen
     */
    activateTab: function( tabId ){
      
      var el = this.element,
      opts = this.options;
      
      var newActTab = el.find( 'a.tab_'+tabId );
      
      // events von disabled tags ignorieren
      if( newActTab.hasClass('disabled') ){
        return false;
      }
      
      el.find( 'a.tab.active' ).removeClass('active').parent().removeClass('active');
      
      opts.contentBox.find('>div.content,>div.tab-content').hide();
      $S('.'+opts.contentBox.attr('id')).hide();
      
      //console.log( 'tab activate #'+opts.contentBox.attr('id')+'-'+ tabId+',.'+opts.contentBox.attr('id')+'.box-'+tabId );
      $S('#'+opts.contentBox.attr('id')+'-'+ tabId+',.'+opts.contentBox.attr('id')+'.box-'+tabId ).show();
      newActTab.addClass('active').show().parent().addClass('active');
      
      var loadUrl = newActTab.attr('wgt_load');
      if( loadUrl ){
        newActTab.removeAttr('wgt_load');
        $R.get( loadUrl, {async:true} );
      }
      
      //this.handleOverflow();
      
    },//end activateTab: function
    
    /**
     * Einen Tab verschieben
     */
    moveTab: function( tabId, newIndex ){

    },//end moveTab: function
    
    /**
     * Einen Tab im head verstecken
     */
    hideTab: function( tabId ){
      
      this.element.find( 'a.tab_'+tabId ).addClass('hidden').removeClass('active').hide();
      //this.handleOverflow();
      
    },//end hideTab: function
    
    /**
     * Einen Tab im head verstecken
     */
    showTab: function( tabId ){
      
      this.element.find( 'a.tab_'+tabId ).removeClass('hidden').show();
      //this.handleOverflow();
      
    },//end showTab: function
    
    /**
     * Einen Tab aktivieren & klickbar machen
     */
    enableTab: function( tabId ){
      
      this.element.find( 'a.tab_'+tabId ).removeClass('disabled');
    },//end enableTab: function
    
    /**
     * Einen Tab deaktivieren
     * klick triggert keine action
     */
    disableTab: function( tabId ){
      
      this.element.find( 'a.tab_'+tabId ).addClass('disabled');
    },//end disableTab: function

    /* 
     * Use the destroy method to clean up any modifications your 
     * widget has made to the DOM
     */
    destroy: function() {

      $S.Widget.prototype.destroy.call( this );
    }

  });

}( jQuery, $WGT ) );

