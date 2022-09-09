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
		

	
			$query = "select * from chart_of_account order by accounttype ";
			
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			$numrows = mysqli_num_rows($result);
			
		
		?>		
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css"  media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css"  media="screen">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		<h3 class= "noprint"><strong><font size='12'>Chart of Account</font></strong></h3>
		<a href="#" class="noprint" onclick="window.close();return false">Close Window</a>
		
		<div id="print_table">
		<h3><strong><font size='12'>Chart of Account </font></strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th nowrap="nowrap" class="Corner">&nbsp;</th>
									<th nowrap="nowrap" class="Odd">S/N</th>
									<th nowrap="nowrap" class="Odd">Chart Code</th>
									<th nowrap="nowrap" class="Odd">Description</th>
									<th nowrap="nowrap" class="Odd">Account Type</th>
									<th nowrap="nowrap" class="Odd">Statement Type</th>
									<th nowrap="nowrap">&nbsp;</th>
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
										<td nowrap="nowrap">&nbsp;</td>
										<td nowrap="nowrap"><?php echo $k;?></td>
										<td nowrap="nowrap"><?php echo $row['chartcode'];?></td>
										<td nowrap="nowrap"><?php echo $row["description"];?></td>
										<td nowrap="nowrap"><?php echo $row['accounttype'];?></td>
										<td nowrap="nowrap"><?php echo $row["financialstatement"];?></td>
										<td nowrap="nowrap"></td>
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