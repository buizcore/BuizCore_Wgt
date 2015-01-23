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
  $UI.fn.tab = {
      
    container: null,
    tab: null,

    init: function( containerId, settings ){

      try{

        var $sCont = $S('#'+containerId);
        // alert(containerId);
        if( undefined !== $sCont ){

          var cont = new $UI.fn.tab.container( containerId, settings );
          $sCont.data('wgt-tab_cont-obj',cont);
          cont.init();

          return cont;

        } else {

          $D.message.error(' Internal Error' );
          $D.console( 'Tried to create a tabcontainer for a nonexisting id: '+containerId );
          return null;

        }

      } catch( err ) {
        //alert( err.description );
      }
    },

    get: function( containerId ) {

      return $S('#'+containerId).data('wgt-tab_cont-obj');

    },

    add: function( containerId, tabData ) {

      try {

        var cnt = $UI.tab.get(containerId);
        var tabIndex = cnt.addTab(tabData);
        cnt.appendTabbingEvents();
        cnt.setActiv( tabIndex );
        //cnt.addScrolling();

      } catch( err ) {
        console.error( 'tab add '+err.message );
      }

    },

    remove: function( containerId, tabId ) {
      var cnt = $UI.tab.get(containerId);
      cnt.removeTab(tabId);
    },

    removeonadd: function( containerId, tabId ) {
      var cnt = $UI.tab.get(containerId);

      if(cnt && undefined !==cnt.removeTabOnAdd ){
          cnt.removeTabOnAdd(tabId);
      }
      console.log(' removeonadd '+containerId+' '+tabId);
    },
    
    // tab entfernen wenn er existiert
    removeIfExists: function( containerId, tabId ) {
      var cnt = $UI.tab.get(containerId);

      if( cnt.tabExists( tabId ) ){
        console.log( 'Remove TAB '+tabId+' first' );
        cnt.removeTab( tabId );
      }
    },

    render: function( _containerId ) {
      cnt = $UI.tab.get( _containerId );
    },

    /**
     *
     * @param childNode dom Node
     * @param changed boolean, default = true
     */
    setPTabChanged: function( childNode, changed ) {
      var pTab = $S(childNode).parentX('.wgt-maintab');

      if(undefined===changed){
        changed = true;
      }

      if(pTab){
        pTab.setChanged(changed);
      }
    },

    parentTab: function( _node ) {

      var pTab = _node.parentX('.wgt-maintab');

      if( !pTab )
        return null;

      return pTab.data('wgt-tab-obj');

    }

  };// end WgtUi.prototype.tab
  
  /**
   * @param _contId
   * @param _tabId
   */
  $UI.fn.tab.tab = function( _contId, _tabId ){

    /**
     * @var contId
     */
    var contId = _contId;

    /**
     * @var tabId
     */
    var tabId = _tabId;

    /**
     * @var jObject
     */
    var jObject = $S('#'+tabId);

    /**
     * @var
     */
    var closeEvent = {};

    /**
     * @var
     */
    var saveEvent = {};

    /**
     * flag to check if there where changes on formelements in the tab
     *
     * @var boolean
     */
    var changed = false;

    /**
     *
     */
    this.close = function() {

      if(!changed || confirm("This Tab contains unsaved data. Please save first, or confirm to drop the changes.")){
        // potentiell offenen menü schliesen
        $D.requestCloseMenu();
        // schliesen des Menüs nach dem Request
        $D.requestCloseMenu = function(){};
        $D.closeView();
        $UI.tab.remove(contId, tabId);
        $S('.wgt-overlay-container').remove();
      }
    };

    /**
     * @param name
     * @param callBack
     */
    this.addOnClose = function( name , callBack ){

      closeEvent[name] = callBack;

      return true;

    };// end function addOnClose */

    /**
     * @param name
     * @param callBack
     */
    this.onClose = function( ){

      //Overwrite me to register to the closing event;
      for( var eventKey in closeEvent ){

        var callback = closeEvent[eventKey];
        try{

          callback( tabId  );
        }
        catch( e ){

          $D.errorWindow( e.name, e.message );
          return false;
        }
      }

      return true;

    };// end function onClose */
    
    
    /**
     * @param name
     * @param callBack
     */
    this.onSave = function( name , callBack ){

      saveEvent[name] = callBack;

      return true;

    };// end function onSave */

    /**
     * Trigger the main save function on the tab
     */
    this.save = function(callbacks){
      
      var self = this,
        success = true;
      
      if (undefined === callbacks){
        callbacks = {};
      }
      
      // trigger subrequests
      jObject.find('form.wgt-sub_reqest').each(function(){
        $R.form($S(this).attr('id'));
      });
      
      //Overwrite me to register to the closing event;
      for( var eventKey in saveEvent ){

        var callback = saveEvent[eventKey];
        try{

          callback( self, tabId );
        }
        catch( e ){
          
          if (undefined !== callbacks.fail) {
            callbacks.fail(self, tabId);
          }
          
          $D.errorWindow( e.name, e.message );
          return false;
        }
      }
      
      if (undefined !== callbacks.success) {
        callbacks.success(self, tabId);
      }

      return true;

    };// end function save */
    
    /**
     * @return $S
     */
    this.getObject = function(){

      return jObject;
    };

    /**
     * @return boolean
     */
    this.getChaged = function(){

      return changed;
    };

     /**
       * @param _changed:boolean
       */
    this.setChanged = function(_changed){

      changed = _changed;
    };

  };// end var Tab



})($UI);