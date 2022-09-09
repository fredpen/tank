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
		
		$datefield = "a.invoice_dt";
		$custnofield = "trim(a.custno)";
		$salespsnfield = "";
		$itemfield ="trim(b.item)";
		$loccdfield = "";
		$vendornofield ="";
		$po_field ="";
		
		$periodmonthfield = "";
		$periodyearfield = "";
		include "reportcondition.php";
		
			$query = "SELECT  a.custno,a.ccompany,b.item,b.itemdesc, SUM(b.store_qty) AS quantity".
						" FROM invoice a,inv_detl b WHERE TRIM(a.slip_no) = TRIM(b.slip_no) " .
						$holdadditionalwhereclause . 
						" GROUP BY b.item,b.itemdesc, a.custno,a.ccompany ORDER BY b.item,  quantity desc";
			
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			$numrows = mysqli_num_rows($result);
			
			
		?>		
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		
		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		 
		<div id="print_table">
		<h3><strong>Customer Patronage Ranking (Details) </strong></h3>
		<h3><strong>Reporting from <?php echo $startdate;?> &nbsp; to  <?php echo $enddate;?> </strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Product</th>
									<th   class="Odd">Customer</th>
									<th   class="Odd">Quantity</th>
									<th   class="Odd">Rank</th>
									<th  >&nbsp;</th>
								</tr>
							</thead>
							<?php 
								
								$k = 0;
								$prevrank = 0;
								$prevpos = 0;
								$tie = 1;
								$ranking = 0;
								$prevqty = 0;
								$previtem = '';
								$currentitem = '';
								
								while($k< $numrows) 
								{
									$k++;
									
									$row = mysqli_fetch_array($result);
																		
									if ($previtem==trim($row['item']))
									{
										$currentitem = trim($row['item']);
										if ($prevqty == $row['quantity'])
										{
											$tie = $tie + 1;
										}else
										{
											$prevpos = $prevpos + $tie;
											$tie = 1;
											$prevqty = $row['quantity'];
										}
										if ($tie==1){$prevrank = $prevrank + 1;}
										
									}else 
									{
										$prevpos = 1;
										$prevrank = 1;
										$tie = 1;
										$prevqty = $row['quantity'];
										$previtem = trim($row['item']);
										
									}
									$ranking = $prevrank;
								
							?>
							
									<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
										<td  >&nbsp;</td>
										<td  ><?php echo $k;?></td>
										<td  ><?php echo ($previtem==$currentitem)?'':trim($row["item"]) ."-" . trim($row["itemdesc"]);?></td>
										<td  ><?php echo trim($row["custno"]) ."-" . trim($row["ccompany"]);?></td>
										<td   align="right"><?php echo  number_format($row["quantity"],2);?></td>
										<td   align="right"><?php echo $ranking ;?></td>
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