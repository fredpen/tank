	<?php
		require("lib/mfbconnect.php"); 
		require_once("lib/dbfunctions.php");
		$dbobject = new dbfunction();
			
			$count = 0;
			$limit = !isset($_REQUEST['limit'])?"200":$_REQUEST['limit'];
			$pageNo = !isset($_REQUEST['fpage'])?"1":$_REQUEST['pageNo'];
			$searchby = !isset($_REQUEST['searchby'])?"ccompany":$_REQUEST['searchby'];
			$keyword = !isset($_REQUEST['keyword'])?"":$_REQUEST['keyword'];
			$orderby = !isset($_REQUEST['orderby'])?"STR_TO_DATE(loc_date , '%d/%m/%Y') ":$_REQUEST['orderby'];
			$orderflag = !isset($_REQUEST['orderflag'])?"desc":$_REQUEST['orderflag'];
			$lower = !isset($_REQUEST['lower'])?"":$_REQUEST['lower'];
			$upper = !isset($_REQUEST['upper'])?"":$_REQUEST['upper'];
			
	
	$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];
	$custno = !isset($_REQUEST['custno'])?'':$_REQUEST['custno'];
	$item = !isset($_REQUEST['item'])?'':$_REQUEST['item'];	
	$loccd = !isset($_REQUEST['loccd'])?'':$_REQUEST['loccd'];
	$reportname = !isset($_REQUEST['reportname'])?'':$_REQUEST['reportname'];
	$reportdesc = !isset($_REQUEST['reportdesc'])?'':$_REQUEST['reportdesc'];
	$purchaseorderno = !isset($_REQUEST['purchaseorderno'])?'':$_REQUEST['purchaseorderno'];
	$vendorno = !isset($_REQUEST['vendorno'])?'':$_REQUEST['vendorno'];
	$salespsn = !isset($_REQUEST['salespsn'])?'':$_REQUEST['salespsn'];
	$startdate = !isset($_REQUEST['startdate'])?date("Y-m-d", strtotime("-32 days")):$_REQUEST['startdate'];
	$enddate = !isset($_REQUEST['enddate'])?date("Y-m-d"):$_REQUEST['enddate'];
	$periodyear = !isset($_REQUEST['periodyear'])?$_SESSION['periodyear']:$_REQUEST['periodyear'];
	$periodmonth = !isset($_REQUEST['periodmonth'])?$_SESSION['periodmonth']:$_REQUEST['periodmonth'];
	
	
	?>