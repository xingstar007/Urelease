

<div id="chart-container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script src="<?php echo base_url().'templates/js/highcharts.js'?>"></script>
<script src="<?php echo base_url().'templates/js/highcharts-exporting.js'?>"></script>
<script type="text/javascript">
$(function () {
    $(document).ready(function() {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
    
        var chart;
        $('#chart-container').highcharts({
            chart: {
                type: 'spline',
                animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                events: {
                    load: function() {
    
                        // set up the updating of the chart each second
                        var series = this.series[0];
                        setInterval(function() {
                            $.getJSON("<?php echo site_url('getData/get_by_ajax');?>",function(json){
                                if(json.length != 0){//没有从数据库中找到数据
                                    x = json.x;
                                    y = json.y;

                                }else{//成功获取数据
                                    x = 0;
                                    y = 0;
                                }
                                series.addPoint([x, y], true, true);        
                            });                           
                        }, 1000);
                    }
                }
            },
            title: {
                text: '动态电压流图'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150
            },
            yAxis: {
                title: {
                    text: '电压'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+
                        Highcharts.numberFormat(this.y, 2);
                }
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            series: [{
                name: 'Random data',
                data: (function() {
                    // generate an array of random data
                    var data = [],
                        time = (new Date()).getTime(),
                        i;
                    for (i = -19; i <= 0; i++) {
                        data.push({
                            x: time + i * 1000,
                            y: 50+5*Math.random()
                        });
                    }
                    return data;
                })()
            }]
        });
    });
    
});
</script>