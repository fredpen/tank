<?php
	if(session_id() == "")
	{
	@session_start();
	}
	set_time_limit (0);


require_once("mfbconnect.php");
require_once("applicationbase.php");
$_SESSION['applicationbase'] =  $applicationbase;
$_SESSION['target_dir'] =  $target_dir;
$_SESSION['tmp_target_dir'] =  $tmp_target_dir;

class dbfunction {

	function test_input($data) 
	{
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  $data = str_replace("'","",$data);
	  $data = str_replace('"',"",$data);
	  return $data;
	}

	//0 no action, 1  PO approvepo, 2 receivepo, 3 vendor payment, 4 approvals, 5 waybill, 6 confirm delivery -- who_totakeaction nextactionflag
	// workflowtype 1 PO creation, PO Approval, PO Receipt,PO Payments
	// workflowtype 2 Requisition, Requisition Approval,
	// workflowtype 3 Loading Slip, Waybill
	function workflow($workflow_officer,$workflow_description,$referencedoc,$actiondate,$who_totakeaction,$workflowtype,$action) 
	{
		 //trying to get users for next action
		 $tosave_actionby ="";
		 switch ($who_totakeaction)
		 {
			 case 4:
				$sql_get_toactionby = "select names from datum where approval = 1";
				break;
				
			  
			 case 5:
				$sql_get_toactionby = "select names from datum where genwaybill = 1";
				break;
				
			 case 6:
				$sql_get_toactionby = "select names from datum where delivery = 1";
				break;	
				
			 case 1:
				$sql_get_toactionby = "select names from datum where approvepo = 1";
				break;	
			
			 case 2:
				$sql_get_toactionby = "select names from datum where receivepo = 1";
				break;
				
			 case 3:
				$sql_get_toactionby = "select names from datum where expense = 1";
				break;	
			default :
				$sql_get_toactionby = "select names from datum where 2 = 1";
				break;	
			 
		 }
		 
		 $result_get_toactionby = mysqli_query($_SESSION['db_connect'],$sql_get_toactionby);
		 $count_get_toactionby = mysqli_num_rows($result_get_toactionby);
		 for ( $ga=0;$ga<$count_get_toactionby; $ga++)
			{ 
				$row= mysqli_fetch_array($result_get_toactionby);
				
				
				$tosave_actionby = (trim($tosave_actionby)=='')?$row['names']:$tosave_actionby.','.$row['names'];
			}
		 
		 //creating or updating work flow
		 if (($who_totakeaction == 1) || ($who_totakeaction == 3) ||  ($who_totakeaction == 5) || ($who_totakeaction == 4 && $workflowtype==2) || ($who_totakeaction == 3 && $workflowtype==1)) 
		 {
			
			//created by requisition, loading slip,  Po creation, and PO Receipt respectively
			$query_saveworkflow = "insert into workflow (initiator,workstartdate,docreference,workdescription,toactionby1,nextactionflag,action) 
									values ('$workflow_officer','$actiondate','$referencedoc','$workflow_description','$tosave_actionby',$who_totakeaction,'$action')
									";
		
		 }else 
		 {
			//1  approvepo, 2 receivepo, 3 vendor payment, 4 approvals, 5 waybill, 6 confirm delivery -- who_totakeaction nextactionflag
			$query_saveworkflow = "update workflow set workdescription = '$workflow_description', nextactionflag = $who_totakeaction , action = '$action' ";
			 //approval or refusal
			 if ($workflowtype==2)
			 {
				 
				 $query_saveworkflow = $query_saveworkflow . ", actionedby1 = '$workflow_officer', actioned1date = '$actiondate',toactionby2 =  '$tosave_actionby' ";
			 }
			 
			 //PO Related and Loading Slip Related
			 if (($workflowtype==1) || ($workflowtype==3))
			 {
				if (($who_totakeaction==2) || ($who_totakeaction==5) )
				{
					//receive po or waybill
					$query_saveworkflow = $query_saveworkflow . ", actionedby1 = '$workflow_officer', actioned1date = '$actiondate',toactionby2 =  '$tosave_actionby' ";
				}
				if (($who_totakeaction==3) || ($who_totakeaction==6))
				{
					//make payment or confirm delivery
					$query_saveworkflow = $query_saveworkflow . ", actionedby2 = '$workflow_officer', actioned2date = '$actiondate',toactionby3 =  '$tosave_actionby' ";
				}
				 
			 }
			
			 $query_saveworkflow = $query_saveworkflow . " where trim(docreference) = '$referencedoc'";
			 
		 }
		 
		// echo $query_saveworkflow."<br />";
		 $result_saveworkflow = mysqli_query($_SESSION['db_connect'],$query_saveworkflow);
			
	}



function getcheckdetails($user,$password,$transtype) 
	{
		//echo 'country code : '.$countrycode;
	//	$dbobject = new dbfunction();
		$key = $user; //"mantraa360";
		//$cipher_password = $this->des($key, $password, 1, 0, null,null);
		$str_cipher_password = md5(md5($user).md5($password)); //$this->stringToHex ($cipher_password);
		//echo $password;
		//$label = "";
		//$str_cipher_password = "0x8d247c943b63c788";
		$table_filter = " where  webpassword='".$str_cipher_password."'";

		$query = "select * from datum".$table_filter;
		//echo $query;
		$result = mysqli_query($_SESSION['db_connect'],$query);
		$numrows = mysqli_num_rows($result);
		//echo ' num rows :'.$numrows.' ';
		
		//obtain period information
		$query_const = "select * from const where 1=1" ;
		$result_const = mysqli_query($_SESSION['db_connect'],$query_const);
		$numrows_const = mysqli_num_rows($result_const);


	//	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	//	$count = mysqli_num_rows($result);
		
		if($numrows > 0)
		{
				
			//	$date = '2016-11-05';
			//	$gr = $dbobject->getitemlabel('types_of_loans','TY_LOAN_ID','4','TY_USERNAME');
			//	if(($gr=='1') && (date("Y-m-d") < $date) ){
		
				
				
				$row = mysqli_fetch_array($result);
				
				$label = "5" ;
		 		if ($transtype==1){
					if ($row['retail']<>1){$label = "3";}
					
				}
				if ($transtype==2){		
					if ($row['credits']<>1){$label = "3";}
				}
				
				if ($transtype==3){
					if ($row['ownuse']<>1){$label = "3";}
					
				}
				if ($transtype==4){		
					if ($row['ptn']<>1){$label = "3";}
				}
				

				if ($label=="5"){
					$_SESSION['username_sess'] = $user;
					$label = "1";
					$_SESSION['username'] = $row['names'];
					$_SESSION['role_id_sess'] = $row['roleid'];
					///obtaing user right
					$_SESSION['trantype'] = $transtype;
					$_SESSION['request'] = $row['request'];
					$_SESSION['spereq'] = $row['spereq'];
					$_SESSION['approval'] = $row['approval'];
					$_SESSION['loadings'] = $row['loadings'];
					$_SESSION['delivery'] = $row['delivery'];
					$_SESSION['prninv'] = $row['prninv'];
					$_SESSION['payments'] = $row['payments']; 
					$_SESSION['prnrcpt'] = $row['prnrcpt'];
					$_SESSION['othincome'] = $row['othincome'];
					$_SESSION['expense'] = $row['expense'];
					$_SESSION['authentica'] = $row['authentica'];
					$_SESSION['reports'] = $row['reports'];
					$_SESSION['reprint'] = $row['reprint'];
					$_SESSION['inventory'] = $row['inventory']; 
					$_SESSION['masters'] = $row['masters'];
					$_SESSION['cca'] = $row['cca'];
					$_SESSION['crrecon'] = $row['crrecon']; 
					$_SESSION['salesorder'] = $row['salesorder']; 		
					$_SESSION['finance'] = $row['finance'];
					$_SESSION['createpo'] = $row['createpo']; 
					$_SESSION['approvepo'] = $row['approvepo']; 		
					$_SESSION['receivepo'] = $row['receivepo']; 
					$_SESSION['returnpo'] = $row['returnpo'];
					$_SESSION['productionreq '] = $row['productionreq']; 		
					$_SESSION['productionappr'] = $row['productionappr']; 
					$_SESSION['glposting'] = $row['glposting'];
					$_SESSION['directjournal'] = $row['directjournal'];
					$_SESSION['receiveprod'] = $row['receiveprod'];

					$_SESSION['issueprod'] = $row['issueprod']; 
					$_SESSION['genwaybill'] = $row['genwaybill'];
					$_SESSION['prnwaybill'] = $row['prnwaybill'];
					$_SESSION['genloadingslip'] = $row['genloadingslip'];
					$_SESSION['prnloadingslip'] = $row['prnloadingslip']; 
					$_SESSION['somasters'] = $row['somasters']; 		
					$_SESSION['armasters'] = $row['armasters']; 
					$_SESSION['pomasters'] = $row['pomasters']; 		
					$_SESSION['glmasters'] = $row['glmasters']; 
					
					$_SESSION['ivmasters'] = $row['ivmasters'];
					$_SESSION['apmasters'] = $row['apmasters'];
					$_SESSION['storagereadings'] = $row['storagereadings'];
					$_SESSION['approvereadings'] = $row['approvereadings'];
					
					$row_const = mysqli_fetch_array($result_const);
					$_SESSION['periodyear'] = $row_const['periodyear'];
					$_SESSION['periodmonth'] = $row_const['periodmonth']; 
					$_SESSION['corpaddr'] = $row_const['corpaddr'];
					$_SESSION['telex'] = $row_const['telex'];
					$_SESSION['email'] = $row_const['email'];
					$_SESSION['webaddress'] = $row_const['webaddress'];
					///
					$oper="IN";
					$audit = $this->doAuditTrail($oper);
					
				}
			
		}else
		{
				$oper="FAIL";
				$_SESSION['username_sess'] = $user;
				$_SESSION['role_id_sess'] = "";
				$audit = $this->doAuditTrail($oper);
				$label = "0";
		}
		return $label;
	}
	




		//function to insert into the audit trail Table
    function doAuditTrail($operation)
	{
		$count_entry = 0;
		$user= isset($_SESSION['username_sess'])?$_SESSION['username_sess']:"";
		$client_ip = $_SERVER['REMOTE_ADDR'];

		if($operation=="IN")
		{
			@$now = date("Y-m-d H:i:s");
			$_SESSION['IN'] = $now;
			
			
			$query = " INSERT INTO login_trail  (musername ,mprocess ,itemcode ,changedt ,transtype ,netinfo )
			  VALUES('$user','Web Portal','Login','$now','Login Success','$client_ip')";
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			//$count_entry = mysql_num_rows($result);
		}
		else if($operation=="0UT")
		{
			@$now = date("Y-m-d H:i:s");
			$_SESSION['IN'] = $now;
			
			
			$query = " INSERT INTO login_trail  (musername ,mprocess ,itemcode ,changedt ,transtype ,netinfo )
			  VALUES('$user','Web Portal','Sign out','$now','Sign out Success','$client_ip')";
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);

		}else {
			@$now = date("Y-m-d H:i:s");
			$_SESSION['IN'] = $now;
			
			
			$query = " INSERT INTO login_trail  (musername ,mprocess ,itemcode ,changedt ,transtype ,netinfo )
			  VALUES('$user','Web Portal','Ilegal Attempt','$now','Access Denied','$client_ip')";
			
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			}
		
		
		
		//return $count_entry;
		return 1;
	}

	function getrecordsetdata($query) 
	{
		$query = $query;
		//echo $query."<br>";
		
		if($result = mysqli_query($_SESSION['db_connect'],$query))
		{
			return $result;
		}
	}

	function getvehicledetails($vehicleno) 
	{

		$table_filter = " where vehcno='".$vehicleno."'";

		$query = "select * from tbvehc".$table_filter;
		//echo $query;
		$result = mysqli_query($_SESSION['db_connect'],$query);
		$numrows = mysqli_num_rows($result);
	
		
		if($numrows > 0)
		{
			@ $ddate = date('w');
			$row = mysqli_fetch_array($result);
			//echo $numrows;
			@ $dhrmin = date('Hi');
					
			$label = "1";
			$_SESSION['trasno'] = $row['trasno'];
			$_SESSION['vehcno'] = $row['vehcno'];
			$_SESSION['capa'] = $row['capa'];
			$_SESSION['frontview'] = $row['frontview'];
			$_SESSION['sideview'] = $row['sideview'];
			$_SESSION['rearview'] = $row['rearview'];
			$_SESSION['calichart'] = $row['calichart'];
			$_SESSION['ownership'] = $row['ownership'];
		
			$sql_trasno = "select *  from tbtras  where trasno = '".$_SESSION['trasno']."'";

			$result_trasno = mysqli_query($_SESSION['db_connect'],$sql_trasno);
			$numrows_trasno = mysqli_num_rows($result_trasno);
			
			if($numrows_trasno > 0)
			{	
				$rowtrans = mysqli_fetch_array($result_trasno);
				$_SESSION['company'] = $rowtrans['company'];
				$_SESSION['address'] = $rowtrans['address'];
				$_SESSION['phone'] = $rowtrans['phone'];
				$_SESSION['transrep'] = $rowtrans['transrep'];
				$_SESSION['rep_phone'] = $rowtrans['rep_phone'];
			}


		}else 
		{
			$_SESSION['trasno'] = '';
			$_SESSION['capa'] = 0;
			$_SESSION['frontview'] = '';
			$_SESSION['sideview'] = '';
			$_SESSION['rearview'] = '';
			$_SESSION['calichart'] = '';
			$_SESSION['ownership'] = '';			
			$_SESSION['company'] = '';
			$_SESSION['address'] = '';
			$_SESSION['phone'] = '';
			$_SESSION['transrep'] = '';
			$_SESSION['rep_phone'] = '';			
			
			$label = "0";
		}
		
		return $label;
	}
	

	function gettransdetails($company) 
	{

		
		$_SESSION['table_filter'] = " where company like '%".$company."%'";
		$query = "select * from tbtras".$_SESSION['table_filter'];
		//echo $query;
		$result = mysqli_query($_SESSION['db_connect'],$query);
		$numrows = mysqli_num_rows($result);
		
		if($numrows > 0)
		{
			$label = "1";

		}else 
		{
			$_SESSION['table_filter'] = "";
			$label = "0";
		}
		
		return $label;
	}


	 function periodcheck($theTransDate){

		//$date=date_create($theTransDate,timezone_open("Europe/Oslo"));
		//echo $theTransDate.'<br />';
		//echo substr($theTransDate,0,4).'<br />';
		//echo substr($theTransDate,5,2).'<br />';
		$theyear =substr($theTransDate,0,4);
		$themonth = substr($theTransDate,5,2);
		//echo strval(substr($theTransDate,3,2)+0).'<br />';
		//echo substr($theTransDate,6,4).'<br />';
		//$date=date_create($theTransDate).'<br />';
		//echo $date.'<br />';
		//if ((strval(substr($theTransDate,3,2)+0) == $_SESSION['periodmonth']) && (substr($theTransDate,6,4) == $_SESSION['periodyear']))
		
		if (($themonth == $_SESSION['periodmonth']) && ($theyear == $_SESSION['periodyear']))	
		{
			return 1;
		}
		else
		{
			return 0;
		}
		

	} 

 	function CreateJournalEntries($mTHEMODULE, $mTHE_SUB_ACCOUNTNO, $mTHE_SUB_ACCOUNT_DESCRIPTION, $mTHE_AMOUNT){
		
		
		$AcctMappingQuery = " select * from account_mapping where trim(themodule) = '" . trim($mTHEMODULE) . "'";
		$result = mysqli_query($_SESSION['db_connect'],$AcctMappingQuery);
		$numrows = mysqli_num_rows($result);

		if ($numrows > 0){
			$k=0;
			$row_AcctMappingQuery = mysqli_fetch_array($result);
			while ($k < $numrows) {
			// GOIMG THROUGH THE MAP
				$k++;
				$CreateJournalQuery = "insert into journal " .
									 " ( transdate, themodule, acctno, acctdescription, subacctno, subacctdescription, cr_amount, dr_amount, periodmonth, periodyear) " .
									 " values ( '" . date("d/m/Y h:i:s A") . "', '" . trim($mTHEMODULE) . "','" . trim($row_AcctMappingQuery['theacctno']) . "', '" .
									  trim($row_AcctMappingQuery['theacctnodescription']) . "', '" . trim($mTHE_SUB_ACCOUNTNO) . "', '" .
									  trim($mTHE_SUB_ACCOUNT_DESCRIPTION) .  "', " ;
				
				if (strtoupper(trim($row_AcctMappingQuery['credit_or_debit']))	== "CREDIT"){	
					$CreateJournalQuery = $CreateJournalQuery . $mTHE_AMOUNT . " , 0 ";
				}
				else {	  
					$CreateJournalQuery = $CreateJournalQuery . " 0 , " . $mTHE_AMOUNT ; 				  
				}				  
				
				$CreateJournalQuery = $CreateJournalQuery . ", '" . $_SESSION['periodmonth'] . "','" . $_SESSION['periodyear'] . "')";
				
				$result_insert_Journal = mysqli_query($_SESSION['db_connect'],$CreateJournalQuery);
				
				
				$row_AcctMappingQuery = mysqli_fetch_array($result);
			
			}

	//***debit
			if (strpos(strtoupper(trim($mTHEMODULE)), 
					"EXPENSES INVENTORYRECV PRODUCTIONAPPR PRODUCTIONCANC COSTREVOFGOODSSOLD")!== false ){
				$CreateJournalQuery = "insert into journal " .
									 " ( transdate, themodule, acctno, acctdescription, subacctno, subacctdescription, cr_amount, dr_amount, periodmonth, periodyear) ".
									 " values ( '" . date("d/m/Y h:i:s A") . "', '" . trim($mTHEMODULE) . "','" . trim($mTHE_SUB_ACCOUNTNO) . "', '" .
									  trim($mTHE_SUB_ACCOUNT_DESCRIPTION) . "', '" . trim($mTHE_SUB_ACCOUNTNO) . "', '" .
									  trim($mTHE_SUB_ACCOUNT_DESCRIPTION) .  "', " ;
				
				$CreateJournalQuery = $CreateJournalQuery . " 0 , " . trim($mTHE_AMOUNT) ;			
				$CreateJournalQuery = $CreateJournalQuery . ", '" . $_SESSION['periodmonth'] . "','" . $_SESSION['periodyear'] . "')";	  
								  
				$result_insert_Journal = mysqli_query($_SESSION['db_connect'],$CreateJournalQuery);		
				

			}



	//**Credit		
			if (strpos(strtoupper(trim($mTHEMODULE)), 
					"INVENTORYISS PRODUCTIONREQ COSTOFGOODSSOLD")!== false ){
				$CreateJournalQuery = "insert into journal ".
									 " ( transdate, themodule, acctno, acctdescription, subacctno, subacctdescription, cr_amount, dr_amount, periodmonth, periodyear) ".
									 " values ( '" . date("d/m/Y h:i:s A") . "', '" . trim($mTHEMODULE) . "','" . trim($mTHE_SUB_ACCOUNTNO) . "', '" .
									  trim($mTHE_SUB_ACCOUNT_DESCRIPTION) . "', '" . trim($mTHE_SUB_ACCOUNTNO) . "', '" .
									  trim($mTHE_SUB_ACCOUNT_DESCRIPTION) . "', " ;
				
				$CreateJournalQuery = $CreateJournalQuery . $mTHE_AMOUNT . " , 0 " 	;		
				$CreateJournalQuery = $CreateJournalQuery . ", '" . $_SESSION['periodmonth'] . "','" . $_SESSION['periodyear'] . "')";	  
								  
				$result_insert_Journal = mysqli_query($_SESSION['db_connect'],$CreateJournalQuery);		
				

			}

			
			$JournalStatus = 1;
		}
		else
		{
			$JournalStatus = -1;
		}
		
		return $JournalStatus;
	
	}
 
	
	function searchentry($TheQuery){
		$result_Stmt = mysqli_query($_SESSION['db_connect'],$TheQuery);
		return mysqli_num_rows($result_Stmt);
		
	}

	function apptrail($lmuserid,$lmprocess,$litemcode,$lchangedt,$ledittype){
		

		$inserttrailstmt= " insert into apptrail ( musername, mprocess, coderef, changedt, edittype, netinfo ) " .
			" values ( '" . $lmuserid . "','" . $lmprocess . "','" . $litemcode . "','" . $lchangedt .
			"','" . $ledittype .  "','" . $_SERVER['REMOTE_ADDR'] . "')";
			
		
		$result_Stmt = mysqli_query($_SESSION['db_connect'],$inserttrailstmt);
		return $result_Stmt;
		
	}
	
	// Function to get the client ip address
	function get_client_ip_server() {
		$ipaddress = '';
		if ($_SERVER['HTTP_CLIENT_IP'])
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if($_SERVER['HTTP_X_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if($_SERVER['HTTP_X_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if($_SERVER['HTTP_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if($_SERVER['HTTP_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if($_SERVER['REMOTE_ADDR'])
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
	 
		return $ipaddress;
	}
	
	function docase($startdate,$enddate,$custno,$salespsn,$item,$loccd,$vendorno,$purchaseorderno,$periodyear,$periodmonth,
					$datefield,$custnofield,$salespsnfield,$itemfield,$loccdfield,$vendornofield,$po_field,$periodyearfield,$periodmonthfield){
		$datecondition = "";
		$customercondition = "";
		$salespersoncondition = "";
		$locationcondition = "";
		$productcondition = "";
		$vendorcondition = "";
		$po_numbercondition = "";
		$wherestatement = "";
		$periodyearcondition = "";
		$periodmonthcondition = "";
		
		if (($startdate <> '') && ($datefield <> '')){
			$datecondition = " STR_TO_DATE(" . $datefield . " , '%d/%m/%Y') >= STR_TO_DATE('" . $startdate . "', '%d/%m/%Y')" .
					" and STR_TO_DATE(" . $datefield . " , '%d/%m/%Y') <= STR_TO_DATE('" . $enddate . "', '%d/%m/%Y') ";
		}

		if (($purchaseorderno <> '') && ($po_field <> '')){
			$po_numbercondition = $po_field . " = '" . trim($purchaseorderno) . "'";
		}

		if (($vendorno <> '') && ($vendornofield <> '')){
			$vendorcondition = $vendornofield . " = '"  . trim($vendorno) . "'";
		}

 			if (($custno<>'') && ($custnofield<>'')){
			$customercondition = $custnofield . " = '" . trim($custno) . "'";
		}

		if (($salespsn <> '') && ($salespsnfield <> '')){
			$salespersoncondition = $salespsnfield . " = '" . trim($salespsn) . "'";
		}

		if (($loccd<>'') && ($loccdfield <> '')){
			$locationcondition = $loccdfield . " = '"  . trim($loccd) . "'";
		}

		if (($item <> '') && ($itemfield <> '')){
			$productcondition = $itemfield . " = '"  . trim($item) . "'";
		} 

		if (($periodyear <> '') && ($periodyearfield <> '')){
			$periodyearcondition = $periodyearfield . " = '"  . trim($periodyear) . "'";
		}

 		if (($periodmonth<>'') && ($periodmonthfield<>'')){
			$periodmonthcondition = $periodmonthfield . " = '" . trim($periodmonth) . "'";
		}


		$wherestatement = $wherestatement .
				($wherestatement <> ""?($datecondition <> ""? " and " . $datecondition :"")
											:($datecondition <> ""? $datecondition :""));


		$wherestatement = $wherestatement .
				($wherestatement <> ""? ($customercondition <> ""? " and " . $customercondition:"")
											:($customercondition <> ""? $customercondition:""));


		$wherestatement = $wherestatement .
				($wherestatement <> ""? ($locationcondition <> ""? " and " . $locationcondition :"")
											:($locationcondition <> ""? $locationcondition :""));


		$wherestatement = $wherestatement .
				($wherestatement <> ""? ($vendorcondition <> ""? " and " . $vendorcondition :"")
											:($vendorcondition <> ""? $vendorcondition:""));


		$wherestatement = $wherestatement .
				($wherestatement <> ""? ($productcondition <> ""? " and " . $productcondition :"")
											:($productcondition <> ""? $productcondition :""));
											

		$wherestatement = $wherestatement .
				($wherestatement <> ""? ($po_numbercondition <> ""? " and " . $po_numbercondition :"")
											:($po_numbercondition <> ""? $po_numbercondition :""));
											
		$wherestatement = $wherestatement .
				($wherestatement <> ""? ($salespersoncondition <> ""? " and " . $salespersoncondition :"")
											:($salespersoncondition <> ""? $salespersoncondition :""));
											
		
		$wherestatement = $wherestatement .
				($wherestatement <> ""? ($periodyearcondition <> ""? " and " . $periodyearcondition :"")
											:($periodyearcondition <> ""? $periodyearcondition :""));


		$wherestatement = $wherestatement .
				($wherestatement <> ""? ($periodmonthcondition <> ""? " and " . $periodmonthcondition :"")
											:($periodmonthcondition <> ""? $periodmonthcondition:""));
/* */		
		
		return $wherestatement;
		
	}

	function convert_number_to_words($number)
	{
		
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		//$decimal     = ' point ';
		$decimal     = ' Naira ';
		$dictionary  = array(
			0                   => 'zero',
			1                   => 'one',
			2                   => 'two',
			3                   => 'three',
			4                   => 'four',
			5                   => 'five',
			6                   => 'six',
			7                   => 'seven',
			8                   => 'eight',
			9                   => 'nine',
			10                  => 'ten',
			11                  => 'eleven',
			12                  => 'twelve',
			13                  => 'thirteen',
			14                  => 'fourteen',
			15                  => 'fifteen',
			16                  => 'sixteen',
			17                  => 'seventeen',
			18                  => 'eighteen',
			19                  => 'nineteen',
			20                  => 'twenty',
			30                  => 'thirty',
			40                  => 'fourty',
			50                  => 'fifty',
			60                  => 'sixty',
			70                  => 'seventy',
			80                  => 'eighty',
			90                  => 'ninety',
			100                 => 'hundred',
			1000                => 'thousand',
			1000000             => 'million',
			1000000000          => 'billion',
			1000000000000       => 'trillion',
			1000000000000000    => 'quadrillion',
			1000000000000000000 => 'quintillion'
		);

		if (!is_numeric($number)) {
			return false;
		}

		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}

		if ($number < 0) {
			return $negative . $this->convert_number_to_words(abs($number));
		}

		$string = $fraction = null;

		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}

		switch (true) {
			
			case $number < 1:
				$string = 'zero';
				//echo $number;
				break;
			case $number < 21:
				$string = $dictionary[$number];
				
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . $this->convert_number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= $this->convert_number_to_words($remainder);
				}
				break;
		}

		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			/*$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words).' Kobo';*/
			$string .= $this->convert_number_to_words($fraction).' Kobo';
		}

		return $string;
	}
	
} //End Class
