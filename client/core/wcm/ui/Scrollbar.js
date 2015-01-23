/* Licence see: /LICENCES/wgt/licence.txt */

/**
 * @author dominik alexander bonsch <db@webfrap.net>
 */


$R.addAction( 'ui_scrollbar', function( jNode ){
    
    jNode.removeClass('wcm_ui_scrollbar');

    var container = jNode.find('.nano');
    
    if (container.is('.nano')) {
        
        container.nanoScroller();
        
    } else {
        
        jNode.html( '<div class="nano" ><div class="nano-content" >'+jNode.html()+'</div></div>' );
        jNode.find('.nano').nanoScroller();
    }
    
});



  