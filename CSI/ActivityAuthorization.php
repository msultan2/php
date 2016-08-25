<?php
// build DB  Connection  and set radio & transmision  var with true or false 

 class ActivityAuthorization {

	public $radioActivityAllowed = false;
	public $transmissionActivityAllowed = false;
	public $mismatchReportActivityAllowed = false;
	public $activityOperationAllowed = false;
	public $cMStatisticsAllowed = false;
	public $activityLogAllowed = false;
	public $sitesStatusCheckAllowed = false;
	public $activityOperationModifyAllowed = false;		
	public $sitesInfoAllowed = false;	
	public $downSitesPerActivityAllowed = false;	
	
	public function __construct ($username)
	{
	$this->authorize($username);
	}
	private function authorize ($username)
	{


		/*$this->radioActivityAllowed = true ;
		
		$this->transmissionActivityAllowed = true ;*/
		 //
		
		$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");
		// Check connection
		if (mysqli_connect_errno())
		{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		// Perform queries
	 $sql = "SELECT Name,Activity  FROM ActivityAuthorization where Name ='".$username."'";
		
		$result = $con->query($sql);
		
		if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
		
		//echo "name: " . $row["name"]. " - Name: " . $row["activity"]."<br>";
		
		if ( $row["Activity"]=="Radio")
			{$this->radioActivityAllowed = true ;continue;}
			
		if ($row["Activity"]=="Transmission")
			{$this->transmissionActivityAllowed = true ;continue;}
			
        if ( $row["Activity"]=="Activity Log")
			{$this->activityLogAllowed = true ;continue;}
			
		if ($row["Activity"]=="Mismatch Report")
			{$this->mismatchReportActivityAllowed = true ;continue;}
			
		if ( $row["Activity"]=="Activity Operation")
			{$this->activityOperationAllowed = true ;continue;}
		
		if ($row["Activity"]=="CM Statistics")
			{$this->cMStatisticsAllowed = true ;continue;}
			
			
		if ($row["Activity"]=="SitesStatusCheck")
			{$this->sitesStatusCheckAllowed = true ;continue;}

        if ($row["Activity"]=="activityOperationModify")
			{$this->activityOperationModifyAllowed = true ;continue;}
 
        if ($row["Activity"]=="sitesInfo")
		
			{$this->sitesInfoAllowed = true ;continue;}
			
	    if ($row["Activity"]=="DownSitesPerActivity")
		
			{$this->downSitesPerActivityAllowed = true ;continue;}
		}
		} else {
		//echo "0 results";
		}
		mysqli_close($con);
		
		
		
		/*
		
		try{
		$db = new PDO("dbtype:host=localhost;dbname=vodafone1st_task;charset=utf8","root","");
		$query=$db->prepare("Select * from Activityauthorization where name=?");
		$query->excute(array($username));
		while($row=$query->fetch(PDO::FETCH_OBJ)) {
		
		if ( $row->Activity="rd")
			$this->radioActivityAllowed = true ;
		if ($row->Activity="tx")
			$this->transmissionActivityAllowed = true ;
		}
		}catch(PDOException  $e ){
		echo "Error: ".$e;
		}
		*/
		
		
		/*$this->radioActivityAllowed = true ;
		
		$this->transmissionActivityAllowed = true ;*/
	}
	


}





