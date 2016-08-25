<!-- here you can stsrt -->

<div id="e_myWorld_mainPage_ajax" style="">
	<div class="＿bea-wlp-disc-context-hook" id="disc_655f6d79576f726c645f6d61696e50616765" >
		<div id="myWorld_mainPage" class="wlp-bighorn-page">
		
		
		
		
<div class="container-fluid">






        




  
  
  
  
  









<div class="row">
  <div class="col-md-11">
  
  
  <!--start table in side tab -->

  
	        <div class="container-fluid">
           
			 <div class="row">
			 <h6> These Sites is Down Impacted After  Activity CRQ(<?php  echo $CRQ ;?> )</h6>
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
                                    
                                    
                                    <th data-column-id="SiteID"  data-identifier="true" data-order="asc" data-align="center" data-header-align="center" data-width="20%">Site ID</th>
                                    <th data-column-id="SiteStatus"  data-visible="true" sortable="true">SiteStatus</th>
                                    <th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
							
                            foreach ($TableArrayResult as $i => $values) {
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
                
                
                
                $("#TotalRowCount2").on("click", function ()
                {
               	 $("#TotalRowCount2").html($("#grid2").bootgrid("getTotalRowCount"));
                   
                });
                $( "#TotalRowCount2" ).blur(function() {
                	$("#TotalRowCount2").html("Total Row Count");
              	});
              	
            });

           
        </script>
	
	
	<!--end table scripts -->



<!-- End additional plugins -->

<!---end these this scripts for animating th charts -->	
	<!--  script type="text/javascript" src="example.min.js"></script-->
			