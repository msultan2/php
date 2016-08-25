<?php
	if (isset($_GET['type'])) 
		$tableType = $_GET['type'];
		
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
		$sql = " SELECT CASE WHEN Assigned_Group LIKE 'NFM%' THEN 'NFM'
							WHEN Assigned_Group LIKE 'Site Manag%' THEN 'Site Management'
							ELSE Assigned_Group
							END Assigned_Group,Status,COUNT(vio.Incident_ID) Violated_TT
				  FROM dbo.[vw_SS_Remedy_TT_SLA_Assigned_Violated] vio
				  WHERE Assigned_Group IS NOT NULL
				  group by CASE WHEN Assigned_Group LIKE 'NFM%' THEN 'NFM'
							WHEN Assigned_Group LIKE 'Site Manag%' THEN 'Site Management'
							ELSE Assigned_Group
							END,Status
				  order by 3 DESC;";
				  
		
		$stmt = sqlsrv_query( $conn, $sql );
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Desc_detail = array();
		$data_Val = array();
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			if($row['Violated_TT'] > 0){
				array_push($data_Desc,$row['Assigned_Group']);
				array_push($data_Desc_detail,$row['Status']);
				array_push($data_Val,$row['Violated_TT']);
			}
		}
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
		
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript">
$(function () {

    Highcharts.data({
        csv: document.getElementById('tsv').innerHTML,
        itemDelimiter: '\t',
        parsed: function (columns) {

            var brands = {},
                brandsData = [],
                versions = {},
                drilldownSeries = [];
            
            // Parse percentage strings
            columns[1] = $.map(columns[1], function (value) {
                if (value.indexOf(';') === value.length - 1) {
                    value = parseFloat(value);
                }
                return value;
            });

            $.each(columns[0], function (i, name) {
                var brand,
                    version;

                if (i > 0) {

                    // Remove special edition notes
                    name = name.split(' -')[0];

                    // Split into brand and version
					brand = name.split(',')[0];
					version = name.split(',')[1];
                    
                    // Create the main data
                    if (!brands[brand]) {
                        brands[brand] = columns[1][i];
                    } else {
                        brands[brand] += columns[1][i];
                    }

                    // Create the version data
                    if (version !== null) {
                        if (!versions[brand]) {
                            versions[brand] = [];
                        }
                        versions[brand].push([version, columns[1][i]]);
                    }
                }
                
            });

            $.each(brands, function (name, y) {
                brandsData.push({ 
                    name: name, 
                    y: y,
                    drilldown: versions[name] ? name : null
                });
            });
            $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });

            // Create the chart
            $('#container').highcharts({
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Teams Violated TT'
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}: {point.y}'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.percentage:.1f}%</b> TT<br/>'
                }, 

                series: [{
                    name: 'Team',
                    colorByPoint: true,
                    data: brandsData
                }],
                drilldown: {
                    series: drilldownSeries
                }
            })

        }
    });
});
</script>

<script src="HighCharts/js/highcharts.js"></script>
<script src="HighCharts/js/modules/data.js"></script>
<script src="HighCharts/js/modules/drilldown.js"></script>
<!--script type="text/javascript" src="HighCharts/js/themes/grid-light.js"></script-->

<div id="container" style="min-width: 310px; max-width: 650px; height: 400px; margin: 0 auto"></div>

<pre id="tsv" style="display:none">Team	Status	TT
<?php for($i=0;$i<count($data_Desc); $i++) {             
						echo substr($data_Desc[$i],0,18)." ,".$data_Desc_detail[$i]."\t".$data_Val[$i].";";
						if ($i<count($data_Desc)-1) echo "\n";	//add ',' to all except last element
					}  
?></pre>

