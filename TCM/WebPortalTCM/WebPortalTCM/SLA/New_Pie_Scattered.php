<style type="text/css">
    <!-- Theme style -->
.text-red {
  color: #f56954 !important;
}
.bg-orange {
  background-color: #ff851b !important;
}
.text-yellow {
  color: #f39c12 !important;
}
.text-blue {
  color: #0073b7 !important;
}
.text-green {
  color: #00a65a !important;
}
</style>


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
		$sql = "SELECT  CASE WHEN TT.Grade = 'P1' THEN 'Red'
							WHEN TT.Grade = 'P2' THEN 'Orange'
							WHEN TT.Grade = 'P3' THEN 'Yellow'
							WHEN TT.Grade = 'P4' THEN 'Blue'
							END Severity, 
						CASE WHEN TT.Grade = 'P1' THEN 1
							WHEN TT.Grade = 'P2' THEN 2
							WHEN TT.Grade = 'P3' THEN 3
							WHEN TT.Grade = 'P4' THEN 4
							END Severity_Order, 
							COUNT(vio.Incident_ID) Violated_TTs,
							COUNT(*) Total_TT
						  FROM dbo.vw_SS_Remedy_TT_SLA_All TT
						  LEFT OUTER JOIN dbo.[vw_SS_Remedy_TT_SLA_Assigned_Violated] vio
						  ON TT.Incident_ID = vio.Incident_ID
						  WHERE TT.Outage = 'No'
						  AND TT.Incident_ID IS NOT NULL
						  GROUP BY CASE WHEN TT.Grade = 'P1' THEN 'Red'
							WHEN TT.Grade = 'P2' THEN 'Orange'
							WHEN TT.Grade = 'P3' THEN 'Yellow'
							WHEN TT.Grade = 'P4' THEN 'Blue'
							END, 
						CASE WHEN TT.Grade = 'P1' THEN 1
							WHEN TT.Grade = 'P2' THEN 2
							WHEN TT.Grade = 'P3' THEN 3
							WHEN TT.Grade = 'P4' THEN 4
							END
						ORDER BY 2;";
		$stmt = sqlsrv_query( $conn, $sql );
		
		if( $stmt === false) {
			die( print_r( sqlsrv_errors(), true) );
		}
		$data_Desc = array();
		$data_Val = array();
		$data_Val_Total = array();
		$data_Val_Per = array();
		$redSeverityPerc = 100;
		$orangeSeverityPerc = 100;
		$yellowSeverityPerc = 100;
		$blueSeverityPerc = 100;
		
		foreach($severity_arr as $sev){
			$data_Val[$sev] = 0;
			$data_Val_Total[$sev] = 0;
			$data_Val_Per[$sev] = 100;
		}
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$Severity = $row['Severity'];
			array_push($data_Desc,$row['Severity']);
			$data_Val[$Severity] = $row['Violated_TTs'];
			$data_Val_Total[$Severity] = $row['Total_TT'];
			/**if ($data_Val[$Severity] == 0) 
				$data_Val_Per[$Severity] = 100;
				
			else
				$data_Val_Per[$Severity] = (100 -round (($data_Val[$Severity] / $data_Val_Total[$Severity] )*100, 0));**/
			if (strcasecmp($row['Severity'], 'red') == 0)
				$redSeverityPerc = (100 -round (($data_Val[$Severity] / $data_Val_Total[$Severity] )*100, 0));
			else if (strcasecmp($row['Severity'], 'orange') == 0)
				$orangeSeverityPerc = (100 -round (($data_Val[$Severity] / $data_Val_Total[$Severity] )*100, 0));
			else if (strcasecmp($row['Severity'], 'yellow') == 0)
				$yellowSeverityPerc = (100 -round (($data_Val[$Severity] / $data_Val_Total[$Severity] )*100, 0));
			else if (strcasecmp($row['Severity'], 'blue') == 0)
				$blueSeverityPerc = (100 -round (($data_Val[$Severity] / $data_Val_Total[$Severity] )*100, 0));
			
		}
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn );
		
		
			echo '<span class="chartRed" data-percent=';
			echo $redSeverityPerc;
			echo '><b>';
			echo $redSeverityPerc;
			echo '</b><b>%</b>';
			//echo '<div class="percent"></div>';
			echo '</span>';
			
			echo '<span class="chartOrange" data-percent=';
			echo $orangeSeverityPerc;
			echo '><b>';
			echo $orangeSeverityPerc;
			echo '</b><b>%</b></span>';

			
			echo '<span class="chartYellow" data-percent=';
			echo $yellowSeverityPerc;
			echo '><b>';
			echo $yellowSeverityPerc;
			echo '</b><b>%</b></span>';
			
			echo '<span class="chartBlue" data-percent=';
			echo $blueSeverityPerc;
			echo '><b>';
			echo $blueSeverityPerc;
			echo '</b><b>%</b></span>';

			
?>

<!--table ><tr>
		<td><span class="chart" data-percent=<!--?php echo "$data_Val_Per[$Severity]"?>><b><!--?php echo "$data_Val_Per[$Severity]"?></b><b>%</b>
		<!--span class="percent"></span>
	</span></td>
	</tr></table-->
	
<!--script src="../js/easypiechart.min.js"></script-->
<script>
!function(a,b){"object"==typeof exports?module.exports=b():"function"==typeof define&&define.amd?define([],b):a.EasyPieChart=b()}(this,function(){var a=function(a,b){var c,d=document.createElement("canvas");a.appendChild(d),"undefined"!=typeof G_vmlCanvasManager&&G_vmlCanvasManager.initElement(d);var e=d.getContext("2d");d.width=d.height=b.size;var f=1;window.devicePixelRatio>1&&(f=window.devicePixelRatio,d.style.width=d.style.height=[b.size,"px"].join(""),d.width=d.height=b.size*f,e.scale(f,f)),e.translate(b.size/2,b.size/2),e.rotate((-0.5+b.rotate/180)*Math.PI);var g=(b.size-b.lineWidth)/2;b.scaleColor&&b.scaleLength&&(g-=b.scaleLength+2),Date.now=Date.now||function(){return+new Date};var h=function(a,b,c){c=Math.min(Math.max(-1,c||0),1);var d=0>=c?!0:!1;e.beginPath(),e.arc(0,0,g,0,2*Math.PI*c,d),e.strokeStyle=a,e.lineWidth=b,e.stroke()},i=function(){var a,c;e.lineWidth=1,e.fillStyle=b.scaleColor,e.save();for(var d=24;d>0;--d)d%6===0?(c=b.scaleLength,a=0):(c=.6*b.scaleLength,a=b.scaleLength-c),e.fillRect(-b.size/2+a,0,c,1),e.rotate(Math.PI/12);e.restore()},j=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||function(a){window.setTimeout(a,1e3/60)}}(),k=function(){b.scaleColor&&i(),b.trackColor&&h(b.trackColor,b.lineWidth,1)};this.getCanvas=function(){return d},this.getCtx=function(){return e},this.clear=function(){e.clearRect(b.size/-2,b.size/-2,b.size,b.size)},this.draw=function(a){b.scaleColor||b.trackColor?e.getImageData&&e.putImageData?c?e.putImageData(c,0,0):(k(),c=e.getImageData(0,0,b.size*f,b.size*f)):(this.clear(),k()):this.clear(),e.lineCap=b.lineCap;var d;d="function"==typeof b.barColor?b.barColor(a):b.barColor,h(d,b.lineWidth,a/100)}.bind(this),this.animate=function(a,c){var d=Date.now();b.onStart(a,c);var e=function(){var f=Math.min(Date.now()-d,b.animate.duration),g=b.easing(this,f,a,c-a,b.animate.duration);this.draw(g),b.onStep(a,c,g),f>=b.animate.duration?b.onStop(a,c):j(e)}.bind(this);j(e)}.bind(this)},b=function(b,c){var d={barColor:"#ef1e25",trackColor:"#f9f9f9",scaleColor:"#dfe0e0",scaleLength:5,lineCap:"round",lineWidth:3,size:110,rotate:0,animate:{duration:1e3,enabled:!0},easing:function(a,b,c,d,e){return b/=e/2,1>b?d/2*b*b+c:-d/2*(--b*(b-2)-1)+c},onStart:function(){},onStep:function(){},onStop:function(){}};if("undefined"!=typeof a)d.renderer=a;else{if("undefined"==typeof SVGRenderer)throw new Error("Please load either the SVG- or the CanvasRenderer");d.renderer=SVGRenderer}var e={},f=0,g=function(){this.el=b,this.options=e;for(var a in d)d.hasOwnProperty(a)&&(e[a]=c&&"undefined"!=typeof c[a]?c[a]:d[a],"function"==typeof e[a]&&(e[a]=e[a].bind(this)));e.easing="string"==typeof e.easing&&"undefined"!=typeof jQuery&&jQuery.isFunction(jQuery.easing[e.easing])?jQuery.easing[e.easing]:d.easing,"number"==typeof e.animate&&(e.animate={duration:e.animate,enabled:!0}),"boolean"!=typeof e.animate||e.animate||(e.animate={duration:1e3,enabled:e.animate}),this.renderer=new e.renderer(b,e),this.renderer.draw(f),b.dataset&&b.dataset.percent?this.update(parseFloat(b.dataset.percent)):b.getAttribute&&b.getAttribute("data-percent")&&this.update(parseFloat(b.getAttribute("data-percent")))}.bind(this);this.update=function(a){return a=parseFloat(a),e.animate.enabled?this.renderer.animate(f,a):this.renderer.draw(a),f=a,this}.bind(this),this.disableAnimation=function(){return e.animate.enabled=!1,this},this.enableAnimation=function(){return e.animate.enabled=!0,this},g()};return b});
</script>

<script>
	
	document.addEventListener('DOMContentLoaded', function() {
		var chartRed = window.chart = new EasyPieChart(document.querySelectorAll('span')[0], {
			easing: 'easeOutElastic',
			size: 70,
			delay: 3000,
			onStep: function(from, to, percent) {
				this.el.children[0].innerHTML = Math.round(percent);
			}
		});
		
		var chartOrange = window.chart = new EasyPieChart(document.querySelectorAll('span')[1], {
			easing: 'easeOutElastic',
			delay: 3000,
			barColor: "#F76F30",
			size: 70,
			onStep: function(from, to, percent) {
				this.el.children[0].innerHTML = Math.round(percent);
			}
		});
		
		var chartYellow = window.chart = new EasyPieChart(document.querySelectorAll('span')[2], {
			easing: 'easeOutElastic',
			delay: 3000,
			barColor: "#FAF211",
			size: 70,
			onStep: function(from, to, percent) {
				this.el.children[0].innerHTML = Math.round(percent);
			}
		});
		
		var chartBlue = window.chart = new EasyPieChart(document.querySelectorAll('span')[3], {
			easing: 'easeOutElastic',
			delay: 3000,
			barColor: "#070AEB",
			size: 70,
			onStep: function(from, to, percent) {
				this.el.children[0].innerHTML = Math.round(percent);
			}
		});
		document.querySelector('.js_update').addEventListener('click', function(e) {
			chartRed.update(Math.random()*200-100);
			chartOrange.update(Math.random()*200-100);
			chartYellow.update(Math.random()*200-100);
			chartBlue.update(Math.random()*200-100);
		});

	});
</script>