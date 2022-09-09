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
		
		$datefield = "";
		$custnofield = "";
		$salespsnfield = "";
		$itemfield ="";
		$loccdfield = "";
		$vendornofield ="trim(a.vendorno)";
		$po_field ="";
		
		$periodmonthfield = "";
		$periodyearfield = "";
		include "reportcondition.php";
		
			$query = "SELECT  a.*,b.country FROM vendors a left outer join countries b on trim(a.alpha3code) = trim(b.alpha3code) WHERE 1=1 " .
						$holdadditionalwhereclause . " ORDER BY a.vendorno ";
			
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			$numrows = mysqli_num_rows($result);
			
			

		?>		
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		
		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		 
		<div id="print_table">
		<h3><strong><font size="10"> Vendor List</font></strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Vendor</th>
									<th   class="Odd">Address</th>
									<th   class="Odd">Country</th>
									<th   class="Odd">Contact Person</th>
									<th   class="Odd">Email</th>
									<th   class="Odd">Phone</th>
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
										<td  ><?php echo trim($row["vendorno"]) ."-" . trim($row["company"]);?></td>
										<td  ><?php echo trim($row['address1']) . " " . trim($row['address2']) ;?></td>
										<td  ><?php echo trim($row['country']) ;?></td>
										<td  ><?php echo trim($row["contactperson"]);?></td>
										<td  ><?php echo trim($row["email"]);?></td>
										<td  ><?php echo trim($row["phone"]);?></td>
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