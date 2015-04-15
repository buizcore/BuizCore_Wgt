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
 *   - jQuery 2.0.0
 * 
 * Dual licensed under the MIT and GPL licenses:
 * @license http://www.opensource.org/licenses/mit-license.php
 * @license http://www.gnu.org/licenses/gpl.html
 */

/**
 * @author dominik bonsch <db@webfrap.net>
 * 
 * WCM zum ein oder ausblenden von tabs abhängig 
 * 
 */
$R.addAction( 'toggle_tab', function( jNode ){
  

  var showNot = jNode.attr('wgt_not') === '!'?true:false, // invert the visibility
    trgtSrc = jNode.attr('wgt_tab'),
    tabKey = jNode.attr('wgt_tab_key');

  
  // hide & show action
  var triggerA = function(){
    
    console.log('toggle_tab '+trgtSrc+' '+tabKey);
    
    var evTNode = $S(trgtSrc);

    if( jNode.is(':checked') ){
      
      if( showNot ){
        if( evTNode.is('[wgt_hidden="true"]') ){
          evTNode.tabHead('showTab',tabKey);
        }else{
          evTNode.tabHead('hideTab',tabKey);
        }
      }
      else{
  
        if( evTNode.is('[wgt_hidden="true"]') ){
          evTNode.tabHead('hideTab',tabKey);
        }else{
          evTNode.tabHead('showTab',tabKey);
        }

      }
        
    } else{

      if( showNot ){

        if( evTNode.is('[wgt_hidden="true"]') ){
          evTNode.tabHead('hideTab',tabKey);
        }else{
          evTNode.tabHead('showTab',tabKey);
        }
      } else {
        
        if( evTNode.is('[wgt_hidden="true"]') ){
          evTNode.tabHead('showTab',tabKey);
        }else{
          evTNode.tabHead('hideTab',tabKey);
        }
      }
    }
    
  };
  
  // initial check
  
  $R.oneTimePostAjax(triggerA);
  
  // toggle vissibility on change of the state
  jNode.bind( 'change', triggerA );
    
  jNode.removeClass( "wcm_toggle_tab" );

});