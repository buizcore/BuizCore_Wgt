/* Licence see: /LICENCES/wgt/licence.txt */

/**
 * @author dominik alexander bonsch <db@webfrap.net>
 */
$R.addAction( 'crumb_menu', function( jNode ){

  jNode.removeClass("wcm_crumb_menu");

  var settings = {},
    cfgData = jNode.next(),
    parentMenu = null,
    entries = null;
  
  if( !cfgData.is('var') ){
    cfgData = $S('var#'+jNode.attr('id')+'-cfg-crumbmenu');
    if(cfgData.length>1){
      cfgData = $S(cfgData.get(0));
    }
  }
  
  if( cfgData.is('var') ){
    settings = $WGT.robustParseJSON(cfgData.text());
    //cfgData.remove();
  } else {
    settings = {};
  }
  
  jNode.find('a').each(function(){
    var mEntry = $S(this),
      tabKey = mEntry.attr('tab'),
      url = mEntry.attr('href');
    
    if (tabKey) {
      mEntry.on('click',function(){
        if ($S('.wgt_tabkey_'+tabKey).length) {
          $S('.wgt_tabkey_'+tabKey).click();
          
          if('wgt-ui-desktop'==tabKey&& window.showMenu !== undefined){
              
              /*
              if(window.showMenu !== undefined){
                  window.showMenu();
              }
              */
          }
          
        } else {
          if (url) {
            $R.get(url);
          } else {
            console.error('Missing tabkey: '+tabKey+' and no action on the crumb');
          }
        }
        return false;
      });
    } else {
      mEntry.on('click',function(){
        if (url) {
          $R.get(url);
        } else {
          console.error('No action on the crumb');
        }
        return false;
      });
    }
    
  });
  
  // checken ob wir noch ein parentmenü mitladen müssen
  parentMenu = jNode.find('li.parent');
  if (parentMenu.length) {
    var pKey = parentMenu.first().attr('parent');
    console.log('parent id #'+pKey);
    var parentCrumbs = $S('#'+pKey+' .wgt-panel.maintab .wgt-menu.crumb li').clone(true,true);
    parentCrumbs.find('a').removeClass('active');
    parentCrumbs.last().append('&nbsp;/&nbsp;');
    parentMenu.replaceWith(parentCrumbs);
    //parentMenu.replaceWith($S('#'+parentMenu.attr('parent')+' li').clone(true,true));
  }


});