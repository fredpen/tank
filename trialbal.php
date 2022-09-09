<?php 
	ob_start();
	include_once "session_track.php";
	
	include "printheader.php";
?>

<style>
	table {
		  border-collapse: collapse;
		}
	@media screen {
			td {padding:5px;}
			.tableb {border-radius: 15px 50px; border-collapse: separate;border : 5px solid olive;}
			
			#print_table {
				display:none;
			}
	}
	
	@media print{
			#print, #head-inner,#smoothmenu1, .tableb, .noprint, .PrintButton{
				display:none;
			}
			#print_table {
				display:block;
			}
		
			
		}
</style>

<div align ="center" id="data-form" > 

	<?php 
		
		include "basicparameters.php";	
		
		$datefield = "a.transdate";
		$custnofield = "";
		$salespsnfield = "";
		$itemfield ="";
		$loccdfield = "";
		$vendornofield ="";
		$po_field ="";
		
		$periodmonthfield = "";
		$periodyearfield = "";
		include "reportcondition.php";
			
		$query = "select a.acctno, a.acctdescription, SUM(a.cr_amount) cr_amount,  sum(a.dr_amount) dr_amount from journal a WHERE 1 = 1 " .
						$holdadditionalwhereclause . " group by TRIM(a.acctno), a.acctdescription order by a.acctno  ";			
		
		$query_summary = "select a.acctno, a.acctdescription, SUM(a.cr_amount) cr_amount,  sum(a.dr_amount) dr_amount from journal a WHERE 1 = 1 " .
						$holdadditionalwhereclause . " group by TRIM(a.acctno), a.acctdescription order by a.acctno  ";
			
			
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			$result_summary = mysqli_query($_SESSION['db_connect'],$query_summary);
			
			$numrows = mysqli_num_rows($result);
			$numrows_summary = mysqli_num_rows($result_summary);
			
			$summary_dr_amount = 0;
			$summary_cr_amount = 0;
			
			if ($numrows_summary > 0)
			{
				$kk = 0;
				while($kk<$numrows_summary ) 
				{
					$kk++;
					//for($i=0; $i<$numrows; $i++){
					$row = mysqli_fetch_array($result_summary);
					$drdr = $row['dr_amount']>$row['cr_amount']? $row['dr_amount']-$row['cr_amount']:0;
					$summary_dr_amount = $summary_dr_amount + $drdr ;
					$crcr = $row['dr_amount']<$row['cr_amount']? $row['cr_amount']-$row['dr_amount']:0;
					$summary_cr_amount = $summary_cr_amount + $crcr ; 
				}
			}					
			
		?>		
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		
		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		 
		<div id="print_table">
		<h3><strong>Trial Balance</strong></h3>
		<h3><strong>Reporting from <?php echo $startdate;?> &nbsp; to  <?php echo $enddate;?> </strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Account</th>
									<th   class="Odd"></th>
									<th   class="Odd">Debit</th>
									<th   class="Odd">Credit</th>
									<th  >&nbsp;</th>
								</tr>
							</thead>
							<?php 
								
								$k = 0;
			  
						  
								while($k< $numrows) 
								{
									$k++;
									//for($i=0; $i<$numrows; $i++){
									$row = mysqli_fetch_array($result);
									//while($i < $skip) continue;
									//echo 'count '.$i.'   '.$skip;	
								//}
							?>
							
									<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
										<td  >&nbsp;</td>
										<td  ><?php echo $k;?></td>
										<td  >&nbsp;<?php echo trim($row["acctdescription"]);?></td>
										<td  >&nbsp;<?php echo trim($row["acctno"]);?></td>
										<td   align="right">&nbsp;
											<?php echo $row['dr_amount']>$row['cr_amount']?number_format($row['dr_amount'] -$row['cr_amount'],2):0;?></td>
										<td   align="right">&nbsp;<?php 
											echo $row['cr_amount']>$row['dr_amount']?number_format($row['cr_amount'] -$row['dr_amount'],2):0;?></td>
										<td  ></td>
									</tr>
							<?php 
									//} //End For Loop
								} //End If Result Test	
							?>
							<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
								<td  >&nbsp;</td>
								<td  ><?php echo $k;?></td>
								<td  ><strong></strong></td>
								<td  ><strong>Total</strong></td>
								<td   align="right">&nbsp;<strong><?php echo number_format($summary_dr_amount,2);?></strong></td>
								<td   align="right" >&nbsp;<strong><?php echo number_format($summary_cr_amount,2);?></strong></td>
								<td  ></td>
							</tr>
							
						</table>
					
				</td>
			</tr>
			
			</table>
			</div>
			
	</form>
</div>

<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
	document.addEventListener("DOMContentLoaded",function(){PrintPage();});
		
</script>