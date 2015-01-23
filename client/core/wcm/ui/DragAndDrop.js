/* Licence see: /LICENCES/wgt/licence.txt */

/**
 * Diverse Generische Drag & Drop Elemente
 */

/**
 * @author dominik alexander bonsch <db@webfrap.net>
 */
$R.addAction( 'ui_sortable', function( jNode ){
	
	jNode.removeClass('wcm_ui_sortable');
	
	jNode.sortable();
	jNode.disableSelection();
	
	jNode.children().addClass('wgt-cursor-move');

});

