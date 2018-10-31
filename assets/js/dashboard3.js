/*
Template Name: Admin Press Admin
Author: Themedesigner
Email: niravjoshi87@gmail.com
File: js
*/
$(function () {
    
    "use strict";
    // ============================================================== 
    // Sales overview
    // ============================================================== 
    var chart = new Chartist.Bar('.amp-pxl', {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
          series: [
            [90000000, 50000000, 30000000, 70000000, 50000000, 100000000, 300000000, 800000000, 100000000, 120000000, 140000000, 160000000],
            // [30000000, 80000000, 100000000, 120000000, 140000000, 160000000, 60000000, 30000000, 90000000, 50000000, 40000000, 60000000]
          ]
        }, {
          axisX: {
            // On the x-axis start means top and end means bottom
            position: 'end',
            showGrid: false
          },
          axisY: {
            // On the y-axis start means left and end means right
            position: 'start'
            , labelInterpolationFnc: function (value) {
                var valueNominal;
                if (value >= 1000000000000000) {
                    return (value / 1000000000000000) + 'b';
                } else if (value >= 1000000000000) {
                    return (value / 1000000000000) + 't';
                } else if (value >= 1000000000) {
                    return (value / 1000000000) + 'm';
                } else if (value >= 1000000) {
                    valueNominal = (value / 1000000) + 'jt';
                } else if (value >= 1000) {
                    valueNominal = (value / 1000) + 'k';
                } 
                return valueNominal;
            }
          },
        high:'1200000000',
        low: '0',
        plugins: [
            Chartist.plugins.tooltip({
              currency: 'Rp. ',
              appendToBody: true
            })
        ]
    });
    

        // Offset x1 a tiny amount so that the straight stroke gets a bounding box
        // Straight lines don't get a bounding box 
        // Last remark on -> http://www.w3.org/TR/SVG11/coords.html#ObjectBoundingBox
        chart.on('draw', function(ctx) {  
          if(ctx.type === 'area') {    
            ctx.element.attr({
              x1: ctx.x1 + 0.001
            });
          }
        });

        // Create the gradient definition on created event (always after chart re-render)
        chart.on('created', function(ctx) {
          var defs = ctx.svg.elem('defs');
          defs.elem('linearGradient', {
            id: 'gradient',
            x1: 0,
            y1: 1,
            x2: 0,
            y2: 0
          }).elem('stop', {
            offset: 0,
            // 'stop-color': 'rgba(255, 255, 255, 1)'
          }).parent().elem('stop', {
            offset: 1,
            // 'stop-color': 'rgba(38, 198, 218, 1)'
          });
        });
    
            
    var chart = [chart];

    // ============================================================== 
    // This is for the animation
    // ==============================================================
    
    for (var i = 0; i < chart.length; i++) {
        chart[i].on('draw', function(data) {
            if (data.type === 'line' || data.type === 'area') {
                data.element.animate({
                    d: {
                        begin: 500 * data.index,
                        dur: 500,
                        from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                        to: data.path.clone().stringify(),
                        easing: Chartist.Svg.Easing.easeInOutElastic
                    }
                });
            }
            if (data.type === 'bar') {
                data.element.animate({
                    y2: {
                        dur: 500,
                        from: data.y1,
                        to: data.y2,
                        easing: Chartist.Svg.Easing.easeInOutElastic
                    },
                    opacity: {
                        dur: 500,
                        from: 0,
                        to: 1,
                        easing: Chartist.Svg.Easing.easeInOutElastic
                    }
                });
            }
        });
    }
    
    
    // ============================================================== 
    // Download count
    // ============================================================== 
   /* var sparklineLogin = function () {
        $('.spark-count').sparkline([4, 5, 0, 10, 9, 12, 4, 9, 4, 5, 3, 10, 9, 12, 10, 9, 12, 4, 9], {
            type: 'bar'
            , width: '100%'
            , height: '70'
            , barWidth: '2'
            , resize: true
            , barSpacing: '6'
            , barColor: 'rgba(255, 255, 255, 0.3)'
        });
    }
    var sparkResize;
    
    sparklineLogin();*/ 
});        
     // ============================================================== 
    // icons
    // ==============================================================  
   /*var icons = new Skycons({"color": "#1976d2"}),
          list  = [
            "clear-day", "clear-night", "partly-cloudy-day",
            "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
            "fog"
          ],
          i;
    for(i = list.length; i--; ) {
        var weatherType = list[i],
            elements = document.getElementsByClassName( weatherType );
        for (e = elements.length; e--;){
            icons.set( elements[e], weatherType );
        }
    } 
     icons.play();*/
  
    