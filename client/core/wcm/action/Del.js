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
 * @author dominik bonsch <db@webfrap.net>
 * 
 * @todo i18n
 */
$R.addAction( 'req_del', function( jNode ){
  
  
  var node = jNode.get(0);
  
  if('a'==node.tagName.toLowerCase()){
    
    jNode.on('click',function(){
      
      var delHref = this.href,
        confirm = this.getAttribute('data-confirm');

      if( !confirm ){
        confirm = 'are you shure, you want to delete this entry?';
      }

      $D.confirmWindow(
        'Please confirm',
        confirm,
        'delete',
        function (){$R.del(delHref+"&request=ajax");}
      );
        
      return false;
      
    });
    
  } else {
    
    jNode.on('click',function(){
      
      var link = this.getAttribute('data-action'),
        confimation = this.getAttribute('data-confirm');

      if(!confimation){
        confimation = 'are you shure, you want to delete this entry?';
      }
      
      $D.confirmWindow(
        'Please confirm',
        confimation,
        'delete',
        function (){$R.del(link+"&request=ajax");}
      );
        
      return false;
      
    });
    

    
  }

  jNode.removeClass("wcm_req_del");

});





$R.addAction( 'req_del_selection', function( jNode ){

  jNode.click(function(){
    
    var delHref = this.href;

    if( this.title == undefined ){
      this.title = 'Are you shure, you want to delete this entries?';
    }
    
    $S( jNode.attr( 'wgt_elem' ) ).find( 'tr.wgt-selected' ).each(function(){
      delHref += '&slct[]='+$S(this).attr('wgt_eid');
    });
    
    $S( jNode.attr( 'wgt_elem' ) ).find( 'input.wgt-eid:checked' ).each(function(){
      delHref += '&'+$S(this).attr('name')+'='+$S(this).val();
    });

    $D.confirmWindow(
      this.title ,
      this.title ,
      'delete',
      function (){$R.del(delHref+"&request=ajax");}
    );
      
    return false;
    
  });
  jNode.removeClass("wcm_req_del_selection");

});