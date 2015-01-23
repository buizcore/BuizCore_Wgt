/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */
/**
 * WGT Web Gui Toolkit
 * http://webfrap.net/WGT
 *
 * @author Dominik Bonsch <db@webfrap.net>
 */
$R.addAction( 'sparkline_bar', function( jNode ){
  
    jNode.removeClass('wcm_sparkline_bar');
  
    var gsNode = jNode.next(),
        graphData = {};
    
    if (gsNode.is('var')) {
      graphData = window.$B.robustParseJSON(gsNode.text());
    }
    
    graphData.type = 'bar';
    graphData.width = '70px';
    graphData.stackedBarColor = '#007f3f';
    graphData.disableTooltips = true;
  
    jNode.sparkline('html',graphData);

});
