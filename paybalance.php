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
			

			$query = "SELECT  a.refno, a.custno, a.descriptn, a.bank_code, a.dd_no, a.dd_date, a.amount, a.amtused, a.pmtdate, ".
				 " (select company from arcust where trim(arcust.custno) = trim(a.custno)) company ".
				 " ,(select bank_name from bank where trim(bank.bank_code) = trim(a.bank_code)) bank_name FROM payments a  ".
				" WHERE 1 = 1  " .
						$holdadditionalwhereclause . " ORDER BY a.pmtdate desc";
			
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			$numrows = mysqli_num_rows($result);
			
			

		?>		
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">

		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		 
		<div id="print_table">
		<h3><strong>Customer Payment Instruments </strong></h3> 
		<h3><strong>Reporting from <?php echo $startdate;?> &nbsp; to  <?php echo $enddate;?> </strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Customer Name</th>
									<th   class="Odd">Receipt No:</th>
									<th   class="Odd">Description</th>
									<th   class="Odd">Bank</th>
									<th   class="Odd">Bank Ref</th>
									<th   class="Odd">DD/TT Date</th>
									<th   class="Odd">Amount</th>
									<th   class="Odd">Amount Used</th>
									<th   class="Odd">Balance</th>
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
										<td  ><?php echo substr(trim($row["company"]),0,20);?></td>
										<td  ><?php echo $row['refno'];?></td>
										<td  ><?php echo $row["descriptn"];?></td>
										<td  ><?php echo substr($row["bank_name"],0,12);?></td>
										<td  ><?php echo $row["dd_no"];?></td>
										<td  ><?php echo $row["dd_date"];?></td>
										<td   align="right"><?php echo number_format($row["amount"],2);?></td>
										<td   align="right"><?php echo number_format($row["amtused"],2);?></td>
										<td   align="right"><?php echo number_format($row["amount"] - $row["amtused"],2);?></td>
										<td  ></td>
									</tr>
							<?php 
									//} //End For Loop
								} //End If Result Test	
							?>
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