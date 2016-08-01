jQuery(document).ready(function(){
	
	"use strict";
    
    // Donut Chart
   var m1 = new Morris.Donut({
        element: 'donut-chart2',
        data: [
          {label: "Chrome", value: 30},
          {label: "Firefox", value: 20},
          {label: "Opera", value: 20},
          {label: "Safari", value: 20},
          {label: "Internet Explorer", value: 10}
        ],
        colors: ['#D9534F','#1CAF9A','#428BCA','#5BC0DE','#428BCA']
    });
    
    
   
	
	// Trigger Resize in Morris Chart
   var delay = (function() {
		var timer = 0;
		return function(callback, ms) {
			clearTimeout(timer);
			timer = setTimeout(callback, ms);
		};
    })();

   jQuery(window).resize(function() {
		delay(function() {
			m1.redraw();
			//m2.redraw();
	}, 200);
   }).trigger('resize');
    
});