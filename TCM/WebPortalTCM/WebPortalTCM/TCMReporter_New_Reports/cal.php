<?php
//phpinfo();
	
	error_reporting(-1);$conf['error_level'] = 2;ini_set('display_errors', TRUE);ini_set('display_startup_errors', TRUE);
?>
<!doctype html> <html lang="en"><head>  <meta charset="utf-8" />  
<title>jQuery UI Datepicker - Select a Date Range</title>  
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>  
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>  
<link rel="stylesheet" href="/resources/demos/style.css" />  
<script>  
$(function() {    
	$( "#from" ).datepicker({      defaultDate: "+1w",      changeMonth: true,      numberOfMonths: 1,      
			onClose: function( selectedDate ) {        
				$( "#to" ).datepicker( "option", "minDate", selectedDate );      
				}    
	});    
	
	$( "#to" ).datepicker({      defaultDate: "+1w",      changeMonth: true,      numberOfMonths: 1,      
			onClose: function( selectedDate ) {        
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );      
				}    
	});  
});  
</script>
</head>
<body> 
<form method=post action='cal.php'>
<label for="from">From </label><input type="text" id="from" value='<?php echo $_POST['from'];?>' name="from" />
<label for="to">to </label><input type="text" id="to" value='<?php echo $_POST['to'];?>' name="to" />  
<input type=submit name='submit'/>
</form>
<?php if(isset($_POST['submit'])) echo $_POST['from'];?>
</body>
</html>