<?php
ob_start();
include_once "session_track.php";
?>


<div align="center" id="data-form_rptheader">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form_rptheader').hide();">

	<?php
	require_once("lib/mfbconnect.php");
	?>


	<style>
		td {
			padding: 5px;
		}
	</style>

	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<p>
		<h3><strong>
				Set Accounting Period
			</strong></h3>
		</p>
		<?php
		if ($_SESSION['glposting'] == 1) {

			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";


			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$sysuserid = !isset($_REQUEST['sysuserid']) ? '' : $_REQUEST['sysuserid'];
			$username = !isset($_REQUEST['username']) ? '' : $_REQUEST['username'];
			$roleid = !isset($_REQUEST['roleid']) ? 0 : $_REQUEST['roleid'];
			$email = !isset($_REQUEST['email']) ? '' : $_REQUEST['email'];
			$webpassword = !isset($_REQUEST['webpassword']) ? '' : $_REQUEST['webpassword'];
			$forgot_pass_identity = !isset($_REQUEST['forgot_pass_identity']) ? 0 : $_REQUEST['forgot_pass_identity'];

			$periodyear = !isset($_REQUEST['periodyear']) ? $_SESSION['periodyear'] : trim($_REQUEST['periodyear']);
			$periodmonth = !isset($_REQUEST['periodmonth']) ? $_SESSION['periodmonth'] : trim($_REQUEST['periodmonth']);

			$strtperiod = !isset($_REQUEST['strtperiod']) ? '' : trim($_REQUEST['strtperiod']);
			$endperiod = !isset($_REQUEST['endperiod']) ? '' : trim($_REQUEST['endperiod']);


			if ($op == 'setperiod') {
				$goahead = 1;
				if (trim($_REQUEST['periodmonth']) == '') {
					$goahead = 0;
		?>
					<script>
						$('#item_error').html("<strong>Please specify the Month</strong>");
					</script>
				<?php }
				if (trim($_REQUEST['periodyear']) == '') {
					$goahead = 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify the Year</strong>");
					</script>
					<?php }


				//					***check if acctyear exist
				$sql_finperiod_check = " select * from financialperiod where acctyear    = '" . trim($_REQUEST['periodyear']) . "' ";
				$result_finperiod_check = mysqli_query($_SESSION['db_connect'], $sql_finperiod_check);
				$count_finperiod_check = mysqli_num_rows($result_finperiod_check);
				if ($count_finperiod_check > 0) {
					$row_finperiod_check = mysqli_fetch_array($result_finperiod_check);
					$periodstatus = $row_finperiod_check['periodstatus'];
					if ($periodstatus == 1) {
						$goahead = 0;
					?>
						<script>
							$('#item_error').html("<strong>Calender Year is Closed ....Period Not Set ....</strong>");
						</script>
					<?php

					}
				} else {
					$goahead = 0;
					?>
					<script>
						$('#item_error').html("<strong>Calender does not exist ....</strong>");
					</script>
				<?php
				}



				$strtperiod_tosave = substr($strtperiod, 8, 2) . "/" . substr($strtperiod, 5, 2) . "/" . substr($strtperiod, 0, 4);
				$endperiod_tosave = substr($endperiod, 8, 2) . "/" . substr($endperiod, 5, 2) . "/" . substr($endperiod, 0, 4);

				if (substr($strtperiod, 5, 2) != $periodmonth) {
					$goahead = 0;
				?>
					<script>
						$('#item_error').html("<strong>Transaction date not within Period ....</strong>");
					</script>
				<?php
				}
				if (substr($strtperiod, 0, 4) != $periodyear) {
					$goahead = 0;
				?>
					<script>
						$('#item_error').html("<strong>Transaction date not within Period ....</strong>");
					</script>
				<?php
				}

				//save if all is ok
				if ($goahead == 1) {


					$sql_setpriod = " UPDATE const SET periodmonth = '$periodmonth',periodyear    = '$periodyear',
									strtperiod    = '$strtperiod_tosave', endperiod    = '$endperiod_tosave' where 1=1 ";

					//echo $sql_setpriod;
					$result_setperiod = mysqli_query($_SESSION['db_connect'], $sql_setpriod);

					$_SESSION['periodmonth'] = $periodmonth;
					$_SESSION['periodyear'] = $periodyear;

				?> <script>
						$('#item_error').html("<strong>Transaction Period Set Successfully.</strong>");
					</script> <?php

							}
						}
						//****			
						$sql_finperiod = "select strtperiod, endperiod from const ";
						$result_finperiod = mysqli_query($_SESSION['db_connect'], $sql_finperiod);
						$count_finperiod = mysqli_num_rows($result_finperiod);
						if ($count_finperiod > 0) {
							$row_finperiod = mysqli_fetch_array($result_finperiod);
							$strtperiod = $row_finperiod['strtperiod'];
							$endperiod = $row_finperiod['endperiod'];

							$thisday = substr($strtperiod, 0, 2);
							$thismth = substr($strtperiod, 3, 2);
							$thisY = substr($strtperiod, 6, 4);

							$strtperiod = $thismth . '/' . $thisday . '/' . $thisY;
							$newd = $thismth . '/' . $thisday . '/' . $thisY;
							$strtperiod = date('Y-m-d', strtotime($newd));

							$thisday = substr($endperiod, 0, 2);
							$thismth = substr($endperiod, 3, 2);
							$thisY = substr($endperiod, 6, 4);

							$endperiod = $thismth . '/' . $thisday . '/' . $thisY;
							$newd = $thismth . '/' . $thisday . '/' . $thisY;
							$endperiod = date('Y-m-d', strtotime($newd));
						}


								?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
				<tr>
					<td colspan="2" style="color:red;" id="item_error" align="left"></td>
				</tr>
				<tr>

					<td><b>Month : </b>&nbsp;&nbsp;
						<select name="periodmonth" class="table_text1" id="periodmonth">
							<?php for ($i = 1; $i <= 12; $i++) {  ?>
								<option value="<?php echo $i; ?>" <?php echo ($periodmonth == $i ? "selected" : ""); ?>><?php echo $i; ?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						<b>Year : </b>&nbsp;&nbsp;<input type="text" size="5" name="periodyear" id="periodyear" value="<?php echo $periodyear; ?>">

					</td>
				</tr>
				<tr>

					<td><b>Active Start Date:</b></td>
					<td><input type="date" name="strtperiod" id="strtperiod" value="<?php echo $strtperiod; ?>" /> </td>
				</tr>
				<tr>
					<td><b>Active End Date:</b></td>
					<td colspan><input type="date" name="endperiod" id="endperiod" value="<?php echo $endperiod; ?>" /> </td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="button" name="Setperiod" id="submit-button" value="Set Period" onclick="javascript:var $form_periodmonth = $('#periodmonth').val();var $form_preriodyear = $('#periodyear').val();
								var $form_strtperiod = $('#strtperiod').val();var $form_endperiod = $('#endperiod').val();
						 getpage('finperiod.php?op=setperiod&periodmonth='+$form_periodmonth+'&periodyear='+$form_preriodyear
								+'&strtperiod='+$form_strtperiod+'&endperiod='+$form_endperiod,'page');">
					</td>

				</tr>

			</table>
		<?php } ?>
	</form>
	<br />
	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('glmodule.php?','page');" />
	<br />
</div>