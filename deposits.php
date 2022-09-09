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
		
		$datefield = "a.pmtdate";
		$custnofield = "trim(a.custno)";
		$salespsnfield = "";
		$itemfield ="";
		$loccdfield = "";
		$vendornofield ="";
		$po_field ="";
		
		
		$periodmonthfield = "";
		$periodyearfield = "";
		include "reportcondition.php";
		
			$query = " SELECT b.custno,b.company, b.address1, b.address2 ,b.city,b.custbal, a.refno,a.descriptn,a.advrefund1,a.amount, ".
				" a.pmtmode, a.bank_code, a.dd_no, a.amtused,a.pmtdate FROM payments a, arcust b ".
				" WHERE trim(a.custno) = trim(b.custno)  " .
						$holdadditionalwhereclause . " ORDER BY a.custno,a.pmtdate ";
			
			$query_summary1 = " SELECT b.custno,b.company, b.address1, b.address2 ,b.city,b.custbal, a.refno,a.descriptn,a.advrefund1,a.amount, ".
				" a.pmtmode, a.bank_code, a.dd_no, a.amtused,a.pmtdate FROM payments a, arcust b ".
				" WHERE trim(a.custno) = trim(b.custno)  " .
						$holdadditionalwhereclause . " ORDER BY a.custno,a.pmtdate ";

			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			$numrows = mysqli_num_rows($result);
			
			$result_summary1 = mysqli_query($_SESSION['db_connect'],$query_summary1);
			$numrows_summary1 = mysqli_num_rows($result_summary1);

			$summary_income = 0;$summary_expense = 0;$summary_amtused = 0;
			if ($numrows_summary1 > 0){
				$k=0;
				while($k<$numrows_summary1) 
				{
					$k++;
					
					$row = mysqli_fetch_array($result_summary1);
					
					$holdvalue = $row['advrefund1']=='1'?$row["amount"]:0;
					$summary_income = $summary_income + $holdvalue;	
					$holdvalue = $row['advrefund1']=='2'?$row["amount"]:0 ;
					$summary_expense = $summary_expense	+ 	$holdvalue;	

					$summary_amtused = $summary_amtused	+ $row["amtused"];
				}
			}

			
		?>		
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		
		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		 
		<div id="print_table">
		<h3><strong>Statement of Acount (Deposits/Refunds)</strong></h3> 
		<h3><strong>Reporting from <?php echo $startdate;?> &nbsp; to  <?php echo $enddate;?> </strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Pmt Ref</th>
									<th   class="Odd">Pmt Date</th>
									<th   class="Odd">Customer</th>
									<th   class="Odd">Description</th>
									<th   class="Odd">Bank Ref</th>
									<th   class="Odd">Deposit</th>
									<th   class="Odd">Refund</th>
									<th   class="Odd">Amt Used</th>
									<th  >&nbsp;</th>
								</tr>
							</thead>
							<?php 
								
								$k = 0;
			  
								
						  
								while($k<$numrows) 
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
										<td  ><?php echo $row['refno'];?></td>
										<td  ><?php echo $row['pmtdate'];?></td>
										<td  ><?php echo trim($row["custno"]) ."-" . trim($row["company"]);?></td>
										<td  ><?php echo $row['descriptn'];?></td>
										<td  ><?php echo trim($row["bank_code"]);?></td>
										<td   align="right"><?php echo  number_format(($row['advrefund1']=='1'?$row["amount"]:0),2);?></td>
										<td   align="right"><?php echo  number_format(($row['advrefund1']=='2'?$row["amount"]:0),2);?></td>
										<td   align="right"><?php echo  number_format($row["amtused"],2);?></td>
										<td  ></td>
									</tr>
							<?php 
									//} //End For Loop
								} //End If Result Test	
							?>
							
									<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
										<td  >&nbsp;</td>
										<td  ></td>
										<td  ></td>
										<td  ></td>
										<td  ><strong>Summary :</strong></td>
										<td  ></td>
										<td  > </td>
										<td   align="right"><strong><?php echo number_format($summary_income,2);?></strong></td>
										<td   align="right"><strong><?php echo number_format($summary_expense,2);?></strong></td>
										<td  ><strong><?php echo number_format($summary_amtused,2);?></strong> </td>
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