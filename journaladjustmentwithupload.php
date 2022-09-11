<?php
ob_start();
include_once "session_track.php";
?>


<div align="center" id="data-form">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form').hide();">
	<?php
	require_once("lib/mfbconnect.php");
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/dynamic_search.js"></script>
	<style>
		td {
			padding: 1px;
		}
	</style>

	<form action="" method="POST" id="form1" enctype="multipart/form-data">
		<h3><strong>Upload Journal Entries</strong></h3>
		<?php
		if ($_SESSION['directjournal'] == 1) {
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";
			$branch_code = "";
			$periodyear = $_SESSION['periodyear'];
			$periodmonth = $_SESSION['periodmonth'];
			$reqst_by = $_SESSION['username_sess'];

			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);

			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];


			$item_count = !isset($_REQUEST['item_count']) ? 0 : $_REQUEST['item_count'];

			$account_var  = array();
			$populate_journal_var  = array();


			$chartcodeDescription = array();

			$chartcodeArray = array();
			$creditArray = array();
			$debitArray = array();
			$ddArray = array();
			$mmtArray = array();
			$yyyyArray = array();

			$journalentryid = !isset($_REQUEST['journalentryid']) ? "" : $dbobject->test_input($_REQUEST['journalentryid']);

			$journaldate = !isset($_REQUEST['journaldate']) ? date('Y-m-d') : $dbobject->test_input($_REQUEST['journaldate']);

			$explanation = !isset($_REQUEST['explanation']) ? "" : $dbobject->test_input($_REQUEST['explanation']);

			$selectaccount = !isset($_REQUEST['selectaccount']) ? '' : $dbobject->test_input($_REQUEST['selectaccount']);


			// obtain next refno
			if ($journalentryid == '') {
				$query_clear = "delete from uploadjournalworkarea where 1=1 ";

				$result_clear = mysqli_query($_SESSION['db_connect'], $query_clear);

				$next_refno = 1;
				$check_refno = 1;

				$transdate = date("d/m/Y H:i:s");
				$refnoday = substr($transdate, 0, 2);
				$refnomonth = substr($transdate, 3, 2);
				$refnoyear = substr($transdate, 6, 4);

				$journalentryid =  "JO" . $refnoday . $refnomonth . $refnoyear . $next_refno;

				while ($check_refno == 1) {
					//check if the reference has been used before
					$sql_checkjournal = "select * from directjournalmaster where trim(journalentryid) = '$journalentryid'";
					//echo $sql_checkjournal;
					$result_checkjournal = mysqli_query($_SESSION['db_connect'], $sql_checkjournal);
					$count_checkjournal = mysqli_num_rows($result_checkjournal);
					if ($count_checkjournal > 0) {
						$next_refno++;
						$journalentryid =  "JO" . $refnoday . $refnomonth . $refnoyear . $next_refno;
					} else {
						$check_refno = 0;
					}
				}
			}




			$sql_account = "select distinct * from chart_of_account order by description";
			$result_account = mysqli_query($_SESSION['db_connect'], $sql_account);
			$count_account = mysqli_num_rows($result_account);
			$account_var_count = $count_account;

			$k = 0;
			while ($k < $count_account) {
				$row = mysqli_fetch_array($result_account);
				$account_var[$k]['chartcode'] = $row['chartcode'];
				$account_var[$k]['description'] = $row['description'];

				$k++;
			}



			$count_populate_journal = 0;
			$hold_totaldebit = 0;
			$hold_totalcredit = 0;
			if ($op == 'myAddAcountExcel') {
				$query_populate_journal = "select * from uploadjournalworkarea where 1=1 ";

				$result_populate_journal = mysqli_query($_SESSION['db_connect'], $query_populate_journal);
				$count_populate_journal = mysqli_num_rows($result_populate_journal);

				$k = 0;
				while ($k < $count_populate_journal) {
					$row = mysqli_fetch_array($result_populate_journal);
					$populate_journal_var[$k]['chartcode'] = $row['chartcode'];
					$populate_journal_var[$k]['description'] = $row['description'];
					$populate_journal_var[$k]['debit'] = $row['debit'];
					$populate_journal_var[$k]['credit'] = $row['credit'];
					$populate_journal_var[$k]['dd'] = $row['dd'];
					$populate_journal_var[$k]['mm'] = $row['mm'];
					$populate_journal_var[$k]['yyyy'] = $row['yyyy'];

					$hold_totaldebit = $hold_totaldebit + $row['debit'];
					$hold_totalcredit = $hold_totalcredit + $row['credit'];
					$k++;
				}
			}

			if ($op == 'searchkeyword') {
				if (trim($keyword) != '') {

					$sql_request = "select *  from chart_of_account where trim(chartcode) = '$keyword'";
					$result_request = mysqli_query($_SESSION['db_connect'], $sql_request);
					$count_request = mysqli_num_rows($result_request);

					if ($count_request >= 1) {
						$row = mysqli_fetch_array($result_request);
						$chartcode = $row['chartcode'];
						$description = $row['description'];

						$selectaccount = trim($row['chartcode']) . "*  " . trim($row['description']);
						//echo $selectvendor;
					} else {
						$selectaccount = '';
		?>
						<script>
							$('#item_error').html("<strong>Chart does not exist</strong>");
						</script>
					<?php
					}
				}
			}

			if ($op == 'savejournal') {
				$saverecord = 1;

				//check if the reference has been used before
				$sql_checkreceipt = "select * from directjournalmaster where trim(journalentryid) = '$journalentryid'";
				//echo $sql_checkreceipt;
				$result_checkreceipt = mysqli_query($_SESSION['db_connect'], $sql_checkreceipt);
				$count_checkreceipt = mysqli_num_rows($result_checkreceipt);

				if ($count_checkreceipt >= 1) {
					$saverecord = 0;
					?>
					<script>
						$('#item_error').html("<strong>This Document Reference already exist</strong>");
					</script>
					<?php
				}

				//get the items

				//echo "item count ".$item_count;
				for ($i = 0; $i < $item_count; $i++) {

					$chartcodeArray[$i] = $_REQUEST['chartcode' . $i];
					$creditArray[$i] = $_REQUEST['credit' . $i];
					$debitArray[$i] = $_REQUEST['debit' . $i];
					$ddArray[$i] = $_REQUEST['dd' . $i];
					$mmArray[$i] = $_REQUEST['mm' . $i];
					$yyyyArray[$i] = $_REQUEST['yyyy' . $i];


					//check if account is valid

					$sql_getaccount = "select * from chart_of_account where trim(chartcode) = '" . $chartcodeArray[$i] . "'";
					//echo "<br />".$sql_getaccount;
					$result_getaccount = mysqli_query($_SESSION['db_connect'], $sql_getaccount);
					$count_getaccount = mysqli_num_rows($result_getaccount);
					if ($count_getaccount > 0) {
						$row       = mysqli_fetch_array($result_getaccount);
						$chartcodeDescription[$i]    = $row['description'];
					} else {
						$saverecord = 0;
					?>
						<script>
							$('#item_error').html("<strong>Atleast One of the Accounts is not Valid</strong>");
						</script>
					<?php
					}
				}

				//$target_dir = $_SERVER['DOCUMENT_ROOT']."/tmpfolder/";
				$source_dir = $_SESSION['tmp_target_dir'];
				$source_file = $source_dir . md5($journalentryid) . ".pdf";
				$source_picture_file = $source_dir . md5($journalentryid) . ".jpg";

				//$target_dir = $_SERVER['DOCUMENT_ROOT']."/documents/";
				$target_dir = $_SESSION['target_dir'];
				$target_file = $target_dir . md5($journalentryid) . ".pdf";
				$target_picture_file = $target_dir . md5($journalentryid) . ".jpg";

				$supportdoc = '';
				if (!(file_exists($source_file) || file_exists($source_picture_file))) {
					$saverecord = 0;
					?>
					<script>
						$('#item_error').html("<strong>Please Verify Supporting Document</strong>");
					</script>
				<?php
				}
				$thefileextention = '';
				if (file_exists($source_file)) {
					$thefileextention = 'pdf';
					$supportdoc = md5($journalentryid) . ".pdf";
				}
				if (file_exists($source_picture_file)) {
					$thefileextention = 'jpg';
					$supportdoc = md5($journalentryid) . ".jpg";
				}


				if ($saverecord == 1) {
					$journaldate_to_save = substr($journaldate, 8, 2) . '/' . substr($journaldate, 5, 2) . '/' . substr($journaldate, 0, 4);




					$journalamount = 0;
					for ($i = 0; $i < $item_count; $i++) {
						$ddArray[$i] = (trim(strlen($ddArray[$i])) == 1) ? "0" . $ddArray[$i] : $ddArray[$i];
						$mmArray[$i] = (trim(strlen($mmArray[$i])) == 1) ? "0" . $mmArray[$i] : $mmArray[$i];

						$journaldatedetl = $ddArray[$i] . "/" . $mmArray[$i] . "/" . $yyyyArray[$i];

						$sql_directjournaldetl = " insert into directjournaldetl (  
								journalentryid,  chartcode , description,credit,debit,journaldatedetl) 
								values ('$journalentryid' , '" . $chartcodeArray[$i] . "' , '" . $chartcodeDescription[$i] . "' , " . $creditArray[$i] . ", " . $debitArray[$i] . ",'$journaldatedetl'  ) ";

						$result_directjournaldetl = mysqli_query($_SESSION['db_connect'], $sql_directjournaldetl);


						$sql_journal = "insert into journal 
												( transdate, themodule, acctno, acctdescription, subacctno, subacctdescription, cr_amount, dr_amount, periodmonth, periodyear) 
												values ( '$journaldatedetl' , 'DIRECTJOURNAL'  ,'" . $chartcodeArray[$i] . "', 
															'" . $chartcodeDescription[$i] . "', '' , 'DIRECT JOURNAL $journalentryid' ,  
															" . $creditArray[$i] . "," . $debitArray[$i] . " ,  '$periodmonth','$periodyear' )	";

						$result_journal = mysqli_query($_SESSION['db_connect'], $sql_journal);

						$journalamount = $journalamount + $creditArray[$i];
					}

					$sql_directjournalmaster = " insert into directjournalmaster (  
							journalamount,journalentryid , journaldate ,  transby , 
							transdate,  explanation ,periodmonth,periodyear,supportdoc)  
							values ($journalamount,'$journalentryid' , '$journaldate_to_save' , '$reqst_by' ,
							'" . date('d/m/Y H:i:s A') . "' , '$explanation', '$periodmonth','$periodyear',
							'$supportdoc' ) ";

					$result_directjournalmaster = mysqli_query($_SESSION['db_connect'], $sql_directjournalmaster);

					if ($thefileextention == 'pdf') {
						if (copy($source_file, $target_file)) {
							unlink($source_file);
						}
					}


					if ($thefileextention == 'jpg') {
						if (copy($source_picture_file, $target_picture_file)) {
							unlink($source_picture_file);
						}
					}


					$dbobject->apptrail($reqst_by, 'Direct Journal Entry', $journalentryid, date('d/m/Y H:i:s A'), 'Created');

					echo "<h3>The Journal Entry Reference Number is <b>$journalentryid</b></h3>";
				?>
					<script>
						$('#item_error').html("<strong>The Transaction was saved </strong>");
					</script>
			<?php

				}
			}




			?>
			<input type="hidden" name="periodmonth" id="periodmonth" value="<?php echo $periodmonth; ?>" />
			<input type="hidden" name="periodyear" id="periodyear" value="<?php echo $periodyear; ?>" />
			<input type="hidden" name="lpo_no" id="lpo_no" value="<?php echo $journalentryid; ?>">

			<input type="hidden" name="get_file" id="get_file" value="journaladjustmentwithupload" />
			<input type="hidden" name="thetablename" id="thetablename" value="chartofaccount" />



			<?php $itemsincart = ''; ?>
			<div id="items_in_cart">
				<?php for ($c = 0; $c < $count_populate_journal; $c++) { ?>
					<input type="hidden" id="<?php echo 'chartcode' . $c . $populate_journal_var[$c]['chartcode']; ?>" name="<?php echo 'chartcode' . $c . $populate_journal_var[$c]['chartcode']; ?>" value="<?php echo $populate_journal_var[$c]['chartcode']; ?>" />
					<input type="hidden" id="<?php echo 'description' . $c . $populate_journal_var[$c]['chartcode']; ?>" name="<?php echo 'description' . $c . $populate_journal_var[$c]['chartcode']; ?>" value="<?php echo $populate_journal_var[$c]['description']; ?>" />
					<input type="hidden" id="<?php echo 'debit' . $c . $populate_journal_var[$c]['chartcode']; ?>" name="<?php echo 'debit' . $c . $populate_journal_var[$c]['chartcode']; ?>" value="<?php echo $populate_journal_var[$c]['debit']; ?>" />
					<input type="hidden" id="<?php echo 'credit' . $c . $populate_journal_var[$c]['chartcode']; ?>" name="<?php echo 'credit' . $c . $populate_journal_var[$c]['chartcode']; ?>" value="<?php echo $populate_journal_var[$c]['credit']; ?>" />
					<input type="hidden" id="<?php echo 'dd' . $c . $populate_journal_var[$c]['chartcode']; ?>" name="<?php echo 'dd' . $c . $populate_journal_var[$c]['chartcode']; ?>" value="<?php echo $populate_journal_var[$c]['dd']; ?>" />
					<input type="hidden" id="<?php echo 'mm' . $c . $populate_journal_var[$c]['chartcode']; ?>" name="<?php echo 'mm' . $c . $populate_journal_var[$c]['chartcode']; ?>" value="<?php echo $populate_journal_var[$c]['mm']; ?>" />
					<input type="hidden" id="<?php echo 'yyyy' . $c . $populate_journal_var[$c]['chartcode']; ?>" name="<?php echo 'yyyy' . $c . $populate_journal_var[$c]['chartcode']; ?>" value="<?php echo $populate_journal_var[$c]['yyyy']; ?>" />

				<?php
					$itemsincart = $itemsincart . $c . $populate_journal_var[$c]['chartcode']  . '*';
				} ?>


			</div>
			<input type="hidden" id="itemsincart" value="<?php echo $itemsincart; ?>" />


			<div style="overflow-x:auto;">
				<table border="0" style="border:1px solid black;border-collapse:separate;border-radius:15px">
					<tr>
						<td colspan="4" style="color:red;" id="item_error" align="left"></td>
					</tr>
					<tr>
						<td>
							<b>Reference</b>
						</td>
						<td><input type="text" name="journalentryid" id="journalentryid" value="<?php echo $journalentryid; ?>" readonly> </td>
						<td align="right">
							<b>Date</b>
						</td>
						<td><input type="date" name="journaldate" id="journaldate" value="<?php echo $journaldate; ?>"> </td>

					</tr>


					<tr>
						<td>
							<b>Explanation:</b>
						</td>
						<td colspan="3"> <textarea cols="50%" id="explanation" name="explanation"><?php echo $explanation; ?></textarea>

						</td>

					</tr>
				</table>
				<br />


				<table border="0" style="border:1px solid black;padding:10px;border-collapse:separate;border-radius:15px">

					<tr>
						<td>
							<p id="size"><b>Upload From Excel </b></p>
						</td>
						<td colspan="2" align="left">
							<input type="file" name="fileToUploadexcel" id="fileToUploadexcel" accept=".csv,.xls,.xlsx" onchange="pickexcelfile()">
						</td>
						<td align="center">
							<div style="overflow-x:auto;" id="confirmuploadexcel"></div>

						</td>

					</tr>
					<tr>
						<td align="center" colspan="2">
							<?php
							//$target_dir = $_SERVER['DOCUMENT_ROOT']."/documents/";
							//$target_dir = $_SESSION['target_dir'];
							$target_dir = 'documents/';
							$filepath = $target_dir . 'directjournaltemplate.xlsx';

							if (file_exists($filepath)) { ?>
								<a href="<?php echo $filepath; ?> " rel="noopener noreferrer" target="_blank">Download Excel Template</a>

							<?php
							}
							?>
						</td>
						<td align="center" colspan="2">
							<table>
								<tr>
									<td><input type="button" name="addaccount" id="submit-button" title="Populate with Verified File" value="Populate" onclick="myAddAcountExcel();"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>



			</div>
			<br>
			<div style=" overflow-x:auto;">
				<table border="0">
					<thead>
						<tr class="right_backcolor">
							<td class="Corner">&nbsp;</td>
							<td class="Odd"><b>Number of Records</b> </td>
							<td class="Odd">
								<input type="text" style="width:40px;background:transparent;border:none;" tabindex="-1" id="no_accountsincart" value=<?php echo $count_populate_journal; ?> readonly />
							</td>
							<td class="Odd"><b>Total Debit</b></td>
							<td class="Odd">
								<input type="text" style="width:150px;background:transparent;border:none;" tabindex="-1" id="hold_totaldebit" value=<?php echo $hold_totaldebit; ?> readonly />
							</td>
							<td class="Odd"><b>Total Credit</b></td>
							<td class="Odd">
								<input type="text" style="width:150px;background:transparent;border:none;" tabindex="-1" id="hold_totalcredit" value=<?php echo $hold_totalcredit; ?> readonly />
							</td>
							</td>
							<td>&nbsp;</td>
						</tr>
					</thead>

				</table>
			</div>
			<div style="max-height:150px;overflow-y:auto; overflow-x:auto;">
				<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="productlistTable">


					<tr class="right_backcolor">
						<th nowrap="nowrap" class="Corner">&nbsp;</th>
						<th nowrap="nowrap" class="Odd">Acount Code</th>
						<th nowrap="nowrap" class="Odd">Description</th>
						<th nowrap="nowrap" class="Odd">Debit</th>
						<th nowrap="nowrap" class="Odd">Credit</th>

						<th nowrap="nowrap">&nbsp;</th>
					</tr>

					<?php for ($c = 0; $c < $count_populate_journal; $c++) { ?>
						<tr id="<?php echo $c . $populate_journal_var[$c]['chartcode']; ?>">
							<td nowrap="nowrap">&nbsp;</td>
							<td>
								<?php echo $populate_journal_var[$c]['chartcode']; ?>
							</td>
							<td>
								<?php echo $populate_journal_var[$c]['description']; ?>
							</td>
							<td>
								<?php echo $populate_journal_var[$c]['debit']; ?>
							</td>
							<td>
								<?php echo $populate_journal_var[$c]['credit']; ?>
							</td>
							<td>
								<input type="button" title="Remove" id="<?php echo 'but' . $c . $populate_journal_var[$c]['chartcode']; ?>" onclick="myremoveitemExcel(this.id);" value="X" />
							</td>
						</tr>
					<?php
					} ?>

				</table>
			</div>
			<br>
			<table>
				<tr>
					<td>
						<p id="size"><b>Supporting Document </b></p>
					</td>
					<td colspan="2" align="left">
						<input type="file" name="fileToUpload" id="fileToUpload" accept="image/*,.pdf" onchange="Filevalidation()">
					</td>
					<td align="center">
						<div style="overflow-x:auto;" id="confirmupload"></div>

					</td>

				</tr>

				<tr>


					<td align="right" nowrap="nowrap">

						<input type="button" name="savebutton" id="submit-button" value="Save Journal" onclick="mysavefunctionExcel()">

					</td>




					<td colspan="3" nowrap="nowrap">

						<?php $calledby = 'journaladjustmentwithupload';
						$reportid = 78;
						include("specificreportlink.php");  ?>

					</td>
					<td align="right">
						<a href="javascript:getpage('lookupreport.php?calledby=journaladjustmentwithupload&reportname=journaladjustment','page')">List Transactions</a>
					</td>
				</tr>

			</table>



			<div style="overflow-x:auto;" id="imagePreview"></div>
			<div style="overflow-x:auto;" id="excelPreview"></div><br>
			<div id="preview"></div><br>


		<?php } ?>
	</form>
	<br />

	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('glmodule.php','page');
				">

	<br />
</div>

<script>
	function pickexcelfile() {
		var fi = document.getElementById('fileToUploadexcel');

		document.getElementById('confirmuploadexcel').innerHTML =
			'<input type="submit" name="addaccountexcel" id="submit-button" title="Confirm that the selected file is your choice" formtarget="_blank" value ="Verify Doc" formaction="<?php echo $_SESSION['applicationbase'] . 'excelUpload.php'; ?>"/>';


	}

	function myAddAcountExcel() {
		var $form_explanation = $('#explanation').val();
		var $form_journalentryid = $('#journalentryid').val();


		getpagestring = "";
		getpagestring = 'journaladjustmentwithupload.php?op=myAddAcountExcel';


		getpagestring = getpagestring + '&explanation=' + $form_explanation + '&journalentryid=' + $form_journalentryid;



		//alert('the getpage string '+getpagestring);

		getpage(getpagestring, 'page');

	}



	function myremoveitemExcel(clicked) {

		if (confirm('Are you sure of this action?')) {

			var therowid = clicked.substring(3);
			var row = document.getElementById(therowid);
			row.parentNode.removeChild(row);


			var thehiddenaccounttextbox = document.getElementById('chartcode' + therowid);
			var thehiddendescriptiontextbox = document.getElementById('description' + therowid);
			var thehiddencreditamounttextbox = document.getElementById('credit' + therowid);
			var thehiddendebitamounttextbox = document.getElementById('debit' + therowid);
			var thehiddenddtextbox = document.getElementById('dd' + therowid);
			var thehiddenmmtextbox = document.getElementById('mm' + therowid);
			var thehiddenyyyytextbox = document.getElementById('yyyy' + therowid);

			alert(thehiddenaccounttextbox.value + ' ' + thehiddendescriptiontextbox.value + ' Removed');

			thehiddenaccounttextbox.parentNode.removeChild(thehiddenaccounttextbox);
			thehiddendescriptiontextbox.parentNode.removeChild(thehiddendescriptiontextbox);
			thehiddenddtextbox.parentNode.removeChild(thehiddenddtextbox);
			thehiddenmmtextbox.parentNode.removeChild(thehiddenmmtextbox);
			thehiddenyyyytextbox.parentNode.removeChild(thehiddenyyyytextbox);





			var addeditems = document.getElementById("itemsincart");
			var thevalue = addeditems.value;


			var newvalue = thevalue.replace(therowid + '*', '');
			//alert('new value '+newvalue);
			addeditems.value = newvalue;



			//substract from total credit or debit
			var add_to_totalcredit = document.getElementById("hold_totalcredit");
			var add_to_totaldebit = document.getElementById("hold_totaldebit");

			//alert('credit '+add_to_totalcredit.value + ' minus '+thehiddencreditamounttextbox.value+ ' compare '+Number(add_to_totalcredit.value) + ' minus '+ Number(thehiddencreditamounttextbox.value));
			//alert('debit '+add_to_totaldebit.value + ' minus '+thehiddendebitamounttextbox.value+ ' compare '+Number(add_to_totaldebit.value) + ' minus ' +Number(thehiddendebitamounttextbox.value));

			var tcredit = Number(add_to_totalcredit.value) - Number(thehiddencreditamounttextbox.value);
			add_to_totalcredit.value = tcredit.toFixed(2);
			var tdebit = Number(add_to_totaldebit.value) - Number(thehiddendebitamounttextbox.value);
			add_to_totaldebit.value = tdebit.toFixed(2);

			thehiddencreditamounttextbox.parentNode.removeChild(thehiddencreditamounttextbox);
			thehiddendebitamounttextbox.parentNode.removeChild(thehiddendebitamounttextbox);

			//deduct from number of items in cart
			var item_count = document.getElementById("no_accountsincart");

			item_count.value = Number($('#no_accountsincart').val()) - 1;
		}
	}



	function mysavefunctionExcel() {

		if (confirm('Are you sure the entries are correct?')) {

			var $goahead = 1;
			//check active period
			var $form_periodyear = $('#periodyear').val();
			var $form_periodmonth = $('#periodmonth').val();
			//var $form_journaldate = Date.parse($('#journaldate').val());
			var $form_journaldate = $('#journaldate').val();

			//var today = new Date();

			var $thisday = $form_journaldate.substring(8, 10);
			var $thismonth = $form_journaldate.substring(5, 7);


			var $thisyear = $form_journaldate.substring(0, 4);



			if (Number($form_periodyear) != Number($thisyear) || Number($form_periodmonth) != Number($thismonth)) {
				alert('Date is not within the current period');
				$goahead *= 0;
			}

			//alert($form_periodyear);
			//obtain total requested cost
			var $form_totalcredit = $('#hold_totalcredit').val();
			var $form_totaldebit = $('#hold_totaldebit').val();



			if (Number($form_totalcredit) != Number($form_totaldebit)) {
				alert('Debit and Credit Balances do not tally');
				$goahead *= 0;
			}



			var $form_explanation = $('#explanation').val();

			if (Number($form_explanation.length) == 0) {
				alert('Explanation Not Specified');
				$goahead *= 0;
			}




			var $form_journalentryid = $('#journalentryid').val();


			if ($form_journalentryid == '') {
				$goahead *= 0;
				alert('Reference Document Not Provided');

			}




			if ($goahead == 1) {
				//prepare to save 
				//determine how many products are in the cart
				var item_count = document.getElementById("no_accountsincart").value;

				//obtain the items in the cart
				var theitemsincart = document.getElementById("itemsincart").value;
				//split to individual products
				const myArrayOfItems = theitemsincart.split("*");

				//obtain chartcode and qtyreq pair
				var productstring = '';
				for (i = 0; i < item_count; i++) {
					//alert(myArrayOfItems[i]);
					var chartcode = document.getElementById('chartcode' + myArrayOfItems[i]).value;
					var credit = document.getElementById('credit' + myArrayOfItems[i]).value;
					var debit = document.getElementById('debit' + myArrayOfItems[i]).value;
					var dd = document.getElementById('dd' + myArrayOfItems[i]).value;
					var mm = document.getElementById('mm' + myArrayOfItems[i]).value;
					var yyyy = document.getElementById('yyyy' + myArrayOfItems[i]).value;


					//alert('The quantity'+theqty);
					productstring = productstring + '&chartcode' + i + '=' + chartcode + '&credit' + i + '=' + credit + '&debit' + i + '=' + debit + '&dd' + i + '=' + dd + '&mm' + i + '=' + mm + '&yyyy' + i + '=' + yyyy;
				}
				//alert('Account String '+productstring);

				getpagestring = 'journaladjustmentwithupload.php?op=savejournal';


				getpagestring = getpagestring + '&explanation=' + $form_explanation + '&journaldate=' + $form_journaldate;

				getpagestring = getpagestring + '&journalentryid=' + $form_journalentryid;
				getpagestring = getpagestring + '&item_count=' + item_count;
				getpagestring = getpagestring + productstring;

				//alert('the getpage string '+getpagestring);

				getpage(getpagestring, 'page');


			} else {
				alert('Cannot Save This Transaction');
			}

		}
	}


	function Filevalidation() {
		const fi = document.getElementById('fileToUpload');
		// Check if any file is selected.
		if (fi.files.length > 0) {
			for (i = 0; i <= fi.files.length - 1; i++) {

				const fsize = fi.files.item(i).size;
				const file = Math.round((fsize / 1024));
				document.getElementById('size').innerHTML = '<b>Supporting Document </b>';
				// The size of the file.
				if (file >= 4096) {
					alert(
						"File too Big, please select a file less than 4mb");
				} else if (file < 1) {
					alert(
						"File too small, please select a file greater than 1kb");
				} else {
					document.getElementById('size').innerHTML = '<b>Supporting Document ' +
						file + '</b> KB';

					var filePath = fi.value;
					// Allowing file type
					var allowedExtensions =
						/(\.jpg|\.jpeg|\.png|\.gif)$/i;

					if (!allowedExtensions.exec(filePath)) {
						// Allowing file type
						var allowedExtensions =
							/(\.pdf)$/i;
						document.getElementById('imagePreview').innerHTML = '';
						document.getElementById('confirmupload').innerHTML = '';
						if (!allowedExtensions.exec(filePath)) {
							alert('Invalid file type');
							fi.value = '';

							return false;
						} else {
							document.getElementById('confirmupload').innerHTML =
								'<input type="submit" name="Acceptfile" id="submit-button" title="Confirm that the selected file is your choice" formtarget="_blank" value ="Verify Doc" formaction="<?php echo $_SESSION['applicationbase'] . 'scan.php'; ?>"/>';
						}
					} else {

						// Image preview
						if (fi.files && fi.files[0]) {
							var reader = new FileReader();
							reader.onload = function(e) {
								document.getElementById(
										'confirmupload').innerHTML =
									'<input type="submit" name="Acceptfile" id="submit-button" formtarget="_blank" value ="Verify Doc" formaction="<?php echo $_SESSION['applicationbase'] . 'scan.php'; ?>"/> <br />';
								document.getElementById(
										'imagePreview').innerHTML =
									'<img width="95%" src="' + e.target.result +
									'"/>';
							};

							reader.readAsDataURL(fi.files[0]);
						}
					}



				}
			}
		}
	}
</script>