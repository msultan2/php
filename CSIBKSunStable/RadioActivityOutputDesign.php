<!-- here you can stsrt -->

<div id="e_myWorld_mainPage_ajax" style="">
	<div class="＿bea-wlp-disc-context-hook" id="disc_655f6d79576f726c645f6d61696e50616765" >
		<div id="myWorld_mainPage" class="wlp-bighorn-page">
		
		
		
		
<div class="container-fluid">

<form method="POST" enctype="multipart/form-data" action="save.php" id="myForm">
	<input type="hidden" name="img_val" id="img_val" value="" />
</form>
<input id="exportallbtn" class ="btn btn-lg  btn-success center-inline" type="button"  value="Export All">
<input type="submit" class="btn btn-lg  btn-success center-inline" value="Charts Picture" onclick="capture();"  style=""/>
<input id="send" class ="btn btn-lg  btn-success center-inline" type="button"  value="Send">
<img id="loadingicon" src="" />




        <div class="row">
  <div class="col-md-11">
  <h6 style="font-size: 40px;text-align: center;"> <?php echo $CardType ?> (<?php  echo $CRQ ;?>)</h6>
  </div>

  
</div>

	
	  <script>
	  		 $("#loadingicon").attr("src","./images/loader.gif");

	 var  ExectionTime =<?php echo "'".$ExectionTime."'" ;?> ;
	 //alert(ExectionTime);
  $.ajax(
{url: "./ConflictsRefresh.php?SQLNUM=1&date="+ExectionTime,
async: true,
 success: function(result){
 //alert(result+"1");
 }});
 
 $.ajax(
{url: "./ConflictsRefresh.php?SQLNUM=2&date="+ExectionTime,
async: true,
 success: function(result){
 //alert(result+"2");
 }});
 $.ajax(
{url: "./ConflictsRefresh.php?SQLNUM=3&date="+ExectionTime,
async: true,
 success: function(result){
 		 $("#loadingicon").attr("src","./images/loaderdone.png");

 //alert(result+"3");
 }});
 $.ajax(
{url: "./ConflictsRefresh.php?SQLNUM=4&date="+ExectionTime,
async: true,
 success: function(result){
 //alert(result+"4");
 }});
 $.ajax(
{url: "./ConflictsRefresh.php?SQLNUM=5&date="+ExectionTime,
async: true,
 success: function(result){
 //alert(result+"5");
 }});
 $.ajax(
{url: "./ConflictsRefresh.php?SQLNUM=6&date="+ExectionTime,
async: true,
 success: function(result){
 //alert(result+"6");
 }});
 

 </script>
 

<div class="row">
<div class="col-md-4">
 <label class="control-label labelsize">Type of Activity &nbsp;:</label> <label class="control-label labelsize"><?php echo $TypeofActivity ?></label> </br>
</div>
  <div class="col-md-4">
   <label class="control-label labelsize">Down Time (Hrs) : </label><label class="control-label labelsize"><?php echo $DownTimeHrs ?></label>
</div> 
 </div>
  
  
   <div class="row">
   <div class="col-md-6">
   <label class="control-label labelsize">Total Speech Traffic Impacted (KErlg)</label> <label class="control-label labelsize"> : <?php echo round($TotalSpeechTrafficImpactedErlg/1000,2) ?></label></br>
     </div>
   <div class="col-md-6">   
   <label class="control-label labelsize">Total Data Traffic Impacted (GB)</label> <label class="control-label labelsize"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo round($TotalDataTrafficImpactedMB/1024,2) ?></label>
    </div>
  </div>
  
   <div class="row">
   <div class="col-md-6">
   <label class="control-label labelsize">Availability impact </label> <label class="control-label labelsize"> : <?php $availabiltiyImp= $TableArrayResult['Total Impacted Sites']['No. Sites'] / ( 16000 * 24); $availabiltiyImp=$availabiltiyImp*100; echo round($availabiltiyImp ,2) ?> %</label></br>
     </div>
  
  </div>



<div class="row">


	<div style="
    display: inline !important;
">
   <div style=" border: 1px solid silver; overflow: auto; width: 100%; height: 400px;">
      <div >   



	     <div class="colmask leftmenu">
      <div class="colleft">
        <div class="col1" id="example-content">

  
<!-- Example scripts go here -->
    <div style="text-align: center;"><span>Impacted Sites Per BSC/RNC</span></div>
   
        
    <div id="chart1" style="margin-top:7px;width:<?php echo($Chart2Width*60)."px"; ?>; height:100%;"></div>
<pre class="code brush:js" style="
    display: none;
"></pre>
<!-- End additional plugins -->
 <div><span>>></span><span id="info1">Nothing yet</span></div>
        </div>
        
               </div>
    </div>
	
	  </div>
	  </div>
	  </div>
	<!---start chart in side tab-->
	
	
 
	<!---end chart in side tabs -->
	
	

</div>





<div class="row">

  <!---start chart in side tab-->
	
	<div style="
    display: inline !important;
">
   <div style=" border: 1px solid silver; overflow: auto; width: 100%; height: 400px;">
      <div >   
	      <div class="colmask leftmenu" style="">
      <div class="colleft">
        <div class="col1" id="example-content">

  
<!-- Example scripts go here -->
         <div style="text-align: center;"><span>Activity Impact Per Area</span></div>

        
    <div id="chart1_1" style="margin-top:7px; width:<?php echo($Chart1Width*60)."px"; ?> ; height:100%;"></div>
<pre class="code brush:js" style="
    display: none;
"></pre>
    <div><span>>> </span><span id="info1_1">Nothing yet</span></div>
<!-- End additional plugins -->
        </div>
        
               </div>
    </div>
	  </div> 
	  </div>
	   </div>
	  

	<!---end chart in side tabs -->
	
	
	
</div>



<div class="row">
  <div class="col-md-11">
  
  
  <!--start table in side tab -->

  
	        <div class="container-fluid">
           
			     <div class="row">
               
			   

                
                <style>
                #append , #clear ,#destroy, #init, #clearSearch, #clearSort ,
                #getCurrentPage, #getRowCount, #getTotalPageCount ,#getSearchPhrase, 
                #getSortDictionary, #getSelectedRows,#getSelectedRows
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
                                    
                                    
									
								
                                    <th data-column-id="ImpactedAreas2"  data-identifier="true" data-order="asc" data-align="center" data-header-align="center" data-width="20%">Impacted Areas</th>
                                    <th data-column-id="Impacted_2G_Sites2" data-type="numeric" sortable="true" data-visible="true" sortable="true">2G Imp Sts</th>
                                    <th data-column-id="Total_2G_Sites2" data-type="numeric" data-visible="true" sortable="true">Tot 2G Sts</th>
                                    <th data-column-id="Impacted_3G_Sites2" data-type="numeric" data-visible="true" sortable="true">3G Imp Sts</th>
                                    <th data-column-id="Total_3G_Sites2" data-type="numeric" data-visible="true" sortable="true">Tot 3G Sts</th>
                                    <th data-column-id="Area_2G_Impact_%2" data-type="numeric" data-visible="true" sortable="true">2G Impact%</th>
									<th data-column-id="Area_3G_Impact_%2"" data-type="numeric" data-visible="true" sortable="true">3G Impact%"</th>
									
                
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
                #getSortDictionary, #getSelectedRows,#getSelectedRows
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
                                    <th data-column-id="impactedsites" data-type="numeric" data-visible="true" sortable="true">No. Sites</th>
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
			
			
			
			<!-- table of temp data -->
				  <div class="row">
               
                
                <style>
                #append , #clear ,#destroy, #init, #clearSearch, #clearSort ,
                #getCurrentPage, #getTotalPageCount ,#getSearchPhrase, 
                #getSortDictionary, #getSelectedRows
					{
						Display:none; 
                	}
                
                </style>
                <div class="col-md-12">
                    <button id="append" type="button" class="btn btn-default">Append</button>
                    <button id="clear" type="button" class="btn btn-default">Clear</button>
                    <button id="exportSites" type="button" class="btn btn-warning">Export Sites</button>
                    <button id="destroy" type="button" class="btn btn-default">Destroy</button>
                    <button id="init" type="button" class="btn btn-default">Init</button>
                    <button id="clearSearch" type="button" class="btn btn-default">Clear Search</button>
                    <button id="clearSort" type="button" class="btn btn-default">Clear Sort</button>
                    <button id="getCurrentPage" type="button" class="btn btn-default">Current Page Index</button>
                    <!--button id="getRowCount" type="button" class="btn btn-default">Row Count</button-->
                    <button id="getTotalRowCount3" type="button" class="btn btn-info">Total Row Count</button>
                    <button id="getTotalPageCount" type="button" class="btn btn-default">Total Page Count</button>
                    <button id="getSearchPhrase" type="button" class="btn btn-default">Search Phrase</button>
                    <button id="getSortDictionary" type="button" class="btn btn-default">Sort Dictionary</button>
                    <button id="getSelectedRows" type="button" class="btn btn-default">Selected Rows</button>
                    <!--div class="table-responsive"-->
                        <table id="tempgrid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                    <!--  th data-column-id="id" data-identifier="true" data-type="numeric" data-align="right" data-width="40">ID</th>
                                    <th data-column-id="sender" data-order="asc" data-align="center" data-header-align="center" data-width="75%">Sender</th>
                                    <th data-column-id="received" data-css-class="cell" data-header-css-class="column" data-filterable="true">Received</th>
                                    <th data-column-id="link" data-formatter="link" data-sortable="false" data-width="75px">Link</th>
                                    <th data-column-id="status" data-type="numeric" data-visible="false">Status</th -->
                                    
                                    
                                    <th data-column-id="tempSiteID"  data-identifier="true" data-order="asc" data-align="center" data-header-align="center" data-width="20%">SiteID</th>
                                    <th data-column-id="tempHubName"  data-visible="true" sortable="true">Hub Name</th>
									<th data-column-id="tempSubRegion"  data-visible="true" sortable="true">Sub Region</th>
									<th data-column-id="tempNE"  data-visible="true" sortable="true">NE</th>
									<th data-column-id="tempTotalSpeechTrafic"  data-visible="true" sortable="true">Total Speech Trafic</th>
									<th data-column-id="tempDataMB"  data-visible="true" sortable="true">Data MB</th>
								    <th data-column-id="tempCRQ"  data-visible="true" sortable="true">CRQ</th>
                                    <th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
							
                            foreach ($TableTempArrayResult as $i => $values) {
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
					
					
					
					$("#tempgrid").bootgrid({
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
                
                
                
                $("#TotalRowCount2").on("click", function ()
                {
               	 $("#TotalRowCount2").html($("#grid2").bootgrid("getTotalRowCount"));
                   
                });
                $( "#TotalRowCount2" ).blur(function() {
                	$("#TotalRowCount2").html("Total Row Count");
              	});
				
				
				$("#getTotalRowCount3").on("click", function ()
                {
               	 $("#getTotalRowCount3").html($("#tempgrid").bootgrid("getTotalRowCount"));
                   
                });
                $( "#getTotalRowCount3" ).blur(function() {
                	$("#getTotalRowCount3").html("Total Row Count");
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
                $('#info1').html('Site: '+ticks[pointIndex]+', Impacted: '+data[1]);
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
                $('#info1_1').html(' Area : '+ticks[pointIndex]+', Impacted Area: '+data[1]);
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
			
			
			<a id="openNew" href="http://www.example.org" style="display:none;">Click me</a>
<script src="js/tableToExcel.js"></script>
<script type="text/javascript" src="js/html2canvas.js"></script>
<script type="text/javascript" src="js/jquery.plugin.html2canvas.js"></script>
<script type="text/javascript">


	function capture() {
	
	
	
  
  
		$('#chart1').html2canvas({
			onrendered: function (canvas) {
                //Set hidden field's value to image data (base-64 string)
				$('#img_val').val(canvas.toDataURL("image/png", 1.0));
				 image = canvas.toDataURL("image/png", 1.0);  // here is the most important part because if you dont replace you will get a DOM 18 exception.

                //window.open(image,'_blank');
             
  $('#openNew').addClass("external").attr({ target: "_blank", href: image,download:'impactedareaPercentage.jpg' })[0].click();

			}
		});
		
		$('#chart1_1').html2canvas({
			onrendered: function (canvas) {
                //Set hidden field's value to image data (base-64 string)
				$('#img_val').val(canvas.toDataURL("image/png", 1.0));

				 image = canvas.toDataURL("image/png", 1.0).replace("image/png", "image/octet-stream");  // here is the most important part because if you dont replace you will get a DOM 18 exception.	 
				 /*$.ajax({
type: "POST",
  url: "uploadcode.php",
  data: image,
 success: function(result){
 alert(result);
 }});*/
 
 
  $('#openNew').addClass("external").attr({ target: "_blank", href: image,download:'impactedSitesPerBSC.jpg' })[0].click();

                 //window.open(image,'_blank');// it will save locally


			}
		});
		
		
		
		
	}
	
	
	
      document.getElementById('exportallbtn').onclick = function() {
//tablesToExcel(['grid'], ['ProductDay1'], 'TestBook.xls', 'Excel');
//tablesToExcel(['grid'], ['ProductDay1'], 'TestBook.xls', 'Excel')
	  tableToExcel('grid2', 'W3C Example Table',<?php echo "'".$CRQ."'" ?> );
	  
	  tableToExcel2('grid', 'W3C Example Table22',<?php echo "'".$CRQ."'" ?>);
	  //tableToExcel3('tempgrid', 'W3C Example Table22',<?php echo "'".$CRQ."'" ?>);
	  capture();
}



document.getElementById('send').onclick = function() {


$('#chart1').html2canvas({
			onrendered: function (canvas) {
                //Set hidden field's value to image data (base-64 string)
				$('#img_val').val(canvas.toDataURL("image/png", 1.0));
				 dataURL = canvas.toDataURL("image/png", 1.0);  // here is the most important part because if you dont replace you will get a DOM 18 exception.             
		$.ajax({type: "POST",url: "script.php",data: { imgBase64: dataURL ,canvasnum:"canvas1",crq:<?php echo '"'.$CRQ.'"';?>}}).done(function(o) {});

			}
		});

	$('#chart1_1').html2canvas({
			onrendered: function (canvas) {
                //Set hidden field's value to image data (base-64 string)
				$('#img_val').val(canvas.toDataURL("image/png", 1.0));
				 dataURL = canvas.toDataURL("image/png", 1.0);  // here is the most important part because if you dont replace you will get a DOM 18 exception.             
$.ajax({type: "POST",url: "script.php",data: { imgBase64: dataURL,canvasnum:"canvas2",crq:<?php echo '"'.$CRQ.'"';?>}}).done(function(o) {});

			}
		});	
		
		$('#grid2').html2canvas({
			onrendered: function (canvas) {
                //Set hidden field's value to image data (base-64 string)
				$('#img_val').val(canvas.toDataURL("image/png", 1.0));
				 dataURL = canvas.toDataURL("image/png", 1.0);  // here is the most important part because if you dont replace you will get a DOM 18 exception.             
$.ajax({type: "POST",url: "script.php",data: { imgBase64: dataURL,canvasnum:"canvas3",crq:<?php echo '"'.$CRQ.'"';?>}}).done(function(o) {});

			}
		});	
		
		$('#grid').html2canvas({
			onrendered: function (canvas) {
                //Set hidden field's value to image data (base-64 string)
				$('#img_val').val(canvas.toDataURL("image/png", 1.0));
				 dataURL = canvas.toDataURL("image/png", 1.0);  // here is the most important part because if you dont replace you will get a DOM 18 exception.             
$.ajax({type: "POST",url: "script.php",data: { imgBase64: dataURL,canvasnum:"canvas4",crq:<?php echo '"'.$CRQ.'"';?>}}).done(function(o) {});

			}
		});	
		
		$('#tempgrid').html2canvas({
			onrendered: function (canvas) {
                //Set hidden field's value to image data (base-64 string)
				$('#img_val').val(canvas.toDataURL("image/png", 1.0));
				 dataURL = canvas.toDataURL("image/png", 1.0);  // here is the most important part because if you dont replace you will get a DOM 18 exception.             
$.ajax({type: "POST",url: "script.php",data: { imgBase64: dataURL,canvasnum:"canvas5",crq:<?php echo '"'.$CRQ.'"';?>}}).done(function(o) {});

			}
		});	
  tableToExcel3('tempgrid', 'W3C Example Table22',<?php echo "'".$CRQ."'" ?>);

		
		
		


$("#loadingicon").attr("src","./images/loader.gif");
$.ajax(
{url: "sendmail.php?send=true&CRQ=<?php  echo $CRQ ;?>",
 success: function(result){if(result=="sent")
$("#loadingicon").attr("src","./images/loaderdone.png");
 else
 $("#loadingicon").attr("src","./images/loaderfailed.png");
 }});
 
 
/*$.ajax({
type: "POST",
  url: "uploadcode.php",
  data: "jjgjg",
  dataType: "text", 
 success: function(result){
 //alert(result);
 }});


*/
}




  $("#exportSites").on("click", function ()
                {
			
         tableToExcel3('tempgrid', 'W3C Example Table22',<?php echo "'".$CRQ."'" ?>);

                });
				
				
</script>