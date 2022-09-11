<?php
include_once("session_track.php");
session_start();
?>
<div id="branch_div">
	<?php require("lib/mfbconnect.php");
	include("lib/dbfunctions.php");
	$dbobject = new dbobject();
	$eod = $dbobject->get_eod();
	$expd = explode('-', $eod);


	?>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<script type="text/javascript" src="js/loading_screen.js"></script>

	<form name="form1" id="form1" method="post" action="">
		<input type="hidden" name="ACCT_NO" />
		<input type="hidden" name="op" />
		<input type="hidden" name="VAR1" />
		<input type="hidden" name="data" id="data" />
		<input type="hidden" name="datafilename" id="datafilename" />
		<?php
		$count = 0;
		//echo $_SESSION["username_sess"]."<br>";
		$user =  $_SESSION["username_sess"];
		$limit = !isset($_REQUEST['limit']) ? "500" : $_REQUEST['limit'];
		$pageNo = !isset($_REQUEST['fpage']) ? "1" : $_REQUEST['pageNo'];
		$searchby = !isset($_REQUEST['searchby']) ? "" : $_REQUEST['searchby'];
		$keyword = !isset($_REQUEST['keyword']) ? "" : $_REQUEST['keyword'];
		$orderby = !isset($_REQUEST['orderby']) ? "ACCT_NAME" : $_REQUEST['orderby'];
		$orderflag = !isset($_REQUEST['orderflag']) ? "asc" : $_REQUEST['orderflag'];
		$lower = !isset($_REQUEST['lower']) ? "" : $_REQUEST['lower'];
		$upper = !isset($_REQUEST['upper']) ? "" : $_REQUEST['upper'];
		$sday = !isset($_REQUEST['sday']) ? "$expd[2]" : $_REQUEST['sday'];
		$smonth = !isset($_REQUEST['smonth']) ? "$expd[1]" : $_REQUEST['smonth'];
		$syear = !isset($_REQUEST['syear']) ? "$expd[0]" : $_REQUEST['syear'];
		$eday = !isset($_REQUEST['eday']) ? "" : $_REQUEST['eday'];
		$emonth = !isset($_REQUEST['emonth']) ? "" : $_REQUEST['emonth'];
		$eyear = !isset($_REQUEST['eyear']) ? "" : $_REQUEST['eyear'];
		$ac_type_name = $dbobject->getItemlabel('account_type_tbl', 'ACCT_TYPE_ID', $searchby, 'ACCT_TY_NAME');
		$ac_type = $dbobject->gettableselect('account_type_tbl', 'ACCT_TYPE_ID', 'ACCT_TY_NAME', $searchby);

		if ($orderby == 'CUS_BAL') {
			$orderby2 = '(SELECT current_bal from current_balance where ACCT_NO=account_details.ACCT_NO)';
		} else {
			$orderby2 = $orderby;
		}

		$searchdate = "";
		if ($sday != '') {
			$startdate = $syear . "-" . $smonth . "-" . $sday;
			//echo $startdate;
			//$enddate = "'".$eyear."-".$emonth."-".$eday."'";
			$searchdate = " ";
		} else {
			$startdate = $syear . "-" . $smonth . "-" . $sday;
			//$searchdate = "  ";
		}


		$filter = "";
		if ($searchby != '') {
			$filter = " AND ACCT_TYPE = '$searchby' ";
		}
		$order = " order by " . $orderby2 . " " . $orderflag;
		$sql = " select count(ACCT_NO) counter from account_details where 
			(ACCT_TYPE <> '') and ACCT_NAME <> '' AND DL='0'   " . $filter . $searchdate . $order;
		//echo $sql;
		$result = mysql_query($sql);
		if ($result) {
			$row = mysql_fetch_array($result);
			$count = $row['counter'];
		}

		$skip = 0;
		$maxPage = $limit;
		//echo $count;
		$npages = (int)($count / $maxPage);
		//echo $npages;
		if ($npages != 0) {
			if (($npages * $maxPage) != $count) {
				$npages = $npages + 1;
				//echo $npages;
			}
		} else {
			$npages = 1;
			//echo "Here";
		}


		// Setting Limit for Record Retrieval
		$start_limit = 0;
		$end_limit = $maxPage;
		if ($pageNo > 1) {
			$start_limit = ($pageNo - 1) * $maxPage;
			$end_limit = $pageNo * $maxPage;
		}
		$limit_addquery = " LIMIT $start_limit, $end_limit ";

		/*$sel = !isset($_REQUEST['op'])?"":$_REQUEST['op'];
			if ($sel=="del"){
				$delvalues = !isset($_REQUEST['role_id'])?"":$_REQUEST['role_id'];
				//$delsql = "delete from role where ACCT_NO = '$delvalues'";
				//$dresult = mysql_query($delsql);
				echo "<font class='header2white'>No of Deleted Records: ".mysql_affected_rows()." ";
			}
                */

		//mysql_select_db($database_courier);
		if ($eod == $startdate) {
			$query = " Select ACCT_ID,
ACCT_NO,
OLD_ACCT_NO,
ACCT_NAME,
GL_TYPE,
(SELECT ACCT_TY_NAME from account_type_tbl where ACCT_TYPE_ID=account_details.ACCT_TYPE ) ACCT_TYPE,
(SELECT current_bal from current_balance where ACCT_NO=account_details.ACCT_NO) CUS_BAL 
From
account_details, branch
where DL='0' AND  account_details.BRANCH_ID=branch.branch_code and (ACCT_TYPE <> '') and ACCT_NAME <> '' " . $filter . $searchdate . $order;
			//echo $query; 
			$result = mysql_query($query) or die(mysql_error());
			$numrows = mysql_num_rows($result);

			//echo 'D page:  '.$pageNo;
			$download_query = "Select
	ACCT_ID,
ACCT_NO,
OLD_ACCT_NO,
ACCT_NAME,
GL_TYPE,
(SELECT ACCT_TY_NAME from account_type_tbl where ACCT_TYPE_ID=account_details.ACCT_TYPE ) ACCT_TYPE,
(SELECT current_bal from current_balance where ACCT_NO=account_details.ACCT_NO) CUS_BAL 
From
account_details, branch
where account_details.BRANCH_ID=branch.branch_code and (account_details.ACCT_TYPE <> '' ) and ACCT_NAME <> '' " . $filter . $searchdate . $order;
		} else {

			$query = " Select ACCT_ID,  ACCT_NO, OLD_ACCT_NO, ACCT_NAME, GL_TYPE,
(SELECT ACCT_TY_NAME from account_type_tbl where ACCT_TYPE_ID=account_details.ACCT_TYPE ) ACCT_TYPE,
(SELECT current_bal from current_balance where ACCT_NO=account_details.ACCT_NO ) CUS_BAL 
From
account_details, branch
where account_details.BRANCH_ID=branch.branch_code and (ACCT_TYPE <> '') and ACCT_NAME <> '' " . $filter . $searchdate . $order;
			//echo $query; 
			$result = mysql_query($query) or die(mysql_error());
			$numrows = mysql_num_rows($result);



			//echo 'D page:  '.$pageNo;
			$download_query = "Select
ACCT_NO,
ACCT_NAME,
(SELECT ACCT_TY_NAME from account_type_tbl where ACCT_TYPE_ID=account_details.ACCT_TYPE ) ACCT_TYPE,
(SELECT current_bal from eod_current_balance where ACCT_NO=account_details.ACCT_NO and BAL_DATE = '$startdate') CUS_BAL
From account_details , branch
where account_details.BRANCH_ID=branch.branch_code and (account_details.ACCT_TYPE <> '' ) and ACCT_NAME <> '' " . $filter . $searchdate . $order;
		}

		?>
		<input type='hidden' name='sql' id='sql' value="<?php echo $download_query; ?>" />
		<input type='hidden' name='filename' id='filename' value="accountdetails" />
		<input type='hidden' name='pageNo' id="pageNo" value="<?php echo $pageNo; ?>">
		<input type='hidden' name='rowCount' value="<?php echo $count; ?>">
		<input type='hidden' name='skipper' value="<?php echo $skip; ?>">
		<input type='hidden' name='pageEnd' value="<?php echo $npages; ?>">
		<input type='hidden' name='sel' />
		<div id="loadingScreen"></div>
		<table width="620" border="0" align="center" cellpadding="0" cellspacing="0" class="tableborder2" id="list_table">
			<tr>
				<td colspan="7" class="treven" id="heading_td"><span id="heading_text">All Member Balances</span></td>
			</tr>
			<tr class="table_background">
				<td colspan="2">
					<table border="0" cellspacing="1" class="table_text1" width="100%">

						<tr class="tr_whitebackground">
							<!-- <td width="18%" nowrap="nowrap">&nbsp;</td>-->
							<td colspan="7" align="center">
								<div align="center">
									<table width="363" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="72" nowrap="nowrap">As at : </td>
											<td width="44"><select name="sday" id="sday">
													<?php
													for ($i = 1; $i <= 31; $i++) {
														if ($i < 10) $i = '0' . $i;
														echo "<option value='$i'" . ($sday == $i ? 'selected' : '') . ">$i</option>";
													}
													?>
												</select> </td>
											<td width="85"><select name="smonth" id="smonth">
													<option value="01" <?php echo ($smonth == '01' ? 'selected' : ''); ?>>January</option>
													<option value="02" <?php echo ($smonth == '02' ? 'selected' : ''); ?>>February</option>
													<option value="03" <?php echo ($smonth == '03' ? 'selected' : ''); ?>>March</option>
													<option value="04" <?php echo ($smonth == '04' ? 'selected' : ''); ?>>April</option>
													<option value="05" <?php echo ($smonth == '05' ? 'selected' : ''); ?>>May</option>
													<option value="06" <?php echo ($smonth == '06' ? 'selected' : ''); ?>>June</option>
													<option value="07" <?php echo ($smonth == '07' ? 'selected' : ''); ?>>July</option>
													<option value="08" <?php echo ($smonth == '08' ? 'selected' : ''); ?>>August</option>
													<option value="09" <?php echo ($smonth == '09' ? 'selected' : ''); ?>>September</option>
													<option value="10" <?php echo ($smonth == '10' ? 'selected' : ''); ?>>October</option>
													<option value="11" <?php echo ($smonth == '11' ? 'selected' : ''); ?>>November</option>
													<option value="12" <?php echo ($smonth == '12' ? 'selected' : ''); ?>>December</option>
												</select></td>
											<td width="199"><select name="syear" id="syear">
													<?php
													for ($i = 2009; $i <= 2020; $i++) {
														echo "<option value='$i'" . ($syear == $i ? 'selected' : '') . ">$i</option>";
													}
													?>
												</select>
												<a href="#" onclick="getpage('change_all_customer_bal_list.php','page')">Change</a>
											</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
						<tr class="tr_whitebackground">
							<td colspan="6" nowrap="nowrap">
								<table width="322" border="0">
									<tr>
										<td align="left" nowrap="nowrap"><span class="table_text1"><a href="#" onclick="javascript: goFirst('all_customer_bal_list.php');"><img src="/mfb/images/first.gif" alt="First" width="16" height="16" border="0"></a> <a href="#" onclick="javascript: goPrevious('all_customer_bal_list.php');"><img src="/mfb/images/prev.gif" alt="Previous" width="16" height="16" border="0"></a><a href="#" onclick="javascript: goNext('all_customer_bal_list.php');"><img src="/mfb/images/next.gif" alt="Next" width="16" height="16" border="0" /></a><a href="#" onclick="javascript: goLast('all_customer_bal_list.php');"><img src="/mfb/images/last.gif" alt="Last" width="16" height="16" border="0" /></a></span></td>
									</tr>
								</table>
							</td>
							<td>&nbsp;</td>
						</tr>

						<tr class="tr_whitebackground">
							<td colspan="7" nowrap="nowrap">
								<table width="688" border="0">
									<tr>
										<td nowrap="nowrap"><span>Search By</span>
											<select name="searchby" class="table_text1" id="searchby">
												<?php echo $ac_type; ?>
											</select>
											:
										</td>
										<td nowrap="nowrap">&nbsp;&nbsp;Order By :
											<select name="orderby" class="table_text1" id="orderby">
												<option value="account_details.ACCT_NO" <?php echo ($orderby == 'account_details.ACCT_NO') ? "selected" : ""; ?>>Account Number</option>
												<option value="account_details.ACCT_NAME" <?php echo ($orderby == 'account_details.ACCT_NAME') ? "selected" : ""; ?>>Account Name</option>
												<option value="(SELECT ACCT_TY_NAME from account_type_tbl where ACCT_TYPE_ID=account_details.ACCT_TYPE )" <?php echo ($orderby == '(SELECT ACCT_TY_NAME from account_type_tbl where ACCT_TYPE_ID=account_details.ACCT_TYPE )') ? "selected" : ""; ?>>Account Type</option>
												<option value="account_details.ACCT_OFFICER" <?php echo ($orderby == 'account_details.ACCT_OFFICER') ? "selected" : ""; ?>>Account Officer</option>
												<option value="account_details.OLD_ACCT_NO" <?php echo ($orderby == 'account_details.OLD_ACCT_NO') ? "selected" : ""; ?>>File No</option>
												<option value="CUS_BAL" <?php echo ($orderby == 'CUS_BAL') ? "selected" : ""; ?>>Customer Balance</option>
												<option value="branch.branch_name" <?php echo ($orderby == 'branch.branch_name') ? "selected" : ""; ?>>Branch</option>
											</select>
											&nbsp;
											<select name="orderflag" class="table_text1" id="orderflag">
												<option value="asc" <?php echo ($orderflag == 'asc') ? "selected" : ""; ?>>Ascending</option>
												<option value="desc" <?php echo ($orderflag == 'desc') ? "selected" : ""; ?>>Descending</option>
											</select>
											<input name="search2" type="button" class="table_text1" id="search2" onclick="javascript:doSearch('all_customer_bal_list.php')" value="Search" />
										</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>


						<tr class="back_image">
							<td colspan="7" align="left">
								<table border="0">
									<tr>
										<td nowrap="nowrap">No of Records : <?php echo $count; ?></td>
										<td>Limit :
											<select name="limit" class="table_text1" id="limit" onchange="javascript:doSearch('all_customer_bal_list.php');">
												<option value="1" <?php echo ($limit == "1" ? "selected" : ""); ?>>1</option>
												<option value="10" <?php echo ($limit == "10" ? "selected" : ""); ?>>10</option>
												<option value="20" <?php echo ($limit == "20" ? "selected" : ""); ?>>20</option>
												<option value="50" <?php ($limit == "50" ? "selected" : ""); ?>>50</option>
												<option value="100" <?php echo ($limit == "100" ? "selected" : ""); ?>>100</option>
												<option value="200" <?php echo ($limit == "200" ? "selected" : ""); ?>>200</option>
												<option value="500" <?php echo ($limit == "500" ? "selected" : ""); ?>>500</option>
												<option value="700" <?php echo ($limit == "700" ? "selected" : ""); ?>>700</option>
												<option value="1000" <?php echo ($limit == "1000" ? "selected" : ""); ?>>1000</option>
												<option value="2000" <?php echo ($limit == "2000" ? "selected" : ""); ?>>2000</option>
												<option value="3000" <?php echo ($limit == "3000" ? "selected" : ""); ?>3>3000</option>
											</select>
										</td>
										<td>Page
											<input name="fpage" type="text" class="table_text1" id="fpage" value="<?php echo $pageNo; ?>" size="3" />
											of
											<input name="tpages" type="text" class="table_text1" id="tpages" value="<?php echo $npages; ?>" size="3" />
											&nbsp;
											<input name="search22" type="button" class="table_text1" id="search22" onclick="javascript:doSearch('all_customer_bal_list.php');" value="Go" />
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr class="back_image">
							<td colspan="7" align="left">
								<font class='table_text1'><a href="user.php">
										<label> </label>
									</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;<a href="javascript: printDiv('print_div');">Print</a> &nbsp; | <a href="javascript:readtabledata('accountinfo','all_cus_bal.xls','generateexcel.php')">Export 2 Excel</a></td>
			</tr>
			<tr>
				<td width="466" align="left">
					<div id="print_div">
						<table width="776" border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="accountinfo">
							<thead>
								<tr class="right_backcolor">
									<th nowrap="nowrap" class="Corner">&nbsp;</th>
									<th nowrap="nowrap" class="Odd">&nbsp;</th>
									<th colspan="4" nowrap="nowrap" class="Odd" align="left"><?php echo $ac_type_name; ?> Balances as at <?php echo @date("d-M-Y", strtotime($startdate)); ?></th>
									<?php if (($searchby == '30') || ($searchby == '31') || ($searchby == '32') || ($searchby == '33') || ($searchby == '34') || ($searchby == '35') || ($searchby == '36') || ($searchby == '37') || ($searchby == '38')) { ?>
										<th colspan="2" nowrap="nowrap">&nbsp;</th>
										<th colspan="2" nowrap="nowrap">&nbsp;</th>
									<?php } ?>
								</tr>
								<tr class="right_backcolor">
									<th width="1" nowrap="nowrap" class="Corner">&nbsp;</th>
									<th width="25" nowrap="nowrap" class="Odd">S/N</th>
									<th nowrap="nowrap" class="Odd">Member ID</th>
									<th width="98" nowrap="nowrap" class="Odd">Member Name</th>
									<th width="102" nowrap="nowrap">Account Type</th>
									<th width="127" nowrap="nowrap">Balance</th>
									<?php if (($searchby == '30') || ($searchby == '31') || ($searchby == '32') || ($searchby == '33') || ($searchby == '34') || ($searchby == '35') || ($searchby == '36') || ($searchby == '37') || ($searchby == '38')) { ?>
										<th width="47" nowrap="nowrap">Loan Outst</th>
										<th width="47" nowrap="nowrap">Int Oust</th>
										<th width="47" nowrap="nowrap">Rep Amt</th>
										<th width="48" nowrap="nowrap">Rep Int</th>
									<?php } ?>
								</tr>
							</thead>
							<?php
							$skip = $maxPage * ($pageNo - 1);
							$k = 0;

							/* for($i=0; $i<$skip; $i++){
				$row = mysql_fetch_array($result);
				//echo 'count '.$i.'   '.$skip;
			} */

							//while($k<$maxPage && $numrows>($k+$skip)) {

							//for($i=0; $i<$numrows; $i++){
							$tot_bal = 0.00;
							$ln_oust = 0.00;
							$Int_oust = 0.00;
							$Rep_amt = 0.00;
							$Rep_int = 0.00;
							while ($row = mysql_fetch_array($result)) {
								//while($i < $skip) continue;
								//echo 'count '.$i.'   '.$skip;	


								$row["CUS_BAL"] = $dbobject->eodcustomerbalance($row["ACCT_NO"], $startdate);
								$all_a = $dbobject->getItemLabelArr(
									'loan_tbl2',
									array('staff_no', 'loan_status'),
									array($row["ACCT_NO"], '1'),
									array('outstd_rep', 'outstd_int', 'total_rep', 'repay_int')
								);
								//echo $row["CUS_BAL"]."<br>";

								//if(($row["GL_TYPE"] == '20001')) {




								//if((($row["CUS_BAL"]>0.00) || ($row["CUS_BAL"]<0.00))&&($row["CUS_BAL"]!='')) {
								$k++;

							?>
								<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
									<td nowrap="nowrap">&nbsp;</td>
									<td nowrap="nowrap"><?php echo $k + $skip; ?></td>
									<td nowrap="nowrap"><?php echo $row["ACCT_ID"]; ?></td>
									<td nowrap="nowrap"><?php echo $row["ACCT_NAME"]; ?></td>
									<td nowrap="nowrap"><?php echo $row["ACCT_TYPE"]; ?></td>
									<td nowrap="nowrap"><?php echo number_format($row["CUS_BAL"], 2);
														$tot_bal += $row["CUS_BAL"]; ?></td>
									<?php if (($searchby == '30') || ($searchby == '31') || ($searchby == '32') || ($searchby == '33') || ($searchby == '34') || ($searchby == '35') || ($searchby == '36') || ($searchby == '37') || ($searchby == '38')) { ?>
										<td nowrap="nowrap"><?php echo number_format($all_a["outstd_rep"], 2);
															$ln_oust += $all_a["outstd_rep"]; ?></td>
										<td nowrap="nowrap"><?php echo number_format($all_a["outstd_int"], 2);
															$Int_oust += $all_a["outstd_int"]; ?></td>
										<td nowrap="nowrap"><?php echo number_format($all_a["total_rep"], 2);
															$Rep_amt += $all_a["total_rep"]; ?></td>
										<td nowrap="nowrap"><?php echo number_format($all_a["repay_int"], 2);
															$Rep_int += $all_a["repay_int"]; ?></td>
									<?php } ?>
								</tr>

							<?php
								//} //End For Loop
							} //End If Result Test	
							?>
							<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
								<td nowrap="nowrap">&nbsp;</td>
								<td nowrap="nowrap">&nbsp;</td>
								<td nowrap="nowrap">&nbsp;</td>
								<td nowrap="nowrap">&nbsp;</td>
								<td nowrap="nowrap">&nbsp;</td>
								<td nowrap="nowrap"><?php echo number_format($tot_bal, 2); ?></td>
								<?php if (($searchby == '30') || ($searchby == '31') || ($searchby == '32') || ($searchby == '33') || ($searchby == '34') || ($searchby == '35') || ($searchby == '36') || ($searchby == '37') || ($searchby == '38')) { ?>
									<td nowrap="nowrap"><?php echo number_format($ln_oust, 2); ?></td>
									<td nowrap="nowrap"><?php echo number_format($Int_oust, 2); ?></td>
									<td nowrap="nowrap"><?php echo number_format($Rep_amt, 2); ?></td>
									<td nowrap="nowrap"><?php echo number_format($Rep_int, 2); ?></td>
								<?php } ?>
							</tr>
						</table>
					</div>
				</td>
				<td width="152" align="left">&nbsp;</td>
			</tr>
			<tr>
				<td align="left">
					<table width="322" border="0">
						<tr>
							<td align="left" nowrap="nowrap"><span class="table_text1"><a href="#" onclick="javascript: goFirst('branch_list.php');"><img src="/mfb/images/first.gif" alt="First" width="16" height="16" border="0" /></a> <a href="#" onclick="javascript: goPrevious('all_customer_bal_list.php');"><img src="/mfb/images/prev.gif" alt="Previous" width="16" height="16" border="0" /></a><a href="#" onclick="javascript: goNext('all_customer_bal_list.php');"><img src="/mfb/images/next.gif" alt="Next" width="16" height="16" border="0" /></a><a href="#" onclick="javascript: goLast('all_customer_bal_list.php');"><img src="/mfb/images/last.gif" alt="Last" width="16" height="16" border="0" /></a></span></td>
						</tr>
					</table>
				</td>
				<td align="left">&nbsp;</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
	addTableRolloverEffect('accountinfo', 'tableRollOverEffect1', 'tableRowClickEffect1');
</script>