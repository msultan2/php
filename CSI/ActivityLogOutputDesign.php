<!-- here you can stsrt -->

<div id="e_myWorld_mainPage_ajax">
	<div class="＿bea-wlp-disc-context-hook" id="disc_655f6d79576f726c645f6d61696e50616765" >
		<div id="myWorld_mainPage" class="wlp-bighorn-page">
		
		
		
		
<div class="container-fluid">






        <div class="row">
  <div class="col-md-11">
  <h6 style="font-size: 40px;text-align: center;"> <?php echo $CardType ?> </h6>
  </div>

  
</div>



<div class="row">
  <div class="col-md-6">
   <label class="control-label labelsize">Type of Activity &nbsp;:</label> <label class="control-label labelsize"><?php echo $TypeofActivity ?></label> </br>
   <label class="control-label labelsize">Down Time (Hrs) : </label><label class="control-label labelsize"><?php echo $DownTimeHrs ?></label>
  </div>
  <div class="col-md-5">
   <label class="control-label labelsize">Total Speech Traffic Impacted (Erlg)</label> <label class="control-label labelsize"> : <?php echo $TotalSpeechTrafficImpactedErlg ?></label></br>
    <label class="control-label labelsize">Total Data Traffic Impacted (MB)</label> <label class="control-label labelsize"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $TotalDataTrafficImpactedMB ?></label>
  </div>

</div>



<div class="row">
  <div class="col-md-5">
  

	<!---start chart in side tab-->
	
	
    <div class="colmask leftmenu">
      <div class="colleft">
        <div class="col1" id="example-content">

  
<!-- Example scripts go here -->
    <div style="text-align: left;"><span>Impacted Sites Per BSC/RNC</span></div>
   
        
    <div id="chart1" style="margin-top:7px;width:300px; height:300px;"></div>
<pre class="code brush:js" style="
    display: none;
"></pre>
<!-- End additional plugins -->
 <div><span>>></span><span id="info1">Nothing yet</span></div>
        </div>
        
               </div>
    </div>
	<!---end chart in side tabs -->
	
	
	
  </div>
  
  
  
  
  <div class="col-md-6">
  
  
  
  <!---start chart in side tab-->
	
	
    <div class="colmask leftmenu" style="margin-left: 150px;">
      <div class="colleft">
        <div class="col1" id="example-content">

  
<!-- Example scripts go here -->
         <div style="text-align: center;"><span>Impacted Areas</span></div>

        
    <div id="chart1_1" style="margin-top:7px; width:300px; height:300px;"></div>
<pre class="code brush:js" style="
    display: none;
"></pre>
    <div><span>>> </span><span id="info1_1">Nothing yet</span></div>
<!-- End additional plugins -->
        </div>
        
               </div>
    </div>
	<!---end chart in side tabs -->
	
	
	
	
	
	
	
	
	
	
	
  
  
  
  
  
  
  
  
  
  
  </div>
</div>

<div class="row">

  <div class="col-md-11"><h6 style="font-size: 20px;text-align: center;"> Activity Impact Per Area</h6>
 
  </div>
</div>
<div class="row">
  <div class="col-md-11">
  
  
  <!--start table in side tab -->

  
	        <div class="container-fluid">
           
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
				<button id="removeSelected2" type="button" class="btn btn-warning">Remove Selected</button>
				<button id="getTotalRowCount2" type="button" class="btn btn-info">Total Row Count</button>
				
                    <button id="append" type="button" class="btn btn-default">Append</button>
                    <button id="clear" type="button" class="btn btn-default">Clear</button>
                    
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
                        <table id="grid2" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                    <!--  th data-column-id="id" data-identifier="true" data-type="numeric" data-align="right" data-width="40">ID</th>
                                    <th data-column-id="sender" data-order="asc" data-align="center" data-header-align="center" data-width="75%">Sender</th>
                                    <th data-column-id="received" data-css-class="cell" data-header-css-class="column" data-filterable="true">Received</th>
                                    <th data-column-id="link" data-formatter="link" data-sortable="false" data-width="75px">Link</th>
                                    <th data-column-id="status" data-type="numeric" data-visible="false">Status</th -->
                                    
                                    
									
								
                                    <th data-column-id="ImpactedAreas2"  data-identifier="true" data-order="asc" data-align="center" data-header-align="center" data-width="20%">Impacted Areas</th>
                                    <th data-column-id="Impacted_2G_Sites2" data-type="numeric" data-visible="true" sortable="true"> Impacted_2G_Sites</th>
                                    <th data-column-id="Total_2G_Sites2" data-type="numeric" data-visible="true" sortable="true">Total_2G_Sites</th>
                                    <th data-column-id="Impacted_3G_Sites2" data-type="numeric" data-visible="true" sortable="true">Impacted_3G_Sites</th>
                                    <th data-column-id="Total_3G_Sites2" data-type="numeric" data-visible="true" sortable="true">Total_3G_Sites</th>
                                    <th data-column-id="Area_2G_Impact_%2" data-type="numeric" data-visible="true" sortable="true">Area 2G Impact %</th>
									<th data-column-id="Area_3G_Impact_%2"" data-type="numeric" data-visible="true" sortable="true">Area 3G Impact %"</th>
									
                
									<th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
                            foreach ($Table2ArrayResult as $i => $values) {
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
                                    
                                    
                                    <th data-column-id="ImpactedAreas"  data-identifier="true" data-order="asc" data-align="center" data-header-align="center" data-width="20%">Impacted Areas</th>
                                    <th data-column-id="impactedsites" data-type="numeric" data-visible="true" sortable="true"># Impacted Sites</th>
                                    <th data-column-id="totalsitesperarea" data-type="numeric" data-visible="true" sortable="true">Total Sites per area</th>
                                    <th data-column-id="areaimpactpercentage" data-type="numeric" data-visible="true" sortable="true">Area Impact %</th>
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
			
			
			
        </div>
	
	
	<!--end table indide tab-->
	
	
	
  
  </div>

</div>
        
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
            $(function()
            {
                function init()
                {
                    $("#grid").bootgrid({
                        formatters: {
                            "link": function(column, row)
                            {
                                return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                            }
                        },
                        rowCount: [-1, 25, 50, 75]
                    });
					
					$("#grid2").bootgrid({
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
                
                $("#append").on("click", function ()
                {
                    $("#grid").bootgrid("append", [{
                            id: 0,
                            sender: "hh@derhase.de",
                            received: "Gestern",
                            link: ""
                        },
                        {
                            id: 12,
                            sender: "er@fsdfs.de",
                            received: "Heute",
                            link: ""
                        }]);
                });
                
                $("#clear").on("click", function ()
                {
                    $("#grid").bootgrid("clear");
                });
                
                $("#removeSelected").on("click", function ()
                {
                    $("#grid").bootgrid("remove");
                });
                
                $("#destroy").on("click", function ()
                {
                    $("#grid").bootgrid("destroy");
                });
                
                $("#init").on("click", init);
                
                $("#clearSearch").on("click", function ()
                {
                    $("#grid").bootgrid("search");
                });
                
                $("#clearSort").on("click", function ()
                {
                    $("#grid").bootgrid("sort");
                });
                
                $("#getCurrentPage").on("click", function ()
                {
                    alert($("#grid").bootgrid("getCurrentPage"));
                });
                
                $("#getRowCount").on("click", function ()
                {
                    alert($("#grid").bootgrid("getRowCount"));
                });
                
                $("#getTotalPageCount").on("click", function ()
                {
                    alert($("#grid").bootgrid("getTotalPageCount"));
                });
                
                $("#getTotalRowCount").on("click", function ()
                {
               	 $("#getTotalRowCount").html($("#grid").bootgrid("getTotalRowCount"));
                   
                });
                
                $("#getSearchPhrase").on("click", function ()
                {
                    alert($("#grid").bootgrid("getSearchPhrase"));
                });
                
                $("#getSortDictionary").on("click", function ()
                {
                    alert($("#grid").bootgrid("getSortDictionary"));
                });
                
                $("#getSelectedRows").on("click", function ()
                {
                    alert($("#grid").bootgrid("getSelectedRows"));
                });


                $( "#getTotalRowCount" ).blur(function() {
                	$("#getTotalRowCount").html("Total Row Count");
              	});
				
				
				///start table 20%
				
				 
                $("#removeSelected2").on("click", function ()
                {
                    $("#grid2").bootgrid("remove");
                });
                
                
                
                $("#getTotalRowCount2").on("click", function ()
                {
               	 $("#getTotalRowCount2").html($("#grid2").bootgrid("getTotalRowCount"));
                   
                });
               
              	
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
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
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
                $('#info1_1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
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

<!---end these this scripts for animating th charts -->	
	<!--  script type="text/javascript" src="example.min.js"></script-->
			