/* Licence see: /LICENCES/wgt/licence.txt */

/**
 * @author dominik alexander bonsch <db@webfrap.net>
 */

(function($,$R){

  var actions ={
     'append':function(selector,text){
       
       if($(selector).length>0){
         $(selector).append( text );
       }
     }, 
     'prepend':function(selector,text){

       if($(selector).length>0){
         $(selector).prepend( text );
       }
       
     }, 
     'replace':function(selector,text){
       
       if($(selector).length>0){
         $(selector).replaceWith( text );
       }
     }, 
     'value':function(selector,text){
       
       if($(selector).length>0){
         $(selector).val( text );
       }
     },
     'val':function(selector,text){ // alias für value

       var tn =$(selector);
       if(tn.length>0){
        if(tn.is(':input')){
          $(selector).val( text );
        } else {
          $(selector).html( text );
        }
       }
     },
     'value_change':function(selector,text){
       
       if($(selector).length>0){
         $(selector).val( text );
         $(selector).change();
       }
     },
     'html':function(selector,text){

       if($(selector).length>0){
         $(selector).html( text );
       }
     }, 
     'inc':function(selector,text){$(selector).text((parseInt($(selector).text())+1));},  
     'dec':function(selector,text){$(selector).text((parseInt($(selector).text())-1));},  
     'addClass':function(selector,text){$(selector).addClass( text );},    
     'removeClass':function(selector,text){$(selector).removeClass( text );},  
     'before':function(selector,text){$(selector).before( text );}, 
     'after':function(selector,text){$(selector).after( text );},
     'eval':function(selector,text){eval( text );},
     'function':function(selector,text){(new Function("self",text))( $(selector) );},
     'alert':function(selector,text){alert( text );},
     'remove':function(selector){$(selector).remove();}
  };

  $R.getHandler().addElementHandler( 'htmlArea', function( htmlAreas ){

    if( htmlAreas.get().length > 0 ) {

      htmlAreas.each(function() {
 
        var htmlArea = $(this);
        var action = htmlArea.attr('action');
        var areaId = htmlArea.attr('selector');
         

        var checkSelector = $.trim( htmlArea.attr('check') );
        if( '' == checkSelector )
          checkSelector = false;
        
        var actionElse = $.trim( htmlArea.attr('else') );
        if( ''==actionElse )
          actionElse = false;
        
        var selectorElse = $.trim( htmlArea.attr('select_else') );
        if( ''==selectorElse )
            selectorElse = areaId;
        
        var checkNot = $.trim( htmlArea.attr('not') );
        checkNot = ('true'==checkNot)?true:false
        
        if( !action || typeof action != 'string' || actions[action] === undefined ){
          
          $D.errorWindow('Sorry an Error Occured','Requested nonexisting Action: '+action);
        } else {
          
          if( checkSelector ){
            
            if( checkNot ){
              
              if( $(checkSelector).length==0 ){
                
                actions[action](areaId, htmlArea.text());
              }
              ///TODO need some warning here?
              else if( actionElse && actions[actionElse] !== undefined ){
                
                actions[actionElse](selectorElse, htmlArea.text());
              }
            }
            else{
              
              if($(checkSelector).length>0){
                
                actions[action](areaId, htmlArea.text());
              }
              ///TODO need some warning here?
              else if( actionElse && actions[actionElse] !== undefined ){
                
                actions[actionElse](selectorElse, htmlArea.text());
              } 
            }
          }
          else{
            
            actions[action](areaId, htmlArea.text());
          }
        }

      });
    }
    
  });

})($,$R);