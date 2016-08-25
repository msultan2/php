<?php
// build LDAP Connection  and set authintecated var with true or false 
 class LDAPAuth {
	
	public $Authinticated = false ; 
	public function  __construct ($username ,$password)
	{
		$this->authenticate($username ,$password);
	}
	private function authenticate ($username ,$password)
	{
	
	
	
	 $adServer = "ldap://10.213.100.56/";
	
     $ldap = ldap_connect($adServer,25) ;
	if (! $ldap)
{
		include 'header.php';
		include 'login.html';
		include 'footer.html';
		return ;
   // echo '<p>LDAP SERVER CONNECTION FAILED</p>';
    //exit;
}

$ldaprdn = 'vf-eg' . "\\" . $username;

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

     $bind = @ldap_bind($ldap, $ldaprdn, $password);


    if ($bind) {
	
        $filter="(sAMAccountName=$username)";
        $result = ldap_search($ldap,"DC=vf-eg,DC=internal,DC=vodafone,DC=com",$filter);
        ldap_sort($ldap,$result,"sn");
        $info = ldap_get_entries($ldap, $result);
        /*for ($i=0; $i<$info["count"]; $i++)
        {
            if($info['count'] > 1)
                break;
				echo $i;
				//."</strong><br /> (" . $info[$i]["samaccountname"][0] .")</p>\n"
            echo "<p>You are accessing <strong> ". $info[$i]["givenname"][0] ." " .$info[$i]["sn"][0]  ;
            //echo '<pre>';
            //var_dump($info);
           // echo '</pre>';
         //echo    $userDn = $info[$i]["distinguishedname"][0]; 
        }*/
		 
		$this->Authinticated=true;
        @ldap_close($ldap);
		
		 $_SESSION["Username"] =$info[0]["givenname"][0] ." " .$info[0]["sn"][0];
		ini_set('session.cookie_lifetime', 30); 
        ini_set('session.gc_maxlifetime', 30);
		$_SESSION['LAST_ACTIVITY']=time();
    } else {
	$this->Authinticated=false;
       // $msg = "Invalid email address / password";
       // echo $msg;
    }
	
	
	//insert in login log  
	
	$con=mysqli_connect("CNPVAS04","Reader","Reader","SOC");

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}



if($this->Authinticated==true)
$loginStatus="login success";
else
$loginStatus="login failed";

$datetime = new DateTime();
$tomorrowDate= $datetime->format('Y-m-d');
 $sql="insert into UserActivityLog  (SiteID,Description,`Data Inserted By`,`Activity Date`,`Activity Owner`)
values
('  ','".$loginStatus."','','".$tomorrowDate."','".$username." ')";   
//$result = $con->query($sqlTable1);
if ($con->query($sql) === TRUE) {
									/*if($con->affected_rows>0)
									$CRQFlag=$executiontime;
									else
									$CRQFlag="notexist";   
                                  */}
	
	
	mysqli_close($con);
	
	
	
	
	
	
	
	
	
	
	
	
	
		
		
	}
	
	
}