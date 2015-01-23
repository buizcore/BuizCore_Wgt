/* Licence see: /LICENCES/wgt/licence.txt */

/**
 * @author dominik alexander bonsch <db@webfrap.net>
 */
(function($R,$S){

  $R.getHandler().addElementHandler( 'tab', function( childNodes ){
      
    
    childNodes.each(function() {

      // first check if the window should be closed

      var tabObj = $S(this);

      var closeTab = tabObj.attr("close");
      
      if( undefined != closeTab && closeTab === "true" ){
        
        console.log( 'Close Tab: '+tabObj.attr("id") );
        
        $UI.tab.remove( 'wgt-maintab', tabObj.attr("id") );
        $D.closeView();
      }

    });

    childNodes.each(function() {

      // first check if the window should be closed
      $S('.wgt-overlay-container').remove();

      var tabObj = $S(this);
      
      $UI.tab.removeIfExists('wgt-maintab',tabObj.attr("id"));
      
      var title = tabObj.attr('title');
      if( title ){
        $D.setTitle( title );
      }
        
      var closeTab = tabObj.attr("close");
      if( !(undefined != closeTab && closeTab == "true") ){
        
        console.log('Open Tab: '+tabObj.attr("id"));
        
        // sollte ein modal offen sein, jetzt schliesen
        $S.modal.close();

        var tabData = {};
        tabData.text = tabObj.attr('label');
        tabData.id = tabObj.attr('id');
        tabData.closeable = (tabObj.attr('closeable')==undefined)?false:true;
        tabData.content = tabObj.find('body').text();
        tabData.script = tabObj.find('script').text();
        $UI.tab.add( 'wgt-maintab', tabData );
        
        if (tabObj.attr('sub_tab')) {
          
          $R.oneTimePostAjax(function() {
            
            if (!$S('#'+tabObj.attr('id')+'-head').find('a[tab="'+tabObj.attr('sub_tab')+'"]').is('a')) {
              return;
            }
            
            var idx = $S('#'+tabObj.attr('id')+'-head')
              .find('h3')
              .index($S('#'+tabObj.attr('id')+'-head')
                  .find('a[tab="'+tabObj.attr('sub_tab')+'"]')
                  .parent());
            
            $S('#'+tabObj.attr('id')+'-head').accordion( "option", "active", idx);
          });
          

        }
        
        if(window.hideMenu !== undefined){
            window.hideMenu();
        }
        
      }

    });
  
  });

})($R,$S);