<?php 
	ob_start();
	include_once "session_track.php";
?>


<style>
	td {padding:5px;}
	
</style>
<script type="text/javascript" src="js/dynamic_search_script.js"></script>
	<div align ="center" id="data-form_500" > 
	<input type="button" name="closebutton" id="submit-button" title="Close"  value="Close" onclick="javascript:  $('#data-form_500').hide();">	
	
	<?php 
		require_once("lib/mfbconnect.php"); 
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong><font size='8'>Gantry Meters</font></strong></h3>
		<?php
			if ($_SESSION['ivmasters']==1)
			{
				include("lib/dbfunctions.php");
				$dbobject = new dbfunction();
				$role_id = "";
				
				$user = $_SESSION['username_sess'];
				$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
				$meterid = !isset($_REQUEST['meterid'])?'':$_REQUEST['meterid'];
				$meterlabel = !isset($_REQUEST['meterlabel'])?'':$dbobject->test_input($_REQUEST['meterlabel']);
				$meterlimit = !isset($_REQUEST['meterlimit'])?'':$dbobject->test_input($_REQUEST['meterlimit']);
				$loccd = !isset($_REQUEST['loccd'])?'':$dbobject->test_input($_REQUEST['loccd']);
				
				$roleid = !isset($_REQUEST['roleid'])?0:$_REQUEST['roleid'];
				
				$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
				$searchin = !isset($_REQUEST['searchin'])?"":$dbobject->test_input($_REQUEST['searchin']);
			
				
				
				$sql_loccd = "select loccd,loc_name from lmf  where 1=1";
				$result_loccd = mysqli_query($_SESSION['db_connect'],$sql_loccd);
				$count_loccd = mysqli_num_rows($result_loccd);
				
									
			
			
				if($op=='searchkeyword')
					{
						
						$sql_QueryStmt = "select * from meters where trim(meterid) = '$keyword'   limit 1";
							
						//echo "<br/> sql_Q ".$sql_Q;	
						//echo "<br/>".$sql_QueryStmt;
						$result_QueryStmt = mysqli_query($_SESSION['db_connect'],$sql_QueryStmt);
						$count_QueryStmt = mysqli_num_rows($result_QueryStmt);
						
						if ($count_QueryStmt >=1){
							$row       = mysqli_fetch_array($result_QueryStmt);
							$meterid    = $row['meterid'];
							$meterlabel   = $row['meterlabel'];
							$loccd   = $row['loccd'];
							$meterlimit   = $row['meterlimit'];
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>Sub Location does not exist</strong>");
							</script>
						<?php	
						}	
						
						
					}			
					
				if($op=='deletemeterid')
				{
					$goahead = 1;
					
					if (trim($meterid) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Meter ID</strong>");
							</script>
						<?php 
						}
					
					if ($goahead ==1 ){
						
						$sql_deletemeteridation = " delete from meters where TRIM(meterid) = '$meterid' ";
								
						$result_deletemeteridation = mysqli_query($_SESSION['db_connect'],$sql_deletemeteridation);
						
						
						
						$dbobject->apptrail($user,'Gantry Meter',$meterid,date('d/m/Y H:i:s A'),'Deleted');
						
						 ?>	
							<script>
								$('#item_error').html("<strong>Gantry Meter Record Deleted</strong>");
							</script>
				  <?php
						
					}
				
				}
		
		
		
				if($op=='saving')
				{
					
					$goahead = 1;
					
					if (trim($meterid) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please Specify Meter Location ID</strong>");
							</script>
				  <?php }
						
					
							
						if (trim($_REQUEST['meterlabel']) =='')
						{
								$goahead = $goahead * 0;
							?>	
								<script>
									$('#item_error').html("<strong>Please Specify Description</strong>");
								</script>
							<?php 
						}		
						if (trim($_REQUEST['loccd']) =='')
						{
								$goahead = $goahead * 0;
							?>	
								<script>
									$('#item_error').html("<strong>Please Specify Location Code</strong>");
								</script>
							<?php 
						}

						
						
				
					
					
								
					//echo $goahead;
					if ($goahead==1)
					{
						
						$sql_Checkmeter = " select * from meters where TRIM(meterid) = '$meterid' " ;
								
						$result_Checkmeter = mysqli_query($_SESSION['db_connect'],$sql_Checkmeter);
						$count_Checkmeter = mysqli_num_rows($result_Checkmeter);		
						
						if ($count_Checkmeter == 0)
						{
							$sql_savemeterid = " insert into meters ( meterid, loccd,meterlabel,meterlimit ) 
									values ('$meterid', '$loccd', '$meterlabel', $meterlimit ) ";
									
							
							$dbobject->apptrail($user,'Gantry Meter',$meterid,date('d/m/Y H:i:s A'),'Created');
							
						}else
						{
							$sql_savemeterid = " update meters set 
								 loccd = '$loccd', 
								 meterlabel  = '$meterlabel' ,
								 meterlimit  = $meterlimit
								 where trim(meterid) = '$meterid'";
								 
							$dbobject->apptrail($user,'Gantry Meter',$meterid,date('d/m/Y H:i:s A'),'Modified');
						}
						
						
						$result_savemeterid = mysqli_query($_SESSION['db_connect'],$sql_savemeterid);
						
						
						
						
						 ?>	
							<script>
								$('#item_error').html("<strong>Gantry Meter Record Saved</strong>");
							</script>
				  <?php
						
					}
					
					
				}
//****			
			

		?>
		
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="thetablename" id="thetablename" value="meters" />
		<input type="hidden" name="get_file" id="get_file" value="gantrymeters" />
		
		<table border ="0"  style="padding:0px;">
			<tr>
				<td colspan="2" style="color:red;" id = "item_error" align = "left"  ></td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="input-group">
						<b>Search by: <i>Name or Code</i> </b>&nbsp;
						<input type="text" size="35px" id="search" placeholder="Search for Meter" />
						<input name="keyword" type="hidden" class="table_text1"  id="keyword" value="<?php echo $keyword; ?>" />
					
					</div>
					<!-- Suggestions will be displayed in below div. -->
					
					   <div id="display"></div>
				</td>  
				
			</tr>
			
		</table>
		<br/>
		<div style="overflow-x:auto;" >
		<table border="0"  style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
			<tr >
				<td >
					<b>Gantry Meter ID : </b>
				</td>
				<td>
					<input type="text" name="meterid" id="meterid" value="<?php echo $meterid; ?>" <?php if ($meterid != ''){echo 'readonly';} ?> placeholder="Enter Gantry Meter ID" />
				</td>
				<td >
				
					  <input type="button" name="refreshbutton" id="submit-button" value="Refresh" 
						onclick="javascript:  getpage('gantrymeters.php?','page');" />
							
				</td>
			</tr>
			<tr >
				<td >
					<b>Gantry Meter Name : </b>
				</td>
				<td colspan="2">
					<input type="text" name="meterlabel" id="meterlabel" value="<?php echo $meterlabel; ?>"  placeholder="Enter Gantry Meter Description" />
				</td>
				
			</tr>
			<tr >
				<td >
					<b>Gantry Meter Limit : </b>
				</td>
				<td colspan="2">
					<input type="number" title="This is the highest possible number of the Meter" name="meterlimit" id="meterlimit" value="<?php echo $meterlimit; ?>"  placeholder="Enter Gantry Meter Limit" />
				</td>
				
			</tr>
			<tr >
				<td >
					<b>Inventory Location : </b>
				</td>
				<td colspan="2">
					<?php 
						$k = 0;
						?>
						<select name="selectloccd"   id="selectloccd"  >
							<option  value="" ></option>
						<?php

						while($k< $count_loccd) 
						{
							$row = mysqli_fetch_array($result_loccd);
							
						?>
							<option  value="<?php echo trim($row['loccd']) ;?>" <?php  echo ($loccd== trim($row['loccd']) ?"selected":""); ?>>
								<?php echo trim($row['loc_name']) ;?> 
							</option>
							
						<?php 
							$k++;
							} //End If Result Test	
						?>								
						</select>
				</td>
				
			</tr>
			
		</table>
		<table>
			
			<tr>
				
				
				<td >
				
					  <input type="button" name="deletebutton" id="submit-button" value="Delete" 
						onclick="deletemeterid();" />
							
				</td>
				
				<td  >
				
					  <input type="button" name="savebutton" id="submit-button" value="Save" 
						onclick="savemeterid();" />
							
				</td>
				
			</tr>
		
	</table>
	</div>	

			<?php } ?>
	</form>
	<br />
	<input type="button" name="closebutton" id="submit-button" value="Back" 
						onclick="javascript:  getpage('inventory.php?','page');
							">
	<br />
</div>

<script>
	
	
	function savemeterid(){
		if (confirm('Are you sure the entries are correct?')) 
		{
			
			var $form_loccd = $('#selectloccd').val();$form_meterid = $('#meterid').val(); var $meterlabel = $('#meterlabel').val();
			var $meterlimit = $('#meterlimit').val();
			

			var $goahead = 1;
					
			if ($form_meterid =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Meter ID ");
			}	
			if ($form_loccd =='')
			{
				$goahead = $goahead * 0;
				alert("Please Specify Inventory Location");
			}	
			if ($meterlabel =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Meter Description");
			}	

			
			
			if ($goahead == 1) {
				getpage('gantrymeters.php?op=saving&meterid='+$form_meterid
					+'&loccd='+$form_loccd+'&meterlimit='+$meterlimit
					+'&meterlabel='+$meterlabel,'page');						
			}
	
		}
	}


	function deletemeterid(){
		if (confirm('Are you sure the entries are correct?')) 
		{
			
			var $form_loccd = $('#selectloccd').val();$form_meterid = $('#meterid').val(); var $meterlabel = $('#meterlabel').val();
			var $meterlimit = $('#meterlimit').val();
			

			var $goahead = 1;
					
			if ($form_meterid =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Meter ID ");
			}	
		
			
			if ($goahead == 1) {
				

				getpage('gantrymeters.php?op=deletemeterid&meterid='+$form_meterid
					+'&loccd='+$form_loccd+'&meterlimit='+$meterlimit
					+'&meterlabel='+$meterlabel,'page');
					
			}
	
		}
	}	
</script>