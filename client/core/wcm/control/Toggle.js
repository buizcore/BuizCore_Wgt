/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */
/**
 * WGT Web Gui Toolkit
 * 
 * Copyright (c) 2009 webfrap.net
 * 
 * http://buizcore.net/WGT
 * 
 * @author Dominik Bonsch <db@webfrap.net>
 * 
 * Depends: 
 *   - jQuery 1.7.2
 * 
 * Dual licensed under the MIT and GPL licenses:
 * @license http://www.opensource.org/licenses/mit-license.php
 * @license http://www.gnu.org/licenses/gpl.html
 */

/**
 * @author dominik bonsch <db@webfrap.net>
 * 
 * WCM zum ein oder ausblenden von Elementen in abhängigkeit vom Checkstatus
 * einer Selectbox
 * 
 */
$R.addAction( 'control_toggle', function( jNode ){
  

  var showNot = jNode.attr('data-not') === '!'?true:false, // invert the visibility
    trgtSrc = jNode.attr('data-target');// any valid jquery selector
  
  // wenn keine checkbox dann einfach toggle
  if (!jNode.is('input[type="checkbox"]')) {
      
      
      if (jNode.is('input[type="radio"]')) {
          
          jNode.on('click.wcm_control_toggle',function(){
              
              var evTNode, 
                  actBox;
              
              if (jNode.attr('data-gc')) {
                  // schliesen des Menüs nach dem Request
                  $D.globalClick.tgcl = null;
                }
              
              evTNode = $S(trgtSrc);
              
              if ($S(this).is(":checked" ) ){
                  
                  if(showNot){
                      evTNode.each(function(){
                          
                          actBox = $S(this);
                              if( actBox.is('[data-hidden="true"]') ){
                                actBox.show();
                              }else{
                                actBox.hide();
                              }
                          });
                      
                  } else {
                      
                      evTNode.each(function(){
                          
                          actBox = $S(this);
                              if( actBox.is('[data-hidden="true"]') ){
                                actBox.hide();
                              }else{
                                actBox.show();
                              }
                          });
                  }
              } else {
                  if(showNot) {
                      
                      evTNode.each(function(){
                          
                          actBox = $S(this);
                              if( actBox.is('[data-hidden="true"]') ){
                                actBox.hide();
                              }else{
                                actBox.show();
                              }
                          });
                      
                  } else {
                      evTNode.each(function(){
                          
                          actBox = $S(this);
                              if( actBox.is('[data-hidden="true"]') ){
                                actBox.show();
                              }else{
                                actBox.hide();
                              }
                          });
                  } 
              }
              
              return true;
              
          });
          
      } else if ( !jNode.is('input[type="checkbox"]') ) {
          
          jNode.on('click.wcm_control_toggle',function(){
          
          if($S(trgtSrc).is(':visible')){
            $S(trgtSrc).hide();
            
            if (jNode.attr('data-gc')) {
              // schliesen des Menüs nach dem Request
              $D.globalClick.tgcl = null;
            }
            
          } else {
            $S(trgtSrc).show();
            
            if (jNode.attr('data-gc')) {
              // schliesen des Menüs nach dem Request
              $D.globalClick.tgcl = function(evt){
                
                var theParent = $S(evt.target).parentX(trgtSrc);
                
                if (!(theParent || $S(evt.target).is(jNode))) {
                  $S(trgtSrc).hide();
                }
              };
            }
          }
          
          return false;      
        });
      }
    
    return;
  }
  

  // hide & show action
  var triggerA = function(){
    
    var 
        trgSrc = jNode.attr('data-target'),
        evTNode = $S(trgtSrc),
        actBox = null;
    

    if( jNode.is(':checked') ){
      
      console.log( 'checked '+trgtSrc+' '+evTNode.length );
      
      if( showNot ){
        evTNode.each(function(){
          
          actBox = $S(this);
          if( actBox.is('[data-hidden="true"]') ){
            actBox.show();
          }else{
            actBox.hide();
          }
        });
        
      } else {
          
        evTNode.each(function(){
          
          actBox = $S(this);
          if( actBox.is('[data-hidden="true"]') ){
            actBox.hide();
          }else{
            actBox.show();
          }
        });
      }
        
    } else {

      if ( showNot ) {
        evTNode.each(function(){
          
          actBox = $S(this);
          if ( actBox.is('[data-hidden="true"]') ) {
            actBox.hide();
          } else {
            actBox.show();
          }
        });
      
      } else{
        
        evTNode.each(function(){
          
          actBox = $S(this);
          if ( actBox.is('[data-hidden="true"]') ) {
            actBox.show();
          } else {
            actBox.hide();
          }
        });
      }
    }
    
  };
  
  // initial check
  $R.oneTimePostAjax(triggerA);
  
  // toggle vissibility on change of the state
  jNode.bind( 'change.wcm_control_toggle', triggerA );
    
  jNode.removeClass( "wcm_control_toggle" );

});


$R.addAction( 'control_close', function( jNode ){
	  

  var trgtSrc = jNode.attr('data-target');
  
	jNode.on('click.wcm_control_toggle',function(){
		$S(trgtSrc).hide();
	    return false;      
	});


  jNode.removeClass( "wcm_control_close" );

});