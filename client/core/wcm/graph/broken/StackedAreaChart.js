/* jshint forin:true, noarg:true, noempty:true, eqeqeq:true, bitwise:true, strict:true, undef:true, unused:true, curly:true, browser:true, devel:true, jquery:true, indent:4, maxerr:50 */

/* Data structure
{
 "xl":"",
 "yl":"",
 "values":"date,IE,Chrome,Firefox,Safari Opera\n
11-Oct-13,41.62,22.36,25.58,9.13,1.22\n
11-Oct-14,41.95,22.15,25.78,8.79,1.25\n
11-Oct-15,37.64,24.77,25.96,10.16,1.39\n
11-Oct-16,37.27,24.65,25.98,10.59,1.44\n
11-Oct-17,42.74,21.87,25.01,9.12,1.17\n
11-Oct-18,42.14,22.22,25.26,9.1,1.19\n
11-Oct-19,41.92,22.42,25.3, 9.07,1.21\n
11-Oct-20,42.41,22.08,25.28,8.94,1.18\n
11-Oct-21,42.74,22.23,25.19,8.5,1.25\n
11-Oct-22,36.95,25.45,26.03,10.06,1.42\n
11-Oct-23,37.52,24.73,25.79,10.46,1.43"
}
 */

/**
 * WGT Web Gui Toolkit
 * http://buizcore.net/WGT
 *
 * @author Dominik Bonsch <db@webfrap.net>
 */
$R.addAction( 'stacked_area_chart', function( jNode ){
  
  jNode.removeClass('wcm_stacked_area_chart');

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
    
    var stack = d3.layout.stack()
      .offset("zero")
      .values(function (d) { return d.values; })
      .x(function (d) { return x(d.label) + x.rangeBand() / 2; })
      .y(function (d) { return d.value; });
    
    var area = d3.svg.area()
      .interpolate("cardinal")
      .x(function (d) { return x(d.label) + x.rangeBand() / 2; })
      .y0(function (d) { return y(d.y0); })
      .y1(function (d) { return y(d.y0 + d.y); });
    
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
    var varNames = d3.keys(data[0])
        .filter(function (key) { return key !== labelVar;});
        color.domain(varNames);
    
    var seriesArr = [], series = {};
    varNames.forEach(function (name) {
      series[name] = {name: name, values:[]};
      seriesArr.push(series[name]);
    });
    
    data.forEach(function (d) {
      varNames.map(function (name) {
        series[name].values.push({name: name, label: d[labelVar], value: +d[name]});
      });
    });
    
    x.domain(data.map(function (d) { return d.x_axis; }));
    
    stack(seriesArr);
    
    y.domain([0, d3.max(seriesArr, function (c) { 
        return d3.max(c.values, function (d) { return d.y0 + d.y; });
    })]);
    
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
      .data(seriesArr)
      .enter().append("g")
        .attr("class", "series");
    
    selection.append("path")
      .attr("class", "streamPath")
      .attr("d", function (d) { return area(d.values); })
      .style("fill", function (d) { return color(d.name); })
      .style("stroke", "grey");
    
    var points = svg.selectAll(".seriesPoints")
      .data(seriesArr)
      .enter().append("g")
        .attr("class", "seriesPoints");
    
    points.selectAll(".point")
      .data(function (d) { return d.values; })
      .enter().append("circle")
       .attr("class", "point")
       .attr("cx", function (d) { return x(d.label) + x.rangeBand() / 2; })
       .attr("cy", function (d) { return y(d.y0 + d.y); })
       .attr("r", "10px")
       .style("fill",function (d) { return color(d.name); })
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
        $S(this).remove();
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
