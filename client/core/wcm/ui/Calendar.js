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
 *   code lang: english
 *   naming style: camel case
 * 
 */

/**
 * @author dominik bonsch <db@webfrap.net>
 * @param jNode the jQuery Object of the target node
 */
$R.addAction( 'ui_calendar', function( jNode ){
  
  
  jNode.removeClass('wcm_ui_calendar');
  
  jNode.appear(function(){
    
    var calId = jNode.attr('id'),
    	tmpId = calId.substring( 4, calId.length );
	  
    var defSettings = {
        header: {
            left: 'prevYear,prev,today,next,nextYear',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
          
          $R.put( 'ajax.php?c=Buiz.Calendar.move&calendar='+calId,
                {'start':moment(event.start).format("YYYY-MM-DD HH:mm")+':00',
                 'end':moment(event.end).format("YYYY-MM-DD HH:mm")+':00'}
          );
          
          // Event verschieben 
          /*
          alert(
              
              event.title + " was moved " +
              event.start.toString("yyyy-mm-dd HH:ii") + " new start "
          );*/
  
        },
        eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
        
          $R.put( 'ajax.php?c=Buiz.Calendar.move&calendar='+calId,
              {'start':moment(event.start).format("YYYY-MM-DD HH:mm")+':00',
               'end':moment(event.end).format("YYYY-MM-DD HH:mm")+':00'}
          );
  
        }
  
    };
    
	var cfgData = jNode.next(),
		settings = cfgData.is('var')
	    ? $WGT.robustParseJSON(cfgData.text())
	    : {};
	          
    settings = $S.extend({}, defSettings, settings);
    
    settings.events = function(start, end, callback) {
    	
    	var data = $R.get(
    	    'ajax.php?c=Buiz.Calendar.search&calendar='+calId
    	    +'=&start='+Math.round(start.getTime() / 1000)
    	    +'&end='+Math.round(end.getTime() / 1000),{},true
    	);
    	callback(data.data);
    };
    
    
    var formObj = $S('#wgt-form-'+tmpId);

    // erstellen des calendar nodes
    var calendarObj = jNode.fullCalendar(settings);
  
    // das calendar objekt wird an ein formular gebunden
    //formObj.data( 'wgt-calendar' , calendarObj );
  });
  
});

$R.addAction( 'ui_calendar_viewer', function( jNode ){
	  
	  
	  jNode.removeClass('wcm_ui_calendar_viewer');
	  
	  jNode.appear(function(){
	    
	    var calId = jNode.attr('id'),
	    	tmpId = calId.substring( 4, calId.length ),
	    	formObj = null,
	    	defSettings = {},
	    	cfgData = null,
			settings = null;
		  
	    defSettings = {
	        header: {
	            left: 'prevYear,prev,today,next,nextYear',
	            center: 'title',
	            right: 'month,agendaWeek,agendaDay'
	        },
	        editable: false
	  
	    };
	    
		cfgData = jNode.find('var');
		settings = cfgData.is('var')
		    ? $WGT.robustParseJSON(cfgData.text())
		    : {};
		          
	    settings = $S.extend({}, defSettings, settings);
	    
	    if(settings.header_right){
	    	settings.header.right = settings.header_right;
	    }	   
	    if(settings.header_left){
	    	settings.header.left = settings.header_left;
	    }
	    
	    if (settings.upd_form_id) {
	    	
	    	formObj = $S('.'+settings.upd_form_id);
	    	
	    	if(formObj.length){
	    	
		    	if (formObj.length == 1) {
				    settings.events = function(start, end, timezone, cb) {
					    
				    	var data = null;
				    	
				    	data = $R.get(
				    		formObj.attr('action')
					    	    +'&start='+start.format('YYYY-MM-DD')
					    	    +'&end='+end.format('YYYY-MM-DD'),
				    	    {},
				    	    true
					    );
				    
				 
				    	cb(data.data.body);
				    };
		    	} else {

		    		var eventSources = [],
		    			sourceNode = null;
		    		
		    		formObj.each(function(){
		    			sourceNode = $S(this);
		    			eventSources.push(function(start, end, timezone, cb) {
						    
					    	var data = null;
					    	data = $R.get(
					    			sourceNode.attr('action')
						    	    +'&start='+start.format('YYYY-MM-DD')
						    	    +'&end='+end.format('YYYY-MM-DD'),
					    	    {},
					    	    true
						    );
					    
					 
					    	cb(data.data.body);
					    });
		    		});
		    		
		    		settings.eventSources = eventSources;
		    		
		    		
		    	}
	    		
	    	}
	    	

	    	
	    }
	    
	    // erstellen des calendar nodes
	    var calendarObj = jNode.fullCalendar(settings);
	  
	    // das calendar objekt wird an ein formular gebunden
	    //formObj.data( 'wgt-calendar' , calendarObj );
	  });
	  
	});