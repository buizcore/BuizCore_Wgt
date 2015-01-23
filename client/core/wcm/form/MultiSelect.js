/* Licence see: /LICENCES/wgt/licence.txt */

/**
 * @author dominik bonsch <db@webfrap.net>
 */
$R.addAction( 'ui_multiselect', function( jNode ){

  jNode.removeClass("wcm_ui_multiselect");
  
  var settings = {'buttonWidth':'100%'};

  var cfgData = $S('var#'+jNode.attr('id')+'-cfg-mslct');
  settings = cfgData.is('var')
    ? $WGT.robustParseJSON(cfgData.text())
    : {};

  jNode.multiselect(settings);

});

$R.addAction( 'ui_multiselect_search', function( jNode ){

  jNode.removeClass("wcm_ui_multiselect_search");
  var formId = jNode.getActionClass('fparam',true,'-'),
    settings = {'buttonWidth':'94%'},
    cfgData = $S('var#'+jNode.attr('id')+'-cfg-mslct');
  
  settings = cfgData.is('var')
    ? $WGT.robustParseJSON(cfgData.text())
    : {
      'buttonWidth':"94%",
      'noneSelectedText':"Filter",
      close: function(){
        $R.form( formId, null, {success:function(){ jNode.focus(); }} );
      }
    };

  jNode.chosen();

});