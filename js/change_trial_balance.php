<?php ob_start(); ?>
<div id="branch_div">
<?php 
require("lib/mfbconnect.php"); 
include_once "session_track.php";

include("lib/dbfunctions.php");
$dbobject = new dbobject();
$eod = $dbobject->get_eod_new();
$exp = explode("-",$eod);
if(isset($_REQUEST["opac"])){
	$bal = $_REQUEST["bal"];
	$acc = $_REQUEST["acc"];
	if(($acc=='1')&&($acc=='1')){
		mysql_query("DELETE FROM transaction where 1=1");
		mysql_query("DELETE FROM gl_transaction where 1=1");
		mysql_query("DELETE FROM loan_tbl where 1=1");
		mysql_query("DELETE FROM loan_repayment_tbl where 1=1");
		mysql_query("DELETE FROM loan_transaction where 1=1");
		//mysql_query("DELETE FROM loan_tbl2 where 1=1");
	}
	//echo $bal."<br>";
	//echo $acc;
	 $qrr2 = "UPDATE gl_current_balance SET current_bal='$bal', ledger_balance='$bal' 
	 WHERE ACCT_NO='$acc'  ";
	 $rs2 = mysql_query($qrr2);
	 //if(($acc!='18000')||($acc!='18001')||($acc!='18002')){
	 $qrr = "UPDATE current_balance SET current_bal='$bal', ledger_balance='$bal' WHERE ACCT_NO='$acc'  ";
	 $rs = mysql_query($qrr);
	// }
	 
}

?>

<link rel="stylesheet" type="text/css" href="css/main.css">
<form name="form1" id="form1" method="post" action="">
<input type="hidden" name="tran_id" />
<input type="hidden" name="op" />
<input type="hidden" name="VAR1" />
<input type="hidden" name="data" id="data" />
<input type="hidden" name="datafilename" id="datafilename" />
<?php
			$count = 0;
			$limit = !isset($_REQUEST['limit'])?"300":$_REQUEST['limit'];
			$pageNo = !isset($_REQUEST['fpage'])?"1":$_REQUEST['pageNo'];
			$searchby = !isset($_REQUEST['searchby'])?"eod_gl_balance.ACCT_NO":$_REQUEST['searchby'];
			$keyword = !isset($_REQUEST['keyword'])?"":$_REQUEST['keyword'];
			$orderby = !isset($_REQUEST['orderby'])?"account_subhead_type.GLCODE":$_REQUEST['orderby'];
			$orderflag = !isset($_REQUEST['orderflag'])?"asc":$_REQUEST['orderflag'];
			$lower = !isset($_REQUEST['lower'])?"":$_REQUEST['lower'];
			$upper = !isset($_REQUEST['upper'])?"":$_REQUEST['upper'];
			//$sday = !isset($_REQUEST['sday'])?"":$_REQUEST['sday'];
			//$smonth = !isset($_REQUEST['smonth'])?"":$_REQUEST['smonth'];
			//$syear = !isset($_REQUEST['syear'])?"":$_REQUEST['syear'];
			$eday = !isset($_REQUEST['eday'])?"$exp[2]":$_REQUEST['eday'];
			$emonth = !isset($_REQUEST['emonth'])?"$exp[1]":$_REQUEST['emonth'];
			$eyear = !isset($_REQUEST['eyear'])?"$exp[0]":$_REQUEST['eyear'];
			
			$searchdate ="";
			if($eday!=''){
			//$startdate = "'".$syear."-".$smonth."-".$sday."'";
			$enddate = $eyear."-".$emonth."-".$eday;
			//echo $enddate;
			$searchdate = " and eod_gl_balance.BAL_DATE = '$enddate' ";
			
		   //if($enddate>"2010-01-31"){	
			
				//////////////////////////////////////////////////////////////////////
		/*$q_ov = " select ACCT_NO FROM account_details where GL_TYPE IN ('600110','600120','600130','600140','600150','600100')
		 and (ACCT_TYPE <> '' or ACCT_TYPE IS NOT NULL) " ;
	          $r_ov = $dbobject->getrecordsetdata($q_ov);
		   	 $n_ov = mysql_num_rows($r_ov);
			 $ovd = 0;
			 if($n_ov>0){
			  while($r_v = mysql_fetch_array($r_ov)){
				$acno = $r_v["ACCT_NO"];
				$bal_day = $dbobject->eodcustomerbalance($acno,$enddate);
				if($bal_day<0){
					$ovd = $ovd+$bal_day;
				}
			  }
			 }
			//$ovd = $ovd+85.20;
			//echo $ovd."<br>";
		
		
		
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$ovdcur = 0;
	$q_ovcur = " select ACCT_NO FROM account_details where GL_TYPE ='600110'  and (ACCT_TYPE <> '' or ACCT_TYPE IS NOT NULL)  ";	
	    $r_ovcur = $dbobject->getrecordsetdata($q_ovcur);
		$n_ovcur = mysql_num_rows($r_ovcur);
		if($n_ovcur>0){
			while($r_cur = mysql_fetch_array($r_ovcur)){
			    $acno2 = $r_cur["ACCT_NO"];
				//echo $acno2." ";
				$bal_day2 = $dbobject->eodcustomerbalance($acno2,$enddate);
				//echo $bal_day2."<br>";
				if($bal_day2<0){
					$ovdcur = $ovdcur+$bal_day2;
				}
			
			}
			
		}
		
	
	
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$q_ovst = " select ACCT_NO FROM account_details where GL_TYPE ='600120'  and (ACCT_TYPE <> '' or ACCT_TYPE IS NOT NULL) ";	
	    $r_ovst = $dbobject->getrecordsetdata($q_ovst);
		$n_ovst = mysql_num_rows($r_ovst);
		if($n_ovst>0){
			while($r_st = mysql_fetch_array($r_ovst)){
			 $acno3 = $r_st["ACCT_NO"];
				$bal_day3 = $dbobject->eodcustomerbalance($acno3,$enddate);
				if($bal_day3<0){
					$ovdst = $ovdst+$bal_day3;
				}
			//echo $ovdst."- ";
			}
		}
		
		
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$q_ovsav = " select ACCT_NO FROM account_details where GL_TYPE ='600130'  and (ACCT_TYPE <> '' or ACCT_TYPE IS NOT NULL) ";	
	    $r_ovsav = $dbobject->getrecordsetdata($q_ovsav);
		$n_ovsav = mysql_num_rows($r_ovsav);
		if($n_ovsav>0){
			while($r_av = mysql_fetch_array($r_ovsav)){
			$acno4 = $r_av["ACCT_NO"];
				$bal_day4 = $dbobject->eodcustomerbalance($acno4,$enddate);
				if($bal_day4<0){
					$ovdsav = $ovdsav+$bal_day4;
				}
			
			}
			
		}
		
		
	
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$q_ovtg = " select ACCT_NO FROM account_details where GL_TYPE ='600140'  and (ACCT_TYPE <> '' or ACCT_TYPE IS NOT NULL) ";	
	    $r_ovtg = $dbobject->getrecordsetdata($q_ovtg);
		$n_ovtg = mysql_num_rows($r_ovtg);
		if($n_ovtg>0){
			while($r_tg = mysql_fetch_array($r_ovtg)){
			$acno5 = $r_tg["ACCT_NO"];
				$bal_day5 = $dbobject->eodcustomerbalance($acno5,$enddate);
				if($bal_day5<0){
					$ovdtg = $ovdtg+$bal_day5;
				}
			
			}
		}
		
		

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$q_oves = " select ACCT_NO FROM account_details where GL_TYPE ='600150'  and (ACCT_TYPE <> '' or ACCT_TYPE IS NOT NULL) ";	
	    $r_oves = $dbobject->getrecordsetdata($q_oves);
		$n_oves = mysql_num_rows($r_oves);
		if($n_oves>0){
			while($r_es = mysql_fetch_array($r_oves)){
			$acno6 = $r_es["ACCT_NO"];
				$bal_day6 = $dbobject->eodcustomerbalance($acno6,$enddate);
				if($bal_day6<0){
					$ovdes = $ovdes+$bal_day6;
				}
			
			}
		}
		
		
	
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$q_ovfx = " select ACCT_NO FROM account_details where GL_TYPE ='600100'  and (ACCT_TYPE <> '' or ACCT_TYPE IS NOT NULL) ";	
	    $r_ovfx = $dbobject->getrecordsetdata($q_ovfx);
		$n_ovfx = mysql_num_rows($r_ovfx);
		if($n_ovfx>0){
			while($r_fx = mysql_fetch_array($r_ovfx)){
			$acno7 = $r_fx["ACCT_NO"];
				$bal_day7 = $dbobject->eodcustomerbalance($acno7,$enddate);
				if($bal_day7<0){
					$ovdfx = $ovdfx+$bal_day7;
				}
			
			}
		}
		*/
	
			}else{
		$searchdate = " and eod_gl_balance.BAL_DATE = '0000-00-00' ";
			}
			
			
			$filter = "";
			//if($keyword!=''){$filter=" AND $searchby like '%$keyword%' ";}
			$order = " order by ".$orderby." ".$orderflag;
			$sql = "select count(*) counter from account_subhead_type where 1=1".$filter;
			//echo $sql;
			$result = mysql_query($sql);
			if($result){
			$row = mysql_fetch_array($result);
			$count = $row['counter'];
			}
			
			$skip = 0;
			$maxPage = $limit;
			//echo $count;
			$npages = (int)($count/$maxPage);
			//echo $npages;
			if ($npages!=0){
				if(($npages * $maxPage) != $count){	
					$npages = $npages+1;
					//echo $npages;
				}
			}else{
				$npages = 1;
				//echo "Here";
			}


	//mysql_select_db($database_courier);
	$query = " Select
account_sub_head.ACCT_SB_NAME,
account_subhead_type.ACCT_SBT_NAME,
account_subhead_type.GLCODE ACCT_NO,
account_sub_head.ACCT_HD_CODE,
account_sub_head.ACCT_SB_CODE
from account_subhead_type, account_sub_head
WHERE  
account_sub_head.ACCT_HD_CODE = account_subhead_type.ACCT_HD_CODE AND account_sub_head.ACCT_SB_CODE = account_subhead_type.ACCT_SB_CODE ".$filter.$order;
 
	//echo $query;
	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);
	 
?>

<input type = 'hidden' name = 'pageNo' id="pageNo" value = "<?php echo $pageNo; ?>">		
<input type = 'hidden' name = 'rowCount' value = "<?php echo $count; ?>">
<input type = 'hidden' name = 'skipper' value = "<?php echo $skip; ?>">
<input type = 'hidden' name = 'pageEnd' value = "<?php echo $npages; ?>">
<input type = 'hidden' name = 'sel' />
<table width="903" border="0" align="center" cellpadding="0" cellspacing="0" class="tableborder2" id="list_table">
<tr>
  <td colspan="7" class="treven" id="heading_td"><span id="heading_text">Comparate Trial balance Report </span> </td>
</tr>
  <tr class="table_background">
    <td colspan="2"><table border="0" cellspacing="1" class="table_text1" width="100%">
	        
	        <tr class="tr_whitebackground">
	         <!-- <td width="18%" nowrap="nowrap">&nbsp;</td>-->
	          <td colspan="7" align="center"><div align="center">
	            <table width="445" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="40" height="22" nowrap="nowrap">Date : </td>
                    <td width="41"><select name="eday" id="eday" >
                      <?php
				  		for($i=1; $i<=31; $i++){
						if($i < 10) $i='0'.$i;
						echo "<option value='$i'". ($eday==$i?'selected':'').">$i</option>";
						}
				  		?>
                      </select></td>
                    <td width="101"><select name="emonth" id="emonth">
                      <option value="01" <?php echo ($emonth=='01'?'selected':''); ?>>January</option>
                      <option value="02" <?php echo ($emonth=='02'?'selected':''); ?>>February</option>
                      <option value="03" <?php echo ($emonth=='03'?'selected':''); ?>>March</option>
                      <option value="04" <?php echo ($emonth=='04'?'selected':''); ?>>April</option>
                      <option value="05" <?php echo ($emonth=='05'?'selected':''); ?>>May</option>
                      <option value="06" <?php echo ($emonth=='06'?'selected':''); ?>>June</option>
                      <option value="07" <?php echo ($emonth=='07'?'selected':''); ?>>July</option>
                      <option value="08" <?php echo ($emonth=='08'?'selected':''); ?>>August</option>
                      <option value="09" <?php echo ($emonth=='09'?'selected':''); ?>>September</option>
                      <option value="10" <?php echo ($emonth=='10'?'selected':''); ?>>October</option>
                      <option value="11" <?php echo ($emonth=='11'?'selected':''); ?>>November</option>
                      <option value="12" <?php echo ($emonth=='12'?'selected':''); ?>>December</option>
                      </select></td>
                    <td nowrap="nowrap" width="131"><select name="eyear" id="eyear">
                      <?php
				  		for($i=2009; $i<=2020; $i++){
						echo "<option value='$i'". ($eyear==$i?'selected':'').">$i</option>";
						}
				  		?>
                      </select>
                      <input name="search2" type="button" class="table_text1" id="search2" onclick="javascript:doSearch('change_trial_balance.php')" value="Search"/></td>
                    <td nowrap="nowrap" width="132"><input name="search3" type="button" class="table_text1" id="search3" 
                onclick="javascript:getpageUpdateGl('1','change_trial_balance.php','page')" value="Delete All Transactions and Loans "/><input type="hidden" id="1" name="1" value="1" /></td>
                  </tr>
				  </table>
	            
	          </div></td>
	        </tr>
	        <tr class="tr_whitebackground">
	          <td colspan="6" nowrap="nowrap"><table width="322" border="0">
                <tr>
                  <td align="left" nowrap="nowrap"><span class="table_text1" ><a href="#" onClick="javascript: goFirst('change_trial_balance.php');"><img src="/mfb/images/first.gif" alt="First" width="16" height="16" border="0"></a> <a href="#" onClick="javascript: goPrevious('change_trial_balance.php');"><img src="/mfb/images/prev.gif" alt="Previous" width="16" height="16" border="0"></a><a href="#" onClick="javascript: goNext('change_trial_balance.php');"><img src="/mfb/images/next.gif" alt="Next" width="16" height="16" border="0"/></a><a href="#" onClick="javascript: goLast('tribalance_report.php');"><img src="/mfb/images/last.gif" alt="Last" width="16" height="16" border="0"/></a></span></td>
                  </tr>
              </table></td>
	          <td>&nbsp;</td>
          </tr>
	        
        </table></td>
  </tr>
  <tr>
    <td colspan="2"> <a href="javascript: printDiv('t2tdiv');">Print</a>&nbsp; | &nbsp;<a href="javascript:readtabledata2('t2tid','tribal_list.xls')" >Export 2 Excel</a></td>
  </tr>
  <tr>
    <td width="900" align="left"><div id="t2tdiv">
      <table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="t2tid" width="900"><thead>
        <tr class="right_backcolor">
          <th colspan="7" nowrap="nowrap" class="Corner"><font size="4"><?php echo strtoupper($fstring); ?></font></th>
          </tr>
        <tr class="right_backcolor">
          <th colspan="7" nowrap="nowrap" class="Corner">TRIAL BALANCE REPORT AS AT <?php echo @date("d-M-Y",strtotime($eyear.'-'.$emonth.'-'.$eday)); ?></th>
          </tr>
        <tr class="right_backcolor">
          <th nowrap="nowrap" class="Corner">Account Type</th><th width="138" nowrap="nowrap" class="Odd">Account Title</th>
          <th width="129" nowrap="nowrap" class="Odd">Account Code</th><th width="129" nowrap="nowrap" class="Odd">Debit</th>
<th width="120" nowrap="nowrap" class="Odd">Credit</th><th width="185" colspan="2" nowrap="nowrap" class="Odd"></th></tr></thead>
        <?php 
		If($enddate<=$eod){		
		  $skip = $maxPage * ($pageNo-1);
			$k = 0;
		  
 		 for($i=0; $i<$skip; $i++){
				$row = mysql_fetch_array($result);
				//echo 'count '.$i.'   '.$skip;
			} 
 			 $bal = 0;
			 $sumdebit=0;
			 $sumcredit=0;
			 
  			while($k<$maxPage && $numrows>($k+$skip)) {
			$k++;
			
			//for($i=0; $i<$numrows; $i++){
				$row = mysql_fetch_array($result);
				$row["creditbal"] = 0.00;
				$row["debitbal"] = 0.00;
		
		$debit_c = $dbobject->getrecordsetdata(" select current_bal FROM gl_current_balance where ACCT_NO='".$row["ACCT_NO"]."'");
			$numro = mysql_num_rows($debit_c);
			if($numro>0){
				$r_bal =  mysql_fetch_array($debit_c);
				$open_bal = -$r_bal["current_bal"];
			 }
				
	           $debit_r = $dbobject->getrecordsetdata(" select sum(TRAN_AMOUNT) TRAN_AMOUNT FROM gl_transaction where 
											SOUR_ACCT_NO='".$row["ACCT_NO"]."' and EOD_DATE <= '$enddate' AND POST_FLAG='0' and EOD_DATE<='$eod' ");
			   $numrow = mysql_num_rows($debit_r);
			   if($numrow>0){
				  $r_deb =  mysql_fetch_array($debit_r);
				  $amt1 = -$r_deb["TRAN_AMOUNT"];
			   }
				  
			   $credit_r = $dbobject->getrecordsetdata(" select sum(TRAN_AMOUNT) TRAN_AMOUNT FROM gl_transaction where 
												ACCT_NO='".$row["ACCT_NO"]."' and EOD_DATE <= '$enddate' AND POST_FLAG='0' and EOD_DATE<='$eod' ");
			   $numrow2 = mysql_num_rows($credit_r);
			   if($numrow2>0){
				  $r_cre =  mysql_fetch_array($credit_r);
				  $amt2 = $r_cre["TRAN_AMOUNT"];
			   }
			        $row["debitbal"] = $amt1 + $amt2 - $open_bal;
					$row["creditbal"] = $amt1 + $amt2 - $open_bal;
	
					
			//if($enddate>"2010-07-31"){		
		if($row["ACCT_NO"]=="300110"){ $row["debitbal"]=$ovd; $row["creditbal"]=$ovd; }	
		if($row["ACCT_NO"]=="600110"){ $row["debitbal"]=$row["debitbal"]+$ovdcur; $row["creditbal"]=$row["creditbal"]+$ovdcur; }
		if($row["ACCT_NO"]=="600120"){ $row["debitbal"]+=$ovdst; $row["creditbal"]+=$ovdst; }
	   if($row["ACCT_NO"]=="600130"){ $row["debitbal"]+=$ovdsav; $row["creditbal"]+=$ovdsav; }
	   if($row["ACCT_NO"]=="600140"){ $row["debitbal"]+=$ovdtg; $row["creditbal"]+=$ovdtg; }
		if($row["ACCT_NO"]=="600150"){ $row["debitbal"]+=$ovdes; $row["creditbal"]+=$ovdes; }	
			//}	
				//while($i < $skip) continue;
				//echo 'count '.$i.'   '.$skip;	
			?>
        <tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> ><td nowrap="nowrap"><?php echo $row["ACCT_SB_NAME"];?></td><td nowrap="nowrap"><?php echo $row["ACCT_SBT_NAME"];?></td><td nowrap="nowrap"><?php echo $row["ACCT_NO"];?></td><td nowrap="nowrap"><?php 	if($row["debitbal"]<0){			
					echo  number_format(abs($row["debitbal"]),2);
				$sumdebit+= abs($row["debitbal"]);}
				else { echo "0.00"; } ?></td>
                <td nowrap="nowrap"><?php if($row["creditbal"]>0)	
				{echo   number_format(abs($row["creditbal"]),2);
				$sumcredit+= abs($row["creditbal"]);} 
				else { echo "0.00"; }?></td>
                <td nowrap="nowrap"><input type="text" id="<?php echo $row["ACCT_NO"];?>" name="<?php echo $row["ACCT_NO"];?>" value="<?php echo $row["debitbal"];?>" />
                <input name="search" type="button" class="table_text1" id="search" 
                onclick="javascript:getpageUpdateGl('<?php echo $row["ACCT_NO"];?>','change_trial_balance.php','page')" value="Update"/></td>
                <? 
				
				
				}  	} ?>
            </tr>
         
        <?php

			?>
        <tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> ><td nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap" align="right">&nbsp;</td><td nowrap="nowrap" align="right"><b></b></td><td nowrap="nowrap"><b><? echo number_format(abs($sumdebit),2); ?></b></td><td nowrap="nowrap"><b><? echo number_format(abs($sumcredit),2); ?></b></td><td nowrap="nowrap" colspan="2"></td></tr></table>
    </div></td>
    <td width="4" align="left"></td>
  </tr>
  <tr>
    <td height="26" align="left"><table width="322" border="0">
      <tr>
        <td align="left" nowrap="nowrap"><span class="table_text1"><a href="#" onClick="javascript: goFirst('change_trial_balance.php');"><img src="/mfb/images/first.gif" alt="First" width="16" height="16" border="0" /></a> <a href="#" onClick="javascript: goPrevious('change_trial_balance.php');"><img src="/mfb/images/prev.gif" alt="Previous" width="16" height="16" border="0" /></a><a href="#" onClick="javascript: goNext('change_trial_balance.php');"><img src="/mfb/images/next.gif" alt="Next" width="16" height="16" border="0"/></a><a href="#" onClick="javascript: goLast('change_trial_balance.php');"><img src="/mfb/images/last.gif" alt="Last" width="16" height="16" border="0"/></a></span></td>
      </tr>
    </table></td>
    <td align="left"></td>
  </tr>
</table>
</form>
</div>
<script type="text/javascript">
addTableRolloverEffect('t2tid','tableRollOverEffect1','tableRowClickEffect1');
</script>