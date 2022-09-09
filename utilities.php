<?php
include("lib/dbfunctions.php");

$dbobject = new dbfunction();
set_time_limit (0);

//echo $dbobject->getnextid('orders');
$op = $_REQUEST['op'];

	if($op=='checklogin')
	{
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		$trantype = $_REQUEST['themodule'];
		//$rs = $dbobject->callaccess();
		//if($rs=1){
		$member_details = $dbobject->getcheckdetails($username,$password,$trantype);
		echo $member_details;
		//}
	}

	if($op=='guestsearch')
	{
		$vehicleno = $_REQUEST['vehicleno'];
		//$rs = $dbobject->callaccess();
		//if($rs=1){
		$vehicle_details = $dbobject->getvehicledetails($vehicleno);
		echo $vehicle_details;
		//}
	}

	if($op=='guestsearch1')
	{
		$company = $_REQUEST['company'];

		$trans_details = $dbobject->gettransdetails($company);
		echo $trans_details;
		//}
	}	


?>