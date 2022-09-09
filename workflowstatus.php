<?php 
	ob_start();
	include_once "session_track.php";
	
	//1  approvepo, 2 receivepo, 3 vendor payment, 4 approvals, 5 waybill, 6 confirm delivery -- actiontotake nextactionflag
	$workflowcondition = "";
	
	$approvalcondition = ""; $loadingscondition = ""; $deliverycondition = "";$approvepocondition = "";$receivepocondition = "";$expensecondition = "";
	
	if ($_SESSION['approval'] == 1){ $approvalcondition = " nextactionflag = 4 ";}
	
	if ($_SESSION['loadings'] == 1){ $loadingscondition = " nextactionflag = 5 ";}
	if ($_SESSION['delivery'] == 1){ $deliverycondition = " nextactionflag = 6 ";}
	
	if ($_SESSION['approvepo'] == 1){ $approvepocondition = " nextactionflag = 1 ";}
	if ($_SESSION['receivepo'] == 1){ $receivepocondition = " nextactionflag = 2 ";}
	if ($_SESSION['expense'] == 1){ $expensecondition = " nextactionflag = 3 ";}
	
	$workflowcondition = (trim($approvalcondition)=='')?'':$approvalcondition;
	if (trim($workflowcondition) == '')
	{
		$workflowcondition = (trim($loadingscondition)=='')?'':$loadingscondition;
	}else
	{
		$workflowcondition = (trim($loadingscondition)=='')?'':$workflowcondition .' or '.$loadingscondition;
	}
	
	
	if (trim($workflowcondition) == '')
	{
		$workflowcondition = (trim($deliverycondition)=='')?'':$deliverycondition;
	}else
	{
		$workflowcondition = (trim($deliverycondition)=='')?'':$workflowcondition .' or '.$deliverycondition;
	}
	
	
	if (trim($workflowcondition) == '')
	{
		$workflowcondition = (trim($approvepocondition)=='')?'':$approvepocondition;
	}else
	{
		$workflowcondition = (trim($approvepocondition)=='')?'':$workflowcondition .' or '.$approvepocondition;
	}
	
	if (trim($workflowcondition) == '')
	{
		$workflowcondition = (trim($receivepocondition)=='')?'':$receivepocondition;
	}else
	{
		$workflowcondition = (trim($receivepocondition)=='')?'':$workflowcondition .' or '.$receivepocondition;
	}
		
	if (trim($workflowcondition) == '')
	{
		$workflowcondition = (trim($expensecondition)=='')?'':$expensecondition;
	}else
	{
		$workflowcondition = (trim($expensecondition)=='')?'':$workflowcondition .' or '.$expensecondition;
	}
		
	if (trim($workflowcondition) == '')	
	{
		$count_workflow = 0;
	}
	else
	{
		$sql_workflow = "select * from workflow where $workflowcondition ORDER BY  STR_TO_DATE(workstartdate, '%d/%m/%Y') desc ";
		$query = $sql_workflow;
		$sql = "select count(docreference) counter from workflow where $workflowcondition ";
		//echo $sql_workflow;
		$result_workflow = mysqli_query($db_connect,$sql_workflow);
		$count_workflow = mysqli_num_rows($result_workflow);
		
	}
	
?>
