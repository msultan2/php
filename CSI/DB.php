<?php
// build DB  Connection  and set radio & transmision  var with true or false 

 class ActivityAuthorization {

	public $radioActivityAllowed = false;
	public $transmissionActivityAllowed = false;
	
	
	public function __construct ($username)
	{
	$this->authorize($username);
	}
	private function authorize ($username)
	{
		

		/*try{
			$db = new PDO("dbtype:host=localhost;dbname=vodafone1st_task;charset=utf8","root","");
            $query=$db->prepare("Select * from activityauthorization where name=?");
			$query->excute(array($username));
			while($row=$query->fetch(PDO::FETCH_OBJ)) {
				
				if ( $row->activity="rd")
					$this->radioActivityAllowed = true ;
				if ($row->activity="tx")
					$this->transmissionActivityAllowed = true ;
			}
		}catch(PDOException  $e ){
			echo "Error: ".$e;
		}*/
			$this->radioActivityAllowed = true ;
	
			$this->transmissionActivityAllowed = true ;
	}


}





