/* Licence see: /LICENCES/wgt/licence.txt */

/**
 * @author dominik alexander bonsch <db@webfrap.net>
 */
$R.addAction( 'control_check_button', function( jNode ){

    jNode.removeClass( "wcm_control_check_button" );
  
    var inpNode = jNode.find( 'input' ),
        iconNode = jNode.find( 'i' );
  
    if (inpNode.is(':checked')) {
        jNode.addClass('active');
        iconNode.toggleClass('fa-check-square-o').toggleClass('fa-square-o');
    }
  
    var funcCheckB = function( event ){
         
        console.log( 'click '+inpNode.attr('name') );

        var fCounter = null,
            evTrgt = $S( event.target );
     
        if( inpNode.is( ':checked') ){
  
            fCounter = $S('#'+jNode.attr('wgt_counter'));  
            fCounter.text(  parseInt(fCounter.text()) - 1 );
            jNode.toggleClass( 'active' );
  
            inpNode.prop( 'checked', false );
            inpNode.change();
            iconNode.toggleClass('fa-check-square-o').toggleClass('fa-square-o');

        } else {
  
            fCounter = $S('#'+jNode.attr('wgt_counter'));  
            fCounter.text(  parseInt(fCounter.text()) + 1 );
  
            inpNode.val(1);
            jNode.toggleClass( 'active' );
  
            inpNode.prop( 'checked', 'checked' );
            inpNode.change();
            iconNode.toggleClass('fa-check-square-o').toggleClass('fa-square-o');

        }
        
        event.stopPropagation();
        return false;
      
    };
  
    // togle check onclick
    jNode.bind( 'mouseup',  funcCheckB );
    //inpNode.bind( 'mouseup',  funcCheckB );

});