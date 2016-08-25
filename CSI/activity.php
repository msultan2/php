
<div id="e_myWorld_mainPage_ajax">
	<div class="bea-wlp-disc-context-hook" id="disc_655f6d79576f726c645f6d61696e50616765">
		<div id="myWorld_mainPage" class="wlp-bighorn-page">
		
		
		
		
<div id="tabs" style="background: rgb(255, 255, 255) url("images/ui-bg_highlight-soft_100_eeeeee_1x100.png") 50% top repeat-x;">
	<ul style="border: 1px solid #e60000;
     background: #e60000; url("images/ui-bg_gloss-wave_35_f6a828_500x100.png") 50% 50% repeat-x;">
		<?php  if ($transmissionActivityAllowed==true){?><li><a href="#tabs-1">Transmission</a></li><?php }?>
		<?php  if ($radioActivityAllowed==true){?><li><a href="#tabs-2">Radio</a></li><?php }?>
		<?php  if ($activityOperationAllowed==true){?><li><a href="#tabs-3">Activity Health Check </a></li><?php }?>
		<?php  if ($sitesStatusCheckAllowed==true){?><li><a href="#tabs-4">Sites Status Check </a></li><?php }?>
		<?php  if (true==true){?><li><a href="#tabs-5">Incident</a></li><?php }?>
		<?php  if ($sitesInfoAllowed==true){?><li><a href="#tabs-6">Sites Info</a></li><?php }?>

	</ul>
	
	
	
	<?php  if ($transmissionActivityAllowed==true){?>
	
	

  
  
	<div id="tabs-1" style="height: 500px;">
			   <label class="control-label Tabtitle">Planned activities Operations </label> </br>

	<div id="formcontainer1_1" style="width: 100%;height: 300px;  margin-top:2%;">
	
		<div id="formcontainer11" style="width: 25%;height: 100%;  float:left">
		
		
		
	
<div style="display: none;" class="col-xs-4">
  <input class="form-control" id="number" type="text" name="SitId" onkeypress="handle(event)" value="SiteID" onblur="if (this.value == '') {this.value = 'SiteID';}"
 onfocus="if (this.value == 'SiteID') {this.value = '';}" />
</div>



	
	
<button type="button" class="btn btn-primary"  id="add-to-list"  style="margin-top: 5px; display: none; margin-left: 30px;">Add a list item</button>
<!-- button id="remove-from-list" type="button" class="btn btn-warning">Remove A list item</button -->
<!--button id="get-all-listitems" type="button" class="btn btn-info">Get  All list items</button -->
<button id="remove-all-listitems" type="button" class="btn btn-danger" style="margin-top: 5px;display: none;" >Clean List</button>

<script type="text/javascript" src="./css/simple-excel.js"></script>
     
     
     
     <div class="form-group">
  <textarea class="form-control" rows="15" cols="10" id="SiteIds"></textarea>
</div>

 <!-- label>Load CSV file: </label><input type="file" id="fileInputCSV" /><br/>
        <label>Load XML file: </label><input type="file" id="fileInputXML" /><br/>
        <table id="result"></table>
        <input type="button" id="fileExport" hidden="true" />
      -->  
        
        <script type="text/javascript">
        
            // check browser support
            // console.log(SimpleExcel.isSupportedBrowser);
            
            var fileInputCSV = document.getElementById('fileInputCSV'); 
            var fileInputXML = document.getElementById('fileInputXML'); 
                  
            // when local file loaded
            fileInputCSV.addEventListener('change', function (e) {
                
                // parse as CSV
                var file = e.target.files[0];
                
                var fileInputCSV =  document.getElementById("fileInputCSV");
                if (fileInputCSV.value.match(/\.(csv)$/))
               {
                var csvParser = new SimpleExcel.Parser.CSV();
                csvParser.setDelimiter(',');
                csvParser.loadFile(file, function () {
                    
                    // draw HTML table based on sheet data
                    var sheet = csvParser.getSheet();
                    var table = document.getElementById('result');
                    table.innerHTML = "";
                    sheet.forEach(function (el, i) {                    
                        var row = document.createElement('tr');
                        el.forEach(function (el, i) {
                            var cell = document.createElement('td');
                            cell.innerHTML = el.value;
                            row.appendChild(cell);
                        });
                        table.appendChild(row);
                    });                    
                                    
                    // create button to export as TSV
                    var btnSave = document.getElementById('fileExport');
                    btnSave.hidden = false;
                    btnSave.value = 'Save as TSV file ->';
                    document.body.appendChild(btnSave);
                    
                    // export when button clicked
                    btnSave.addEventListener('click', function (e) {                
                        var tsvWriter = new SimpleExcel.Writer.TSV();
                        tsvWriter.insertSheet(csvParser.getSheet(1));
                        tsvWriter.saveFile();
                    });
                    
                    // print to console just for quick testing
                    console.log(csvParser.getSheet(1));
                    console.log(csvParser.getSheet(1).getRow(1));
                    console.log(csvParser.getSheet(1).getColumn(2));
                    console.log(csvParser.getSheet(1).getCell(3, 1));
                    console.log(csvParser.getSheet(1).getCell(2, 3).value); 
                });

            }else{alert("not suported");}
            });
            
            // when local XML file loaded
            fileInputXML.addEventListener('change', function (e) {
                
                // parse as XML
                var file = e.target.files[0];
                var fileInputXML =  document.getElementById("fileInputXML");
                if (fileInputXML.value.match(/\.(xml)$/))
                {
                var xmlParser = new SimpleExcel.Parser.XML();
                xmlParser.loadFile(file, function () {
                    
                    // draw HTML table based on sheet data
                    var sheet = xmlParser.getSheet();
                    var table = document.getElementById('result');
                    table.innerHTML = "";
                    sheet.forEach(function (el, i) {                    
                        var row = document.createElement('tr');
                        el.forEach(function (el, i) {
                            var cell = document.createElement('td');
                            cell.innerHTML = el.value;
                            row.appendChild(cell);
                        });
                        table.appendChild(row);
                    });          
                                    
                    // create button to export as CSV
                    var btnSave = document.getElementById('fileExport');
                    btnSave.hidden = false;
                    btnSave.value = 'Save as CSV file ->';
                    document.body.appendChild(btnSave);
                    
                    // export when button clicked
                    btnSave.addEventListener('click', function (e) {                
                        var csvWriter = new SimpleExcel.Writer.CSV();
                        csvWriter.insertSheet(xmlParser.getSheet(1));
                        csvWriter.saveFile();
                    });          
                    
                    // print to console just for quick testing
                    console.log(xmlParser.getSheet(1));
                    console.log(xmlParser.getSheet(1).getRow(1));
                    console.log(xmlParser.getSheet(1).getColumn(2));
                    console.log(xmlParser.getSheet(1).getCell(3, 1));
                    console.log(xmlParser.getSheet(1).getCell(2, 3).value); 
                });
            }else{alert("not suported csv");}
            });
            
        </script>
        


		
		</div><!-- greeen end  -->
		
		<div id="formcontainer12_1" style="width: 50%;height: 100%;  float:left ;margin-left: 50px;">
		
		<div id="formcontainer121_1" style="width: 100%;height: 50%;  float:left">

		
		
		
		<div id="formcontainer1211_1" style="width: 100%;height: 30%;  float:left">
		 
	
		 
		 
		 <label class="control-label labelsize">StartTime</label>
      
            <select id="StartTime" name="StartTime" class="btn btn-default">
               <option value="0">0</option>
                <option value="1">1</option>
                  <option value="2">2</option>
                    <option value="3">3</option>
                      <option value="4">4</option>
                        <option value="5">5</option>
                          <option value="6">6</option>
                            <option value="7">7</option>
                              <option value="8">8</option>
                                <option value="9">9</option>
                                  <option value="10">10</option>
                                    <option value="11">11</option>
                                      <option value="12">12</option>
                                        <option value="13">13</option>
                                          <option value="14">14</option>
                                            <option value="15">15</option>
                                              <option value="16">16</option>
                                                <option value="17">17</option>
                                                  <option value="18">18</option>
                                                    <option value="19">19</option>
                                                      <option value="20">20</option>
                                                        <option value="21">21</option>
                                                          <option value="22">22</option>
                                                            <option value="23">23</option> 
            </select>
        
		</div>
		<div id="formcontainer1212_1" style=";width: 100%;height:25%;  float:left">
       

<label class="control-label labelsize">EndTime</label>
       
            <select id="EndTime" name="EndTime" class="btn btn-default">
               <option value="0">0</option>
                <option value="1">1</option>
                  <option value="2">2</option>
                    <option value="3">3</option>
                      <option value="4">4</option>
                        <option value="5">5</option>
                          <option value="6">6</option>
                            <option value="7">7</option>
                              <option value="8">8</option>
                                <option value="9">9</option>
                                  <option value="10">10</option>
                                    <option value="11">11</option>
                                      <option value="12">12</option>
                                        <option value="13">13</option>
                                          <option value="14">14</option>
                                            <option value="15">15</option>
                                              <option value="16">16</option>
                                                <option value="17">17</option>
                                                  <option value="18">18</option>
                                                    <option value="19">19</option>
                                                      <option value="20">20</option>
                                                        <option value="21">21</option>
                                                          <option value="22">22</option>
                                                            <option value="23">23</option> 
            </select>
       
	   </div>
		
		<div id="formcontainer1213_1" style="width: 100%;height: 30%;  float:left">
		<label class="control-label labelsize">Implementer</label>
<input class="btn btn-default " id="TXImplementer" type="text" name="implementer"  value="" onblur="if (this.value == '') {this.value = 'Name';}"
 onfocus="if (this.value == 'Implementer') {this.value = '';}" />

        
		</div>
		<div id="formcontainer1214_1" style="width: 100%;  float:left">
		<label class="control-label labelsize">Execution</label>
		<input class="btn btn-default" type="text" name="TxExectionTime" value="" id="Txdatetimepicker"/><br><br>






		</div>
		
		
	 

    <label id ="LableError" class="control-label LableError " style="display:none;">EndTime</label >

		 
    	<div id="formcontainer1221_1" style="width: 100%; height: 35%; float:left">
		    <input  id="TX_NodeTypeFlag" type="hidden" name="" value="">

		
	<label class="control-label labelsize">Activity Type</label>
       
            <select id="ActivityType" name="ActivityType" class="btn btn-default">
             
                <option value="TX_Node">TX Hub Node</option>
				<option value="TX_MW_Link">MW Link (FOC)</option>
				<option value="TX_Site">Site</option>
				<option value="TX_BSS_Node">BSS Node</option>
				<option value="MTX_Failure">MTX Failure</option>
               	<option value="MTX_BEP_TN_Node">MTX BEP TN Node</option>
			    <option value="MTX_BEP_Service_Node">MTX Service Node(BEP PTN)</option>


            </select>

		</div>
		
		
    	<div id="formcontainer1223_1" style="width: 100%; height: 30%; float:left;display:none;">

		
	<label class="control-label labelsize">MTX Code</label>
       
            <select id="MTXCode" name="MTXCode" class="btn btn-default">
                <option value="0">select</option>
                <option value="MOK">Mokattam</option>
                <option value="BS">Beni Suef</option>
				<option value="C4">Zahraa</option>
				<option value="C5">3rd District</option>
				<option value="RMD">10th Ramadan</option>
				<option value="Alex">Alex</option>
				<option value="HQ">HQ</option>
				<option value="TNT">Tanta</option>			
				<option value="MNS">Mansoura</option>
            </select>
		</div>



    	<div id="formcontainer1223_2" style="width: 100%; height: 30%; float:left;display:none;">

		
	<label class="control-label labelsize">Node Type</label>
       
            <select id="TX_NodeType" name="MTXCode" class="btn btn-default">
                <option value="MTX_BEP_Service_Node">BEP</option>
                <option value="MTX_PTN_Service_Node">PTN</option>
            </select>
		</div>


		
		
		<div id="formcontainer1222_1" style="width: 100%;height: 35%;  float:left">

<label class="control-label labelsize">CRQ</label>
<input class="btn btn-default " id="CRQ" type="text" name="CRQ"  value="CRQ" onblur="if (this.value == '') {this.value = 'CRQ';}"
 onfocus="if (this.value == 'CRQ') {this.value = '';}" />
<span style="color:red" id="txtHint"></span>
        
		
		</br></br>
		<button id="TXRefresh" type="button" class="btn btn-lg  btn-success center-inline"  >Refresh</button>  

	<button id="TXAnalyze" type="button" class="btn btn-lg  btn-success center-inline"  >Get Impact</button>
	
	 
	 <button id="TXNotifyBSS" type="button" class="btn btn-lg  btn-success center-inline"  >send upload notification </button>	  
</br><br/>
	 <button id="RDNotifyConflicts" type="button" class="btn btn-lg  btn-success center-inline" style="" >Send Activities Conflict Analysis </button>	  
<img id="loadingiconTX" src="" /> 
	
		</div>
		

		   
       
        

      
   

		
		
		
		
		
		
		 <!--<div style="position: relative; height: 1000px;">
   <div style="position: absolute; border: 1px solid silver; overflow: auto; width: 300px; height: 300px; ">
   --->
    	<div style="
    display: inline !important;
">
   <div style=" border: 1px solid silver; overflow: auto; width: 300px; height: 300px; display: none;">
      <div >     
<ul id="list" >
</ul>
<style>
#list li {
  list-style: none;
  background: #28B7B7;
  color: #fff;
  height: 0;
  line-height: 2em;
  margin: 0;
  padding: 0 0.5em;
  overflow: hidden;
  /*width: 10em;*/
}
#list li.show {
  height: 2em;
  margin: 2px 0;
}
</style>

<!-- script type="text/javascript">



document.getElementById('add-to-list').onclick = function() {


	var list = document.getElementById('list');
	  var newLI = document.createElement('li');
	  newLI.innerHTML = document.getElementById("number").value;
	  newLI.id=document.getElementById("number").value;
	//newLI.addEventListener("click", function(){deleteItem(newLI.id)}, false);  
	  list.appendChild(newLI);
	    //newLI.onclick = "alert('You are clicking on me');";
	  setTimeout(function() {
	    newLI.className = newLI.className + " show";
	 
	  
	  }, 10);
  	newLI.innerHTML = newLI.innerHTML+"<img style='float: right;'  src='images/Icon_delete.png' alt='Flower' onClick='javascript:deleteItem(\""+newLI.id+"\");'>";
  	list.appendChild(elem);


  	


	 /* var list = document.getElementById('list');
  var newLI = document.createElement('li');
  newLI.innerHTML = document.getElementById("number").value;
  
  newLI.id=document.getElementById("number").value;
  list.appendChild(newLI);
  setTimeout(function() {
    newLI.className = newLI.className + " show";
  }, 10);*/
}
/*
document.getElementById('remove-from-list').onclick = function() {
	  var listItem = document.getElementById(document.getElementById("number").value);
	  listItem.remove(); 
	}
*/

/*
alert("grtht3");
document.getElementById('remove-from-list').onclick = function() {
	  var listItem = document.getElementById(document.getElementById("number").value);
	  listItem.remove(); 
	}

	
alert("grtht4");

document.getElementById('get-all-listitems').onclick = function() {
	
	var x = document.getElementById("list");
	var y = x.getElementsByTagName("li");
	var i;
	for (i = 0; i < y.length; i++) {
	    alert(y[i].id);
	}
	}

	*/


document.getElementById('remove-all-listitems').onclick = function() {
	var x = document.getElementById("list");
	var y = x.getElementsByTagName("li");
	var i;
	for (i = 0; i < y.length; i++) {
	  
	    y[i].remove();
	}
	
	}


	
	
function handle(e){
    if(e.keyCode === 13){
        
    	var list = document.getElementById('list');
  	  var newLI = document.createElement('li');
  	  newLI.innerHTML = document.getElementById("number").value;
  	  newLI.id=document.getElementById("number").value;
    	//newLI.addEventListener("click", function(){deleteItem(newLI.id)}, false);  
  	  list.appendChild(newLI);
	    //newLI.onclick = "alert('You are clicking on me');";
  	  setTimeout(function() {
  	    newLI.className = newLI.className + " show";
    	 
    	  
  	  }, 10);
      	newLI.innerHTML = newLI.innerHTML+"<img style='float: right;'  src='images/Icon_delete.png' alt='Flower' onClick='javascript:deleteItem(\""+newLI.id+"\");'>";
      	list.appendChild(elem);




      	
  	  
    }

    return false;
}



function deleteItem(id){
	  var listItem = document.getElementById(id);
	  listItem.remove(); 
}


*/

</script -->




      </div>
   </div>
</div>

		
		</div>
	
	
	</div>
	
	
      <div id="formcontainer2_1" style="width: 100%;height: 300px;  margin-top:5%;">
      
       
        
      </br>  
     
  
        
        
    </div>
    
    
    
    
    
    
    
    
      
	
	
      </div><!-- blck end -->
      
  
    

</div>
	
	
	  <!--Transmission Js -->
	  <script type="text/javascript">
	  
	  
document.getElementById('TXNotifyBSS').onclick = function() {





 
 

$("#loadingiconTX").attr("src","./images/loader.gif");
$.ajax(
{url: "sendmail.php?TXNotifyBSS=true",
 success: function(result){if(result=="sent")
$("#loadingiconTX").attr("src","./images/loaderdone.png");
 else
 $("#loadingiconTX").attr("src","./images/loaderfailed.png");
 }});
 
 
 
/*$.ajax(
{url: "sendmail.php?TXNotifyBSS=true",
 success: function(result){

 
 }});
 */
		 

}



document.getElementById('TXRefresh').onclick = function() {
$("#SiteIds").val('');
$("#CRQ").val('');
} 



document.getElementById('RDNotifyConflicts').onclick = function() {
$("#loadingiconTX").attr("src","./images/loader.gif");
$.ajax(
{url: "sendmail.php?TXNotify=true",
 success: function(result){if(result=="sent")
$("#loadingiconTX").attr("src","./images/loaderdone.png");
 else
 $("#loadingiconTX").attr("src","./images/loaderfailed.png");
 }});
 
 
 
 
 
/*$.ajax(
{url: "sendmail.php?TXNotify=true",
 success: function(result){

 
 }});*/
		 

}

	
	
	


      document.getElementById('TXAnalyze').onclick = function() {



/*
    	  var errorLabel = document.getElementById("LableError");
    	  errorLabel.color="white";
    	 */
    	  	
  		var eStartTime = document.getElementById("StartTime");
	  	var StartTime = eStartTime.options[eStartTime.selectedIndex].value;
	  	
	  	
	  	var eEndTime = document.getElementById("EndTime");
	  	var EndTime = eEndTime.options[eEndTime.selectedIndex].value;
		
		var eTXExectionTime = document.getElementById("Txdatetimepicker");
	  	var ExectionTime = eTXExectionTime.value;
	  	
		var eImplementer = document.getElementById("TXImplementer");
	  	var Implementer = eImplementer.value;	
    	  /*
    	  
    	  	var url = "RadioActivityOutput.php";
    	  	var params = "lorem=ipsum&name=alpha";
    	  	var xhr = new XMLHttpRequest();
    	  	xhr.open("POST", url, true);

    	  	//Send the proper header information along with the request
    	  	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    	  	xhr.send(params);
    	  */
    	  	
    	  	var URL='RadioActivityOutput.php?SiteIDs=';
			
    	  	var SiteIdssplitted = $('#SiteIds').val().split("\n").filter(function (val) {if (val != null) return  val;}).join('|'); 
    	  	//var SiteIdssplitted = $('#SiteIds').val().split("\n").join("|");  
			
			SiteIdssplitted = SiteIdssplitted.replace(/(^\|)|(\|$)*/g, "");
            URL =URL+SiteIdssplitted;
  
    	  	
    	  	/*
    	  	var x = document.getElementById("list");
    	  	var y = x.getElementsByTagName("li");
    	  	var i;
    	  	for (i = 0; i < y.length; i++) {
    	  		if(i==0){
    	  			URL=URL+y[i].id;
    	  			}else{
    	  	  URL=URL+','+y[i].id;
    	  			}
    	  	}
    	  */

    	  	var eActivityType = document.getElementById("ActivityType");
    	  	var ActivityType = eActivityType.options[eActivityType.selectedIndex].value;

			  if(document.getElementById("TX_NodeTypeFlag").value==1){
		   
		   var eNodeType = document.getElementById("TX_NodeType");
    	  	var NodeType = eNodeType.options[eNodeType.selectedIndex].value;
			 ActivityType=NodeType;
			
		   }
		   
		   
		   
    	  	var eCRQ = document.getElementById("CRQ");
    	  	var CRQ = eCRQ.value;

    	 
    	  	if(CRQ.length === 0|CRQ==="CRQ"|ActivityType.length === 0|StartTime.length === 0|EndTime.length === 0|SiteIdssplitted.length === 0|StartTime>=EndTime){
			alert("Data missed error make sure that\" start time greater than end time  \"");
			//errorLabel.color="Red";
		
			
			}else{
    	  	


    	  	URL=URL+'&CRQ='+CRQ+'&StartTime='+StartTime+'&EndTime='+EndTime+'&ActivityType='+ActivityType+'&CardType=TX'+'&ExectionTime='+ExectionTime+'&Implementer='+Implementer;
			
			
			
	$.ajax({url: "CheckCRQExistance.php?CRQ="+CRQ, success: function(result){if(result==="exist"){$("#txtHint").html("CRQ Exist Choose another one");}else{$("#txtHint").html("");window.open(URL,'_blank');}}});
	
    	  //	
    	  	//window.location.href = URL;
			}
    	  	
    	  	}
    	  	
			
			$( "#ActivityType" ).change(function() {
            
			
			if($( this ).val()=="MTX_Failure"){
             $('#formcontainer1223_1').show();
			}else{
			 $('#formcontainer1223_1').hide();
			}
			
			if($( this ).val()=="MTX_BEP_Service_Node"){
             $('#formcontainer1223_2').show();
			 
    	  	document.getElementById("TX_NodeTypeFlag").value=1;
			
			}else{
			 
			 $('#formcontainer1223_2').hide();
			 document.getElementById("TX_NodeTypeFlag").value=0;
			}
			
			
			
			
			
});


			$( "#MTXCode" ).change(function() {
			$("#SiteIds").val($( this ).val());

			
});


			
	  </script>
	  
	  <!---->
	
	
	<?php }?>
	
	<?php  if ($radioActivityAllowed==true){?>
	<div id="tabs-2" style="height: 500px;">
	
	
	
	 <label class="control-label Tabtitle ">Radio Activity </label> </br>

	
	<div id="formcontainer1_2" style="width: 100%;height: 300px;  margin-top:2%;">
	
		<div id="formcontainer11" style="width: 25%;height: 100%;  float:left">
		
		
		
	
<div class="col-xs-4" style="display: none;" >
  <input class="form-control" id="TXnumber" type="text" name="SitId" onkeypress="handle(event)" value="SiteID" onblur="if (this.value == '') {this.value = 'SiteID';}"
 onfocus="if (this.value == 'SiteID') {this.value = '';}" />
</div>



	
	
<button type="button" class="btn btn-primary"  id="TXadd-to-list"  style="margin-top: 5px;   margin-left: 30px;display: none">Add a list item</button>
<!-- button id="remove-from-list" type="button" class="btn btn-warning">Remove A list item</button -->
<!--button id="get-all-listitems" type="button" class="btn btn-info">Get  All list items</button -->
<button id="TXremove-all-listitems" type="button" class="btn btn-danger" style="margin-top: 5px; display: none;" >Clean List</button>


 <div class="form-group">
  <textarea class="form-control" rows="15" cols="10" id="TXSiteIds"></textarea>
</div>


		
		</div><!-- greeen end  -->
		
	
		
		<div id="formcontainer12_2" style="width: 50%;height: 100%;  float:left ;margin-left: 50px;">
		
		<div id="formcontainer121_2" style="width: 100%;height: 50%;  float:left">

		
	    <div id="formcontainer1211_2" style="width: 100%;height: 25%;  float:left">
		<!-- transfere 1 -->
		<label class="control-label labelsize">StartTime</label>
      
            <select id="TXStartTime" name="StartTime" class="btn btn-default">
               <option value="0">0</option>
                <option value="1">1</option>
                  <option value="2">2</option>
                    <option value="3">3</option>
                      <option value="4">4</option>
                        <option value="5">5</option>
                          <option value="6">6</option>
                            <option value="7">7</option>
                              <option value="8">8</option>
                                <option value="9">9</option>
                                  <option value="10">10</option>
                                    <option value="11">11</option>
                                      <option value="12">12</option>
                                        <option value="13">13</option>
                                          <option value="14">14</option>
                                            <option value="15">15</option>
                                              <option value="16">16</option>
                                                <option value="17">17</option>
                                                  <option value="18">18</option>
                                                    <option value="19">19</option>
                                                      <option value="20">20</option>
                                                        <option value="21">21</option>
                                                          <option value="22">22</option>
                                                            <option value="23">23</option> 
            </select>
        
		</div>
		<div id="formcontainer1212_2" style=";width: 100%;height: 25%;  float:left">
		<!-- transfere 2 -->
		
		<label class="control-label labelsize">EndTime</label>
       
            <select id="TXEndTime" name="EndTime" class="btn btn-default">
               <option value="0">0</option>
                <option value="1">1</option>
                  <option value="2">2</option>
                    <option value="3">3</option>
                      <option value="4">4</option>
                        <option value="5">5</option>
                          <option value="6">6</option>
                            <option value="7">7</option>
                              <option value="8">8</option>
                                <option value="9">9</option>
                                  <option value="10">10</option>
                                    <option value="11">11</option>
                                      <option value="12">12</option>
                                        <option value="13">13</option>
                                          <option value="14">14</option>
                                            <option value="15">15</option>
                                              <option value="16">16</option>
                                                <option value="17">17</option>
                                                  <option value="18">18</option>
                                                    <option value="19">19</option>
                                                      <option value="20">20</option>
                                                        <option value="21">21</option>
                                                          <option value="22">22</option>
                                                            <option value="23">23</option> 
            </select>
          
		  
		  
	    </div>
<div id="formcontainer1213_2" style="width: 100%;height:25%;  float:left">
		<label class="control-label labelsize">Implementer</label>
<input class="btn btn-default " id="RDImplementer" type="text" name="implementer"  value="" onblur="if (this.value == '') {this.value = 'Name';}"
 onfocus="if (this.value == 'Implementer') {this.value = '';}" />

        
		</div>
		
		
		<div id="formcontainer1214_2" style="width: 100%;height: 25%;  float:left">
		<label class="control-label labelsize">Execution</label>
		<input class="btn btn-default" type="text" name="RdExectionTime" value="" id="Rddatetimepicker"/><br><br>

		
		</div>
		
		
		
	
		
		
	 
		</div>
		<div id="formcontainer122_2" style="width: 100%;height: 50%;  float:left">
        

  <div id="formcontainer1211_2" style="width: 100%;height: 50%;   float:left">
		<!-- transfere 3 -->
		
		
		<label class="control-label labelsize">Activity Type</label>
       
            <select id="TXActivityType" name="TXActivityType" class="btn btn-default">
             
                <option value="BSS_Site">2G_CutOver</option>
				<option value="BSS_Site">3G_CutOver</option>
				<option value="BSS_BSS_Node">Node Level</option>
               	<option value="MTX_Failure">MTX Failure</option>

            </select>
			
			
		</div>
		
		    	<div id="formcontainer12231_2" style="width: 100%; height: 30%; float:left;display:none;">

		
	<label class="control-label labelsize">MTX Code</label>
       
            <select id="RadioActivity_MTXCode" name="MTXCode" class="btn btn-default">
                <option value="0">select</option>
                <option value="MOK">Mokattam</option>
                <option value="BS">Beni Suef</option>
				<option value="C4">Zahraa</option>
				<option value="C5">3rd District</option>
				<option value="RMD">10th Ramadan</option>
				<option value="Alex">Alex</option>
				<option value="HQ">HQ</option>
				<option value="TNT">Tanta</option>			
				<option value="MNS">Mansoura</option>
			
	
	
	
	
	
	
	
	

            </select>

		</div>
		
		
		<div id="formcontainer1212_2" style=";width: 100%;height: 50%;   float:left">
		<!-- transfere 4 -->
		
		
		   

<label class="control-label labelsize">CRQ</label>
<input class="btn btn-default " id="TXCRQ" type="text" name="CRQ"  value="CRQ" onblur="if (this.value == '') {this.value = 'CRQ';}"
 onfocus="if (this.value == 'CRQ') {this.value = '';}" />
<span style="color:red" id="txtHint2"></span>
 </br></br> 
 <button id="RDRefresh" type="button" class="btn btn-lg  btn-success center-inline" style="width:20%;" >Refresh</button>	  
 <button id="RDAnalyze" type="button" class="btn btn-lg  btn-success center-inline" style="width:25%;" >Get Impact</button>
 <button id="RDNotify" type="button" class="btn btn-lg  btn-success center-inline" style="width:42%;" >send upload notification </button>	  
	 </br><br/>
	 <button id="TXNotify" type="button" class="btn btn-lg  btn-success center-inline" style="width:52%;" >Send Activities Conflict Analysis </button>	  
     
	 <img id="loadingiconRD" src="" />
	 </div>
		
	


	   </div>
		
		
		
		 <!--<div style="position: relative; height: 1000px;">
   <div style="position: absolute; border: 1px solid silver; overflow: auto; width: 300px; height: 300px; ">
   --->
    	<div style="
    display: inline !important;
">
   <div style=" border: 1px solid silver; overflow: auto; width: 300px; height: 300px;display: none; ">
      <div >     
<ul id="TXlist">
</ul>
<style>
#TXlist li {
  list-style: none;
  background: #28B7B7;
  color: #fff;
  height: 0;
  line-height: 2em;
  margin: 0;
  padding: 0 0.5em;
  overflow: hidden;
  /*width: 10em;*/
}
#TXlist li.show {
  height: 2em;
  margin: 2px 0;
}
</style>



<script>


			$( "#TXActivityType" ).change(function() {
            if($( this ).val()=="MTX_Failure"){
             $('#formcontainer12231_2').show();
			}else{
			 $('#formcontainer12231_2').hide();
			}
});


			$( "#RadioActivity_MTXCode" ).change(function() {
			$("#TXSiteIds").val($( this ).val());

			
});

</script>




      </div>
   </div>
</div>

		
		</div>
	
	
	</div>
	
	
      <div id="formcontainer2_2" style="width: 100%;height: 300px;  margin-top:5%;">
      
       <style>
	 
		.labelsize{
	width: 20%;
		}
	
		.Tabtitle{
			    font-size: 25px;
    font-family: -webkit-body;
    color: crimson;
		}
	
	</style>

    
    
    
    
    
    
    
    
    
    
      
	
	
      
	  
	  
	  
	  </div><!-- blck end -->
      
  
    

</div>
	
	
	
	 
	  <!--Radio Js -->
	  <script type="text/javascript">
	  
	  
document.getElementById('TXNotify').onclick = function() {



$("#loadingiconRD").attr("src","./images/loader.gif");
$.ajax(
{url: "sendmail.php?TXNotify=true",
 success: function(result){if(result=="sent")
$("#loadingiconRD").attr("src","./images/loaderdone.png");
 else
 $("#loadingiconRD").attr("src","./images/loaderfailed.png");
 }});

}




	     document.getElementById('RDRefresh').onclick = function() {
		 
$("#TXSiteIds").val('');
$("#TXCRQ").val('');
}

 document.getElementById('RDAnalyze').onclick = function() {
    	
			var URL='RadioActivityOutput.php?SiteIDs=';
			
    	  	var SiteIdssplitted = $('#TXSiteIds').val().split("\n").filter(function (val) {if (val != null) return  val;}).join('|'); 
    	  	//var SiteIdssplitted = $('#SiteIds').val().split("\n").join("|");  
			
			SiteIdssplitted = SiteIdssplitted.replace(/(^\|)|(\|$)*/g, "");
            URL =URL+SiteIdssplitted;
			
			
			
			
    	  	
    	  	var eStartTime = document.getElementById("TXStartTime");
    	  	var StartTime = eStartTime.options[eStartTime.selectedIndex].value;
    	  	
    	  	
    	  	var eEndTime = document.getElementById("TXEndTime");
    	  	var EndTime = eEndTime.options[eEndTime.selectedIndex].value;

    	  	var eActivityType = document.getElementById("TXActivityType");
    	  	var ActivityType = eActivityType.options[eActivityType.selectedIndex].value;

    	  	var eCRQ = document.getElementById("TXCRQ");
    	  	var CRQ = eCRQ.value;

			var eRdExectionTime = document.getElementById("Rddatetimepicker");
	  	var ExectionTime = eRdExectionTime.value;
	  	
			var eImplementer = document.getElementById("RDImplementer");
	  	var Implementer = eImplementer.value;	  
    	  	
    	  	
    	  	if(CRQ.length === 0|CRQ==="CRQ"|ActivityType.length === 0|StartTime.length === 0|EndTime.length === 0|SiteIdssplitted.length === 0|StartTime>=EndTime){
			alert("Data missed error make sure that\" start time greater than end time  \"");
			
		
			
			}else{


    	  	URL=URL+'&CRQ='+CRQ+'&StartTime='+StartTime+'&EndTime='+EndTime+'&ActivityType='+ActivityType+'&CardType=RD'+'&ExectionTime='+ExectionTime+'&Implementer='+Implementer;
				$.ajax({url: "CheckCRQExistance.php?CRQ="+CRQ, success: function(result){if(result==="exist"){$("#txtHint2").html(CRQ +":Exist Choose another CRQ");}else{$("#txtHint2").html("");window.open(URL,'_blank');}}});

    	  	//window.location.href = URL;
    	  	}
    	  	}
    	
		
		
document.getElementById('RDNotify').onclick = function() {



$("#loadingiconRD").attr("src","./images/loader.gif");
$.ajax(
{url: "sendmail.php?Notify=true",
 success: function(result){if(result=="sent")
$("#loadingiconRD").attr("src","./images/loaderdone.png");
 else
 $("#loadingiconRD").attr("src","./images/loaderfailed.png");
 }});
 
 
 
 
 /*
$.ajax(
{url: "sendmail.php?Notify=true",
 success: function(result){

 
 }});*/
		 

}  </script>
	  
	  <!---->
	
	<?php } ?>
	
	<?php  if ($activityOperationAllowed==true){?>
	<div id="tabs-3" style="height: 500px;">

	
	
	
	
		
	
			   <label class="control-label Tabtitle">Modify CRQ </label> </br>

	<div id="formcontainer1_13" style="width: 100%;height: 500px;  margin-top:2%;">
	
		<div id="formcontainer113" style="width: 28%;height: 100%;  float:left">
		
		 <label class="control-label labelsize" style="width: 11%;" >CRQ</label>
<input class="btn btn-default " id="ActivityUnderEditCRQ" type="text" name="CRQ"  value="CRQ" onblur="if (this.value == '') {this.value = 'CRQ';}"
 onfocus="if (this.value == 'CRQ') {this.value = '';}" style="width: 62%;"/><img id="loadingiconOperation" src="" /> </br>
 <span style="color:red" id="txtHint3"></span></br>
	<?php if ($activityOperationModifyAllowed==true){?>
	<button id="EditActivity" type="button" class="btn btn-lg  btn-primary center-inline" style="" >Edit</button>	
    <button id="SaveEdit" type="button" class="btn btn-lg  btn-success center-inline"  >Save</button>
    <?php }?>
	<br/><br/>
<div style="border: 1px solid silver;padding-left: 25px;padding-top: 10px;padding-bottom: 10px;" >
		 <label class="control-label ">CRQ Healthy Check</label>
<button id="AnalyzeCRQ" type="button" class="btn btn-lg  btn-success center-inline" style="width:200px !important"  >Analyze</button>
<br/><br/>
	<button id="CheckActivityBeforebtn" type="button" class="btn btn-lg  btn-info center-inline" style="width:200px !important" >Check Before Activity</button> 
	<br/><br/>
<button id="CheckActivityAfterbtn" type="button" class="btn btn-lg  btn-info center-inline" style="width:200px !important" >Check After Activity </button><br/>
    <br/>
<button id="ActivityDownSites" type="button" class="btn btn-lg  btn-info center-inline" style="width:200px !important" >Activity Impacted Sites</button>

<br/><br/>
	<?php if ($activityOperationModifyAllowed==true){?>
	<button id="DeleteActivity" type="button" class="btn btn-lg  btn-danger center-inline" style="width:200px !important"  >Delete CRQ</button>
    <?php }?>
<br/>

</div>
  
<!-- button id="AddNewSites" type="button" class="btn btn-lg  btn-success center-inline"  >Impact New Sites</button -->
     

	
     
   


		
		</div><!-- greeen end  -->
		
		<div id="formcontainer12_13" style="width: 70%;height: 100%;  float:left ;margin-left: 5px;">
		<div id="formcontainer120_13" style="width: 100%;height: 60%;  float:left">

		
		<div id="formcontainer1201_13" style="width: 30%;height: 100%;  float:left;margin-right: 3%;">
		<label class="control-label ">CRQ Sites</label>

    	<div style="display: inline !important;">
   <div style=" border: 1px solid silver; overflow: auto; width: 100%; height: 74%; ">
      <div >     
<ul id="ExistSiteslist" class="Siteslist" >
</ul>


<style>
.Siteslist li {
  list-style: none;
  background: #28B7B7;
  color: #fff;
  height: 0;
  line-height: 2em;
  margin: 0;
  padding: 0 0.5em;
  overflow: hidden;
  /*width: 10em;*/
}
.Siteslist li.show {
  height: 2em;
  margin: 2px 0;
}
</style>
      </div>
   </div>
</div>

		
		</div>
		<div id="formcontainer1202_13" style=";width: 30%;height: 100%;  float:left;margin-right: 3%;">
         
   		<label class="control-label ">Deleted List</label>

    	<div style="display: inline !important;">
   <div style=" border: 1px solid silver; overflow: auto; width: 100%; height: 74%; ">
      <div >     
<ul id="DeletedSiteslist" class="Siteslist" >
</ul>
<style>
.Siteslist li {
  list-style: none;
  background: #28B7B7;
  color: #fff;
  height: 0;
  line-height: 2em;
  margin: 0;
  padding: 0 0.5em;
  overflow: hidden;
  /*width: 10em;*/
}
.Siteslist li.show {
  height: 2em;
  margin: 2px 0;
}
</style>
      </div>
   </div>
</div>

		

	   </div>
		
		<div id="formcontainer1203_13" style=";width: 30%;height: 100%;  float:left;margin-right: 3%;">
  		 <label class="control-label ">Add New Sites</label>

  <textarea style="width: auto;border-color: #66afe9 !important;" class="form-control" rows="10" cols="25" id="NewSiteIds"    ></textarea>

		</div>
		</div>
		<div id="formcontainer121_13" style="width: 100%;height: 25%;  float:left">

		
		
		
		<div id="formcontainer1211_13" style="width: 50%;height: 50%;  float:left">
		 <label class="control-label ">StartTime</label>
      
            <select id="EditStartTime" name="StartTime" class="btn btn-default">
               <option value="0">0</option>
                <option value="1">1</option>
                  <option value="2">2</option>
                    <option value="3">3</option>
                      <option value="4">4</option>
                        <option value="5">5</option>
                          <option value="6">6</option>
                            <option value="7">7</option>
                              <option value="8">8</option>
                                <option value="9">9</option>
                                  <option value="10">10</option>
                                    <option value="11">11</option>
                                      <option value="12">12</option>
                                        <option value="13">13</option>
                                          <option value="14">14</option>
                                            <option value="15">15</option>
                                              <option value="16">16</option>
                                                <option value="17">17</option>
                                                  <option value="18">18</option>
                                                    <option value="19">19</option>
                                                      <option value="20">20</option>
                                                        <option value="21">21</option>
                                                          <option value="22">22</option>
                                                            <option value="23">23</option> 
            </select>
   
		</div>
    	<div id="formcontainer1221_13" style="width: 50%; height: 50%; float:left">
		<label class="control-label " style="width: 112px;">Implementer</label>
<input class="btn btn-default " id="EditImplementer" type="text" name="implementer"  value="" onblur="if (this.value == '') {this.value = 'Name';}"
 onfocus="if (this.value == 'Implementer') {this.value = '';}" />
		
		</div> 
		<div id="formcontainer1212_13" style=";width: 50%;height: 50%;  float:left">
        
<label class="control-label ">End Time</label>
       
            <select id="EditEndTime" name="EndTime" class="btn btn-default">
               <option value="0">0</option>
                <option value="1">1</option>
                  <option value="2">2</option>
                    <option value="3">3</option>
                      <option value="4">4</option>
                        <option value="5">5</option>
                          <option value="6">6</option>
                            <option value="7">7</option>
                              <option value="8">8</option>
                                <option value="9">9</option>
                                  <option value="10">10</option>
                                    <option value="11">11</option>
                                      <option value="12">12</option>
                                        <option value="13">13</option>
                                          <option value="14">14</option>
                                            <option value="15">15</option>
                                              <option value="16">16</option>
                                                <option value="17">17</option>
                                                  <option value="18">18</option>
                                                    <option value="19">19</option>
                                                      <option value="20">20</option>
                                                        <option value="21">21</option>
                                                          <option value="22">22</option>
                                                            <option value="23">23</option> 
            </select>
   
		</div>

		<div id="formcontainer1222_13" style="width: 50%;height: 50%;  float:left">
		<label class="control-label ">Execution Time</label>
		<input class="btn btn-default" type="text" name="EditExectionTime" value="" id="Editdatetimepicker"/><br><br>
        <input  id="EditCardType" type="hidden" name="" value="">
		 <input  id="ExistStartTime" type="hidden" name="" value="">
		  <input  id="ExistEndTime" type="hidden" name="" value="">
		   <input  id="ExistImplementer" type="hidden" name="" value="">
		    <input  id="ExistExecution" type="hidden" name="" value="">
		</div>
		
		
		   
       
        

    

		
		
		
		
		
		
		
		
		</div>
	
	
	</div>
	
	
     
    
    
    
    
    
    
    
    
      
	
	
      </div><!-- blck end -->
      </div><!-- blck end -->
      
  
    

	
	
	
	
	
	
	
	
	
	
	
	
	<?php }?>
	
	<?php  if ($sitesStatusCheckAllowed==true){?>
	<div id="tabs-4" style="height: 500px;">
			   <label class="control-label Tabtitle">Check Sites Status </label> </br>

	<div id="formcontainer1_1" style="width: 100%;height: 300px;  margin-top:2%;">
	
		<div id="formcontainer11" style="width: 25%;height: 100%;  float:left">
		
		
	<textarea class="form-control" rows="15" cols="10" id="SiteIdstoCheck"></textarea>
	</br>
	</br>
	<button id="CheckSitesStatusbtn" type="button" class="btn btn-lg  btn-info center-inline" style="width:200px !important" >Check Sites</button> 

		  
		  
		</div></div>
		
		<script>
		
		<?php if ($sitesStatusCheckAllowed==true){?>
			 document.getElementById('CheckSitesStatusbtn').onclick = function() {

			 var SiteIdssplitted = $('#SiteIdstoCheck').val().split("\n").filter(function (val) {if (val != null) return  val;}).join('|'); 			
			SiteIdssplitted = SiteIdssplitted.replace(/(^\|)|(\|$)*/g, "");
           
			
			
			
			var URL='SitesStatusCheck.php?Sites='+SiteIdssplitted;
            window.open(URL,'_blank');

    	  	}
			<?php }?>
		</script>
	
	
	
	  

	  
	  
	<?php }?>
	
	
	  <!--start operation -->
 
     <script type="text/javascript">

       			
      document.getElementById('CheckActivityAfterbtn').onclick = function() {
    
			var URL='DownSitesCheck.php?ActivityUnderCheckCRQ=';
			
    	  	var eCRQ = document.getElementById("ActivityUnderEditCRQ");
    	  	var CRQ = eCRQ.value;

    	  	

    	  	URL=URL+CRQ+'&CheckStatus=1';
$.ajax({url: "CheckCRQExistance.php?CRQ="+CRQ, success: function(result){if(result==="exist"){$("#txtHint3").html("");window.open(URL,'_blank');}else{$("#txtHint3").html("CRQ Not Exist ");}}});

    	  	//window.location.href = URL;
    	  	
    	  	}
    	  	
			
			 document.getElementById('CheckActivityBeforebtn').onclick = function() {

			var URL='DownSitesCheck.php?ActivityUnderCheckCRQ=';
			
    	  	var eCRQ = document.getElementById("ActivityUnderEditCRQ");
    	  	
			var CRQ = eCRQ.value;

    	  	

    	  	URL=URL+CRQ+'&CheckStatus=0';
$.ajax({url: "CheckCRQExistance.php?CRQ="+CRQ, success: function(result){if(result==="exist"){$("#txtHint3").html("");window.open(URL,'_blank');}else{$("#txtHint3").html("CRQ Not Exist");}}});

    	  	/*var URL='DownSitesCheck.php?SiteIDs=';
			
    	  	var SiteIdssplitted = $('#SiteIds').val().split("\n").filter(function (val) {if (val != null) return  val;}).join('|'); 
    	  	//var SiteIdssplitted = $('#SiteIds').val().split("\n").join("|");  
			var eCRQ = document.getElementById("CRQ");
    	  	var CRQ = eCRQ.value;
			var eStartTime = document.getElementById("StartTime");
	  	var StartTime = eStartTime.options[eStartTime.selectedIndex].value;
	  	
	  	
	  	var eEndTime = document.getElementById("EndTime");
	  	var EndTime = eEndTime.options[eEndTime.selectedIndex].value;
	  	var eActivityType = document.getElementById("ActivityType");
    	  	var ActivityType = eActivityType.options[eActivityType.selectedIndex].value;
		
		//remove //
			SiteIdssplitted = SiteIdssplitted.replace(/(^\|)|(\|$)*///g, "");
            //URL =URL+SiteIdssplitted;
			
			
    	  	/*if(CRQ.length === 0|ActivityType.length === 0|StartTime.length === 0|EndTime.length === 0|SiteIdssplitted.length === 0|StartTime>=EndTime){
			alert("Data missed error make sure that\" start time greater than end time  \"");
			//errorLabel.color="Red";
		
			
			}else{
		URL=URL+'&CRQ='+CRQ+'&StartTime='+StartTime+'&EndTime='+EndTime+'&ActivityType='+ActivityType+'&CardType=TX';
    
 var GetImactButton = document.getElementById("TXAnalyze");
	 GetImactButton.style.visibility = 'visible';
    	  	window.open(URL,'_blank');
			
    	  	//window.location.href = URL;
			}*/
    	  	
    	  	}
			
			<?php if ($activityOperationModifyAllowed==true){?>
	
     
document.getElementById('DeleteActivity').onclick = function() {
    	 
		 
		 $("#loadingiconOperation").attr("src","./images/loader.gif");
		 
			
    	  	var eCRQ = document.getElementById("ActivityUnderEditCRQ");
    	  	var CRQ = eCRQ.value;
$.ajax({url: "DeleteCRQ.php?CRQ="+CRQ, success: function(result){if(result!="notexist"){

	 var  ExectionTime =result ;
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
 $("#loadingiconOperation").attr("src","./images/loaderdone.png");$("#txtHint3").html(CRQ +":Deleted Successfully");
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

}else{$("#txtHint3").html(CRQ+":Not Exist");}}});




		 
		 }

<?php }?>   	 
		 
		 
				document.getElementById('ActivityDownSites').onclick = function() {
    	
			var URL='ActivityDownSites.php?ActivityUnderCheckCRQ=';
			
    	  	var eCRQ = document.getElementById("ActivityUnderEditCRQ");
    	  	var CRQ = eCRQ.value;

    	  	

    	  	URL=URL+CRQ;
			window.open(URL,'_blank');
    	  	//window.location.href = URL;
    	  	
    	  	}
			
			
			
  

			
			      document.getElementById('ActivityDownSites').onclick = function() {
    	
			var URL='ActivityDownSites.php?ActivityUnderCheckCRQ=';
			
    	  	var eCRQ = document.getElementById("ActivityUnderEditCRQ");
    	  	var CRQ = eCRQ.value;

    	  	

    	  	URL=URL+CRQ;
			window.open(URL,'_blank');
    	  	//window.location.href = URL;
    	  	
    	  	}
			
			
			
	<?php  if ($activityOperationModifyAllowed==true){?>				    
document.getElementById('EditActivity').onclick = function() {
    	 //get sites 
		 $("#txtHint3").html("");
		 var list = document.getElementById('ExistSiteslist');
 
  list.innerHTML ="" ;
		 var DeleteedSiteslist = document.getElementById('DeletedSiteslist');
 
  DeleteedSiteslist.innerHTML ="" ;		
		 
			
    	  	var eCRQ = document.getElementById("ActivityUnderEditCRQ");
    	  	var CRQ = eCRQ.value;
$.ajax({url: "CRQModification.php?Operation=Sites&CRQ="+CRQ, success: function(result){

var SiteIdssplitted = result.split("|").filter(function (val) {
if (val != null){ 
 var list = document.getElementById('ExistSiteslist');
  var newLI = document.createElement('li');
  newLI.innerHTML =val ;
  newLI.id=val;
  newLI.innerHTML = newLI.innerHTML+"<img style='float: right;'  src='images/Icon_delete.png' alt='Flower' onClick='javascript:deleteSiteItem(\""+newLI.id+"\");'>";
  list.appendChild(newLI);
   setTimeout(function() {
    newLI.className = newLI.className + " show";
  }, 10);
  }
  

}); 

}});
			$("#loadingiconOperation").attr("src","./images/loaderdone.png");




		 //get details 
		 
		 var eCRQ = document.getElementById("ActivityUnderEditCRQ");
    	  	var CRQ = eCRQ.value;
$.ajax({url: "CRQModification.php?Operation=CRQDetails&CRQ="+CRQ, success: function(result){
var SiteIdssplitted = result.split("|")
var eEditStartTime = document.getElementById("EditStartTime");
    	  	eEditStartTime.value=SiteIdssplitted[0];
var eEditEndTime = document.getElementById("EditEndTime");
    	  	eEditEndTime.value=SiteIdssplitted[1];

var date = SiteIdssplitted[2].split(" ");
var eEditdatetimepicker = document.getElementById("Editdatetimepicker");
    	  	eEditdatetimepicker.value=date[0];
var eEditImplementer = document.getElementById("EditImplementer");
    	  	eEditImplementer.value=SiteIdssplitted[3];
var eEditCardType = document.getElementById("EditCardType");
    	  	eEditCardType.value=SiteIdssplitted[4];
			
			
			var eExistStartTime = document.getElementById("ExistStartTime");
    	  	eExistStartTime.value=SiteIdssplitted[0];
			var eExistEndTime = document.getElementById("ExistEndTime");
    	  	eExistEndTime.value=SiteIdssplitted[1];
			var eExistImplementer = document.getElementById("ExistImplementer");
    	  	eExistImplementer.value=SiteIdssplitted[3];
			var eExistExecution = document.getElementById("ExistExecution");
    	  	eExistExecution.value=date[0];

}});



		 }
		 
		 <?php }?>
	
		 
		 function deleteSiteItem(id){
	  var listItem = document.getElementById(id);
	  
	  var list = document.getElementById('DeletedSiteslist');
	    
  listItem.innerHTML = listItem.id+"<img style='float: right;'  src='images/Icon_delete.png' alt='Flower' onClick='javascript:deleteSiteItemfromDeletedList(\""+listItem.id+"\");'>";
 
      list.appendChild(listItem);
  
  
        }
		 function deleteSiteItemfromDeletedList(id){
	  var listItem = document.getElementById(id);
	  
	  var list = document.getElementById('ExistSiteslist');
	    
  listItem.innerHTML = listItem.id+"<img style='float: right;'  src='images/Icon_delete.png' alt='Flower' onClick='javascript:deleteSiteItem(\""+listItem.id+"\");'>";
 
      list.appendChild(listItem);
  
  
        }

<?php  if ($activityOperationModifyAllowed==true){?>
		document.getElementById('SaveEdit').onclick = function() { 

var x = document.getElementById("DeletedSiteslist");
	var y = x.getElementsByTagName("li");
		var eCRQ = document.getElementById("ActivityUnderEditCRQ");
    	  	var CRQ = eCRQ.value;
	if(y.length>0){
	var i;var Sites="";
	for (i = 0; i < y.length; i++) {
	if(i<y.length-1)
	   Sites= Sites+"'"+y[i].id+"'"+",";
	   else
	   Sites= Sites+"'"+y[i].id+"'";
	}
	

	$("#loadingiconOperation").attr("src","./images/loader.gif");

$.ajax({url: "DeleteSitesFromCRQ.php?CRQ="+CRQ+"&Sites="+Sites, success: function(result){			/*$("#loadingiconOperation").attr("src","./images/loaderdone.png");*/$( "#EditActivity" ).click(); }});

	}
	
  		var eStartTime = document.getElementById("EditStartTime");
	  	var StartTime = eStartTime.options[eStartTime.selectedIndex].value;
	  	
	  	
	  	var eEndTime = document.getElementById("EditEndTime");
	  	var EndTime = eEndTime.options[eEndTime.selectedIndex].value;
		
		var eTXExectionTime = document.getElementById("Editdatetimepicker");
	  	var ExectionTime = eTXExectionTime.value;
	  	
		var eImplementer = document.getElementById("EditImplementer");
	  	var Implementer = eImplementer.value;	
    	 
		 
		 
		 //  schedule the CRQ 

        var eExistStartTime = document.getElementById("ExistStartTime");
    	  	
			var eExistEndTime = document.getElementById("ExistEndTime");
    	  
			var eExistImplementer = document.getElementById("ExistImplementer");
    	  	
			var eExistExecution = document.getElementById("ExistExecution");
    	    
			
			
			
			var ScheduleDetails="";
			if(eExistStartTime.value!=StartTime)
			ScheduleDetails=ScheduleDetails+"&NewStartTime="+StartTime;
			if(eExistEndTime.value!=EndTime)
			ScheduleDetails=ScheduleDetails+"&NewEndTime="+EndTime;
			if(eExistImplementer.value!=Implementer)
			ScheduleDetails=ScheduleDetails+"&NewImplementer="+Implementer;
			if(eExistExecution.value!=ExectionTime)
			ScheduleDetails=ScheduleDetails+"&NewExectionTime="+ExectionTime;
			
			if(ScheduleDetails!="")
			if(CRQ== ""|CRQ=="CRQ"|parseInt(StartTime)>=parseInt(EndTime)){
			alert("Data missed error make sure that\" start time greater than end time  \"");
			}else{
			$("#loadingiconOperation").attr("src","./images/loader.gif");

			//check if no schedule required 
$.ajax({url: "CRQModification.php?Operation=Schedule&CRQ="+CRQ+ScheduleDetails, success: function(result){			/*$("#loadingiconOperation").attr("src","./images/loaderdone.png");*/$( "#EditActivity" ).click(); 
/*$("#txtHint3").html("Saved Successfully");*/}});

}
    	  	var URL='RadioActivityOutput.php?SiteIDs=';
			
    	  	var SiteIdssplitted = $('#NewSiteIds').val().split("\n").filter(function (val) {if (val != null) return  val;}).join('|'); 
			
			SiteIdssplitted = SiteIdssplitted.replace(/(^\|)|(\|$)*/g, "");
            URL =URL+SiteIdssplitted;

    	  	var eCardType = document.getElementById("EditCardType");
    	  	var CardType = eCardType.value;
            if(CardType=="TX")
			ActivityType="TX_Site";
		    if(CardType=="RX")
			ActivityType="BSS_Site";
    	  	

    	 
    	  	if(CRQ=="CRQ"|parseInt(StartTime)>=parseInt(EndTime)){
			alert("Data missed error make sure that\" start time greater than end time  \"");
			}else{
          if(!SiteIdssplitted==""){
    	  	URL=URL+'&CRQ='+CRQ+'&StartTime='+StartTime+'&EndTime='+EndTime+'&ActivityType='+ActivityType+'&CardType='+CardType+'&ExectionTime='+ExectionTime+'&Implementer='+Implementer+'&Operation=Modify';
			//$("#txtHint3").html("Saved Successfully");
            $('#NewSiteIds').val("");
			$("#loadingiconOperation").attr("src","./images/loader.gif");
			
			$.ajax({url: URL, success: function(result){ 
			$( "#EditActivity" ).click();
			//$("#loadingiconOperation").attr("src","./images/loaderdone.png");
			
 
			//$("#txtHint3").html("Saved Added Successfully ");
			
			
			}});
		   
			//window.open(URL,'_blank');

 
 
 
 
			}
			
			
	//$.ajax({url: "CheckCRQExistance.php?CRQ="+CRQ, success: function(result){if(result==="exist"){$("#txtHint").html("CRQ Exist Choose another one");}else{$("#txtHint").html("");window.open(URL,'_blank');}}});
	
    	  //	
    	  	//window.location.href = URL;
			}
	
}

<?php }?>

document.getElementById('AnalyzeCRQ').onclick = function() { 
		var eCRQ = document.getElementById("ActivityUnderEditCRQ");
    	  	var CRQ = eCRQ.value;
window.open("AnalyzeCRQ.php?CRQ="+CRQ,'_blank');
}

    	  	
      </script>
      
	  <!---->	
	
	
	
	</div>

	
	
	<?php  if ($sitesInfoAllowed==true){?>
	
	<div id="tabs-6" style="height: 500px;">
			   <label class="control-label Tabtitle">Planned activities Operations </label> </br>

	<div id="formcontainer1_1" style="width: 100%;height: 300px;  margin-top:2%;">
	
		<div id="formcontainer11" style="width: 25%;height: 100%;  float:left">
		
		
		
	


	
	     
     
     
     <div class="form-group">
  <textarea class="form-control" rows="15" cols="10" id="SitesInfo_SiteIds"></textarea>
</div>

 


		
		</div><!-- greeen end  -->
		
		<div id="formcontainer12_1" style="width: 50%;height: 100%;  float:left ;margin-left: 50px;">
		
		<div id="formcontainer121_1" style="width: 100%;height: 50%;  float:left">

		
		
		
		<div id="formcontainer1211_1" style="width: 100%;height: 30%;  float:left">
		 
	
		 
		 
		      
		</div>
		<div id="formcontainer1212_1" style=";width: 100%;height:25%;  float:left">
       
      
	   </div>
		
		<div id="formcontainer1213_1" style="width: 100%;height: 30%;  float:left">
		
        
		</div>
		<div id="formcontainer1214_1" style="width: 100%;  float:left">
		





		</div>
		
		
	 


		 
    	<div id="formcontainer1224_1" style="width: 100%; height: 35%; float:left">

		
	<label class="control-label labelsize">Activity Type</label>
       
            <select id="SitesInfo_ActivityType" name="ActivityType" class="btn btn-default">
             
                <option value="TX_Node">TX Hub Node</option>
				<option value="TX_MW_Link">MW Link (FOC)</option>
				<option value="TX_Site">Site</option>
				<option value="TX_BSS_Node">BSS Node</option>
				<option value="MTX_Failure">MTX Failure</option>
               	<option value="MTX_BEP_TN_Node">MTX BEP TN Node</option>
			    <option value="MTX_BEP_Service_Node">MTX Service Node(BEP PTN)</option>

            </select>

		</div>
		
		
    	<div id="formcontainer12231_1" style="width: 100%; height: 30%; float:left;display:none;">

		    <input  id="SitesInfo_NodeTypeFlag" type="hidden" name="" value="0">
	<label class="control-label labelsize">MTX Code</label>
       
            <select id="SitesInfo_MTXCode" name="MTXCode" class="btn btn-default">
                <option value="0">select</option>
                <option value="MOK">Mokattam</option>
                <option value="BS">Beni Suef</option>
				<option value="C4">Zahraa</option>
				<option value="C5">3rd District</option>
				<option value="RMD">10th Ramadan</option>
				<option value="Alex">Alex</option>
				<option value="HQ">HQ</option>
				<option value="TNT">Tanta</option>			
				<option value="MNS">Mansoura</option>
            </select>

		</div>
		
		
		    	<div id="formcontainer12232_1" style="width: 100%; height: 30%; float:left;display:none;">

		
	<label class="control-label labelsize"> Node Type</label>
       
            <select id="SitesInfo_NodeType" name="NodeType" class="btn btn-default">
                <option value="MTX_BEP_Service_Node">BEP</option>
                <option value="MTX_PTN_Service_Node">PTN</option>
                
            </select>

		</div>
		
		
		
		
		
		<div id="formcontainer1222_1" style="width: 100%;height: 35%;  float:left">


        
		
	
	<button id="SitesInfo_Analyze" type="button" class="btn btn-lg  btn-success center-inline"  >Get Impact</button>
	
	 
	
	
		</div>
		

		   
       
        

      
   

		
		
		
		
		
		
		 <!--<div style="position: relative; height: 1000px;">
   <div style="position: absolute; border: 1px solid silver; overflow: auto; width: 300px; height: 300px; ">
   --->
    	<div style="
    display: inline !important;
">
   <div style=" border: 1px solid silver; overflow: auto; width: 300px; height: 300px; display: none;">
      <div >     
<ul id="list" >
</ul>
<style>
#list li {
  list-style: none;
  background: #28B7B7;
  color: #fff;
  height: 0;
  line-height: 2em;
  margin: 0;
  padding: 0 0.5em;
  overflow: hidden;
  /*width: 10em;*/
}
#list li.show {
  height: 2em;
  margin: 2px 0;
}
</style>




      </div>
   </div>
</div>

		
		</div>
	
	
	</div>
	
	
      <div id="formcontainer2_1" style="width: 100%;height: 300px;  margin-top:5%;">
      
       
        
      </br>  
     
  
        
        
    </div>
    
    
    
    
    
    
    
    
      
	
	
      </div><!-- blck end -->
      
  
    

</div>
	
	
	  <!--Transmission Js -->
	  <script type="text/javascript">



      document.getElementById('SitesInfo_Analyze').onclick = function() {

    	  	var URL='Sitesinfo.php?SiteIDs=';
			
    	  	var SiteIdssplitted = $('#SitesInfo_SiteIds').val().split("\n").filter(function (val) {if (val != null) return  val;}).join('|'); 
    	  	//var SiteIdssplitted = $('#SiteIds').val().split("\n").join("|");  
			
			SiteIdssplitted = SiteIdssplitted.replace(/(^\|)|(\|$)*/g, "");
            URL =URL+SiteIdssplitted;

    	  	var eActivityType = document.getElementById("SitesInfo_ActivityType");
    	  	var ActivityType = eActivityType.options[eActivityType.selectedIndex].value;

		   if(document.getElementById("SitesInfo_NodeTypeFlag").value==1){
		   
		   var eNodeType = document.getElementById("SitesInfo_NodeType");
    	  	var NodeType = eNodeType.options[eNodeType.selectedIndex].value;
			 ActivityType=NodeType;
			 
		   }

    	 
    	  	


    	  	URL=URL+'&ActivityType='+ActivityType;
			
			if(SiteIdssplitted.length === 0){
			alert("Data missed error make sure that\" start time greater than end time  \"");
			//errorLabel.color="Red";
		
			
			}else{
			window.open(URL,'_blank')
			}
    	  	
    	  	}
    	  	



			$( "#SitesInfo_ActivityType" ).change(function() {
            if($( this ).val()=="MTX_Failure"){
             $('#formcontainer12231_1').show();
			}else{
			 $('#formcontainer12231_1').hide();
			}
			
			if($( this ).val()=="MTX_BEP_Service_Node"){
			
             $('#formcontainer12232_1').show();
			 document.getElementById("SitesInfo_NodeTypeFlag").value=1;
			}else{
			 $('#formcontainer12232_1').hide();
			 document.getElementById("SitesInfo_NodeTypeFlag").value=0;
			}
			
});


			$( "#SitesInfo_MTXCode" ).change(function() {
			$("#SitesInfo_SiteIds").val($( this ).val());

			
});


			
	  </script>
	  
	  <!---->
	
	
	<?php }?>
	
	

</div>
</div>
   
   
   		</div>
	</div>
</div>
            
   
     <script type="text/javascript">

	/*		document.getElementById('DeleteActivity').onclick = function() {
    	 
		 
		 
		 
			
    	  	var eCRQ = document.getElementById("ActivityUnderCheckCRQ");
    	  	var CRQ = eCRQ.value;
$.ajax({url: "DeleteCRQ.php?CRQ="+CRQ, success: function(result){if(result==="deleted"){$("#txtHint3").html(CRQ +":Deleted Successfully");}else{$("#txtHint3").html(CRQ+":Not Exist");}}});




		 
		 }*/
      /*document.getElementById('CheckActivityBeforebtn').onclick = function() {

			var URL='DownSitesCheck.php?ActivityUnderCheckCRQ=';
    	  	var eCRQ = document.getElementById("ActivityUnderCheckCRQ");
    	  	var CRQ = eCRQ.value;
    	  	URL=URL+CRQ+'&CheckStatus=0';
$.ajax({url: "CheckCRQExistance.php?CRQ="+CRQ, success: function(result){if(result==="exist"){$("#txtHint3").html("");window.open(URL,'_blank');}else{$("#txtHint3").html("CRQ Not Exist");}}});
    	  	}*/
	
      </script>
	  
	 
	  
	  
   
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

<!--ajax work start-->

<!--ajax work end -->
<!---end tabs here -->
<!---end here-->
<!---end here -->

	<script type="text/javascript" src="example.min.js"></script>
			<!--start date style and js -->
			
			<link rel="stylesheet" type="text/css" href="./css/jquery.datetimepicker.css"/>
<script src="./js/jquery.datetimepicker.full.min.js"></script>
<script>
var tomorrow = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);
var dd2 = tomorrow.getDate();
var mm2 = tomorrow.getMonth()+1; //January is 0!
var yyyy2 = tomorrow.getFullYear();
if(dd2<10)dd2='0'+dd2
if(mm2<10) mm2='0'+mm2
tomorrow = mm2+'/'+dd2+'/'+yyyy2;


var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
if(dd<10)dd='0'+dd
if(mm<10) mm='0'+mm
today = mm+'/'+dd+'/'+yyyy;


	
	
	
$('#Txdatetimepicker').datetimepicker({
yearOffset:0,
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y-m-d',
    startDate:	tomorrow
});

$('#Txdatetimepicker').datetimepicker({value:tomorrow+' 05:03',step:10});

$('#Rddatetimepicker').datetimepicker({
yearOffset:0,
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y-m-d',
    startDate:	tomorrow
});
$('#Rddatetimepicker').datetimepicker({value:tomorrow+' 05:03',step:10});


$('#Editdatetimepicker').datetimepicker({
yearOffset:0,
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y-m-d',
    startDate:	tomorrow
});
$('#Editdatetimepicker').datetimepicker({value:tomorrow+' 05:03',step:10});


$('#Inc_Txdatetimepicker').datetimepicker({
yearOffset:0,
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y-m-d',
    startDate:	tomorrow
});
$('#Inc_Txdatetimepicker').datetimepicker({value:tomorrow+' 05:03',step:10});




</script>

			
			<!--end date -->
			
			