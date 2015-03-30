/* Licence see: /LICENCES/wgt/licence.txt */

/**
 * @author dominik alexander bonsch <db@webfrap.net>
 */
$R.addAction( 'req_search', function( jNode ){

  "use strict";

  jNode.removeClass('wcm_req_search');

  var nForm = jNode.parentX('form'),
    formId,
    evAction,
    fTrigger,
    parentSelector,
    triggerNode,
    dropBox;
  
  parentSelector = jNode.attr('data-parent-click');
  
  if (parentSelector) {
      triggerNode = jNode.parentX(parentSelector);
  } else {
      triggerNode = jNode;
  }

  if( !nForm ){


    // ist als parameter an eine form gebunden
    formId = jNode.getActionClass('up',true,'-');
    
    if(!formId){
        // ist als parameter an eine form gebunden
        formId = jNode.getActionClass('fparam',true,'-');
    }
    
    if(!formId){
        // ist als parameter an eine form gebunden
        formId = jNode.getActionClass('dp',true,'-');
    }
    
    if(!formId){
        // ist als parameter an eine form gebunden
        formId = jNode.getActionClass('asgd',true,'-');
    }
    
    if( !formId ){
      console.log("found no form for the given search element");
      return;
    }
    
    nForm = $S('form#'+formId);

    //console.log("found form "+formId);
  } else {
      formId = nForm.attr('id');
  }

  /*
  jNode.change(function(){
    nForm.data('start','0');
    nForm.data('begin',null);

    $R.form( nForm );
    return false;
  });
  */

  evAction = function(e) {
    nForm.data('start','0');
    nForm.data('begin',null);
    $R.form( formId );
    e.preventDefault();
    return false;
  };

  // custom event to trigger a search event
  if( triggerNode.is('input[type=checkbox],input[type=hidden],.search-trigger-onchange') ){

      triggerNode.bind( 'change.wcm_search', evAction );

  } else {

    // on change & on return
      triggerNode.bind( 'change.wcm_search', evAction ).keydown(function(e) {

      fTrigger = false;
      if(e.keyCode === $S.ui.keyCode.RETURN ) {

        nForm.data('start','0');
        nForm.data('begin',null);
        $R.form( formId );
        e.preventDefault();
        return false;
      }

    }).keyup( function(e) {

        if( e.keyCode === $S.ui.keyCode.ESCAPE ){
          jNode.val('');
          nForm.data('start','0');
          nForm.data('begin',null);
          $R.form( formId );
          e.preventDefault();
          return false;
        }

    });

    dropBox = jNode.attr('wgt_drop_trigger');

    if( dropBox ){
        triggerNode.bind( 'click.wcm_search keydown.wcm_search', function(){
        $S('#'+dropBox).dropdown('open');
      });
    }

  }

});


/**
 * @author dominik alexander bonsch <db@webfrap.net>
 */
$R.addAction( 'list_filter', function( jNode ){

    "use strict";

    jNode.removeClass('wcm_list_filter');
  
    try {
        
        var settingsNode = jNode.find('var.list_filter'),
            settings;
        
        settings = settingsNode.is('var.list_filter')
            ? $WGT.robustParseJSON(settingsNode.text())
            : {};
            
    } catch( err ) {
        
        $D.errorWindow( 'Failed to read settings '+jNode.getNodePath('/') , err.description );
    }

    jNode.find('.search-param').on('click', function(){ 
        
        /*
         *  form
            param
            param_name
         */
        
    });

});