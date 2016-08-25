<?php //session_start();  $pagePrivValue=50; require 'approve.php'; ?>
<?php include ("newtemplate.php"); ?>
<div class="body_text"><B>TCM Monthly Calendar</B></div>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization',
       'version':'1','packages':['timeline']}]}"></script>
<script type="text/javascript">


google.setOnLoadCallback(drawChart);
function drawChart() {

  var container = document.getElementById('example5.2');
  var chart = new google.visualization.Timeline(container);

  var dataTable = new google.visualization.DataTable();
  dataTable.addColumn({ type: 'string', id: 'Position' });
  dataTable.addColumn({ type: 'string', id: 'Name' });
  dataTable.addColumn({ type: 'date', id: 'Start' });
  dataTable.addColumn({ type: 'date', id: 'End' });
 /* dataTable.addRows([
    [ 'Voice Engineering',          'RNC25 IP migration', new Date(2014, 3, 26), new Date(2014, 12, 3)],
    [ 'Voice Engineering',          'BC expansion',        new Date(2014, 2, 3),  new Date(2014, 2, 30)],
    [ 'Voice Engineering',          'BSC G13B upgrade',  new Date(2014, 2, 1),  new Date(2014, 2, 3)],
    [ 'Mobile Internet Engineering',     'GGSN HW expansion',        new Date(2014, 2, 2), new Date(2014, 2, 3)],
    [ 'Mobile Internet Engineering',     'CISCO Traffic Migration',  new Date(2014, 2, 3),  new Date(2014, 2, 5)],
    [ 'Mobile Internet Engineering',     'QoS Trial',        new Date(2014, 2, 3),  new Date(2014, 2, 10)],
    [ 'Mobile Internet Engineering',     'CISCO GGSN SW upgrade',    new Date(2014, 2, 3),  new Date(2014, 3, 19)],
	[ 'Mobile Internet Engineering',     'APN Resolution',    new Date(2014, 2, 3),  new Date(2014, 3, 19)],
    [ 'IP Engineering (fixed)', 'Prouter modernization',          new Date(2014, 5, 25), new Date(2014, 8, 21)],
    [ 'IP Engineering (fixed)', 'Akamai https',  new Date(2014, 2, 21), new Date(2014, 11, 30)],
    [ 'IP Engineering (fixed)', 'QoS',   new Date(2014, 1, 1),  new Date(2014, 7, 19)],
    [ 'IP Engineering (fixed)', 'P router modernization', new Date(2014, 4, 19), new Date(2014, 7, 11)],
    [ 'IP Engineering (fixed)', 'International links upgrade',       new Date(2014, 4, 12), new Date(2014, 5, 4)],
    [ 'IP Engineering (fixed)', 'Core ring upgrade',     new Date(2014, 5, 12), new Date(2014, 6, 3)]
	]);
*/
	  dataTable.addRows([
    [ 'Voice Engineering',          'RNC25 IP migration', new Date(2014, 4, 4), new Date(2014, 4, 13)],
    [ 'Voice Engineering',          'BC expansion',        new Date(2014, 3, 3),  new Date(2014, 3, 30)],
    [ 'Voice Engineering',          'BSC G13B upgrade',  new Date(2014, 3, 1),  new Date(2014, 4, 3)],
    [ 'Mobile Internet Engineering',     'GGSN HW expansion',        new Date(2014, 3, 2), new Date(2014, 3, 3)],
    [ 'Mobile Internet Engineering',     'CISCO Traffic Migration',  new Date(2014, 3, 3),  new Date(2014, 3, 15)],
    [ 'Mobile Internet Engineering',     'QoS Trial',        new Date(2014, 3, 17),  new Date(2014, 3, 26)],
    [ 'Mobile Internet Engineering',     'CISCO GGSN SW upgrade',    new Date(2014, 3, 27),  new Date(2014,4,10)],
	[ 'Mobile Internet Engineering',     'APN Resolution',    new Date(2014, 3, 3),  new Date(2014, 3, 19)],
    [ 'IP Engineering (fixed)', 'Prouter modernization',          new Date(2014, 3, 25), new Date(2014, 4, 21)],
    [ 'IP Engineering (fixed)', 'Akamai https',  new Date(2014, 3, 2), new Date(2014, 3, 10)],
    [ 'IP Engineering (fixed)', 'QoS',   new Date(2014, 3, 1),  new Date(2014, 3, 19)],
    [ 'IP Engineering (fixed)', 'P router modernization', new Date(2014, 3, 19), new Date(2014, 4, 11)],
    [ 'IP Engineering (fixed)', 'International links upgrade',       new Date(2014, 3, 12), new Date(2014, 4, 4)],
    [ 'IP Engineering (fixed)', 'Core ring upgrade',     new Date(2014, 4, 5), new Date(2014, 4, 15)]
	]);
	

 var options = {
    timeline: { colorByRowLabel: true }
  };



  chart.draw(dataTable, options);
}
</script>

<div id="example5.2" style="width: 900px; height: 450px;"></div>

<?php include ("footer_new.php"); ?>