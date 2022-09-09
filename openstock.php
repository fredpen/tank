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
		
		$datefield = "a.opendate";
		$custnofield = "";
		$salespsnfield = "";
		$itemfield ="trim(a.item)";
		$loccdfield = "trim(a.loccd)";
		$vendornofield ="";
		$po_field ="";
		
		
		$periodmonthfield = "";
		$periodyearfield = "";
		include "reportcondition.php";
		
			$query = "SELECT  a.*,b.itemdesc FROM openstock a, icitem b  ".
						" WHERE trim(a.item) = trim(b.item)".
							$holdadditionalwhereclause . " ORDER BY  STR_TO_DATE(a.opendate, '%d/%m/%Y') desc  ";


		
		
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
		<h3><strong>Inventory Historic Onhand</strong></h3>
		<h3><strong>Reporting from <?php echo $startdate;?> &nbsp; to  <?php echo $enddate;?> </strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Date</th>
									<th   class="Odd">Product</th>
									<th   class="Odd">Location</th>
									<th   class="Odd">Onhand</th>
									<th   class="Odd">WIP Onhand</th>
									<th   class="Odd">Useable Onhand</th>
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
										<td  ><?php echo trim($row['opendate']);?></td>
										<td  ><?php echo trim($row['item'])."-".trim($row['itemdesc']);?></td>
										<td  ><?php echo trim($row['loccd'])."-".trim($row['subloc']);?></td>
										<td   align="right"><?php echo number_format($row['onhand'],2);?></td>
										<td   align="right"><?php echo number_format($row['wiponhand'],2);?></td>
										<td   align="right"><?php echo number_format($row['useable_onhand'],2);?></td>
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