<!-- here you can stsrt -->
 
<div id="e_myWorld_mainPage_ajax">
	<div class="＿bea-wlp-disc-context-hook" id="disc_655f6d79576f726c645f6d61696e50616765" >
		<div id="myWorld_mainPage" class="wlp-bighorn-page">
		
		
		
		
<div class="container-fluid">

<div id="" style="width: 100%;  float:left">
		<label class="control-label labelsize">Choose Date :</label>
		<input class="btn btn-default" type="text" name="MismatchReportDate" value="" id="Mismatchdatetimepicker"/>

		<button id="MismatchReportChangeDate" type="button" class="btn btn-lg  btn-success center-inline" style="width:20%;" >Change Date</button>  
		</div>

		</br></br></br></br>


	<div id="tabs" style="background: rgb(255, 255, 255) url("images/ui-bg_highlight-soft_100_eeeeee_1x100.png") 50% top repeat-x;">
	<ul style="border: 1px solid #e60000;
     background: #e60000; url("images/ui-bg_gloss-wave_35_f6a828_500x100.png") 50% 50% repeat-x;">
		<?php  if (true==true){?><li><a href="#tabs-1">Intra TX Conflict</a></li><?php }?>
		<?php  if (true==true){?><li><a href="#tabs-2">Intra BSS Conflict</a></li><?php }?>
		<li><a href="#tabs-3">Sites Conflict</a></li>
		<li><a href="#tabs-4">Hubs Conflict </a></li>
		<li><a href="#tabs-5">Nodes Conflict </a></li>
		<li><a href="#tabs-6">Coverage Conflict </a></li>
	</ul>
	
	
	<div id="tabs-1" style="">
	
	 <div class="row">
  <div class="col-md-11">
  <h4 class="mismatchtitle" style="font-size: 40px;text-align: center;">TX Duplication</h4>
  </div>

  
</div>


		    <div class="row">
               
                
              
                <div class="col-md-12">
				<button id="removeSelected2" type="button" class="btn btn-warning"style="display: none;">Remove Selected</button>
				<button id="TotalRowCount2" type="button" class="btn btn-info">Total Row Count</button>
				
                    
                    <!--div class="table-responsive"-->
                        <table id="TXDuplicationsGrid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                 
                                    <th data-column-id="Site_ID_TXDUP"      data-align="center" data-header-align="center" data-width="20%">Site ID</th>
									<th data-column-id="BSS_CRQ_Number1"  data-visible="true" sortable="true">  CRQ Number1</th>
                                    <th data-column-id="TX_CRQ_Number2"  data-visible="true" sortable="true"> CRQ Number2</th>
                                    <th data-column-id="BSS_CRQ_Number3"  data-visible="true" sortable="true">  CRQ Number3</th>
                                    <th data-column-id="TX_CRQ_Number4"  data-visible="true" sortable="true"> CRQ Number4</th>
                                    <th data-column-id="BSS_CRQ_Number5"  data-visible="true" sortable="true">  CRQ Number5</th>
									
                
									<th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
                            foreach ($TXDuplicationArrayResult as $i => $values) {
								   echo '<tr class="warning">';
								   //echo '<td>'.$i.'</td>';
								    foreach ($values as $key => $value) {
								       echo '<td>'.$value.'</td>';
								    }
								    echo '</tr>';
								}
?>
                                
                              
                                   
                               
                            
                                
                            </tbody>
                        </table>
                        
                        
                    <!--/div-->
                </div>
            </div>
			
			
			



	</div>
	
	
	
	
	<div id="tabs-2" style="">
	
	
			   <div class="row">
  <div class="col-md-11">
  <h4 class="mismatchtitle" style="font-size: 40px;text-align: center;">  BSS Duplication </h4>
  </div>

  
</div>
       
	
	
	
	    <div class="row">
               
                
              
                <div class="col-md-12">
				<button id="removeSelected2" type="button" class="btn btn-warning"style="display: none;">Remove Selected</button>
				<button id="TotalRowCount3" type="button" class="btn btn-info">Total Row Count</button>
				
                    
                    <!--div class="table-responsive"-->
                        <table id="BSSDuplicationsGrid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                 
                                    <th data-column-id="Site_ID_BSSDUP"   data-align="center" data-header-align="center" data-width="20%">Site ID</th>
                                    
								   
                                    <th data-column-id="BSS_CRQ_Number1"  data-visible="true" sortable="true">  CRQ Number1</th>
                                    <th data-column-id="TX_CRQ_Number2"  data-visible="true" sortable="true"> CRQ Number2</th>
                                     <th data-column-id="BSS_CRQ_Number3"  data-visible="true" sortable="true">  CRQ Number3</th>
                                    <th data-column-id="TX_CRQ_Number4"  data-visible="true" sortable="true"> CRQ Number4</th>
                                     <th data-column-id="BSS_CRQ_Number5"  data-visible="true" sortable="true">  CRQ Number5</th>
                                    
									<th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                  
                                   
									
									
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
                            foreach ($BSSDuplicationArrayResult as $i => $values) {
								   echo '<tr class="warning">';
								   //echo '<td>'.$i.'</td>';
								    foreach ($values as $key => $value) {
								       echo '<td>'.$value.'</td>';
								    }
								    echo '</tr>';
								}
?>
                                
                              
                                   
                               
                            
                                
                            </tbody>
                        </table>
                        
                        
                    <!--/div-->
                </div>
            </div>
			
			
			
			
			
	</div>

	<div id="tabs-3" style="">
	
	
			      <div class="row">
  <div class="col-md-11">
  <h4 class="mismatchtitle"style="font-size: 40px;text-align: center;"> TX-BSS Sites Conflicts </h4>
  </div>

  
</div>



           
			     <div class="row">
               
                
                
                <div class="col-md-12">
				<button id="removeSelected2" type="button" class="btn btn-warning" style="display: none;">Remove Selected</button>
				<button id="TotalRowCount4" type="button" class="btn btn-info" >Total Row Count</button>
				
                    <!--div class="table-responsive"-->
                        <table id="mismatchedSitesGrid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                
                                    <th data-column-id="SiteID"    data-align="center" data-header-align="center" data-width="20%">Site ID</th>
                                    <th data-column-id="BSS_CRQ_Number1"  data-visible="true" sortable="true"> TX CRQ Number</th>
                                    <th data-column-id="TX_CRQ_Number1"  data-visible="true" sortable="true">BSS CRQ Number</th>
                                  
									
          
									<th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
							//print_r($SitesArrayResult);
                            foreach ($SitesArrayResult as $i => $values) {
								   echo '<tr class="warning">';
								   //echo '<td>'.$i.'</td>';
								    foreach ($values as $key => $value) {
								       echo '<td>'.$value.'</td>';
								    }
								    echo '</tr>';
								
								}
								
?>
                                
                              
                                   
                               
                            
                                
                            </tbody>
                        </table>
                        
                        
                    <!--/div-->
                </div>
            </div>
	

	
	
	
	</div>
	<div id="tabs-4" style="">
	
   <div class="row">
  <div class="col-md-11">
  <h4 class="mismatchtitle" style="font-size: 40px;text-align: center;">TX-BSS Hubs Conflicts </h4>
  </div>

  
</div>

	
			  <div class="row">
               
                
              
                <div class="col-md-12">
				<button id="removeSelected" type="button" class="btn btn-warning"style="display: none;">Remove Selected</button>
				<button id="TotalRowCount5" type="button" class="btn btn-info">Total Row Count</button>
                    
                    <!--div class="table-responsive"-->
                        <table id="mismatchedHubGrid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                
                                    <th data-column-id="Hub_Name"    data-align="center" data-header-align="center" data-width="20%">Hub Name</th>
                                    <th data-column-id="Site_ID"  data-visible="true" sortable="true">Site ID</th>
                                    <th data-column-id="CRQ"  data-visible="true" sortable="true">CRQ Number</th>
									<th data-column-id="Activity Owner"  data-visible="true" sortable="true">Activity Owner</th>
                                    <th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
                            foreach ($HubArrayResult as $i => $values) {
								   echo '<tr class="warning">';
								  // echo '<td>'.$i.'</td>';
								    foreach ($values as $key => $value) {
								       echo '<td>'.$value.'</td>';
									  
								    }
								    echo '</tr>'; 
								}
								
?>
                                
                              
                                   
                               
                            
                                
                            </tbody>
                        </table>
                        
                        
                    <!--/div-->
                </div>
            </div>
			
		
		
		
	</div>
	<div id="tabs-5" style="">
	
	
			   <div class="row">
  <div class="col-md-11">
  <h4 class="mismatchtitle" style="font-size: 40px;text-align: center;"> TX-BSS Nodes Conflicts  </h4>
  </div>

  
</div>



			
			     <div class="row">
               
                
             
                <div class="col-md-12">
				<button id="removeSelected2" type="button" class="btn btn-warning"style="display: none;">Remove Selected</button>
				<button id="TotalRowCount6" type="button" class="btn btn-info">Total Row Count</button>
				
                   
                    <!--div class="table-responsive"-->
                        <table id="mismatchedNodesGrid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                 
                                                  <th data-column-id="Coverage_Area"    data-align="center" data-header-align="center" data-width="20%">NE</th>
                                    <th data-column-id="Site_ID_BSS Action"  data-visible="true" sortable="true"> Site ID</th>
									 <th data-column-id="BSS_CRQ_Number4"  data-visible="true" sortable="true">CRQ Number</th>
                                    <th data-column-id="Activity Owner"  data-visible="true" sortable="true">Activity Owner </th>
                                   

                
									<th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
                            foreach ($NodesArrayResult as $i => $values) {
								   echo '<tr class="warning">';
								  // echo '<td>'.$i.'</td>';
								    foreach ($values as $key => $value) {
								       echo '<td>'.$value.'</td>';
								    }
								    echo '</tr>';
								}
?>
                                
                              
                                   
                               
                            
                                
                            </tbody>
                        </table>
                        
                        
                    <!--/div-->
                </div>
            </div>
			
			
			
			
			
	</div>
	
	<div id="tabs-6" style="">
	
	
		
			   <div class="row">
  <div class="col-md-11">
  <h4 class="mismatchtitle" style="font-size: 40px;text-align: center;"> TX-BSS Coverage Conflicts </h4>
  </div>

  
</div>
			
			
			     <div class="row">
               
                
              
                <div class="col-md-12">
				<button id="removeSelected2" type="button" class="btn btn-warning"style="display: none;">Remove Selected</button>
				<button id="TotalRowCount7" type="button" class="btn btn-info">Total Row Count</button>
				
                    
                    <!--div class="table-responsive"-->
                        <table id="mismatchedCoverageGrid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                 
                                    <th data-column-id="Coverage_Area"    data-align="center" data-header-align="center" data-width="20%">Coverage Area</th>
                                    <th data-column-id="Site_ID_BSS Action"  data-visible="true" sortable="true"> Site ID</th>
									 <th data-column-id="BSS_CRQ_Number4"  data-visible="true" sortable="true">CRQ Number</th>
                                    <th data-column-id="Activity Owner"  data-visible="true" sortable="true">Activity Owner </th>
                                   

                              
									
									
                
									<th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
                            foreach ($CoverageArrayResult as $i => $values) {
								   echo '<tr class="warning">';
								   //echo '<td>'.$i.'</td>';
								    foreach ($values as $key => $value) {
								       echo '<td>'.$value.'</td>';
								    }
								    echo '</tr>';
								}
								
?>
                                
                              
                                   
                               
                            
                                
                            </tbody>
                        </table>
                        
                        
                    <!--/div-->
                </div>
            </div>
			
			

			
			
	</div>
    
	
	</div>	
	
	
	


      



<style>

.mismatchtitle{
color: #d9534f;}
</style>



			
			
			
        
		
		
		  
		
		
		
     </div>  <!-- end container  -->   
        
        
		
		
		</div>
	</div>
</div>
            

        
      

	<!---start table scrupts -->
	
	 <script src="./lib/jquery-1.11.1.min.js"></script>
        <script src="js/bootstrap.js"></script>	
        <script src="./dist/jquery.bootgrid.js"></script>
        <script src="./dist/jquery.bootgrid.fa.js"></script>
   
  <script>
  				
		 
           
                function init()
                {
                    
					$("#TXDuplicationsGrid").bootgrid({
					
                        formatters: {
                            "link": function(column, row)
                            {
                                return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                            }
                        },
                        rowCount: [-1, 25, 50, 75]
                    });
					$("#mismatchedSitesGrid").bootgrid({
                        formatters: {
                            "link2": function(column, row)
                            {
                                return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                            }
                        },
                        rowCount: [-1, 25, 50, 75]
                    });
					
					
						$("#mismatchedHubGrid").bootgrid({
                        formatters: {
                            "link2": function(column, row)
                            {
                                return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                            }
                        },
                        rowCount: [-1, 25, 50, 75]
                    });
					
					
					
					
						$("#mismatchedNodesGrid").bootgrid({
                        formatters: {
                            "link2": function(column, row)
                            {
                                return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                            }
                        },
                        rowCount: [-1, 25, 50, 75]
                    });
					
					
					$("#BSSDuplicationsGrid").bootgrid({
                        formatters: {
                            "link2": function(column, row)
                            {
                                return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                            }
                        },
                        rowCount: [-1, 25, 50, 75]
                    });
					
					$("#mismatchedCoverageGrid").bootgrid({
                        formatters: {
                            "link2": function(column, row)
                            {
                                return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                            }
                        },
                        rowCount: [-1, 25, 50, 75]
                    });
					
					
				
				
                }

                init();
                
               $("#TotalRowCount2").on("click", function ()
                {
				alert($("#TXDuplicationsGrid").bootgrid("getRowCount"));
               	 $("#TotalRowCount2").html($("#TXDuplicationsGrid").bootgrid("getRowCount"));
                   
                });
                $( "#TotalRowCount2" ).blur(function() {
                	$("#TotalRowCount2").html("Total Row Count");
              	});
                    
				
                
             
                
                
          
           
        </script>
	
	<!--end table scripts -->



<!---start these scripts to anmat charts--->

  <script class="code" type="text/javascript">$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        var s1 = [<?php echo $TotalImpactedSites?>];
       
        var ticks = [<?php echo $BSCName;?>];
        plot1 = $.jqplot('chart1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });
    
        $('#chart1').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('Site: '+ticks[pointIndex]+', Impacted: '+data);
            }
        );
    });</script>
    
    
    
    
    
    <script class="code" type="text/javascript">$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        var s1 = [<?php echo $impactedAreasPercentage ;?>];
        var ticks = [<?php echo $AreasList ;?>];
        
        plot1 = $.jqplot('chart1_1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });
    
        $('#chart1_1').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1_1').html(' Area : '+ticks[pointIndex]+', Impacted Area: '+data);
            }
        );
    });</script>
    
    
    
<!-- End example scripts -->

<!-- Don't touch this! -->


    <script class="include" type="text/javascript" src="./jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="syntaxhighlighter/scripts/shCore.min.js"></script>
    <script type="text/javascript" src="syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
    <script type="text/javascript" src="syntaxhighlighter/scripts/shBrushXml.min.js"></script>
<!-- Additional plugins go here -->

  <script class="include" type="text/javascript" src="./plugins/jqplot.barRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="./plugins/jqplot.pieRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="./plugins/jqplot.categoryAxisRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="./plugins/jqplot.pointLabels.min.js"></script>

<!-- End additional plugins -->
   <!---start tabs here -->
<script src="external/jquery/jquery.js"></script>
<script src="jquery-ui.js"></script>
<script>
$( "#tabs" ).tabs();
// Hover states on the static widgets
$( "#dialog-link, #icons li" ).hover(
	function() {
		$( this ).addClass( "ui-state-hover" );
	},
	function() {
		$( this ).removeClass( "ui-state-hover" );
	}
);
</script>
<!---end tabs here -->
<!---end these this scripts for animating th charts -->	
	<!--  script type="text/javascript" src="example.min.js"></script-->
				<link rel="stylesheet" type="text/css" href="./css/jquery.datetimepicker.css"/>
<script src="./js/jquery.datetimepicker.full.min.js"></script>
<script>
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
if(dd<10)dd='0'+dd
if(mm<10) mm='0'+mm
today = <?php echo "'".$MismatchReportDate."'" ;?> ;
$('#Mismatchdatetimepicker').datetimepicker({
	yearOffset:0,
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y-m-d',
    startDate:	today
});
$('#Mismatchdatetimepicker').datetimepicker({value:today+'',step:10});
document.getElementById('MismatchReportChangeDate').onclick = function() {
var eMismatchReportChangeDate = document.getElementById("Mismatchdatetimepicker");
	  	var MismatchReportChangeDate = eMismatchReportChangeDate.value;
		//alert('CMStatistics.php?ChangeStatisticsDate='.MismatchReportChangeDate);
window.location.href ='MismatchOutput.php?MismatchReportDate='+MismatchReportChangeDate ;
} 
</script>




			
			<!--end date -->
			