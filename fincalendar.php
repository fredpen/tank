<?php
ob_start();
include_once "session_track.php";
?>


<div align="center" id="data-form_rptheader">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="X" onclick="javascript:  $('#data-form_rptheader').hide();">
<!--	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form_rptheader').hide();">-->

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
				Financial Calendar
			</strong></h3>
		</p>
		<?php
		if ($_SESSION['glmasters'] == 1) {

			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";


			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$sysuserid = !isset($_SESSION['username_sess']) ? '' : $_SESSION['username_sess'];

			$periodyear = !isset($_REQUEST['periodyear']) ? $_SESSION['periodyear'] : trim($_REQUEST['periodyear']);

			if ($op == 'closeopenyear') {
				$goahead = 1;

				if (trim($periodyear) == '') {
					$goahead = 0;
		?>
					<script>
						$('#item_error').html("<strong>Please specify the Year</strong>");
					</script>
				<?php }


				//					***check if acctyear exist
				$sql_finperiod_check = " select * from financialperiod where acctyear    = '$periodyear' ";
				$result_finperiod_check = mysqli_query($_SESSION['db_connect'], $sql_finperiod_check);
				$count_finperiod_check = mysqli_num_rows($result_finperiod_check);
				if ($count_finperiod_check == 0) {

					$goahead = 0;
				?>
					<script>
						$('#item_error').html("<strong>Calendar Year Does Not Exist ....</strong>");
					</script>
				<?php


				}




				//save if all is ok
				if ($goahead == 1) {

					$row = mysqli_fetch_array($result_finperiod_check);
					if ($row['periodstatus'] == 0) {
						$periodstatustxt = 'Closed';
						$periodstatus = 1;
					} else {
						$periodstatustxt = 'Opened';
						$periodstatus = 0;
					}


					$sql_updateyear =	" update  financialperiod  set periodstatus = $periodstatus where acctyear    = '$periodyear' ";

					$result_updateyear = mysqli_query($_SESSION['db_connect'], $sql_updateyear);


					$dbobject->apptrail($sysuserid, 'Financial Calendar', $periodyear, date('d/m/Y H:i:s A'), $periodstatustxt);

				?> <script>
						$('#item_error').html("<strong>Financial Year Status Modified Successfully.</strong>");
					</script> <?php

							}
						}


						if ($op == 'addyear') {
							$goahead = 1;

							if (trim($periodyear) == '') {
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

								$goahead = 0;
				?>
					<script>
						$('#item_error').html("<strong>Calendar Year already Exist ....</strong>");
					</script>
				<?php


							}




							//save if all is ok
							if ($goahead == 1) {


								$transdate = date('d/m/Y H:s:i');

								$sql_addyear =	" insert into  financialperiod  (acctyear, periodstatus,addedby,added_date)  
									 values ('$periodyear',0,'$sysuserid','$transdate') ";

								$result_addyear = mysqli_query($_SESSION['db_connect'], $sql_addyear);


								$dbobject->apptrail($sysuserid, 'Financial Calendar', $periodyear, date('d/m/Y H:i:s A'), 'Added');

				?> <script>
						$('#item_error').html("<strong>Financial Year Added Successfully.</strong>");
					</script> <?php

							}
						}
						//****			
						$sql_fincalendar = "select acctyear, IF(periodstatus=0,'Opened','Closed') PeriodStatus from financialperiod order by acctyear desc";
						$result_fincalendar = mysqli_query($_SESSION['db_connect'], $sql_fincalendar);
						$count_fincalendar = mysqli_num_rows($result_fincalendar);

								?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />

			<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">

				<tr>
					<td colspan="2" style="color:red;" id="item_error" align="left"></td>
				</tr>
				<tr>

					<td align="right">
						<input type="text" name="periodyear" size="4" id="periodyear" value="<?php echo $periodyear; ?>" />
					</td>
					<td>
						<input type="button" name="addyear" id="submit-button" value="Add Year" onclick="javascript: my_addyear();">
					</td>
				</tr>
				<tr>

					<td colspan="2">
						<?php $calledby = 'fincalendar';
						$reportid = 65;
						include("specificreportlink.php");  ?>
					</td>

				</tr>
			</table>
			<div style="height: 150px; overflow-y: auto">
				<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
					<tr>
						<td colspan="2" align="center"><b>Calendar Year and Status</b></td>

					</tr>
					<?php
					$k = 0;


					while ($k < $count_fincalendar) {
						$row_fincalendar = mysqli_fetch_array($result_fincalendar);
					?>
						<tr>

							<td>
								<?php echo $row_fincalendar['acctyear'] . " " . $row_fincalendar['PeriodStatus']; ?>
							</td>
							<td>
								<input type="button" name="<?php echo $row_fincalendar['acctyear']; ?>" id="submit-button" value="<?php if ($row_fincalendar['PeriodStatus'] == 'Closed') {
																																		echo 'Open Year';
																																	} else {
																																		echo 'Close Year';
																																	} ?>" onclick="javascript: my_closeopenyear(<?php echo $row_fincalendar['acctyear']; ?>);">
							</td>
						</tr>
					<?php
						$k++;
					} //End If Result Test	
					?>
				</table>
			</div>

		<?php } ?>
	</form>
	<br />
	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('glmodule.php?','page');" />
	<br />
</div>

<script>
	function my_addyear() {
		if (confirm('Are you sure the entries are correct?')) {
			var $goahead = 1;
			var $form_periodyear = $('#periodyear').val();
			if ($form_periodyear == '') {
				$goahead *= 0;
				alert('The Year Not Provided');

			}

			if ($goahead == 1) {
				getpage('fincalendar.php?op=addyear&periodyear=' + $form_periodyear, 'page');
			}
		}
	}


	function my_closeopenyear(theyear) {
		if (confirm('Are you sure the entries are correct?')) {
			var $goahead = 1;
			var $form_periodyear = theyear;
			if ($form_periodyear == '') {
				$goahead *= 0;
				alert('The Year Not Provided');

			}

			if ($goahead == 1) {
				getpage('fincalendar.php?op=closeopenyear&periodyear=' + $form_periodyear, 'page');
			}
		}
	}
</script>