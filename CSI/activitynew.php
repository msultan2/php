<!-- here you can stsrt -->


<div id="e_myWorld_mainPage_ajax">
	<div class="bea-wlp-disc-context-hook" id="disc_655f6d79576f726c645f6d61696e50616765">
		<div id="myWorld_mainPage" class="wlp-bighorn-page">
		
		
		
		
		
<div id="tabs" style="background: rgb(255, 255, 255) url("images/ui-bg_highlight-soft_100_eeeeee_1x100.png") 50% top repeat-x;">
	<ul style="border: 1px solid #e60000;
     background: #e60000; url("images/ui-bg_gloss-wave_35_f6a828_500x100.png") 50% 50% repeat-x;">
		<?php  if ($radioActivityAllowed==true){?><li><a href="#tabs-1">Transmission</a></li><?php }?>
		<?php  if ($transmissionActivityAllowed==true){?><li><a href="#tabs-2">Radio</a></li><?php }?>
		
	</ul>
	
	
	<?php  if ($radioActivityAllowed==true){?>
	
	<div id="tabs-1">
			   <label class="control-label Tabtitle">Transmission Activity </label> </br>

	<div id="formcontainer1" style="width: 100%;height: 300px;  margin-top:2%;">
	
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
		
		<div id="formcontainer12" style="width: 75%;height: 100%;  float:left">
		
		
		<div id="formcontainer121" style="background-color :red;width: 100%;height: 50%;  float:left">

		
		<style>
		.labelsize{
	width: 9%;
		}
	</style>

    <label id ="LableError" class="control-label LableError ">EndTime</label >
    
     <div class="form-group">


        
        
        
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
       
        

        
      </br>  
     
	 
	 
	 
		</div>
		<div id="formcontainer122" style="background-color :blue;width: 100%;height: 50%;  float:left">
		
		 
    	

		
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

<script type="text/javascript">



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




</script>




      </div>
   </div>
</div>

		
		</div>
	
	
	</div>
	
	
      <div id="formcontainer2" style="width: 100%;height: 300px;  margin-top:5%;">
      
       <style>
		.labelsize{
	width: 9%;
		}
	</style>

    <label id ="LableError" class="control-label LableError ">EndTime</label >
    
     <div class="form-group">


        
        
        
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
       
        

        
      </br>  
     
     <label class="control-label labelsize">Activity Type</label>
       
            <select id="ActivityType" name="ActivityType" class="btn btn-default">
             
                <option value="TX_Node">Node</option>
				<option value="TX_MW_Link">MW_Link</option>
				<option value="TX_Site">Site</option>
				<option value="TX_BSS_Node">BSS_Node</option>
               
            </select>
       
        

<label class="control-label labelsize">CRQ</label>
<input class="btn btn-default " id="CRQ" type="text" name="CRQ"  value="CRQ" onblur="if (this.value == '') {this.value = 'CRQ';}"
 onfocus="if (this.value == 'CRQ') {this.value = '';}" />

        
        
        
    </div>
    
    
    
    
    
    
    
    
      
	
	
	<button id="Analyze" type="button" class="btn btn-lg  btn-success center-block" style="width:30%;" >Analyze</button>
      
      
     <script type="text/javascript">

      document.getElementById('Analyze').onclick = function() {



/*
    	  var errorLabel = document.getElementById("LableError");
    	  errorLabel.color="white";
    	 */
    	  	
  		var eStartTime = document.getElementById("StartTime");
	  	var StartTime = eStartTime.options[eStartTime.selectedIndex].value;
	  	
	  	
	  	var eEndTime = document.getElementById("EndTime");
	  	var EndTime = eEndTime.options[eEndTime.selectedIndex].value;
	  	
	  	
	  
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

    	  	var eCRQ = document.getElementById("CRQ");
    	  	var CRQ = eCRQ.value;

    	 
    	  	if(CRQ.length === 0|CRQ==="CRQ"|ActivityType.length === 0|StartTime.length === 0|EndTime.length === 0|SiteIdssplitted.length === 0|StartTime>=EndTime){
			alert("Data missed error make sure that\" start time greater than end time  \"");
			//errorLabel.color="Red";
		
			
			}else{
    	  	


    	  	URL=URL+'&CRQ='+CRQ+'&StartTime='+StartTime+'&EndTime='+EndTime+'&ActivityType='+ActivityType+'&CardType=TX';
			
			
    	  	window.location.href = URL;
			}
    	  	
    	  	}
    	  	

      </script>
      </div><!-- blck end -->
      
  
    

</div>
	
	
	
	
	<?php }?>
	
	<?php  if ($transmissionActivityAllowed==true){?>
	<div id="tabs-2">
	
	
	
	 <label class="control-label Tabtitle ">Radio Activity </label> </br>
	
	
	<div id="formcontainer1" style="width: 100%;height: 300px;  margin-top:2%;">
	
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
		
		<div id="formcontainer12" style="width: 50%;height: 100%;  float:left">
		
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

<script type="text/javascript">



document.getElementById('TXadd-to-list').onclick = function() {


	var list = document.getElementById('TXlist');
	  var newLI = document.createElement('li');
	  newLI.innerHTML = document.getElementById("TXnumber").value;
	  newLI.id=document.getElementById("TXnumber").value;
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


document.getElementById('TXremove-all-listitems').onclick = function() {
	var x = document.getElementById("TXlist");
	var y = x.getElementsByTagName("li");
	var i;
	for (i = 0; i < y.length; i++) {
	  
	    y[i].remove();
	}
	
	}


	
	
function handle(e){
    if(e.keyCode === 13){
        
    	var list = document.getElementById('TXlist');
  	  var newLI = document.createElement('li');
  	  newLI.innerHTML = document.getElementById("TXnumber").value;
  	  newLI.id=document.getElementById("TXnumber").value;
    	//newLI.addEventListener("click", function(){deleteItem(newLI.id)}, false);  
  	  list.appendChild(newLI);
	    //newLI.onclick = "alert('You are clicking on me');";
  	  setTimeout(function() {
  	    newLI.className = newLI.className + " show";
    	 
    	  
  	  }, 10);
      	newLI.innerHTML = newLI.innerHTML+"<img style='float: right;'  src='images/Icon_delete.png' alt='Flower' onClick='javascript:TXdeleteItem(\""+newLI.id+"\");'>";
      	list.appendChild(elem);




      	
  	  
    }

    return false;
}



function TXdeleteItem(id){
	  var listItem = document.getElementById(id);
	  listItem.remove(); 
}




</script>




      </div>
   </div>
</div>

		
		</div>
	
	
	</div>
	
	
      <div id="formcontainer2" style="width: 100%;height: 300px;  margin-top:5%;">
      
       <style>
		.labelsize{
	width: 9%;
		}
		.Tabtitle{
			    font-size: 25px;
    font-family: -webkit-body;
    color: crimson;
		}
	
	</style>

    
    
     <div class="form-group">

     
        

        
        
        
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
          
      </br>  
     
     <label class="control-label labelsize">Activity Type</label>
       
            <select id="TXActivityType" name="TXActivityType" class="btn btn-default">
             
                <option value="BSS_Site">2G_CutOver</option>
				<option value="BSS_Site">3G_CutOver</option>
				<option value="BSS_BSS_Node">Node Level</option>
               
            </select>
       
        

<label class="control-label labelsize">CRQ</label>
<input class="btn btn-default " id="TXCRQ" type="text" name="CRQ"  value="CRQ" onblur="if (this.value == '') {this.value = 'CRQ';}"
 onfocus="if (this.value == 'CRQ') {this.value = '';}" />

        
        
        
    </div>
    
    
    
    
    
    
    
    
      
	
	
	<button id="TXAnalyze" type="button" class="btn btn-lg  btn-success center-block" style="width:30%;" >Analyze</button>
      
      
     <script type="text/javascript">

      document.getElementById('TXAnalyze').onclick = function() {
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

    	  	
    	  	
    	  	if(CRQ.length === 0|CRQ==="CRQ"|ActivityType.length === 0|StartTime.length === 0|EndTime.length === 0|SiteIdssplitted.length === 0|StartTime>=EndTime){
			alert("Data missed error make sure that\" start time greater than end time  \"");
			
		
			
			}else{


    	  	URL=URL+'&CRQ='+CRQ+'&StartTime='+StartTime+'&EndTime='+EndTime+'&ActivityType='+ActivityType+'&CardType=RD';
			
    	  	window.location.href = URL;
    	  	}
    	  	}
    	  	

      </script>
      </div><!-- blck end -->
      
  
    

</div>
	
	
	
	
	
	
	
	
	</div>
	<?php } ?>
</div>

   
   
   		</div>
	</div>
</div>
            
   
   
   
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
<!---end here-->
<!---end here -->

	<script type="text/javascript" src="example.min.js"></script>
			