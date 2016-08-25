        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

<?php
		/* Parse configuration file */
		$ini_array = parse_ini_file("config.ini");
		
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
		$sql = "SELECT  CASE WHEN CAST(TT.[Customer Value] AS VARCHAR) IN ('Premium','Platinum') THEN 'P&P'
						ELSE 'Normal'
						END Severity
					,COUNT(vio.Incident_ID) Violated_TT , COUNT(*) Total_TT
			FROM dbo.[vw_SS_Remedy_TT_SLA_Assigned_Services] TT
			LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Services_Violated] vio
			ON TT.Incident_ID = vio.Incident_ID
			GROUP BY CASE WHEN CAST(TT.[Customer Value] AS VARCHAR) IN ('Premium','Platinum') THEN 'P&P'
						ELSE 'Normal'
						END
			ORDER BY 1 DESC;";
		$stmt = sqlsrv_query( $conn, $sql );
		
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		
		$data_Val_PlPr = 0;
		$data_Val_Normal = 0;
		$Total_Normal = 0;
		$Total_PlPr = 0;
		$Percent = 100 - 80;
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			if($row['Severity'] == 'P&P') { 
				$data_Val_PlPr = $row['Violated_TT']; 
				$Total_PlPr = $row['Total_TT']; 
			}
			else if($row['Severity'] == 'Normal') { 
				$data_Val_Normal = $row['Violated_TT']; 
				$Total_Normal = $row['Total_TT']; 
			}
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
    
    // The P&P gauge
    $('#container-PP').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
	        min: 0,
	        max: 100,
	        title: {
	            text: 'P&P SRs SLA'
	        }       
	    },

	    credits: {
	    	enabled: false
	    },
	
	    series: [{
	        name: 'P&P',
	        data: [<?php echo 100-round(($data_Val_PlPr / $Total_PlPr)*100,0); ?>],
	        dataLabels: {
	        	format: '<div style="text-align:center"><span style="font-size:25px;color:' + 
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>' + 
                   	'<span style="font-size:12px;color:silver"><?php echo "Violated: ".$data_Val_PlPr."/".$Total_PlPr." SR"; ?></span></div>'
	        },
	        tooltip: {
	            valueSuffix: '% of SR'
	        }
	    }]
	
	}));
    
    // The Normal gauge
    $('#container-normal').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
        	min: 0,
        	max: 100,
	        title: {
	            text: 'Normal SRs SLA'
	        }       
	    },
	
	    series: [{
	        name: 'Normal',
	        data: [<?php echo 100-round(($data_Val_Normal / $Total_Normal)*100,0); ?>],
	        dataLabels: {
	        	format: '<div style="text-align:center"><span style="font-size:25px;color:' + 
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>' + 
                   	'<span style="font-size:12px;color:silver"><?php echo "Violated: ".$data_Val_Normal."/".$Total_Normal." SR"; ?></span></div>'
	        },
	        tooltip: {
	            valueSuffix: '% of SR'
	        }      
	    }]
	
	}));
                               
    // Bring life to the dials
    setInterval(function () {
    	// P&P
        var chart = $('#container-PP').highcharts();
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

        // Normal
        chart = $('#container-normal').highcharts();
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
<script src="HighCharts/js/highcharts.js"></script>
<script src="HighCharts/js/highcharts-more.js"></script>

<script src="HighCharts/js/modules/solid-gauge.src.js"></script>

<div style="width: 700px; height: 400px; margin: 0 auto">
	<div  style="background-color:white; width: 80px; height: 200px; float: left"></div>
	<div id="container-PP" style="width: 300px; height: 200px; float: left"></div>
	<div id="container-normal" style="width: 300px; height: 200px; float: left"></div>
	<div  style="background-color:white; width: 20px; height: 200px; float: left"></div>
</div>