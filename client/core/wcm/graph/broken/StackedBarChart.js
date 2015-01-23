/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */

/* Data structure
{
 "xl":"",
 "yl":"",
 "values":"State,Under 5 Years,5 to 13 Years,14 to 17 Years,18 to 24 Years,25 to 44 Years,45 to 64 Years,65 Years and Over\n
AL,310504,552339,259034,450818,1231572,1215966,641667\n
AK,52083,85640,42153,74257,198724,183159,50277\n
AZ,515910,828669,362642,601943,1804762,1523681,862573\n
AR,202070,343207,157204,264160,754420,727124,407205\n
CA,2704659,4499890,2159981,3853788,10604510,8819342,4114496\n
CO,358280,587154,261701,466194,1464939,1290094,511094\n
CT,211637,403658,196918,325110,916955,968967,478007\n
DE,59319,99496,47414,84464,230183,230528,121688\n
DC,36352,50439,25225,75569,193557,140043,70648"
}
 */

/**
 * WGT Web Gui Toolkit
 * http://webfrap.net/WGT
 *
 * @author Dominik Bonsch <db@webfrap.net>
 */
$R.addAction( 'stacked_bar_chart', function( jNode ){
  
  jNode.removeClass('wcm_stacked_bar_chart');

  window.$B.loadModule('d3');

  var margin = {top: 20, right: 80, bottom: 60, left: 40},
      width = jNode.innerWidth() - margin.left - margin.right,
      height = jNode.innerHeight() - margin.top - margin.bottom;


var x = d3.scale.ordinal()
  .rangeRoundBands([0, width], .1);

var y = d3.scale.linear()
  .rangeRound([height, 0]);

var xAxis = d3.svg.axis()
  .scale(x)
  .orient("bottom");

var yAxis = d3.svg.axis()
  .scale(y)
  .orient("left");

var color = d3.scale.ordinal()
  .range(["#ff3019","#27ae60","#f1c40f","#3BB1D8","#c0392b","#e67e22","#2c3e50","#34495e","#8e44ad","#7f8c8d","#404A01"]);

var svg = d3.select('#'+jNode.attr('id')).append("svg")
  .attr("width",  width  + margin.left + margin.right)
  .attr("height", height + margin.top  + margin.bottom)
.append("g")
  .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

var graphData = window.$B.robustParseJSON(jNode.find('var').text());
var data = d3.csv.parse(graphData.values);
jNode.find('var').remove();

var labelVar = 'x_axis';
var varNames = d3.keys(data[0]).filter(function (key) { return key !== labelVar;});
color.domain(varNames);

data.forEach(function (d) {
  var y0 = 0;
  d.mapping = varNames.map(function (name) { 
    return {
      name: name,
      label: d[labelVar],
      y0: y0,
      y1: y0 += +d[name]
    };
  });
  d.total = d.mapping[d.mapping.length - 1].y1;
});

x.domain(data.map(function (d) { return d.x_axis; }));
y.domain([0, d3.max(data, function (d) { return d.total; })]);

svg.append("g")
    .attr("class", "x axis")
    .attr("transform", "translate(0," + height + ")")
    .call(xAxis)
    .selectAll("text")  
    .style("text-anchor", "end")
    .attr("dx", "-.8em")
    .attr("dy", ".15em")
    .attr("transform", function(d) {
        return "rotate(-65)" 
    });

svg.append("g")
    .attr("class", "y axis")
    .call(yAxis)
  .append("text")
    .attr("transform", "rotate(-90)")
    .attr("y", 6)
    .attr("dy", ".71em")
    .style("text-anchor", "end")
    .text("Number of Rounds");

var selection = svg.selectAll(".series")
    .data(data)
  .enter().append("g")
    .attr("class", "series")
    .attr("transform", function (d) { return "translate(" + x(d.x_axis) + ",0)"; });

selection.selectAll("rect")
  .data(function (d) { return d.mapping; })
.enter().append("rect")
  .attr("width", x.rangeBand())
  .attr("y", function (d) { return y(d.y1); })
  .attr("height", function (d) { return y(d.y0) - y(d.y1); })
  .style("fill", function (d) { return color(d.name); })
  .style("stroke", "grey")
  .on("mouseover", function (d) { showPopover.call(this, d); })
  .on("mouseout",  function (d) { removePopovers(); })

var legend = svg.selectAll(".legend")
    .data(varNames.slice().reverse())
  .enter().append("g")
    .attr("class", "legend")
    .attr("transform", function (d, i) { return "translate(55," + i * 20 + ")"; });

legend.append("rect")
    .attr("x", width - 10)
    .attr("width", 10)
    .attr("height", 10)
    .style("fill", color)
    .style("stroke", "grey");

legend.append("text")
    .attr("x", width - 12)
    .attr("y", 6)
    .attr("dy", ".35em")
    .style("text-anchor", "end")
    .text(function (d) { return d; });

function removePopovers () {
  $S('.popover').each(function() {
    $(this).remove();
  }); 
}

function showPopover (d) {
  $S(this).popover({
    title: d.name,
    placement: 'auto top',
    container: 'body',
    trigger: 'manual',
    html : true,
    content: function() { 
      return "Quarter: " + d.label + 
             "<br/>Rounds: " + d3.format(",")(d.value ? d.value: d.y1 - d.y0); }
  });
  $S(this).popover('show')
}


});
