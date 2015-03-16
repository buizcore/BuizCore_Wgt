/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */
/**
 * WGT Web Gui Toolkit
 * http://buizcore.net/WGT
 *
 * @author Dominik Bonsch <db@webfrap.net>
 */
$R.addAction( 'sparkline_pie', function( jNode ){
  
  jNode.removeClass('wcm_sparkline_pie');
  
  jNode.sparkline('html',{
    type:'pie',
    barColor: 'red'
  });

});
