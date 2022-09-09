<?php
ob_start();
include_once "session_track.php";
	
//Including Database configuration file.

require_once("lib/dbfunctions.php"); 
$dbobject = new dbfunction();
//Getting value of "search" variable from "script.js".

if (isset($_POST['search'])) {

//Search box value assigning to $Name variable.

   $keyword = $dbobject->test_input($_POST['search']);
   $tablename = $dbobject->test_input($_POST['thetablename']);
   $thecontrol = $dbobject->test_input($_POST['thecontrol']);
	switch ($tablename)
	{
		case 'customer':
			$filter=" custno like '%$keyword%' || company like '%$keyword%' || phone1 like '%$keyword%' || email like '%$keyword%' ";
			$source = 'arcust';
			$fields = "custno as field1,company as field2 ,phone1 as field3,email as field4 ";
			
			break;
			
		case 'vendor':
			$filter=" vendorno like '%$keyword%' || company like '%$keyword%' || phone like '%$keyword%' || email like '%$keyword%' ";
			$source = 'vendors';
			$fields = "vendorno as field1,company as field2 ,phone as field3,email as field4 ";
			
			break;	
			
		case 'approvals':
			$filter=" custno like '%$keyword%' || ccompany like '%$keyword%' || request like '%$keyword%'  ";
			$source = 'headdata';
			$fields = "request as field1,ccompany as field2 ,custno as field3,'' as field4 ";
			
			break;	
			
		case 'waybill':
			$filter=" custno like '%$keyword%' || ccompany like '%$keyword%' || slip_no like '%$keyword%' || invoice_no like '%$keyword%'  ";
			$source = 'invoice';
			$fields = "invoice_no as field1,ccompany as field2 ,custno as field3,slip_no as field4 ";
			
			break;	
			
		case 'loadingslip':
			$filter=" custno like '%$keyword%' || ccompany like '%$keyword%' || slip_no like '%$keyword%' || invoice_no like '%$keyword%'  ";
			$source = 'invoice';
			$fields = "slip_no as field1,ccompany as field2 ,custno as field3,invoice_no as field4 ";
			
			break;		
			
		case 'users':
			$filter=" userid like '%$keyword%' || names like '%$keyword%' || useremail like '%$keyword%' || roleid like '%$keyword%'  ";
			$source = 'datum';
			$fields = "userid as field1,names as field2 ,useremail as field3,roleid as field4 ";
			
			break;	
			
		case 'vendorpay':
			$filter=" purchaseorderno like '%$keyword%' || company like '%$keyword%' || vendorno like '%$keyword%' || inv_recpt_no like '%$keyword%'  ";
			$source = 'accountpayable';
			$fields = "purchaseorderno as field1,company as field2 ,vendorno as field3,inv_recpt_no as field4 ";
			
			break;		

		case 'location':
			$filter=" loccd like '%$keyword%' || loc_name like '%$keyword%' || xchar2 like '%$keyword%' || address1 like '%$keyword%'  ";
			$source = 'lmf';
			$fields = "loccd as field1,loc_name as field2 ,xchar2 as field3,address1 as field4 ";
			
			break;	
			
		case 'sublocation':
			$filter=" subloc like '%$keyword%' || loccd like '%$keyword%' || item like '%$keyword%'  ";
			$source = 'itemsubloc';
			$fields = "subloc as field1,loccd as field2 ,item as field3,'' as field4 ";
			
			break;	
			
		case 'item':
			$filter=" item like '%$keyword%' || itemdesc like '%$keyword%' || pack like '%$keyword%'  ";
			$source = 'icitem';
			$fields = "item as field1,itemdesc as field2 ,pack as field3,'' as field4 ";
			
			break;
		
		case 'bankdef':
			$filter=" bank_code like '%$keyword%' || bank_name like '%$keyword%' || bankaddr like '%$keyword%'  ";
			$source = 'bank';
			$fields = "bank_code as field1,bank_name as field2 ,bankaddr as field3,'' as field4 ";
			
			break;
			
		case 'slabs':
			$filter=" slabid like '%$keyword%' || slabdesc like '%$keyword%'  ";
			$source = 'slabdef';
			$fields = "slabid as field1,slabdesc as field2 ,'' as field3,'' as field4 ";
			
			break;
					
		case 'transporters':
			$filter=" trasno like '%$keyword%' || company like '%$keyword%'  || address like '%$keyword%'  || phone like '%$keyword%'  ";
			$source = 'tbtras';
			$fields = "trasno as field1,company as field2 ,address as field3,phone as field4 ";
			
			break;
					
		case 'brvdef':
			$filter=" vehcno like '%$keyword%' || trasno like '%$keyword%'  || company like '%$keyword%'  || capacity like '%$keyword%'  ";
			$source = 'tbvehc';
			$fields = "vehcno as field1,company as field2 ,capacity as field3,trasno as field4 ";
			
			break;	
					
		case 'chartofaccount':
			$filter=" chartcode like '%$keyword%' || description like '%$keyword%'  || accounttype like '%$keyword%'  || financialstatement like '%$keyword%'  ";
			$source = 'chart_of_account';
			$fields = "chartcode as field1,description as field2 ,accounttype as field3,financialstatement as field4 ";
			
			break;	
		
		case 'journaladjustment':
			$filter=" chartcode like '%$keyword%' || description like '%$keyword%'  || accounttype like '%$keyword%'  || financialstatement like '%$keyword%'  ";
			$source = 'chart_of_account';
			$fields = "concat(trim(chartcode),'*  ', trim(description)) as field1,accounttype as field2,financialstatement as field3, '' as field4 ";
			
			break;	
		
		case 'salespsn':
			$filter=" salespsn like '%$keyword%' || salespsnname like '%$keyword%'  || salespsnemail like '%$keyword%'  || salespsnphone like '%$keyword%'  ";
			$source = 'salesperson';
			$fields = "salespsn as field1,salespsnname as field2 ,salespsnemail as field3,salespsnphone as field4 ";
			
			break;	
			
		case 'purchaseorderno':
			$filter=" purchaseorderno like '%$keyword%' || vendorno like '%$keyword%'  ";
			$source = 'purchaseorder';
			$fields = "purchaseorderno as field1,vendorno as field2 ,po_amount as field3,po_date as field4 ";
			
			break;	
			
	}
//Search query.
	
   $Query = "SELECT $fields FROM $source WHERE $filter LIMIT 5";
//echo $Query;
//Query execution

   $ExecQuery = mysqli_query($_SESSION['db_connect'], $Query);
	//$result_client = mysqli_query($_SESSION['db_connect'],$sql_client);
//Creating unordered list to display result.

   echo '

<ul>

   ';

   //Fetching result from database.

   while ($Result = mysqli_fetch_array($ExecQuery)) {

		   ?>

	   <!-- Creating unordered list items.

			Calling javascript function named as "fill" found in "script.js" file.

			By passing fetched result as parameter. -->

	   <li onclick='dynamicfill("<?php echo $thecontrol; ?>","<?php echo $Result['field1']; ?>")'>

	   <a>

	   <!-- Assigning searched result in "Search box" in "search.php" file. -->

		   <?php echo $Result['field1']. " " . $Result['field2']. " " . $Result['field3']. " " . $Result['field4']; ?>

	   </a></li>

	   <!-- Below php code is just for closing parenthesis. Don't be confused. -->

	   <?php

	}
	
	echo '</ul>';
	
}


?>

