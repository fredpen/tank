<?php
ob_start();
include_once "session_track.php";
?>


<style>
	td {
		padding: 5px;
	}
</style>
<script type="text/javascript" src="js/dynamic_search_script.js"></script>
<div align="center" id="data-form">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form').hide();">

	<?php
	require_once("lib/mfbconnect.php");
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong>
				General Expenditure
			</strong></h3>
		<?php
		if ($_SESSION['expense'] == 1) {
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";
			$periodmonth = $_SESSION['periodmonth'];
			$periodyear = $_SESSION['periodyear'];
			$user = $_SESSION['username_sess'];
			$reqst_by = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$vendorno = !isset($_REQUEST['vendorno']) ? '' : $_REQUEST['vendorno'];
			$company = !isset($_REQUEST['company']) ? '' : $dbobject->test_input($_REQUEST['company']);
			$phone = !isset($_REQUEST['phone']) ? '' : $dbobject->test_input($_REQUEST['phone']);
			$address1 = !isset($_REQUEST['address1']) ? '' : $dbobject->test_input($_REQUEST['address1']);
			$expenstype = !isset($_REQUEST['expenstype']) ? '' : $dbobject->test_input($_REQUEST['expenstype']);
			$contactperson = !isset($_REQUEST['contactperson']) ? '' : $dbobject->test_input($_REQUEST['contactperson']);
			$selectbank = !isset($_REQUEST['selectbank']) ? '' : $dbobject->test_input($_REQUEST['selectbank']);
			$selectexpensetype = !isset($_REQUEST['selectexpensetype']) ? '' : $dbobject->test_input($_REQUEST['selectexpensetype']);


			$goahead = !isset($_REQUEST['goahead']) ? 0 : $_REQUEST['goahead'];

			$exprefno = !isset($_REQUEST['exprefno']) ? '' : $_REQUEST['exprefno'];
			$pmtmode = !isset($_REQUEST['pmtmode']) ? 2 : $_REQUEST['pmtmode'];
			$bank_code = !isset($_REQUEST['bank_code']) ? "" : $_REQUEST['bank_code'];

			$dd_date = !isset($_REQUEST['dd_date']) ? date("Y-m-d") : $_REQUEST['dd_date'];
			$amount = !isset($_REQUEST['amount']) ? 0.0 : $_REQUEST['amount'];
			$pmtdate = !isset($_REQUEST['pmtdate']) ? date("Y-m-d") : $_REQUEST['pmtdate'];
			$descriptn = !isset($_REQUEST['descriptn']) ? "" : $_REQUEST['descriptn'];
			$email = !isset($_REQUEST['email']) ? "" : $_REQUEST['email'];
			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);

			$sql_bank = "select distinct  bank_code, bank_name FROM bank WHERE 1=1 order by bank_name";
			$result_bank = mysqli_query($_SESSION['db_connect'], $sql_bank);
			$count_bank = mysqli_num_rows($result_bank);

			$sql_expensehead = "select chartcode,description FROM chart_of_account WHERE UCASE(trim(accounttype)) = 'EXPENSE'";
			$result_expensehead = mysqli_query($_SESSION['db_connect'], $sql_expensehead);
			$count_expensehead = mysqli_num_rows($result_expensehead);

			$sql_client = "select distinct * FROM arcust WHERE 1=1 order by company";
			$result_client = mysqli_query($_SESSION['db_connect'], $sql_client);
			$count_client = mysqli_num_rows($result_client);
			//echo "dd_no ".$dd_no;


			// obtain next exprefno
			$sql_const = "select next_expno from const where 1=1";
			//echo $sql_const;
			$result_const = mysqli_query($db_connect, $sql_const);
			$count_const = mysqli_num_rows($result_const);

			$next_exprefno = 1;
			if ($count_const > 0) {
				$row = mysqli_fetch_array($result_const);
				if ($row['next_expno'] == 99999) {
					$next_exprefno = 1;
				} else {
					$next_exprefno = $row['next_expno'];
				}
			}

			$transdate = date("d/m/Y H:i:s");
			$exprefnoday = substr($transdate, 0, 2);
			$exprefnomonth = substr($transdate, 3, 2);
			$exprefnoyear = substr($transdate, 6, 4);

			$exprefno =  "EXP" . $exprefnoday . $exprefnomonth . $exprefnoyear . $next_exprefno;
			$dd_no = !isset($_REQUEST['dd_no']) ? $exprefno : $_REQUEST['dd_no'];




			if ($op == 'searchkeyword') {

				//echo "keyword ".$keyword . "<br/>";
				//echo "string length ".strlen($keyword) . "<br/>";
				$filter = "";
				$filter = " AND trim(vendorno) like '%$keyword%'   ";


				$sql_Q = "SELECT * FROM vendors where ";
				if (strlen($keyword) != 0) {
					$sql_Q = $sql_Q . " 1 = 1 ";
				} else {
					$sql_Q = $sql_Q . " 1 = 2 ";
				}
				$orderby = "   ";
				$orderflag	= " ";
				$order = $orderby . " " . $orderflag;
				$sql_QueryStmt = $sql_Q . $filter . $order . " limit 1";

				//echo "<br/> sql_Q ".$sql_Q;	
				//echo "<br/>".$sql_QueryStmt;
				$result_QueryStmt = mysqli_query($_SESSION['db_connect'], $sql_QueryStmt);
				$count_QueryStmt = mysqli_num_rows($result_QueryStmt);

				if ($count_QueryStmt >= 1) {
					$row       = mysqli_fetch_array($result_QueryStmt);
					$vendorno    = $row['vendorno'];
					$company   = $row['company'];
					$phone = $row['phone'];
					$email = $row['email'];
					$address1  = $row['address1'];
					$contactperson  = $row['contactperson'];


					//echo "fetch address ".$flataddress;
				} else {
		?>
					<script>
						$('#item_error').html("<strong>Vendor does not exist</strong>");
					</script>
				<?php
				}
			}



			if ($op == 'saving') {
				//global $next_exprefno;
				$goahead = 1;



				if (trim($_REQUEST['vendorno']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Vendor ID</strong>");
					</script>
				<?php }

				if (trim($_REQUEST['selectexpensetype']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify the Expense Type</strong>");
					</script>
					<?php } else {
					$theexpense = explode("*", $selectexpensetype);
					$expenstype = $theexpense[0];
					$expensedesc = $theexpense[1];
				}

				if (trim($_REQUEST['pmtmode']) == 2) {

					if (trim($_REQUEST['selectbank']) == '') {
						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>Please specify the Bank Name</strong>");
						</script>
					<?php } else {
						$thebank = explode("*", $selectbank);
						$bank_code = $thebank[0];
						$bank_name = $thebank[1];
					}

					if (trim($_REQUEST['dd_no']) == '') {
						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>Please specify the Bank Teller Refernce</strong>");
						</script>
					<?php }

					if (trim($_REQUEST['dd_date']) == '') {
						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>Please specify the Bank Teller Date</strong>");
						</script>
					<?php }


					// check if payment reference has been used before
					$sql_pmtStmt = "select * from payments where trim(bank_code) = '" . trim($bank_code) . "' and trim(dd_no) = '" . trim($dd_no)	 . "'";

					$count_pmtStmt = $dbobject->searchentry($sql_pmtStmt);

					if ($count_pmtStmt >= 1) {
						$goahead = $goahead * 0;

					?>
						<script>
							$('#item_error').html("<strong>Payment reference has been used before</strong>");
						</script>
					<?php
					}

					$sql_pmtStmt2 = "select * from otherincome where trim(bank_code) = '" . trim($bank_code) . "' and trim(dd_no) = '" . trim($dd_no)	 . "'";

					$count_pmtStmt2 = $dbobject->searchentry($sql_pmtStmt2);
					if ($count_pmtStmt2 >= 1) {
						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>Payment reference has been used before</strong>");
						</script>
					<?php

					}

					$sql_pmtStmt3 = "select * from expense where trim(bank_code) = '" . trim($bank_code) . "' and trim(dd_no) = '" . trim($dd_no)	 . "'";

					$count_pmtStmt3 = $dbobject->searchentry($sql_pmtStmt3);
					if ($count_pmtStmt3 >= 1) {
						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>Payment reference has been used before</strong>");
						</script>
					<?php

					}
				}

				if (trim($_REQUEST['amount']) == 0) {
					$goahead = $goahead * 0;
					?>
					<script>
						$('#item_error').html("<strong>Please specify the Amount</strong>");
					</script>
					<?php
				} else {

					//check if fund is available
					$sql_const = "select * from const where 1=1";
					//echo $sql_const;
					$result_const = mysqli_query($db_connect, $sql_const);
					$count_const = mysqli_num_rows($result_const);
					if ($count_const > 0) {
						$row_const = mysqli_fetch_array($result_const);
						if ($pmtmode == 1 && $row_const['cashbal'] < $amount) {
							$goahead = $goahead * 0;
					?>
							<script>
								$('#item_error').html("<strong>The amount requested for is not affordable <br/> You do not have sufficient Cash on Hand</strong>");
							</script>
							<?php
						} else {
							if ($row_const['bankbal'] < $amount) {
								$goahead = $goahead * 0;
							?>
								<script>
									$('#item_error').html("<strong>The amount requested for is not affordable <br/> You do not have sufficient Cash in the Bank</strong>");
								</script>
								<?php
							} else {
								$check_Bank_stmt = "select * from bank where TRIM(bank_code) = '$bank_code'";
								$result_Bank_stmt = mysqli_query($db_connect, $check_Bank_stmt);
								$count_Bank_stmt = mysqli_num_rows($result_Bank_stmt);
								if ($count_Bank_stmt > 0) {
									$row_Bank_stmt = mysqli_fetch_array($result_Bank_stmt);
									if ($row_Bank_stmt['bankbal'] < $amount) {
										$goahead = $goahead * 0;
								?>
										<script>
											$('#item_error').html("<strong>The amount requested for is not affordable <br/> You do not have sufficient Cash in the selected bank</strong>");
										</script>
					<?php
									}
								}
							}
						}
					}
				}




				if (trim($_REQUEST['pmtdate']) == '') {
					$goahead = $goahead * 0;
					?>
					<script>
						$('#item_error').html("<strong>Please specify the Date of Payment</strong>");
					</script>
					<?php } else {
					$goaheadDateWithinPeriod = $dbobject->periodcheck(trim($_REQUEST['pmtdate']));
					if ($goaheadDateWithinPeriod == 0) {
						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>Please specify  Date within the current period</strong>");
						</script>
					<?php }
				}

				if (trim($_REQUEST['descriptn']) == '') {
					$goahead = $goahead * 0;
					?>
					<script>
						$('#item_error').html("<strong>Please say something about the Payment</strong>");
					</script>
				<?php }






				//echo $goahead;
				if ($goahead == 1) {
					//generate exprefno or receipt number 



					//2021-07-15
					$pmtdatetosave = substr($pmtdate, 8, 2) . "/" . substr($pmtdate, 5, 2) . "/" . substr($pmtdate, 0, 4);
					$dd_datetosave = substr($dd_date, 8, 2) . "/" . substr($dd_date, 5, 2) . "/" . substr($dd_date, 0, 4);

					$LoopMore = 1;
					while ($LoopMore == 1) {
						$check_exprefno = "select * from expense where trim(exprefno) = '" . $exprefno . "'";
						$result_exprefno = mysqli_query($db_connect, $check_exprefno);
						$count_exprefno = mysqli_num_rows($result_exprefno);

						if ($count_exprefno > 0) {
							$LoopMore = 1;
							$next_exprefno++;
							$exprefno = "EXP" . $exprefnoday . $exprefnomonth . $exprefnoyear . $next_exprefno;
						} else {
							$LoopMore = 0;
						}
					}

					$Save_Expense_stmt = "insert into expense 
							( vendorno,exprefno,descriptio,expenstype,expensdate,transdate, 
								transby,  pmtmode, bank_code, dd_no, dd_date, amount, periodmonth, periodyear ) 
							values ('$vendorno' , '$exprefno' , '$descriptn', '$expenstype',
							'$pmtdatetosave', '$transdate','$reqst_by',$pmtmode,'$bank_code', '$dd_no', '$dd_datetosave' ,$amount, '$periodmonth','$periodyear') ";

					$result_Expense_stmt = mysqli_query($_SESSION['db_connect'], $Save_Expense_stmt);

					//echo $Save_Expense_stmt;
					$sql_CreateJournal2 = "call CreateJournalEntries('EXPENSES','$expenstype','$expensedesc',$amount,'" . date('d/m/Y H:i:s A') . "','$periodmonth','$periodyear')";

					$result_CreateJournal2 = mysqli_query($_SESSION['db_connect'], $sql_CreateJournal2);


					//echo $sql_QueryStmt;


					$dbobject->apptrail($reqst_by, 'General Expenditure', $exprefno, date('d/m/Y H:i:s A'), 'Saved');
					//update next receiptno 
					$tosave = $next_exprefno + 1;
					$ConstQuery =  "update const set next_expno = $tosave ,corpbal = corpbal - $amount";

					if ($pmtmode == 1) {
						$ConstQuery = $ConstQuery . ", cashbal = cashbal - $amount where 1=1 ";
					} else {
						$ConstQuery = $ConstQuery . ", bankbal = bankbal - $amount  where 1=1 ";
						$UpdateBank_stmt =  " update bank set bankbal = bankbal - $amount where bank_code = '$bank_code'";
						$result_UpdateBank_stmt = mysqli_query($db_connect, $UpdateBank_stmt);
					}

					$result_ConstQuery = mysqli_query($db_connect, $ConstQuery);








					$descriptn = '';
					$dd_no = '';
					$amount = 0;

				?>
					<script>
						$('#item_error').html("<strong>Transaction was successful</strong>");
					</script>
			<?php
				}
			}
			//****			


			?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="vendorno" id="vendorno" value="<?php echo $vendorno; ?>" />
			<input type="hidden" name="company" id="company" value="<?php echo $company; ?>" />
			<input type="hidden" name="bank_code" id="bank_code" value="<?php echo $bank_code; ?>" />

			<input type="hidden" name="address1" id="address1" value="<?php echo $address1; ?>" />
			<input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
			<input type="hidden" name="exprefno" id="exprefno" value="<?php echo $exprefno; ?>" />
			<input type="hidden" name="thetablename" id="thetablename" value="vendor" />
			<input type="hidden" name="get_file" id="get_file" value="generalexpenditure" />
			<table border="0" style="padding:0px;">
				<tr>
					<td colspan="2" style="color:red;" id="item_error" align="left"></td>
				</tr>
				<?php if ($goahead == 1) { ?>
					<tr>
						<td colspan="2" align="left">
							<h3>The Transaction Reference is <b><?php echo $exprefno; ?></b></h3>
						</td>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="2">
						<div class="input-group">
							<b>Search by: <i>Name or Code or Phone Number</i> </b>&nbsp;
							<input type="text" size="35px" id="search" placeholder="Search for Vendor" />
							<input name="keyword" type="hidden" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />

						</div>
						<!-- Suggestions will be displayed in below div. -->

						<div id="display"></div>
					</td>

				</tr>

			</table>
			<br />
			<div style="overflow-x:auto;">
				<table border="0">
					<tr>
						<td colspan="4">
							<h3><b>Vendor : </b>&nbsp;&nbsp;<?php echo $vendorno; ?> &nbsp;&nbsp;<?php echo $company; ?></h3>

						</td>
					</tr>
					<tr>

						<td>
							<b>Expense Head</b>
						</td>
						<td colspan="3">

							<?php
							$k = 0;
							?>
							<select name="expenstype" id="expenstype">
								<option value=""></option>
								<?php

								while ($k < $count_expensehead) {
									$row_expensehead = mysqli_fetch_array($result_expensehead);
									$theselectedexpensetype = trim($row_expensehead['chartcode']) . "*" . str_replace("&", "and", trim($row_expensehead['description']));

								?>
									<option value="<?php echo $theselectedexpensetype; ?>" <?php echo ($selectexpensetype == $theselectedexpensetype ? "selected" : ""); ?>>
										<?php echo $row_expensehead['description']; ?>
									</option>

								<?php
									$k++;
								} //End If Result Test	
								?>
							</select>

						</td>
					</tr>
					<tr>
						<td>
							<b>Select Payment Mode:</b>
						</td>
						<td>

							<select name="pmtmode" class="table_text1" id="pmtmode" onChange="javascript: hidebankboxorshow();;">
								<option value=1>Cash </option>
								<option value=2 selected>Bank</option>
							</select>

						</td>
						<td>
							<b>Select Bank</b>
						</td>
						<td>

							<?php
							$k = 0;
							?>
							<select name="selectbank" id="selectbank" style="display:block;">
								<option value=""></option>
								<?php

								while ($k < $count_bank) {
									$row_bank = mysqli_fetch_array($result_bank);
									$theselectedbank = trim($row_bank['bank_code']) . "*" . str_replace("&", "and", trim($row_bank['bank_name']));
								?>
									<option value="<?php echo $theselectedbank; ?>" <?php echo ($selectbank == $theselectedbank ? "selected" : ""); ?>>
										<?php echo $theselectedbank; ?>
									</option>

								<?php
									$k++;
								} //End If Result Test	
								?>
							</select>

						</td>
					</tr>
					<tr>
						<td>
							<b> Teller Date:</b>
						</td>
						<td>
							<input type="date" name="dd_date" id="dd_date" value="<?php echo $dd_date; ?>" style="display:block;">
						</td>
						<td>
							<b> Teller No:</b>
						</td>
						<td>
							<input type="text" name="dd_no" id="dd_no" value="<?php echo $dd_no; ?>" style="display:block;">
						</td>
					</tr>



					<tr>
						<td>
							<b>Payment Naration:</b>
						</td>
						<td colspan="3">
							<input style="width:400px;" type="text" name="descriptn" id="descriptn" value="<?php echo $descriptn; ?>">
						</td>


					</tr>
					<tr>


						<td align="left">
							<b> Date:</b>
						</td>
						<td>
							<input type="date" name="pmtdate" id="pmtdate" value="<?php echo $pmtdate; ?>">
						</td>

						<td align="left">
							<b> Amount:</b>
						</td>
						<td>
							<input type="text" name="amount" id="amount" value="<?php echo $amount; ?>">
						</td>
					</tr>
					<tr>

						<td colspan="3">

							<input type="button" name="savebutton" id="submit-button" value="Save" onclick="savepayment();" />

						</td>
						<td>

							<?php $calledby = 'generalexpenditure';
							$reportid = 62;
							include("specificreportlink.php");  ?>

						</td>
					</tr>

				</table>
			</div>

		<?php } ?>
	</form>
	<br />

	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('finance.php?','page');
				">

	<br />
</div>

<script>
	function hidebankboxorshow() {
		var pmtmode = document.getElementById('pmtmode').value;
		var bank = document.getElementById('selectbank');
		var dd_date = document.getElementById('dd_date');
		var dd_no = document.getElementById('dd_no');

		if (Number(pmtmode == 1)) {
			bank.style.display = "none";
			dd_date.style.display = "none";
			dd_no.style.display = "none";
		} else {
			bank.style.display = "block";
			dd_date.style.display = "block";
			dd_no.style.display = "block";
		}


	}

	function savepayment() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_custno = $('#vendorno').val();
			$form_address1 = $('#address1').val();
			var $form_company = $('#company').val();
			var $form_dd_no = $('#dd_no').val();
			var $form_exprefno = $('#exprefno').val();
			var $form_pmtmode = $('#pmtmode').val();
			var $form_selectbank = $('#selectbank').val();
			var $form_dd_date = $('#dd_date').val();
			var $form_pmtdate = $('#pmtdate').val();
			var $form_amount = $('#amount').val();
			var $form_descriptn = $('#descriptn').val();
			var $form_email = $('#email').val();
			var $selectexpensetype = $('#expenstype').val();


			var $goahead = 1;

			if ($form_custno == '') {
				$goahead = $goahead * 0;
				alert("Please select a Vendor");
			}

			if ($selectexpensetype == '') {
				$goahead = $goahead * 0;
				alert("Please select an Expense Head");
			}

			if (Number($form_pmtmode) == 2) {

				if ($form_selectbank == '') {
					$goahead = $goahead * 0;
					alert("Please specify the Bank Name");

				}

				if ($form_dd_no == '') {
					$goahead = $goahead * 0;
					alert("Please specify the Bank Teller Refernce");
				}

				if ($form_dd_date == '') {
					$goahead = $goahead * 0;
					alert("Please specify the Bank Teller Date");
				}

			}

			if (Number($form_amount) == 0) {
				$goahead = $goahead * 0;
				alert("Please specify the Amount");
			}


			if ($form_pmtdate == '') {
				$goahead = $goahead * 0;
				alert("Please specify the Date of Payment");
			}


			if ($form_descriptn == '') {
				$goahead = $goahead * 0;
				alert("Please say something about the Payment");
			}

			if ($goahead == 1) {
				getpage('generalexpenditure.php?op=saving&vendorno=' + $form_custno +
					'&company=' + $form_company +
					'&dd_no=' + $form_dd_no + '&exprefno=' + $form_exprefno + '&pmtmode=' + $form_pmtmode + '&selectbank=' + $form_selectbank +
					'&dd_date=' + $form_dd_date + '&pmtdate=' + $form_pmtdate + '&amount=' + $form_amount + '&email=' + $form_email +
					'&address1=' + $form_address1 + '&descriptn=' + $form_descriptn + '&selectexpensetype=' + $selectexpensetype, 'page');
			}

		}
	}
</script>