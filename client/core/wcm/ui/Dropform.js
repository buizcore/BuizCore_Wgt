/* Licence see: /LICENCES/wgt/licence.txt */

/**
 * @author dominik alexander bonsch <db@webfrap.net>
 */
$R.addAction( 'ui_dropform', function( jNode ){

  var source = jNode.find( 'var:first' ),
      confAddr = null;
    props = {};
  
  // entfernen der klasse
  jNode.removeClass('wcm_ui_dropform');

  //console.log( 'before var' );
  if (source.is('var')) {
    props =  $WGT.robustParseJSON( source.text() );
    source.remove();
  } else {
      
      confAddr = jNode.attr('data-conf-ui_dropform');
      
      if (confAddr) {
          
          source = $(confAddr);
          
          if (source.is('var')) {
              props =  $WGT.robustParseJSON( source.text() );
              source.remove();
          }
      }
  }

  if( undefined === props.button ){
    props.button = 'Close';
  }else if( '' === props.button ){
    props.plain = true;
  }

  if( undefined === props.noBorder ){
    props.noBorder = false;
  }

  var menuWidth = '750px',
    menuItems = [],
    overlayData,
    nextNode,
    nodeId,
    sizes = {
      'xsmall':'250px',
      'small':'350px',
      'medium':'500px',
      'big':'750px',
      'huge':'90%'
    };

  //console.log( 'before in size' );

  // menu sizes
  if( undefined !== props.size && undefined !== sizes[props.size] ){
    //console.log( 'log in size '+props.size );
    menuWidth = sizes[props.size];
    console.log( jNode.attr('id')+' menu size now '+menuWidth);
  } else if( undefined !== props.width ){
    menuWidth = props.width;
  }

  props.menuWidth = menuWidth;

  if( props.url ){

    jNode.click( function( event ){

      nextNode = jNode.next();
      nodeId = jNode.attr('id');

      overlayData = jNode.data( 'mini-menu-overlay' );

      if( !overlayData && nextNode.is( '.'+nodeId ) ){
        overlayData = nextNode.html();
        jNode.data( 'mini-menu-overlay', overlayData );
      }

      // wenn nicht vorhanden vom server laden
      if( !overlayData && props.url  ){  //!nextNode.is( '.'+nodeId ) ){

        var theTemplate = $R.get( props.url+'&input='+nodeId ).data;
        props.url = null; // sicher stellen, dass wir in keiner endlosschleife landen
        jNode.data( 'mini-menu-overlay', theTemplate );

        //var theContentNode = $S( '.'+nodeId );
        var theContent = $S( '<div>'+theTemplate+'</div>' );

        theContent.find( ':input' ).removeClass( 'flag-template' );

        ///TODO add i from search form to make order persistent
        menuItems.push({
          type : 'html',
          content : theContent.html()
        });

        props.globalClose = false;
        props.align = 'middle';
        props.overlayStyle = {"width":props.menuWidth};
        props.menuItems = menuItems;

        jNode.miniMenu(props);

        jNode.click();
      }

    });

  } else {
      
    nodeId = jNode.attr('wgt-drop-box');
    
    if (!nodeId) {
      nodeId = jNode.attr('id');
    }
    
    nextNode = $S('.'+nodeId);

    overlayData = jNode.data( 'mini-menu-overlay' );
      
    // der nächste node muss als klasse die id des triggers haben
    if( !overlayData  ){

      if ( nextNode.is( '.'+nodeId )){
        overlayData = nextNode.html();
        jNode.data( 'mini-menu-overlay', overlayData );
        nextNode.remove();
      } 
    }

    //var theContentNode = $S( '.'+jNode.attr('id') );
    var theContent = $S('<div>'+overlayData+'</div>');

    theContent.find(':input').removeClass('flag-template');

    ///TODO add i from search form to make order persistent
    menuItems.push({
      type : 'html',
      content : theContent.html()
    });
    
    var overLayStyle = {"width":props.menuWidth};
    
    if( undefined !== props.height ){
      overLayStyle.height = props.height;
      console.log('height '+props.height);
    }
    if( undefined === props.trigger ){
      props.trigger = 'click';
    }


    props.globalClose = false;
    props.align = 'middle';
    props.overlayStyle = overLayStyle;
    props.menuItems = menuItems;

    jNode.miniMenu(props);
  }

});