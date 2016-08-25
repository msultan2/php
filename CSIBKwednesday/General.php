<!-- here you can stsrt -->






	<!---start chart in side tab-->
	
	
    <div class="colmask leftmenu" style="margin-left: 200px;">
      <div class="colleft">
        <div class="col1" id="example-content">

  
<!-- Example scripts go here -->
    <div><span>You Clicked: </span><span id="info1">Nothing yet</span></div>
        
    <div id="chart1" style="margin-top:20px; margin-left:20px; width:300px; height:300px;"></div>
<pre class="code brush:js"></pre>
<!-- End additional plugins -->
        </div>
        
               </div>
    </div>
	<!---end chart in side tabs -->
	<!--start table in side tab -->
	
	
	
	
	
	
	
	
	        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 visible-md visible-lg">
                    <div class="affix">
                        Sub Nav
                    </div>
                </div>
                <div class="col-md-9">
                    <button id="append" type="button" class="btn btn-default">Append</button>
                    <button id="clear" type="button" class="btn btn-default">Clear</button>
                    <button id="removeSelected" type="button" class="btn btn-default">Remove Selected</button>
                    <button id="destroy" type="button" class="btn btn-default">Destroy</button>
                    <button id="init" type="button" class="btn btn-default">Init</button>
                    <button id="clearSearch" type="button" class="btn btn-default">Clear Search</button>
                    <button id="clearSort" type="button" class="btn btn-default">Clear Sort</button>
                    <button id="getCurrentPage" type="button" class="btn btn-default">Current Page Index</button>
                    <button id="getRowCount" type="button" class="btn btn-default">Row Count</button>
                    <button id="getTotalRowCount" type="button" class="btn btn-default">Total Row Count</button>
                    <button id="getTotalPageCount" type="button" class="btn btn-default">Total Page Count</button>
                    <button id="getSearchPhrase" type="button" class="btn btn-default">Search Phrase</button>
                    <button id="getSortDictionary" type="button" class="btn btn-default">Sort Dictionary</button>
                    <button id="getSelectedRows" type="button" class="btn btn-default">Selected Rows</button>
                    <!--div class="table-responsive"-->
                        <table id="grid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                    <th data-column-id="id" data-identifier="true" data-type="numeric" data-align="right" data-width="40">ID</th>
                                    <th data-column-id="sender" data-order="asc" data-align="center" data-header-align="center" data-width="75%">Sender</th>
                                    <th data-column-id="received" data-css-class="cell" data-header-css-class="column" data-filterable="true">Received</th>
                                    <th data-column-id="link" data-formatter="link" data-sortable="false" data-width="75px">Link</th>
                                    <th data-column-id="status" data-type="numeric" data-visible="false">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>me@rafaelstaib.com</td>
                                    <td>11.12.2014</td>
                                    <td>Link</td>
                                    <td>999</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>me@rafaelstaib.com</td>
                                    <td>12.12.2014</td>
                                    <td>Link</td>
                                    <td>999</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>me@rafaelstaib.com</td>
                                    <td>10.12.2014</td>
                                    <td>Link</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>mo@rafaelstaib.com</td>
                                    <td>12.08.2014</td>
                                    <td>Link</td>
                                    <td>999</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>ma@rafaelstaib.com</td>
                                    <td>12.06.2014</td>
                                    <td>Link</td>
                                    <td>3</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>me@rafaelstaib.com</td>
                                    <td>12.12.2014</td>
                                    <td>Link</td>
                                    <td>999</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>ma@rafaelstaib.com</td>
                                    <td>12.11.2014</td>
                                    <td>Link</td>
                                    <td>999</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>mo@rafaelstaib.com</td>
                                    <td>15.12.2014</td>
                                    <td>Link</td>
                                    <td>999</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>me@rafaelstaib.com</td>
                                    <td>24.12.2014</td>
                                    <td>Link</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>ma@rafaelstaib.com</td>
                                    <td>14.12.2014</td>
                                    <td>Link</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>mo@rafaelstaib.com</td>
                                    <td>12.12.2014</td>
                                    <td>Link</td>
                                    <td>999</td>
                                </tr>
                            </tbody>
                        </table>
                    <!--/div-->
                </div>
            </div>
        </div>
	
	
	<!--end table indide tab-->

        
        
        
        
        
        
        
        
        

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
                    alert($("#grid").bootgrid("getTotalRowCount"));
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
            });
        </script>
	
	
	<!--end table scripts -->



<!---start these scripts to anmat charts--->

  <script class="code" type="text/javascript">$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        var s1 = [10, 10, 7, 10];
        var ticks = ['a', 'b', 'c', 'd'];
        
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
			