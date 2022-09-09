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
		
		$datefield = "a.expensdate";
		$custnofield = "";
		$salespsnfield = "";
		$itemfield ="";
		$loccdfield = "";
		$vendornofield ="";
		$po_field ="";
		
		
		$periodmonthfield = "";
		$periodyearfield = "";
		include "reportcondition.php";
		
			$query = "SELECT (select description from chart_of_account where trim(chartcode) = trim(a.expenstype)) as expenstype,1 AS advrefund1,a.exprefno ,a.descriptio ,a.expensdate, a.amount, a.bank_code, a.dd_no, a.pmtmode".
					"   FROM expense a WHERE 1=1 " .
						$holdadditionalwhereclause ;


		$datefield = "a.pmtdate";
		$custnofield = "";
		$salespsnfield = ")";
		$itemfield ="";
		$loccdfield = "";
		$vendornofield ="";
		$po_field ="";
		

		
		$periodmonthfield = "";
		$periodyearfield = "";
		include "reportcondition.php";
		
			$query = $query . " union SELECT concat('REFUND',SPACE(4)) AS expenstype,a.advrefund1,a.refno AS exprefno ,a.descriptn AS descriptio ,".
				" a.pmtdate AS expensdate, a.amount, a.bank_code, a.dd_no, a.pmtmode".
					 "   FROM payments a WHERE advrefund1=2 ".
						$holdadditionalwhereclause ;
		
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			$numrows = mysqli_num_rows($result);
			
			

		?>		
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css"  media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css"  media="screen">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		
		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		 
		<div id="print_table">
		<h3><strong><font size="10">General Expenditure </font></strong></h3>
		<h3><strong>Reporting from <?php echo $startdate;?> &nbsp; to  <?php echo $enddate;?> </strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Refno</th>
									<th   class="Odd">Description</th>
									<th   class="Odd">Expense Category</th>
									<th   class="Odd">Amount</th>
									<th   class="Odd">Date</th>
									<th   class="Odd">Pmt Mode</th>
									<th   class="Odd">Bank</th>
									<th   class="Odd">Teller</th>
									<th  >&nbsp;</th>
								</tr>
							</thead>
							<?php 
								
								$k = 0;
			  
								while($k<  $numrows ) 
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
										<td  ><?php echo $row['exprefno'];?></td>
										<td  ><?php echo trim($row["descriptio"]);?></td>
										<td  ><?php echo ($row["expenstype"]==null?"Vendor Payment":trim($row["expenstype"]));?></td>
										<td  ><?php echo number_format($row['amount'],2);?></td>
										<td  ><?php echo $row['expensdate'];?></td>
										<td  ><?php echo ($row['pmtmode']==1?'Cash':'Bank');?></td>
										<td  ><?php echo $row['bank_code'];?></td>
										<td  ><?php echo $row['dd_no'];?></td>
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