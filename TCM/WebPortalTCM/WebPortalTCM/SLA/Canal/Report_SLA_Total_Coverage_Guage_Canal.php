        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="../css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="../css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="../css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="../css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="../css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />

<?php
		/* Parse configuration file */
		$ini_array = parse_ini_file("../config.ini");
		
		/* Specify the server and connection string attributes. */

		$serverName = $ini_array['SERVER_NAME']; 
		$connectionInfo = array( "UID"=>$ini_array['DB_USER'],
								"PWD"=>$ini_array['DB_PASS'],
								"Database"=>$ini_array['DB_NAME']);

		/* Connect using Windows Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( !$conn ) {
			 die( print_r( sqlsrv_errors(), true));
		}
		$sql = "SELECT COUNT(vio.Incident_ID) Violated_TTs,COUNT(TT.Incident_ID) Total_TTs
					FROM dbo.vw_SS_Remedy_TT_SLA_All TT
				  LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Violated] vio
				  ON TT.Incident_ID = vio.Incident_ID
				  WHERE TT.Region like '%Canal%';";
		$stmt = sqlsrv_query( $conn, $sql );
		
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		
		$data_Val_Violated = 0;
		$data_Val_Total = 0;
		$Total_scattered = 0;
		$Total_outage = 0;
		$Percent = 100 - 80;
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			
				$data_Val_Violated = $row['Violated_TTs']; 
				$data_Val_Total = $row['Total_TTs']; 
			}
		
		
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript">
$(function () {
	
    var gaugeOptions = {
	
	    chart: {
	        type: 'solidgauge'
	    },
	    
	    title: null,
	    
	    pane: {
	    	center: ['50%', '85%'],
	    	size: '140%',
	        startAngle: -90,
	        endAngle: 90,
            background: {
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                innerRadius: '60%',
                outerRadius: '100%',
                shape: 'arc'
            }
	    },

	    tooltip: {
	    	enabled: false
	    },
	       
	    // the value axis
	    yAxis: {
			stops: [
				[0.25, '#DF5353'], // red
				[0.75, '#FFA500'], // orange
				[0.85, '#DDDF0D'], // yellow
				[0.95, '#55BF3B'] // green
	        	
			],
			lineWidth: 0,
            minorTickInterval: null,
            tickPixelInterval: 400,
            tickWidth: 0,
	        title: {
                y: -70
	        },
            labels: {
                y: 16
            }        
	    },
        
        plotOptions: {
            solidgauge: {
                dataLabels: {
                    y: -30,
                    borderWidth: 0,
                    useHTML: true
                }
            }
        }
    };
    
    // The outage gauge
    $('#container-outage').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
	        min: 0,
	        max: 100,
	        title: {
	            text: '<b>Access SLA Compliance</b>'
	        }       
	    },

	    credits: {
	    	enabled: false
	    },
	
	    series: [{
	        name: 'Outage',
	        data: [<?php echo 100-round(($data_Val_Violated / $data_Val_Total)*100,0); ?>],
	        dataLabels: {
	        	format: '<div style="text-align:center"><span style="font-size:25px;color:' + 
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>' + 
                   	'<span style="font-size:12px;color:black"><?php echo "Violated: ".$data_Val_Violated."/".$data_Val_Total." TT"; ?></span></div>'
	        },
	        tooltip: {
	            valueSuffix: '% of TT'
	        }
	    }]
	
	}));
                               
    // Bring life to the dials
    setInterval(function () {
    	// Outage
        var chart = $('#container-outage').highcharts();
        if (chart) {
            var point = chart.series[0].points[0],
                newVal,
                inc = Math.round((Math.random() - 0.5) * 100);
            
            newVal = point.y + inc;
            if (newVal < 0 || newVal > 200) {
                newVal = point.y - inc;
            }
            
            //point.update(newVal);
        }

        // Scattered
        chart = $('#container-scatt').highcharts();
        if (chart) {
            var point = chart.series[0].points[0],
                newVal,
                inc = Math.random() - 0.5;
            
            newVal = point.y + inc;
            if (newVal < 0 || newVal > 5) {
                newVal = point.y - inc;
            }
            
            //point.update(newVal);
        }
    }, 2000);  
    
	
});
</script>
<script src="../HighCharts/js/highcharts.js"></script>
<script src="../HighCharts/js/highcharts-more.js"></script>

<script src="../HighCharts/js/modules/solid-gauge.src.js"></script>

<div style="background-color:white; style="width: 700px; height: 400px; margin: 0 auto">
	<div  style="background-color:white; width: 80px; height: 200px; float: left"></div>
	<div id="container-outage" style="width: 300px; height: 200px; float: left"></div>
	<div  style="background-color:white; width: 20px; height: 200px; float: left"></div>
</div>