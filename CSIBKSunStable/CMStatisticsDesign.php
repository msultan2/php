<!-- here you can stsrt -->

<div id="e_myWorld_mainPage_ajax">
	<div class="＿bea-wlp-disc-context-hook" id="disc_655f6d79576f726c645f6d61696e50616765" >
		<div id="myWorld_mainPage" class="wlp-bighorn-page">
		
		
		
		
<div class="container-fluid">




	<div id="tabs" style="background: rgb(255, 255, 255) url("images/ui-bg_highlight-soft_100_eeeeee_1x100.png") 50% top repeat-x;">
	<ul style="border: 1px solid #e60000;
     background: #e60000; url("images/ui-bg_gloss-wave_35_f6a828_500x100.png") 50% 50% repeat-x;">
		<?php  if (true==true){?><li><a href="#tabs-1">Change Statistics </a></li><?php }?>
		<?php  if (true==true){?><li><a href="#tabs-2">Conflict Statistics </a></li><?php }?>
	</ul>
	
	
	<div id="tabs-1" style="">
	
		
	
			     <div class="row">
               
			   
			   




			   
<div id="" style="width: 100%;  float:left">
		<label class="control-label labelsize">Choose Date :</label>
		<input class="btn btn-default" type="text" name="ChangeStatisticsDate" value="" id="CSdatetimepicker"/>

		<button id="CSChangeDate" type="button" class="btn btn-lg  btn-success center-inline" style="width:20%;" >Get Statistics</button>  
	<button id="Save"  type="button" class="btn btn-lg  btn-success center-inline" style="width:20%;" >Save</button>  
<img id="loadingicon" src="" />




		</div>
                
                <style>
                #append , #clear ,#destroy, #init, #clearSearch, #clearSort ,
                #getCurrentPage, #getRowCount, #getTotalPageCount ,#getSearchPhrase, 
                #getSortDictionary, #getSelectedRows
					{
						Display:none; 
                	}
                
                </style>
                <div class="col-md-12">
				<button id="removeSelected2" type="button" class="btn btn-warning">Remove Selected</button>
				<button id="TotalRowCount2" type="button" class="btn btn-info">Total Row Count</button>
				
                    <button id="append" type="button" class="btn btn-default">Append</button>
                    <button id="clear" type="button" class="btn btn-default">Clear</button>
                    
                    <button id="destroy" type="button" class="btn btn-default">Destroy</button>
                    <button id="init" type="button" class="btn btn-default">Init</button>
                    <button id="clearSearch" type="button" class="btn btn-default">Clear Search</button>
                    <button id="clearSort" type="button" class="btn btn-default">Clear Sort</button>
                    <button id="getCurrentPage" type="button" class="btn btn-default">Current Page Index</button>
                    <button id="getRowCount" type="button" class="btn btn-default">Row Count</button>
                    
                    <button id="getTotalPageCount" type="button" class="btn btn-default">Total Page Count</button>
                    <button id="getSearchPhrase" type="button" class="btn btn-default">Search Phrase</button>
                    <button id="getSortDictionary" type="button" class="btn btn-default">Sort Dictionary</button>
                    <button id="getSelectedRows" type="button" class="btn btn-default">Selected Rows</button>
                    <!--div class="table-responsive"-->
                        <table id="grid2" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                    <!--  th data-column-id="id" data-identifier="true" data-type="numeric" data-align="right" data-width="40">ID</th>
                                    <th data-column-id="sender" data-order="asc" data-align="center" data-header-align="center" data-width="75%">Sender</th>
                                    <th data-column-id="received" data-css-class="cell" data-header-css-class="column" data-filterable="true">Received</th>
                                    <th data-column-id="link" data-formatter="link" data-sortable="false" data-width="75px">Link</th>
                                    <th data-column-id="status" data-type="numeric" data-visible="false">Status</th -->
                                    
                                    
			
								
                                    <th data-column-id="crq"   data-identifier="true"data-order="asc" data-align="center" data-header-align="center" data-width="20%">CRQ</th>
                                    <th data-column-id="Total_SPEECH_TRAFFIC_KErlg" data-visible="true" sortable="true">Tot Speech KErlg</th>
                                    <th data-column-id="NW_SPEECH_TRAFFIC_KErlg" data-visible="false">NW_SPEECH_TRAFFIC_KErlg</th>
                                    <th data-column-id="Activity_Impact_Speech"  data-visible="true" sortable="true">Impacted Speech</th>
                                    <th data-column-id="DATA_GB"  data-visible="true" sortable="true">DATA_GB</th>
                                    <th data-column-id="NW_DATA_GB"  data-visible="false">NW_DATA_GB</th>
									<th data-column-id="Activity_Impact_Data"  data-visible="true" sortable="true">Impact Data(%)</th>
									<th data-column-id="Site_Count"  data-visible="true" sortable="true">Site Count</th>
									<th data-column-id="Activity_owner"  data-visible="true" sortable="true">Owner</th>
									<th data-column-id="Postponded"  data-visible="true" sortable="true">Status</th>

                
									<th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
                            foreach ($Table2ArrayResult as $i => $values) {
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
			
			  <div class="row">
               
                
                <style>
                #append , #clear ,#destroy, #init, #clearSearch, #clearSort ,
                #getCurrentPage, #getRowCount, #getTotalPageCount ,#getSearchPhrase, 
                #getSortDictionary, #getSelectedRows
					{
						Display:none; 
                	}
                
                </style>
                <div class="col-md-12">
                    <button id="append" type="button" class="btn btn-default">Append</button>
                    <button id="clear" type="button" class="btn btn-default">Clear</button>
                    <button id="removeSelected" type="button" class="btn btn-warning">Remove Selected</button>
                    <button id="destroy" type="button" class="btn btn-default">Destroy</button>
                    <button id="init" type="button" class="btn btn-default">Init</button>
                    <button id="clearSearch" type="button" class="btn btn-default">Clear Search</button>
                    <button id="clearSort" type="button" class="btn btn-default">Clear Sort</button>
                    <button id="getCurrentPage" type="button" class="btn btn-default">Current Page Index</button>
                    <button id="getRowCount" type="button" class="btn btn-default">Row Count</button>
                    <button id="getTotalRowCount" type="button" class="btn btn-info">Total Row Count</button>
                    <button id="getTotalPageCount" type="button" class="btn btn-default">Total Page Count</button>
                    <button id="getSearchPhrase" type="button" class="btn btn-default">Search Phrase</button>
                    <button id="getSortDictionary" type="button" class="btn btn-default">Sort Dictionary</button>
                    <button id="getSelectedRows" type="button" class="btn btn-default">Selected Rows</button>
                    <!--div class="table-responsive"-->
                        <table id="grid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                    <!--  th data-column-id="id" data-identifier="true" data-type="numeric" data-align="right" data-width="40">ID</th>
                                    <th data-column-id="sender" data-order="asc" data-align="center" data-header-align="center" data-width="75%">Sender</th>
                                    <th data-column-id="received" data-css-class="cell" data-header-css-class="column" data-filterable="true">Received</th>
                                    <th data-column-id="link" data-formatter="link" data-sortable="false" data-width="75px">Link</th>
                                    <th data-column-id="status" data-type="numeric" data-visible="false">Status</th -->
                                    
                                    
                                    <th data-column-id="title"  data-identifier="true" data-order="asc" data-align="center" data-header-align="center" data-width="20%">Title</th>
                                    <th data-column-id="impactedsites"  data-visible="true" sortable="true">No. Sites</th>
                                    <th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
							
                            foreach ($TableArrayResult as $i => $values) {
								   echo '<tr class="warning">';
								   echo '<td>'.$i.'</td>';
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
			
					

					
			     <div class="row">
               
			   

                
                <style>
                #append , #clear ,#destroy, #init, #clearSearch, #clearSort ,
                #getCurrentPage, #getRowCount, #getTotalPageCount ,#getSearchPhrase, 
                #getSortDictionary, #getSelectedRows
					{
						Display:none; 
                	}
                
                </style>
                <div class="col-md-12">
			<div id="RegionAnalysisShowContainer" style="border:3px solid blue;position:fixed;bottom:2%;left:40%;width:300px;min-height: 100px;background:white;visibility: hidden;">
<div>
<div id="RegionNameLabel" style="Display:inline"></div>
<img style="float:right;" src="images/close.png" onclick='$("#RegionAnalysisShowContainer").css("visibility","hidden");' />
</div>
<div>CRQ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NumOfSites</div>
<div id="RegionAnalysisShow"></div>
 </div>
				<button id="removeSelected2" type="button" class="btn btn-warning">Remove Selected</button>
				<button id="TotalRowCount3" type="button" class="btn btn-info">Total Row Count</button>
				
                    <button id="append" type="button" class="btn btn-default">Append</button>
                    <button id="clear" type="button" class="btn btn-default">Clear</button>
                    
                    <button id="destroy" type="button" class="btn btn-default">Destroy</button>
                    <button id="init" type="button" class="btn btn-default">Init</button>
                    <button id="clearSearch" type="button" class="btn btn-default">Clear Search</button>
                    <button id="clearSort" type="button" class="btn btn-default">Clear Sort</button>
                    <button id="getCurrentPage" type="button" class="btn btn-default">Current Page Index</button>
                    <button id="getRowCount" type="button" class="btn btn-default">Row Count</button>
                    
                    <button id="getTotalPageCount" type="button" class="btn btn-default">Total Page Count</button>
                    <button id="getSearchPhrase" type="button" class="btn btn-default">Search Phrase</button>
                    <button id="getSortDictionary" type="button" class="btn btn-default">Sort Dictionary</button>
                    <button id="getSelectedRows" type="button" class="btn btn-default">Selected Rows</button>
                    <!--div class="table-responsive"-->
                        <table id="grid3" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                    <!--  th data-column-id="id" data-identifier="true" data-type="numeric" data-align="right" data-width="40">ID</th>
                                    <th data-column-id="sender" data-order="asc" data-align="center" data-header-align="center" data-width="75%">Sender</th>
                                    <th data-column-id="received" data-css-class="cell" data-header-css-class="column" data-filterable="true">Received</th>
                                    <th data-column-id="link" data-formatter="link" data-sortable="false" data-width="75px">Link</th>
                                    <th data-column-id="status" data-type="numeric" data-visible="false">Status</th -->
                                    
                                    
			
		
                                    <th data-column-id="Sub_Region" data-identifier="true" data-formatter="link"  data-order="asc" data-align="center" data-header-align="center" data-width="20%">Sub_Region</th>
                                    <th data-column-id="Impacted_2G_Sites" data-visible="true" sortable="true">Imp 2G</th>
                                    <th data-column-id="Total_2G_Sites" data-visible="true" sortable="true">Tot 2G</th>
                                    <th data-column-id="Impacted_3G_Sites"  data-visible="true" sortable="true">Imp 3G</th>
                                    <th data-column-id="Total_3G_Sites"  data-visible="true" sortable="true">Tot 3G</th>
                                    <th data-column-id="Area 2G Impact %"  data-visible="true" sortable="true">% 2G Impact</th>
									<th data-column-id="Area 3G Impact %"  data-visible="true" sortable="true">% 3G Impact</th>
                
									<th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
                            foreach ($Table3ArrayResult as $i => $values) {
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
	
	

	
	
	
	<div id="tabs-2" style="">
	
		
	
			     <div class="row">
               
			   
			   




			   
<div id="" style="width: 100%;  float:left">
		<label class="control-label labelsize">From :</label>
		<input class="btn btn-default" type="text" name="ChangeStatisticsDate" value="" id="CSdatetimepickerFrom"/>
		<label class="control-label labelsize">To :</label>
		<input class="btn btn-default" type="text" name="ChangeStatisticsDate" value="" id="CSdatetimepickerTo"/>

		<button id="CSChangeDateConfilct" type="button" class="btn btn-lg  btn-success center-inline" style="width:20%;" >Get Statistics</button>  
	<!--button id="Save"  type="button" class="btn btn-lg  btn-success center-inline" style="width:20%;" >Save</button -->  
<img id="loadingicon" src="" />




		</div>
                
                <style>
                #append , #clear ,#destroy, #init, #clearSearch, #clearSort ,
                #getCurrentPage, #getRowCount, #getTotalPageCount ,#getSearchPhrase, 
                #getSortDictionary, #getSelectedRows
					{
						Display:none; 
                	}
                
                </style>
                <div class="col-md-12">
				<button id="removeSelected2" type="button" class="btn btn-warning">Remove Selected</button>
				<button id="TotalRowCount2" type="button" class="btn btn-info">Total Row Count</button>
				
                    <button id="append" type="button" class="btn btn-default">Append</button>
                    <button id="clear" type="button" class="btn btn-default">Clear</button>
                    
                    <button id="destroy" type="button" class="btn btn-default">Destroy</button>
                    <button id="init" type="button" class="btn btn-default">Init</button>
                    <button id="clearSearch" type="button" class="btn btn-default">Clear Search</button>
                    <button id="clearSort" type="button" class="btn btn-default">Clear Sort</button>
                    <button id="getCurrentPage" type="button" class="btn btn-default">Current Page Index</button>
                    <button id="getRowCount" type="button" class="btn btn-default">Row Count</button>
                    
                    <button id="getTotalPageCount" type="button" class="btn btn-default">Total Page Count</button>
                    <button id="getSearchPhrase" type="button" class="btn btn-default">Search Phrase</button>
                    <button id="getSortDictionary" type="button" class="btn btn-default">Sort Dictionary</button>
                    <button id="getSelectedRows" type="button" class="btn btn-default">Selected Rows</button>
                    <!--div class="table-responsive"-->
                        <table id="gridConflictAnalyze" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                    <!--  th data-column-id="id" data-identifier="true" data-type="numeric" data-align="right" data-width="40">ID</th>
                                    <th data-column-id="sender" data-order="asc" data-align="center" data-header-align="center" data-width="75%">Sender</th>
                                    <th data-column-id="received" data-css-class="cell" data-header-css-class="column" data-filterable="true">Received</th>
                                    <th data-column-id="link" data-formatter="link" data-sortable="false" data-width="75px">Link</th>
                                    <th data-column-id="status" data-type="numeric" data-visible="false">Status</th -->
                                    
                                    
			
								
                                    <th data-column-id="date"   data-identifier="true" data-order="asc" data-align="center" data-header-align="center" data-width="20%">Date</th>
                                    <th data-column-id="TxDublication" data-visible="true" sortable="true">Tx Dublication</th>
                                    <th data-column-id="BSSDublication" data-visible="true" sortable="true">BSS Dublication</th>
                                    <th data-column-id="SiteConflicts"  data-visible="true" sortable="true">Site Conflicts</th>
                                    <th data-column-id="HubConflicts"  data-visible="true" sortable="true">Hub Conflicts</th>
									<th data-column-id="NodesConflicts"  data-visible="true" sortable="true">Nodes Conflicts</th>
                                    <th data-column-id="CoverageConflicts"  data-visible="true" sortable="true">Coverage Conflicts</th>



                
									<th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
                            foreach ($TableConflictAnalyzeArrayResult as $i => $values) {
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
                    $("#grid2").bootgrid({
                        formatters: {
                            "link": function(column, row)
                            {
                                return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                            }
							
                        },
                        rowCount: [-1, 25, 50, 75]
                    });
					
					$("#grid").bootgrid({
                        formatters: {
                            "link2": function(column, row)
                            {
                                return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                            }
                        },
                        rowCount: [-1, 25, 50, 75]
                    });
					
					
						$("#grid3").bootgrid({
                        formatters: {
                            "link": function(column, row)
                            {
                                 // return "<a  onclick=\"alert('sdsds')\">"+row.Sub_Region+"</a>";

                                  return "<a  href=\"javascript:GetRegionAnalysies('"+row.Sub_Region+"')\">"+row.Sub_Region+"</a>";

                                //return " <a href='GetRegionAnalysis.php?ChangeStatisticsDate=2015-10-28&Region=" + row.Sub_Region + "'</a>"+row.Sub_Region+"</a>";
                            }
                        },
                        rowCount: [-1, 25, 50, 75]
                    });
					
					
					
					$("#gridConflictAnalyze").bootgrid({
                        formatters: {
                            "link": function(column, row)
                            {
                                 // return "<a  onclick=\"alert('sdsds')\">"+row.Sub_Region+"</a>";

                                  //return "<a  href=\"javascript:GetRegionAnalysies('"+row.Sub_Region+"')\">"+row.Sub_Region+"</a>";

                                //return " <a href='GetRegionAnalysis.php?ChangeStatisticsDate=2015-10-28&Region=" + row.Sub_Region + "'</a>"+row.Sub_Region+"</a>";
                            }
                        },
                        rowCount: [-1, 25, 50, 75]
                    });
					
					
					
					
					
				
					
                }

                init();
                
                
                $("#removeSelected").on("click", function ()
                {
                    $("#grid").bootgrid("remove");
                });
                
             
                
                $("#getTotalRowCount").on("click", function ()
                {
               	 $("#getTotalRowCount").html($("#grid").bootgrid("getTotalRowCount"));
                   
                });
                
              


                $( "#getTotalRowCount" ).blur(function() {
                	$("#getTotalRowCount").html("getTotalRowCount");
              	});
				
				
				///start table 20%
				
				 
                $("#removeSelected2").on("click", function ()
                {
                    $("#grid2").bootgrid("remove");
                });
                
                
                
                /*$("#TotalRowCount2").on("click", function ()
                {
               	 $("#TotalRowCount2").html($("#grid2").bootgrid("getTotalRowCount"));
                   
                });
                $( "#TotalRowCount2" ).blur(function() {
                	$("#TotalRowCount2").html("Total Row Count");
              	});*/
              	
         $("#TotalRowCount3").on("click", function ()
                {
               	 $("#TotalRowCount3").html($("#grid3").bootgrid("getTotalRowCount"));
                   
                });
                $( "#TotalRowCount3" ).blur(function() {
                	$("#TotalRowCount3").html("Total Row Count");
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
today =<?php echo "'".$ChangeStatisticsDate."'" ;?> ;

$('#CSdatetimepicker').datetimepicker({
	yearOffset:0,
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y-m-d',
    startDate:	today
});
$('#CSdatetimepicker').datetimepicker({value:today+'',step:10});
document.getElementById('CSChangeDate').onclick = function() {
var eCSChangeDate = document.getElementById("CSdatetimepicker");
	  	var CSChangeDate = eCSChangeDate.value;
		//alert('CMStatistics.php?ChangeStatisticsDate='.CSChangeDate);
window.location.href ='CMStatistics.php?ChangeStatisticsDate='+CSChangeDate ;
} 


// From
$('#CSdatetimepickerFrom').datetimepicker({
	yearOffset:0,
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y-m-d',
    startDate:	<?php echo "'".$ConflictStatisticsDateFrom."'" ;?>
});
$('#CSdatetimepickerFrom').datetimepicker({value:<?php echo "'".$ConflictStatisticsDateFrom."'" ;?>+'',step:10});



// To 

$('#CSdatetimepickerTo').datetimepicker({
	yearOffset:0,
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y-m-d',
    startDate:	<?php echo "'".$ConflictStatisticsDateTo."'" ;?>
});
$('#CSdatetimepickerTo').datetimepicker({value:<?php echo "'".$ConflictStatisticsDateTo."'" ;?>+'',step:10});
document.getElementById('CSChangeDateConfilct').onclick = function() {
var eCSChangeDateFrom = document.getElementById("CSdatetimepickerFrom");
	  	var CSChangeDateFrom = eCSChangeDateFrom.value;
var eCSChangeDateTo = document.getElementById("CSdatetimepickerTo");
	    var CSChangeDateTo = eCSChangeDateTo.value;
var eCSChangeDate = document.getElementById("CSdatetimepicker");
	  	var CSChangeDate = eCSChangeDate.value;
		//alert('CMStatistics.php?ChangeStatisticsDate='.CSChangeDate);
window.location.href ='CMStatistics.php?ChangeStatisticsDate='+CSChangeDate+'&ConflictStatisticsDateFrom='+CSChangeDateFrom+'&ConflictStatisticsDateTo='+CSChangeDateTo+"&#tabs-2" ;
} 


document.getElementById('Save').onclick = function() {
var selected = [];
$('#grid2 input:checked').each(function() {
selected.push($(this).attr('value'));
});
if(selected.length<1)
var CRQs ="";
else
var CRQs ="'"+selected.join('\',\'')+"'";
$.ajax(
{url: "postpondCRQ.php?CRQs="+CRQs,
 success: function(result){
 if(result==="Postponed"){
 var eCSChangeDate = document.getElementById("CSdatetimepicker");
	  	var CSChangeDate = eCSChangeDate.value;
$("#loadingicon").attr("src","./images/loaderdone.png");
 $( "#CSChangeDate" ).click();
//location.href ="./CMStatistics.php?ChangeStatisticsDate="+CSChangeDate;


}
 else
 $("#loadingicon").attr("src","./images/loaderfailed.png");
 }});
 
 
 
} 




$('#grid2 > tbody  > tr').each(function(){
//alert($(this).first().text().trim());
//$(this).find('[type=checkbox]').attr('checked', true);
if ($(this).first().text().trim().indexOf("Conf-Post") > -1)
   {
    $(this).find('[type=checkbox]').attr('checked', true);
   }
});

// start scripting the region details  

//return " <a href='GetRegionAnalysis.php?ChangeStatisticsDate=2015-10-28&Region=" + row.Sub_Region + "'</a>"+row.Sub_Region+"</a>";

function  GetRegionAnalysies(region){

$.ajax({url: "GetRegionAnalysis.php?ChangeStatisticsDate=<?php echo $ChangeStatisticsDate ;?>&Region="+region, success: function(result){

if(result){
$("#RegionAnalysisShowContainer").css("visibility","visible");
//alert(result);
$("#RegionAnalysisShow").html(result);

$("#RegionNameLabel").html("Region: "+region);
}else{
}

}});


}
/*$( "#RegionAnalysisShow" ).blur(function() {
$("#RegionAnalysisShow").css("visibility","hidden");
});*/
</script>




			
			<!--end date -->
			