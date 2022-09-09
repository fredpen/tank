<?php 
	ob_start();
	include_once "session_track.php";
?>


<div align ="center" id="data-form" > 
	<input type="button" name="closebutton" id="submit-button" title="Close"  value="Close" onclick="javascript:  $('#data-form').hide();">	

	<?php 
		require_once("lib/mfbconnect.php"); 
	?>



	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong><font size='12'>General Ledger Posting </font></strong></h3>
		<?php
			if ($_SESSION['glposting']==1){
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";
			
			
			$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
			$recalculated_summary_dr_amount = !isset($_REQUEST['recalculated_summary_dr_amount'])?0:$_REQUEST['recalculated_summary_dr_amount'];
			$recalculated_summary_cr_amount = !isset($_REQUEST['recalculated_summary_cr_amount'])?0:$_REQUEST['recalculated_summary_cr_amount'];
			$ledger_summary_dr_amount = !isset($_REQUEST['ledger_summary_dr_amount'])?0:$_REQUEST['ledger_summary_dr_amount'];
			$ledger_summary_cr_amount = !isset($_REQUEST['ledger_summary_cr_amount'])?0:$_REQUEST['ledger_summary_cr_amount'];
			$genledger_summary_dr_amount = !isset($_REQUEST['genledger_summary_dr_amount'])?0:$_REQUEST['genledger_summary_dr_amount'];
			$genledger_summary_cr_amount = !isset($_REQUEST['genledger_summary_cr_amount'])?0:$_REQUEST['genledger_summary_cr_amount'];
			
		
			$count_ledger = !isset($_REQUEST['count_ledger'])?0:$_REQUEST['count_ledger'];
			$count_recalculatedjournal = !isset($_REQUEST['count_recalculatedjournal'])?0:$_REQUEST['count_recalculatedjournal'];
			
			
			$periodyear = !isset($_REQUEST['periodyear'])?$_SESSION['periodyear']:trim($_REQUEST['periodyear']);
			$periodmonth = !isset($_REQUEST['periodmonth'])?$_SESSION['periodmonth']:trim($_REQUEST['periodmonth']);
			
			if($op=='post_to_gl'){
				$sql_post_to_gl = "call Post_to_GL('$periodmonth', '$periodyear' ) ";
				$result_post_to_gl = mysqli_query($_SESSION['db_connect'],$sql_post_to_gl);
				//echo $sql_post_to_gl;
				?>
					<script>
					
					$('#item_error').html("<strong>Posting to General Ledger Concluded.</strong>");
					</script>
				<?php	
				$pulldata='yes';
			}
			
			
				$QueryStmt_recalculatedjournal = "select * FROM journal WHERE  trim(periodmonth) = '$periodmonth' 
							and trim(periodyear) =  '$periodyear'  order by str_to_date(transdate,'%d/%m/%Y') desc ";

	
				//echo "<br/>".$QueryStmt_refresh_journal;
				$result_recalculatedjournal = mysqli_query($_SESSION['db_connect'],$QueryStmt_recalculatedjournal);
				$count_recalculatedjournal = mysqli_num_rows($result_recalculatedjournal);
					
	
								
				
				$QueryStmt_recalculatedjournal_summary = "select sum(cr_amount) cr_amount, sum(dr_amount) dr_amount
								FROM journal WHERE  trim(periodmonth) = '$periodmonth' 
											and trim(periodyear) =  '$periodyear'  ";

				$result_recalculatedjournal_summary = mysqli_query($_SESSION['db_connect'],$QueryStmt_recalculatedjournal_summary);
				$count_recalculatedjournal_summary = mysqli_num_rows($result_recalculatedjournal_summary);
				
				
				$QueryStmt_generatedledger = "select acctno , acctdescription , IF(cr_amount>dr_amount,cr_amount-dr_amount,0) cr_amount,
					IF(dr_amount>cr_amount,dr_amount-cr_amount,0) dr_amount,periodyear  ,periodmonth from 
					(select  acctno , acctdescription , SUM(cr_amount) as cr_amount, 
						SUM(dr_amount) as dr_amount , periodyear  ,periodmonth FROM journal  WHERE  trim(periodmonth) = '$periodmonth' 
							and trim(periodyear) =  '$periodyear' GROUP BY acctno, acctdescription, periodyear  ,periodmonth order by acctdescription ) gensum order by acctdescription";

	
				//echo "<br/>".$QueryStmt_refresh_journal;
				$result_generatedledger = mysqli_query($_SESSION['db_connect'],$QueryStmt_generatedledger);
				$count_generatedledger = mysqli_num_rows($result_generatedledger);
					
	
								
				
				$QueryStmt_generatedledger_summary = "select sum(cr_amount) cr_amount, sum(dr_amount) dr_amount
								FROM 
								( select acctno , acctdescription , IF(cr_amount>dr_amount,cr_amount-dr_amount,0) cr_amount,
									IF(dr_amount>cr_amount,dr_amount-cr_amount,0) dr_amount,periodyear  ,periodmonth 
									from 
									(select  acctno , acctdescription , SUM(cr_amount) as cr_amount, 
										SUM(dr_amount) as dr_amount , periodyear  ,periodmonth FROM journal  WHERE  trim(periodmonth) = '$periodmonth' 
											and trim(periodyear) =  '$periodyear' GROUP BY acctno, acctdescription, periodyear  ,periodmonth order by acctdescription ) gensum) gensummary ";

				$result_generatedledger_summary = mysqli_query($_SESSION['db_connect'],$QueryStmt_generatedledger_summary);
				$count_generatedledger_summary = mysqli_num_rows($result_generatedledger_summary);				
				
				
				$QueryStmt_ledger = "select * FROM ledger WHERE  trim(periodmonth) = '$periodmonth' and trim(periodyear) =  '$periodyear' order by acctdescription";
				
				//echo $QueryStmt_ledger;
				$result_ledger = mysqli_query($_SESSION['db_connect'],$QueryStmt_ledger);
				$count_ledger = mysqli_num_rows($result_ledger);
				
				//$ledger_var = mysqli_fetch_all($result_ledger,MYSQLI_ASSOC);
				//$_SESSION['ledger_var'] = $ledger_var;
				
				$QueryStmt_ledger_summary = "select sum(cr_amount) cr_amount, sum(dr_amount) dr_amount 
					FROM ledger WHERE  trim(periodmonth) = '$periodmonth' and trim(periodyear) =  '$periodyear' ";
				
				$result_ledger_summary = mysqli_query($_SESSION['db_connect'],$QueryStmt_ledger_summary);
				$count_ledger_summary = mysqli_num_rows($result_ledger_summary);
				
				
				
				if ($count_ledger > 0)
				{
					$row_ledger_summary = mysqli_fetch_array($result_ledger_summary);
					$ledger_summary_dr_amount = $row_ledger_summary['dr_amount'];
					$ledger_summary_cr_amount = $row_ledger_summary['cr_amount'];
				}
				
				if ($count_generatedledger > 0)
				{
					$row_genledger_summary = mysqli_fetch_array($result_generatedledger_summary);
					$genledger_summary_dr_amount = $row_genledger_summary['dr_amount'];
					$genledger_summary_cr_amount = $row_genledger_summary['cr_amount'];
				}
				
				if ($count_recalculatedjournal > 0)
				{
					$row_recalculated_summary = mysqli_fetch_array($result_recalculatedjournal_summary);
					$recalculated_summary_dr_amount = $row_recalculated_summary['dr_amount'];
					$recalculated_summary_cr_amount = $row_recalculated_summary['cr_amount'];
				}

				
			
					
			
	

		?>
		
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="count_ledger" id="count_ledger" value="<?php echo $count_ledger; ?>" />
		<input type="hidden" name="count_recalculatedjournal" id="count_recalculatedjournal" value="<?php echo $count_recalculatedjournal; ?>" />
		<input type="hidden" name="recalculated_summary_dr_amount" id="recalculated_summary_dr_amount" value="<?php echo $recalculated_summary_dr_amount; ?>" />
		<input type="hidden" name="recalculated_summary_cr_amount" id="recalculated_summary_cr_amount" value="<?php echo $recalculated_summary_cr_amount; ?>" />
		<input type="hidden" name="ledger_summary_dr_amount" id="ledger_summary_dr_amount" value="<?php echo $ledger_summary_dr_amount; ?>" />
		<input type="hidden" name="ledger_summary_cr_amount" id="ledger_summary_cr_amount" value="<?php echo $ledger_summary_cr_amount; ?>" />
		
		<table>
			
			<tr>
				
				<td><b>Financial Period : </b>&nbsp;&nbsp;
					<select name="periodmonth" class="table_text1"  id="periodmonth" >
						<?php for ($i=1;$i<=12;$i++) {  ?>
							<option value="<?php echo $i; ?>" <?php echo ($periodmonth==$i?"selected":""); ?>><?php echo $i; ?></option>
						<?php } ?>
					</select>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<b>Financial Year : </b>&nbsp;&nbsp;<input type="text" size="5" name="periodyear" id="periodyear" value="<?php echo $periodyear; ?>" >
					
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" name="recalculate" id="submit-button" value="Refresh" 
							onclick="javascript:var $form_periodmonth = $('#periodmonth').val();var $form_preriodyear = $('#periodyear').val();
						 getpage('glposting.php?periodmonth='+$form_periodmonth+'&periodyear='+$form_preriodyear+'&pulldata=yes','page');">
					
					
				</td>
			</tr>
			
		</table>
		
		<br/>
		<table>
			<tr id="refreshledger" style="display:none" align="center">
				
				<td>
					<input type="button" name="post_to_gl" id="submit-button" value="Post to GL" 
							title="Click Post to GL if Generated is different from Posted Ledger Entries"
							onclick="javascript:
							if (confirm('Are you sure the entries are correct?')) {
							var $form_periodmonth = $('#periodmonth').val();var $form_preriodyear = $('#periodyear').val();
							getpage('glposting.php?op=post_to_gl&periodmonth='+$form_periodmonth+'&periodyear='+$form_preriodyear+'&pulldata=no','page');}" />
				
				</td>
			</tr>
			<tr>
				<td  style="color:red;" id = "item_error" align = "right"  ></td>
			</tr>
		</table>
			<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
				<tr >
					<td align="center">
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="displaywhat" id="journal" value="journal" checked
							onclick="javascript: refreshoption();"/>&nbsp;&nbsp;<b>Journal Entries</b>&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						&nbsp;&nbsp;<input type="radio" name="displaywhat" id="genledger" value="genledger" 
								onclick="javascript: refreshoption();"/>&nbsp;&nbsp;<b>Generated Ledger Entries</b>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;
					</td>
					<td>
						&nbsp;&nbsp;<input type="radio" name="displaywhat" id="ledger" value="ledger" 
								onclick="javascript: refreshoption();"/>&nbsp;&nbsp;<b>Posted Ledger Entries</b>
						&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
			</table>
			
		<div style="height: 300px; overflow-y: auto">
			<table border="1"  style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
				
				<tr id="journalrow" style="display:block" >
					<td>
						<b>Re-Calculated Journal Entries</b><br/>
						<table width="100%">
							<thead>
								<tr class="right_backcolor">
									<th nowrap="nowrap" class="Corner">&nbsp;</th>
									<th nowrap="nowrap" class="Corner">SN</th>
									
									<th nowrap="nowrap" class="Odd">Date</th>
									<th nowrap="nowrap" class="Odd">Chart Code</th>
									<th  class="Odd">Description</th>
									<th nowrap="nowrap" class="Odd">Credit</th>
									<th nowrap="nowrap" class="Odd">Debit</th>
									<th nowrap="nowrap">&nbsp;</th>
								</tr>
							</thead>
							
							<tr >
										<td nowrap="nowrap" colspan="3">&nbsp;</td>
										<td nowrap="nowrap"  colspan="2"><strong>Summary:</strong></td>
										<td nowrap="nowrap" align = "right" ><strong><?php echo number_format($recalculated_summary_cr_amount,2) ;?></strong></td>
										<td nowrap="nowrap" align = "right" ><strong><?php echo number_format($recalculated_summary_dr_amount,2)  ;?></strong></td>
										<td></td>
							</tr>
							
							
							<?php 
							
								$k = 0;
			  
						  
								while($k<$count_recalculatedjournal )
								{
									
									$row_QueryStmt = mysqli_fetch_array($result_recalculatedjournal); 
									
							?>
						
							<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
										<td nowrap="nowrap">&nbsp;</td>
										<td nowrap="nowrap"><?php echo $k+1 ;?></td>
										
										<td nowrap="nowrap"><?php echo $row_QueryStmt['transdate'] ;?></td>
										<td nowrap="nowrap"><?php echo $row_QueryStmt['acctno'] ;?></td>
										<td >&nbsp;<?php echo $row_QueryStmt['acctdescription'] ;?></td>
										<td nowrap="nowrap" align = "right" ><?php echo number_format(($row_QueryStmt["cr_amount"] ),2) ;?></td>
										<td nowrap="nowrap" align = "right" ><?php echo number_format($row_QueryStmt["dr_amount"],2)  ;?></td>
										<td></td>
							</tr>
							<?php 
									$k++;
								} 	
							?>
							
							<tr >
								<td nowrap="nowrap" colspan="3">&nbsp;</td>
								<td nowrap="nowrap"  colspan="2"><strong>Summary:</strong></td>
								<td nowrap="nowrap" align = "right" ><strong><?php echo number_format($recalculated_summary_cr_amount,2) ;?></strong></td>
								<td nowrap="nowrap" align = "right" ><strong><?php echo number_format($recalculated_summary_dr_amount,2)  ;?></strong></td>
								<td></td>
							</tr>
						</table>
				
					</td>
				</tr>
				
				<tr id="genledgerrow" style="display:none" >
					<td>
						<b>Generated Ledger Entries</b><br/>
						<table  width="100%">
							<thead>
								<tr class="right_backcolor">
									<th nowrap="nowrap" class="Corner">&nbsp;</th>
									<th nowrap="nowrap" class="Corner">SN</th>
									
									<th nowrap="nowrap" class="Odd">Chart Code</th>
									<th  class="Odd">Description</th>
									<th nowrap="nowrap" class="Odd">Credit</th>
									<th nowrap="nowrap" class="Odd">Debit</th>
									<th nowrap="nowrap">&nbsp;</th>
								</tr>
							</thead>
							
							<tr >
										<td nowrap="nowrap">&nbsp;</td>
										<td nowrap="nowrap">&nbsp;</td>
										
										<td nowrap="nowrap"><strong>&nbsp;</strong></td>
										<td nowrap="nowrap"><strong>Summary:</strong></td>
										<td nowrap="nowrap" align = "right" ><strong><?php echo number_format($genledger_summary_cr_amount,2) ;?></strong></td>
										<td nowrap="nowrap" align = "right" ><strong><?php echo number_format($genledger_summary_dr_amount,2)  ;?></strong></td>
										<td></td>
							</tr>
							
							
							<?php 
							
								$k = 0;
			  
						  
								while($k<$count_generatedledger )
								{
									
									$row_QueryStmt = mysqli_fetch_array($result_generatedledger); 
									
							?>
						
							<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
										<td nowrap="nowrap">&nbsp;</td>
										<td nowrap="nowrap"><?php echo $k+1 ;?></td>
										
										<td nowrap="nowrap"><?php echo $row_QueryStmt['acctno'] ;?></td>
										<td >&nbsp;<?php echo $row_QueryStmt['acctdescription'] ;?></td>
										<td nowrap="nowrap" align = "right" ><?php echo number_format($row_QueryStmt["cr_amount"] ,2) ;?></td>
										<td nowrap="nowrap" align = "right" ><?php echo number_format($row_QueryStmt["dr_amount"],2)  ;?></td>
										<td></td>
							</tr>
							<?php 
									$k++;
								} 	
							?>
							
							<tr >
									<td nowrap="nowrap">&nbsp;</td>
									<td nowrap="nowrap">&nbsp;</td>
									
									<td nowrap="nowrap"><strong>&nbsp;</strong></td>
									<td nowrap="nowrap"><strong>Summary:</strong></td>
									<td nowrap="nowrap" align = "right" ><strong><?php echo number_format($genledger_summary_cr_amount,2) ;?></strong></td>
									<td nowrap="nowrap" align = "right" ><strong><?php echo number_format($genledger_summary_dr_amount,2)  ;?></strong></td>
									<td></td>
							</tr>
						</table>
					</td>
				</tr>
				
				<tr id="ledgerrow" style="display:none" >
					<td>
						<b>Posted Ledger Entries</b><br/>
						<table  width="100%">
							<thead>
								<tr class="right_backcolor">
									<th nowrap="nowrap" class="Corner">&nbsp;</th>
									<th nowrap="nowrap" class="Corner">SN</th>
									
									<th nowrap="nowrap" class="Odd">Chart Code</th>
									<th  class="Odd">Description</th>
									<th nowrap="nowrap" class="Odd">Credit</th>
									<th nowrap="nowrap" class="Odd">Debit</th>
									<th nowrap="nowrap">&nbsp;</th>
								</tr>
							</thead>
							
							<tr >
										<td nowrap="nowrap">&nbsp;</td>
										<td nowrap="nowrap">&nbsp;</td>
										
										<td nowrap="nowrap"><strong>&nbsp;</strong></td>
										<td nowrap="nowrap"><strong>Summary:</strong></td>
										<td nowrap="nowrap" align = "right" ><strong><?php echo number_format($ledger_summary_cr_amount,2) ;?></strong></td>
										<td nowrap="nowrap" align = "right" ><strong><?php echo number_format($ledger_summary_dr_amount,2)  ;?></strong></td>
										<td></td>
							</tr>
							
							
							<?php 
							
								$k = 0;
			  
						  
								while($k<$count_ledger )
								{
									
									$row_QueryStmt = mysqli_fetch_array($result_ledger); 
									
							?>
						
							<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
										<td nowrap="nowrap">&nbsp;</td>
										<td nowrap="nowrap"><?php echo $k+1 ;?></td>
										
										<td nowrap="nowrap"><?php echo $row_QueryStmt['acctno'] ;?></td>
										<td >&nbsp;<?php echo $row_QueryStmt['acctdescription'] ;?></td>
										<td nowrap="nowrap" align = "right" ><?php echo number_format($row_QueryStmt["cr_amount"] ,2) ;?></td>
										<td nowrap="nowrap" align = "right" ><?php echo number_format($row_QueryStmt["dr_amount"],2)  ;?></td>
										<td></td>
							</tr>
							<?php 
									$k++;
								} 	
							?>
							
							<tr >
									<td nowrap="nowrap">&nbsp;</td>
									<td nowrap="nowrap">&nbsp;</td>
									
									<td nowrap="nowrap"><strong>&nbsp;</strong></td>
									<td nowrap="nowrap"><strong>Summary:</strong></td>
									<td nowrap="nowrap" align = "right" ><strong><?php echo number_format($ledger_summary_cr_amount,2) ;?></strong></td>
									<td nowrap="nowrap" align = "right" ><strong><?php echo number_format($ledger_summary_dr_amount,2)  ;?></strong></td>
									<td></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		
			<?php } ?>
	</form>
	<br />
	<input type="button" name="closebutton" id="submit-button" value="Back" 
											onclick="javascript:  getpage('glmodule.php?','page');" />
	<br />
</div>

<script>
	function refreshoption() 
	{
		var theradio = document.getElementsByName('displaywhat');
		var journalrow = document.getElementById('journalrow');
		var ledgerrow = document.getElementById('ledgerrow');
		var refreshledger = document.getElementById('refreshledger');
		
		ledgerrow.style.display = "none";
		journalrow.style.display = "none";
		genledgerrow.style.display = "none";
		refreshledger.style.display = "none";
		
		for(i = 0; i < theradio.length; i++) 
		{
			if(theradio[i].checked){
				if (i==0){
					journalrow.style.display = "block";
				}else if(i==1){
					genledgerrow.style.display = "block";
					refreshledger.style.display = "block";
				}
				
				else {
					ledgerrow.style.display = "block";
					
					
				}
			}
			
		}
    }

</script>