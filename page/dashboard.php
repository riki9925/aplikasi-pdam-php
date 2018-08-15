<?php
session_start(); 
date_default_timezone_set("Asia/Jakarta");

include "../config.php";

$bulan = date('m');
$tahun = date('Y');
$duedate = date('Ym');
$tanggal = date('Y-m-d'); 

$sql1=$conn->query("SELECT count(*) pelanggan FROM pelanggan");
$a=$sql1->fetch_assoc();

$sql2=$conn->query("SELECT sum(total) pembayaran FROM pembayaran where date_format(tanggal,'%Y%m') = '$duedate'");
$b=$sql2->fetch_assoc();

$sql3=$conn->query("SELECT count(*) duedate FROM meter where date_format(tanggal,'%Y%m') < $duedate and st = '0'");
$c=$sql3->fetch_assoc();

$sql4=$conn->query("SELECT sum(total) penerimaan FROM pembayaran where date_format(tanggal,'%Y') = '$tahun'");
$d=$sql4->fetch_assoc();

$sql5=$conn->query("
SELECT sum(volume) volume, sum(total) total, date_format(tanggal,'%b-%Y') nama, date_format(tanggal,'%m') id
FROM pdam.pembayaran
group by date_format(tanggal,'%Y-%m')
order by tanggal ASC
LIMIT 12
");
$sql6=$conn->query("
SELECT sum(volume) volume, sum(total) total, date_format(tanggal,'%b-%Y') nama, date_format(tanggal,'%m') id
FROM pdam.pembayaran
group by date_format(tanggal,'%Y-%m')
order by tanggal ASC
LIMIT 12
");
$sql7=$conn->query("
SELECT sum(volume) volume, sum(total) total, date_format(tanggal,'%b-%Y') nama, date_format(tanggal,'%m') id
FROM pdam.pembayaran
group by date_format(tanggal,'%Y-%m')
order by tanggal ASC
LIMIT 12
");
$sql8=$conn->query("
SELECT sum(volume) volume, sum(total) total, date_format(tanggal,'%b-%Y') nama, date_format(tanggal,'%m') id
FROM pdam.pembayaran
group by date_format(tanggal,'%Y-%m')
order by tanggal ASC
LIMIT 12
");
$row=$sql5->num_rows;

?>
<div class="row">
    <div class="col-sm-12 col-lg-6">
        <a href="javascript:void(0)" class="widget" onclick="load('meter')">
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background">
                    <i class="gi gi-cardio text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text-danger">
                    <strong><span data-toggle="counter" data-to="<?php echo $c['duedate']; ?>"></span></strong>
                </h2>
                <span class="text-muted">JATUH TEMPO</span>
            </div>
        </a>
    </div>
    <div class="col-sm-12 col-lg-6">
        <a href="javascript:void(0)" class="widget">
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background-warning">
                    <i class="gi gi-user text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text-default">
                    <strong><span data-toggle="counter" data-to="<?php echo $a['pelanggan']; ?>"></span></strong>
                </h2>
                <span class="text-muted">PELANGGAN</span>
            </div>
        </a>
    </div>
    <div class="col-sm-12 col-lg-6">
        <a href="javascript:void(0)" class="widget" onclick="load('pembayaran')">
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background-success">
                    <i class="gi gi-cardio text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text-danger">
                    <strong>Rp. <span data-toggle="counter" data-to="<?php echo $b['pembayaran']; ?>"></span></strong>
                </h2>
                <span class="text-muted">TRANSAKSI BULAN INI</span>
            </div>
        </a>
    </div>
    <div class="col-sm-12 col-lg-6">
        <a href="javascript:void(0)" class="widget" onclick="load('pembayaran')">
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background-danger">
                    <i class="gi gi-wallet text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text-success">
                    <strong>Rp. <span data-toggle="counter" data-to="<?php echo $d['penerimaan']; ?>"></span></strong>
                </h2>
                <span class="text-muted">PENDAPATAN Thn. <?php echo $tahun;?></span>
            </div>
        </a>
    </div>
    <div class="col-sm-12 col-lg-12">
        <!-- Chart Widget -->
        <div class="widget">
            <div class="widget-content border-bottom">
                <!-- <span class="pull-right text-muted"></span> -->
                Grafik Pendapatan dalam Setahun
            </div>
            <div class="widget-content border-bottom themed-background-muted">
                <!-- Flot Charts (initialized in js/pages/readyDashboard.js), for more examples you can check out http://www.flotcharts.org/ -->
                <div id="chart-classic-dash1" style="height: 393px;"></div>
            </div>
        </div>
        <!-- END Chart Widget -->
    </div>
    <div class="col-sm-12 col-lg-12">
        <!-- Chart Widget -->
        <div class="widget">
            <div class="widget-content border-bottom">
                <!-- <span class="pull-right text-muted"></span> -->
                Grafik Pengeluaran Volume Air/M3 dalam Setahun
            </div>
            <div class="widget-content border-bottom themed-background-muted">
                <!-- Flot Charts (initialized in js/pages/readyDashboard.js), for more examples you can check out http://www.flotcharts.org/ -->
                <div id="chart-classic-dash2" style="height: 393px;"></div>
            </div>
        </div>
        <!-- END Chart Widget -->
    </div>
</div>

        <script type="text/javascript">

            /* With CountTo, Check out examples and documentation at https://github.com/mhuggins/jquery-countTo */
            $('[data-toggle="counter"]').each(function(){
                var $this = $(this);

                $this.countTo({
                    speed: 1000,
                    refreshInterval: 25,
                    onComplete: function() {
                        if($this.data('after')) {
                            $this.html($this.html() + $this.data('after'));
                        }
                    }
                });
            });

            /* Mini Line Charts with jquery.sparkline plugin, for more examples you can check out http://omnipotent.net/jquery.sparkline/#s-about */
            var widgetChartLineOptions = {
                type: 'line',
                width: '200px',
                height: '109px',
                tooltipOffsetX: -25,
                tooltipOffsetY: 20,
                lineColor: '#9bdfe9',
                fillColor: '#9bdfe9',
                spotColor: '#555555',
                minSpotColor: '#555555',
                maxSpotColor: '#555555',
                highlightSpotColor: '#555555',
                highlightLineColor: '#555555',
                spotRadius: 3,
                tooltipPrefix: '',
                tooltipSuffix: ' Sales',
                tooltipFormat: '{{prefix}}{{y}}{{suffix}}'
            };
            $('#widget-dashchart-sales').sparkline('html', widgetChartLineOptions);

            /*
             * Flot Charts Jquery plugin is used for charts
             *
             * For more examples or getting extra plugins you can check http://www.flotcharts.org/
             * Plugins included in this template: pie, resize, stack, time
             */

            // Get the element where we will attach the chart
            var chartClassicDash1    = $('#chart-classic-dash1');

            // Data for the chart
            var dataEarnings1        =
            [
            <?php $no1=0;
            while($m=$sql5->fetch_assoc()){ $no1++;
            if ($no1 == $row) {?>
                [<?php echo $no1; ?>, <?php echo $m['total']; ?>]
            <?php }else{ ?>
                [<?php echo $no1; ?>, <?php echo $m['total']; ?>], 
            <?php }} ?>
            ];

            var dataMonths1          =
            [
            <?php $no3=0;
            while($o=$sql7->fetch_assoc()){ $no3++;
            if ($no3 == $row) {?>
                [<?php echo $no3; ?>, "<?php echo $o['nama']; ?>"]
            <?php }else{ ?>
                [<?php echo $no3; ?>, "<?php echo $o['nama']; ?>"], 
            <?php }} ?>
            ];

            // Classic Chart
            $.plot(chartClassicDash1,
                [
                    {
                        label: 'Pembayaran',
                        data: dataEarnings1,
                        lines: {show: true, fill: true, fillColor: {colors: [{opacity: .6}, {opacity: .6}]}},
                        points: {show: true, radius: 5}
                    }
                ],
                {
                    colors: ['#F22613'],
                    legend: {show: true, position: 'nw', backgroundOpacity: 0},
                    grid: {borderWidth: 0, hoverable: true, clickable: true},
                    yaxis: {show: false, tickColor: '#f5f5f5', ticks: 3},
                    xaxis: {ticks: dataMonths1, tickColor: '#f9f9f9'}
                }
            );

            // Creating and attaching a tooltip to the classic chart
            var previousPoint = null, ttlabel = null;
            chartClassicDash1.bind('plothover', function(event, pos, item) {

                if (item) {
                    if (previousPoint !== item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $('#chart-tooltip').remove();
                        var x = item.datapoint[0], y = item.datapoint[1];

                        if (item.seriesIndex === 0) {
                            ttlabel = '$ <strong>' + y + '</strong>';
                        } else if (item.seriesIndex === 1) {
                            ttlabel = '<strong>' + y + '</strong> sales';
                        } else {
                            ttlabel = '<strong>' + y + '</strong> tickets';
                        }

                        $('<div id="chart-tooltip" class="chart-tooltip">' + ttlabel + '</div>')
                            .css({top: item.pageY - 45, left: item.pageX + 5}).appendTo("body").show();
                    }
                }
                else {
                    $('#chart-tooltip').remove();
                    previousPoint = null;
                }
            });

            /*
             * Flot Charts Jquery plugin is used for charts
             *
             * For more examples or getting extra plugins you can check http://www.flotcharts.org/
             * Plugins included in this template: pie, resize, stack, time
             */

            // Get the element where we will attach the chart
            var chartClassicDash2    = $('#chart-classic-dash2');

            var dataSales2           =
            [
            <?php $no2=0;
            while($n=$sql6->fetch_assoc()){ $no2++;
            if ($no2 == $row) {?>
                [<?php echo $no2; ?>, <?php echo $n['volume']; ?>]
            <?php }else{ ?>
                [<?php echo $no2; ?>, <?php echo $n['volume']; ?>], 
            <?php }} ?>
            ];

            var dataMonths2          =
            [
            <?php $no4=0;
            while($p=$sql8->fetch_assoc()){ $no4++;
            if ($no4 == $row) {?>
                [<?php echo $no4; ?>, "<?php echo $p['nama']; ?>"]
            <?php }else{ ?>
                [<?php echo $no4; ?>, "<?php echo $p['nama']; ?>"], 
            <?php }} ?>
            ];

            // Classic Chart
            $.plot(chartClassicDash2,
                [
                    {
                        label: 'Volume',
                        data: dataSales2,
                        lines: {show: true, fill: true, fillColor: {colors: [{opacity: .6}, {opacity: .6}]}},
                        points: {show: true, radius: 5}
                    }
                ],
                {
                    colors: ['#454e59'],
                    legend: {show: true, position: 'nw', backgroundOpacity: 0},
                    grid: {borderWidth: 0, hoverable: true, clickable: true},
                    yaxis: {show: false, tickColor: '#f5f5f5', ticks: 3},
                    xaxis: {ticks: dataMonths2, tickColor: '#f9f9f9'}
                }
            );

            // Creating and attaching a tooltip to the classic chart
            var previousPoint = null, ttlabel = null;
            chartClassicDash2.bind('plothover', function(event, pos, item) {

                if (item) {
                    if (previousPoint !== item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $('#chart-tooltip').remove();
                        var x = item.datapoint[0], y = item.datapoint[1];

                        if (item.seriesIndex === 0) {
                            ttlabel = '$ <strong>' + y + '</strong>';
                        } else if (item.seriesIndex === 1) {
                            ttlabel = '<strong>' + y + '</strong> sales';
                        } else {
                            ttlabel = '<strong>' + y + '</strong> tickets';
                        }

                        $('<div id="chart-tooltip" class="chart-tooltip">' + ttlabel + '</div>')
                            .css({top: item.pageY - 45, left: item.pageX + 5}).appendTo("body").show();
                    }
                }
                else {
                    $('#chart-tooltip').remove();
                    previousPoint = null;
                }
            });
        
        </script>