<?
//Get Account type details
$sSQL="SELECT * FROM account_type_tbl WHERE ACCT_TY_NAME='$acctype'";
$db->query($sSQL);
$c=$db->get_row($sSQL);
            $acid=$c->ACCT_TYPE_ID;
			$glcode=$c->GL_CODE;
			$curcode=$c->CURRENCY_CODE; 	
			$acctypename=$c->ACCT_TY_NAME;
			$startval=$c->ACCOUNT_START_VALUE;
			$endval=$c->ACCOUNT_END_VALUE;
			$lastused=$c->ACCOUNT_LAST_USED_VALUE;
			$total=$c->ACCOUNTS_TOTAL_CREATED;
			$cot=$c->COT_RATE;
			$dep=$c->DEPOSIT_RATE;
			$intRate=$c->INTEREST_RATE;
			$bal_lim=$c->BALANCE_LIMIT;
			//echo "true";
			//echo $acid;
			//echo $acctype;
			
			
//Function to generate Account Number			
function getAccountNos($acid,$acctype,$startval,$endval,$lastused,$total){
	 if($startval>$lastused){
		   $cus_ac_cid = $startval;
		   $newlastused = $startval;
		   $newtotal = $total+1;
	  }
	 else
	  {
		 $cus_ac_cid = $lastused + 1;	  
		 $newlastused = $cus_ac_cid ;
		 $newtotal = $total+1;
	  }
	 if($cus_ac_cid>=$endval){ //Checks to see if the account number has been exhuated ot not valid
		$message = 'The Account could not be created! Please Contact the System Admin';
		return $message;
	 }
	    
		$used = false;
	 
	 do 
	       {
				$SearchAcc = "select ACCT_NO from account_details where ACCT_NO ='".$cus_ac_cid."'";
				$SearchQueryResult = mysql_query($SearchAcc) or die(mysql_error());
				// keeps getiing fetching to see if the account number exists
				if($row = mysql_fetch_array($SearchQueryResult))
				{	//Generate Account Number again
				    $cus_ac_cid = getAccountNos($acid,$acctype,$startval,$endval,$lastused,$total);
				    $used = true;
				} 
			   
		   }
			while ($used);
	 
	 $sSQL="UPDATE account_type_tbl SET ACCOUNT_LAST_USED_VALUE=$newlastused,ACCOUNTS_TOTAL_CREATED=$newtotal 
	        WHERE ACCT_TYPE_ID='$acid' AND ACCT_TY_NAME='$acctype'";
     $db = mysql_query($sSQL);
	 
	 return $cus_ac_cid;
	  	
	
}
			


?>