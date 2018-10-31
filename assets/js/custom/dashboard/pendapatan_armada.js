
$(function () {
    
    var seriesVal = [];
    var highVal = "";
    $.post("/dashboard/pendapatanArmada",function(json) {
        
        if (json.status == true) {
            $.each(json.data.series_value,function(i,v) {
                seriesVal.push(v);
            });
            highVal = json.data.high_value;
            $("#totalPerTahun").html(json.data.total_per_tahun);
        } else {
            seriesVal = [0,0,0,0,0,0,0,0,0,0,0,0];
            highVal = "0";
        }

        /*alert(seriesVal);
        console.log(seriesVal);
        console.log(highVal);*/

        "use strict";
        // ============================================================== 
        // Sales overview

        var chart = new Chartist.Bar('#pendapatanArmadaPerTahun', {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
                series: [seriesVal],
            }, 
            {
                axisX: {
                    // On the x-axis start means top and end means bottom
                    position: 'end',
                    showGrid: false
                },
                axisY: {
                    // On the y-axis start means left and end means right
                    position: 'start', 
                    labelInterpolationFnc: function (value) {
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
                high:highVal,
                low: '0',
                plugins: [
                    Chartist.plugins.tooltip({
                        currency: 'Rp. ',
                        appendToBody: true
                    })
                ]
            }
        );

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
    
    }); // end post 
});   

$.post("/dashboard/groupByTahunChart",function(json) {
   if (json.status == true && json.data != null) {
        var option = "";
        $.each(json.data,function(i,v) {
            option += '<option value="'+v.tahun+'">'+v.tahun+'</option>';
        });
        $("#tahunChart").html(option);
        $("#tahunChart").show();
        var d = new Date();
        $("#tahunChart").val(d.getFullYear());
   } else {
         $("#tahunChart").hide();
   }
});

$("#tahunChart").change(function () {
   showChartTahunan($(this).val());
});

function showChartTahunan(tahun) {
    var seriesVal = [];
    var highVal = "";
    $.post("/dashboard/pendapatanArmada/"+tahun,function(json) {
        
        if (json.status == true) {
            $.each(json.data.series_value,function(i,v) {
                seriesVal.push(v);
            });
            highVal = json.data.high_value;
            $("#totalPerTahun").html(json.data.total_per_tahun);
        } else {
            seriesVal = [0,0,0,0,0,0,0,0,0,0,0,0];
            highVal = "0";
        }

        /*alert(seriesVal);
        console.log(seriesVal);
        console.log(highVal);*/

        "use strict";
        // ============================================================== 
        // Sales overview

        var chart = new Chartist.Bar('#pendapatanArmadaPerTahun', {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
                series: [seriesVal],
            }, 
            {
                axisX: {
                    // On the x-axis start means top and end means bottom
                    position: 'end',
                    showGrid: false
                },
                axisY: {
                    // On the y-axis start means left and end means right
                    position: 'start', 
                    labelInterpolationFnc: function (value) {
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
                high:highVal,
                low: '0',
                plugins: [
                    Chartist.plugins.tooltip({
                        currency: 'Rp. ',
                        appendToBody: true
                    })
                ]
            }
        );

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
    
    }); // end post 
}