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
				Cash Receipts
			</strong></h3>
		<?php
		if ($_SESSION['payments'] == 1) {
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";

			$user = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$custno = !isset($_REQUEST['custno']) ? '' : $_REQUEST['custno'];
			$company = !isset($_REQUEST['company']) ? '' : $dbobject->test_input($_REQUEST['company']);
			$phone1 = !isset($_REQUEST['phone1']) ? '' : $dbobject->test_input($_REQUEST['phone1']);
			$address1 = !isset($_REQUEST['address1']) ? '' : $dbobject->test_input($_REQUEST['address1']);
			$selectbank = !isset($_REQUEST['selectbank']) ? '' : $dbobject->test_input($_REQUEST['selectbank']);
			$selectclient = !isset($_REQUEST['selectclient']) ? '' : $dbobject->test_input($_REQUEST['selectclient']);

			$roleid = !isset($_REQUEST['roleid']) ? 0 : $_REQUEST['roleid'];
			$refno = !isset($_REQUEST['refno']) ? '' : $_REQUEST['refno'];
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

			$sql_client = "select distinct * FROM arcust WHERE 1=1 order by company";
			$result_client = mysqli_query($_SESSION['db_connect'], $sql_client);
			$count_client = mysqli_num_rows($result_client);
			//echo "dd_no ".$dd_no;


			// obtain next refno
			$sql_const = "select recptno from const where 1=1";
			//echo $sql_const;
			$result_const = mysqli_query($db_connect, $sql_const);
			$count_const = mysqli_num_rows($result_const);

			$next_refno = 1;
			if ($count_const > 0) {
				$row = mysqli_fetch_array($result_const);
				if ($row['recptno'] == 99999) {
					$next_refno = 1;
				} else {
					$next_refno = $row['recptno'];
				}
			}

			$transdate = date("d/m/Y H:i:s");
			$refnoday = substr($transdate, 0, 2);
			$refnomonth = substr($transdate, 3, 2);
			$refnoyear = substr($transdate, 6, 4);

			$refno =  "Rcpt_" . $refnoday . $refnomonth . $refnoyear . $next_refno;
			$dd_no = !isset($_REQUEST['dd_no']) ? $refno : $_REQUEST['dd_no'];

			if ($op == 'getselectclient') {
				$filter = "";

				$sql_Q = "SELECT * FROM arcust where  ";
				$custno = '';
				if (trim($selectclient) <> '') {
					//echo $selectitem;
					$itemdetails = explode("*", $selectclient);
					$custno = $itemdetails[0];
				}

				$filter = "  upper(trim(custno)) = upper('$custno')  ";



				$orderby = "   ";
				$orderflag	= " ";
				$order = $orderby . " " . $orderflag;
				$sql_QueryStmt = $sql_Q . $filter . $order . " limit 1";

				//echo "<br/> sql_Q ".$sql_Q;	
				//echo "<br/>".$sql_QueryStmt."<br/>";
				$result_QueryStmt = mysqli_query($_SESSION['db_connect'], $sql_QueryStmt);
				$count_QueryStmt = mysqli_num_rows($result_QueryStmt);

				if ($count_QueryStmt >= 1) {
					$row       = mysqli_fetch_array($result_QueryStmt);
					$custno    = $row['custno'];
					$company   = $row['company'];
					$phone1 = $row['phone1'];
					$email = $row['email'];
					$address1  = $row['address1'];
					$selectclient = trim($row['custno']) . "*" . trim($row['company']);
				} else {
		?>
					<script>
						$('#item_error').html("<strong>Customer does not exist</strong>");
					</script>
				<?php
				}
			}

			if ($op == 'Searchcustno') {
				$sql_custno = "select *  from arcust where upper(" . trim($_REQUEST['fieldtosearch']) . ")  like upper('%" . trim($_REQUEST['lookfor']) . "%')";
				$result_custno = mysqli_query($_SESSION['db_connect'], $sql_custno);
				$count_custno = mysqli_num_rows($result_custno);
				if ($count_custno >= 1) {
					$row = mysqli_fetch_array($result_custno);
					$custno    = $row['custno'];
					$company   = $row['company'];
					$phone1 = $row['phone1'];
					$email = $row['email'];
					$address1  = $row['address1'];
					$selectclient = trim($row['custno']) . "*" . trim($row['company']);
				} else {
				?>
					<script>
						$('#item_error').html("<strong>Customer does not exist</strong>");
					</script>
				<?php
				}
			}




			if ($op == 'searchkeyword') {

				//echo "keyword ".$keyword . "<br/>";
				//echo "string length ".strlen($keyword) . "<br/>";
				$filter = "";
				$filter = " AND trim(custno) like '%$keyword%'   ";


				$sql_Q = "SELECT * FROM arcust where ";
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
					$custno    = $row['custno'];
					$company   = $row['company'];
					$phone1 = $row['phone1'];
					$email = $row['email'];
					$address1  = $row['address1'];
					$selectclient = trim($row['custno']) . "*" . trim($row['company']);
				} else {
				?>
					<script>
						$('#item_error').html("<strong>Customer does not exist</strong>");
					</script>
				<?php
				}
			}



			if ($op == 'saving') {
				//global $next_refno;
				$goahead = 1;



				if (trim($_REQUEST['custno']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Customer ID</strong>");
					</script>
					<?php }


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
				<?php }

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
					//generate refno or receipt number 



					//2021-07-15
					$pmtdatetosave = substr($pmtdate, 8, 2) . "/" . substr($pmtdate, 5, 2) . "/" . substr($pmtdate, 0, 4);
					$dd_datetosave = substr($dd_date, 8, 2) . "/" . substr($dd_date, 5, 2) . "/" . substr($dd_date, 0, 4);

					$LoopMore = 1;
					while ($LoopMore == 1) {
						$check_refno = "select * from payments where trim(refno) = '" . $refno . "'";
						$result_refno = mysqli_query($db_connect, $check_refno);
						$count_refno = mysqli_num_rows($result_refno);

						if ($count_refno > 0) {
							$LoopMore = 1;
							$next_refno++;
							$refno = "Rcpt_" . $refnoday . $refnomonth . $refnoyear . $next_refno;
						} else {
							$LoopMore = 0;
						}
					}

					$advrefund1 = 1;
					$transby = $user;
					$next_refno++;
					$sql_QueryStmt = "call postpayments('" . $refno .
						"', '" . $custno .
						"', '" . $descriptn .
						"', " . $advrefund1 .
						",  " . $pmtmode .
						", " . $amount .
						", '" . $transby .
						"', '" . $transdate .
						"', '" . $bank_code .
						"', '" . $dd_no .
						"', '" . $dd_datetosave .
						"', '" . $pmtdatetosave .
						"', '" . $_SESSION['periodmonth'] .
						"', '" . $_SESSION['periodyear'] .
						"',  " . $next_refno .  ") ";

					$result_QueryStmt = mysqli_query($_SESSION['db_connect'], $sql_QueryStmt);

					//echo $sql_QueryStmt;


					$savetrail = $dbobject->apptrail($_SESSION['username_sess'], 'Cash Receipt', $refno . " " . $company, date("d/m/Y h:i:s A"), 'Created');
					//update next receiptno 

					$ConstQuery =  "update const set recptno = " . $next_refno . " where 1=1";
					$result_ConstQuery = mysqli_query($db_connect, $ConstQuery);




					// send official receipt to Resident




					//email body
					$pmtstyle = $pmtmode == 2 ? "Bank" : "Cash";
					$amountinwords = number_format($amount, 2)  . " (" . $dbobject->convert_number_to_words($amount) . ")";
					$emailbody = "
							<table  id='myreport_title_table' style='border:1px solid black;padding:2px;border-collapse:separate;border-radius:15px'>
						
								<tr  >
									<td > 
										<table id='myreport_title_table' style='border:1px solid black;padding:2px;border-collapse:separate;border-radius:15px'> 
											<tr>
												<td  id='myreport_title_table' align='center' width='250'>
													<strong><h3>" . $_SESSION['corpaddr'] . "</h3> 
													Official Receipts<br>" .
						$_SESSION['telex']  . "<br/>" .
						$_SESSION['email'] . "<br/>" .
						$_SESSION['webaddress'] . " </strong>
												</td>
												<td>
													<p><strong>&nbsp;Receipt No &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;: </strong> $refno</p>
													<p><strong>&nbsp;Payment Date  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;: </strong>$pmtdate</p>
													<p><strong>&nbsp;Payment Mode  &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;: </strong>$pmtstyle</p>
													<p><strong>&nbsp;Payment Reference : </strong> $bank_code $dd_no</p>
														
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<p><strong>Customer : &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; </strong>$custno - $company </p>
										<p><strong>Address : </strong>$address1 </p>
										<p><strong>The Sum of :</strong> $amountinwords</p>
										<p><strong>Being for : </strong> $descriptn </p>
										<p><strong>Data Entry Officer : </strong> $transby &nbsp; &nbsp; Data Entry Date: $transdate</p>
										
									</td>
								</tr>
							</table>
						
						";
					//end of email body


					//check email is well formed before sending
					$emailok = 1;
					if (empty($email)) {
						$emailok = 0;
					} else {
						$email = $dbobject->test_input($email);
						if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

							$emailok = 0;
						}
					}

					if ($emailok == 1) {
						$to = $email;
						$subject = "Tank-Farm Payment Acknowledgement";
						$mailContent = "Dear $company , 
							<br/>This is an acknowledment of Payment.
							<br/><br/>$emailbody 
							<br/><br/>Regards,
							<br/>Teju Royal Gardens Finance Team.";
						//set content-type header for sending HTML email
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						//additional headers
						$headers .= 'From: Tank-Farm Online<no_replyt@.com.ng>' . "\r\n";
						//send email
						mail($to, $subject, $mailContent, $headers);
						echo "<br/><h3><b>Mail sent to " . $email . "</b></h3>";
					} else {
						echo "<br/><h3><b>Mail not sent to " . $email . "</b></h3>";
					}


					$custno    = '';
					$descriptn = '';
					$dd_no = '';
					$amount = 0;


					echo $emailbody . "<br/>";
				?>
					<script>
						$('#item_error').html("<strong>Official Receipt Generated</strong>");
					</script>
			<?php
				}
			}
			//****			


			?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="custno" id="custno" value="<?php echo $custno; ?>" />
			<input type="hidden" name="company" id="company" value="<?php echo $company; ?>" />
			<input type="hidden" name="bank_code" id="bank_code" value="<?php echo $bank_code; ?>" />

			<input type="hidden" name="address1" id="address1" value="<?php echo $address1; ?>" />
			<input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
			<input type="hidden" name="refno" id="refno" value="<?php echo $refno; ?>" />
			<input type="hidden" name="thetablename" id="thetablename" value="customer" />
			<input type="hidden" name="get_file" id="get_file" value="cshpayments" />
			<table border="0" style="padding:0px;">
				<tr>
					<td colspan="2" style="color:red;" id="item_error" align="left"></td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="input-group">
							<b>Search by: <i>Name or Code or Phone Number</i> </b>&nbsp;
							<input type="text" size="35px" id="search" placeholder="Search for Customer" />
							<input name="keyword" type="hidden" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />

						</div>
						<!-- Suggestions will be displayed in below div. -->

						<div id="display"></div>
					</td>

				</tr>

			</table>

			<div style="overflow-x:auto;">
				<table border="0">
					<tr>
						<td colspan="4">
							<h3><b>Customer ID : </b>&nbsp;&nbsp;<?php echo $custno; ?> &nbsp;&nbsp;&nbsp;&nbsp; <b>Name : </b>&nbsp;<?php echo $company; ?></h3>

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
							<input style="width:400px;" type="text" name="deccriptn" id="descriptn" value="<?php echo $descriptn; ?>">
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
							<?php $calledby = 'cshpayments';
							$reportid = 64;
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

			var $form_custno = $('#custno').val();
			$form_address1 = $('#address1').val();
			var $form_company = $('#company').val();
			var $form_dd_no = $('#dd_no').val();
			var $form_refno = $('#refno').val();
			var $form_pmtmode = $('#pmtmode').val();
			var $form_selectbank = $('#selectbank').val();
			var $form_dd_date = $('#dd_date').val();
			var $form_pmtdate = $('#pmtdate').val();
			var $form_amount = $('#amount').val();
			var $form_descriptn = $('#descriptn').val();
			var $form_email = $('#email').val();


			var $goahead = 1;

			if ($form_custno == '') {
				$goahead = $goahead * 0;
				alert("Please select a Customer");
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
				getpage('cshpayments.php?op=saving&custno=' + $form_custno +
					'&company=' + $form_company +
					'&dd_no=' + $form_dd_no + '&refno=' + $form_refno + '&pmtmode=' + $form_pmtmode + '&selectbank=' + $form_selectbank +
					'&dd_date=' + $form_dd_date + '&pmtdate=' + $form_pmtdate + '&amount=' + $form_amount + '&email=' + $form_email +
					'&address1=' + $form_address1 + '&descriptn=' + $form_descriptn, 'page');
			}

		}
	}
</script>