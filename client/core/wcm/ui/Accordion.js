/* Licence see: /LICENCES/wgt/licence.txt */

/**
 * @author dominik alexander bonsch <db@webfrap.net>
 * @param jNode the jQuery Object of the target node
 */
$R.addAction( 'ui_accordion', function( jNode ){
  
    var settings = {
        icons:null,
        animate:false
      };
    
    try{
      
      var cfgData = jNode.next();
      settings = cfgData.is('var')
        ? $WGT.robustParseJSON(cfgData.text())
        : {autoHeight: true,fillSpace: true,animate: false, icons:null};
    }
    catch(err){
      
      $D.errorWindow( 'UI Error', err.description );
    }
    settings.animate=false;
  
    jNode.accordion(settings);
    jNode.removeClass('wcm_ui_accordion');

});