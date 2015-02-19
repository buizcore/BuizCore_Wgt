/* Licence see: /LICENCES/wgt/licence.txt */

/**
 * @author dominik alexander bonsch <db@webfrap.net>
 * @param jNode the jQuery Object of the target node
 */
$R.addAction( 'form_treeselect', function( jNode ){

  jNode.removeClass('wcm_form_treeselect');
  
  jNode.mtree();
  
  jNode.find('a').on('click.treeselect',function(){ 
     
      
      if ($(this).is('.value_node')) {
          $(jNode.attr('data-target-field')+'-text').val($(this).text());
          $(jNode.attr('data-target-field')).val($(this).attr('data-value'));
      } else {
          $(jNode.attr('data-target-field')+'-text').val('');
          $(jNode.attr('data-target-field')).val('');
      }

      return false;
  });

});