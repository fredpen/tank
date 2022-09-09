<?php 
	ob_start();
	include_once "session_track.php";
?>


<style>
	td {padding:5px;}
	
</style>
<script type="text/javascript" src="js/dynamic_search_script.js"></script>
<div align ="center" id="data-form" > 
	<input type="button" name="closebutton" id="submit-button" title="Close"  value="Close" onclick="javascript:  $('#data-form').hide();">	
	

	<?php 
		require_once("lib/mfbconnect.php");
	?>

	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong><font size='10'>Inventory Locations </font></strong></h3>
		<?php
			 include("lib/dbfunctions.php");
			 $dbobject = new dbfunction();
			$ivmasters = !isset($_SESSION['ivmasters'])?0:$dbobject->test_input($_SESSION['ivmasters']);
			if ($ivmasters==1)
			{
				
				
				$role_id = "";
				
				$user = $_SESSION['username_sess'];
				$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
				$loccd = !isset($_REQUEST['loccd'])?'':$_REQUEST['loccd'];
				$loc_name = !isset($_REQUEST['loc_name'])?'':$dbobject->test_input($_REQUEST['loc_name']);
				$address1 = !isset($_REQUEST['address1'])?'':$dbobject->test_input($_REQUEST['address1']);
				$address2 = !isset($_REQUEST['address2'])?'':$dbobject->test_input($_REQUEST['address2']);
				$xchar2 = !isset($_REQUEST['xchar2'])?'':$dbobject->test_input($_REQUEST['xchar2']);
				
					
				$selectloccd = !isset($_REQUEST['selectloccd'])?'':$dbobject->test_input($_REQUEST['selectloccd']);
				
				$roleid = !isset($_REQUEST['roleid'])?0:$_REQUEST['roleid'];
				
				$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
				$searchin = !isset($_REQUEST['searchin'])?"":$dbobject->test_input($_REQUEST['searchin']);
				
				$sql_lmf = "select distinct * FROM lmf WHERE 1=1 order by loc_name";
					$result_lmf = mysqli_query($_SESSION['db_connect'],$sql_lmf);
					$count_lmf = mysqli_num_rows($result_lmf);
				
				
									
				if($op=='getselectloccd')
					{
						$filter = "";
						
						$sql_Q = "SELECT * FROM lmf where  ";
						$loccd = '';		
						if(trim($selectloccd)<>'')
							{
								//echo $selectitem;
								$itemdetails = explode("*",$selectloccd);
								$loccd = $itemdetails[0];
								
							}
						
							$filter="  upper(trim(loccd)) = upper('$loccd')  ";
						
												
						
						$orderby = "   ";
						$orderflag	= " ";
						$order = $orderby." ".$orderflag;
						$sql_QueryStmt = $sql_Q.$filter.$order. " limit 1";
							
						//echo "<br/> sql_Q ".$sql_Q;	
						//echo "<br/>".$sql_QueryStmt."<br/>";
						$result_QueryStmt = mysqli_query($_SESSION['db_connect'],$sql_QueryStmt);
						$count_QueryStmt = mysqli_num_rows($result_QueryStmt);
						
						if ($count_QueryStmt >=1){
							$row       = mysqli_fetch_array($result_QueryStmt);
							$loccd    = $row['loccd'];
							$loc_name   = $row['loc_name'];
							$address1 = $row['address1'];
							$address2  = $row['address2'];
							$xchar2  = $row['xchar2'];
							$selectloccd = trim($row['loccd'])."*". trim($row['loc_name']) ;
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>Location does not exist</strong>");
							</script>
						<?php	
						}	
						
						
					}			
					
				
			
			
				if($op=='searchkeyword')
					{
						
						$filter=" AND trim(loccd) like '%$keyword%'   ";
						
						
						
						$sql_Q = "SELECT * FROM lmf where ";
						if (strlen($keyword)!=0) {$sql_Q = $sql_Q . " 1 = 1 ";}else {$sql_Q = $sql_Q . " 1 = 2 ";}
						$orderby = "   ";
						$orderflag	= " ";
						$order = $orderby." ".$orderflag;
						$sql_QueryStmt = $sql_Q.$filter.$order. " limit 1";
							
						//echo "<br/> sql_Q ".$sql_Q;	
						//echo "<br/>".$sql_QueryStmt;
						$result_QueryStmt = mysqli_query($_SESSION['db_connect'],$sql_QueryStmt);
						$count_QueryStmt = mysqli_num_rows($result_QueryStmt);
						
						if ($count_QueryStmt >=1){
							$row       = mysqli_fetch_array($result_QueryStmt);
							$loccd    = $row['loccd'];
							$loc_name   = $row['loc_name'];
							$address1 = $row['address1'];
							$address2  = $row['address2'];
							$xchar2  = $row['xchar2'];
							$selectloccd = trim($row['loccd'])."*". trim($row['loc_name']) ;
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>Location does not exist</strong>");
							</script>
						<?php	
						}	
						
						
					}			
					
				if($op=='deletelocation')
				{
					$goahead = 1;
					
					if (trim($loccd) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Location ID</strong>");
							</script>
						<?php 
						}else {
							
								$sql_checkrec_invent =  "select * from rec_invent where trim(loccd) = '$loccd'";
								$result_checkrec_invent = mysqli_query($_SESSION['db_connect'],$sql_checkrec_invent);
								$count_checkrec_invent = mysqli_num_rows($result_checkrec_invent);
									
								if ($count_checkrec_invent >=1)
								{
									$goahead = $goahead * 0;
								 ?>	
									<script>
										$('#item_error').html("<strong>This Location cannot be deleted because it has been used in transactions.</strong>");
									</script>
						  <?php }
															
						}
					
					if ($goahead ==1 ){
						$sql_deletelocation =  "delete from lmf where trim(loccd) = '$loccd'";
						$result_deletelocation = mysqli_query($_SESSION['db_connect'],$sql_deletelocation);
								
						$dbobject->apptrail($user,'Location Master',$loc_name,date('d/m/Y H:i:s A'),'Deleted');
						
						 ?>	
							<script>
								$('#item_error').html("<strong>Location Record Deleted</strong>");
							</script>
				  <?php
						
					}
				
				}
		
		
		
				if($op=='saving')
				{
					
					$goahead = 1;
					
					if (trim($loccd) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Location ID</strong>");
							</script>
				  <?php }
						
					
					if (trim($_REQUEST['loc_name']) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Location Name</strong>");
							</script>
				  <?php }
						
							
						if (trim($_REQUEST['address1']) =='')
						{
								$goahead = $goahead * 0;
							?>	
								<script>
									$('#item_error').html("<strong>Please specify the Address</strong>");
								</script>
							<?php 
						}		
						if (trim($_REQUEST['xchar2']) =='')
						{
								$goahead = $goahead * 0;
							?>	
								<script>
									$('#item_error').html("<strong>Please specify Unique Two Character Code for the Location</strong>");
								</script>
							<?php 
						}

						
						
				
					
					
								
					//echo $goahead;
					if ($goahead==1)
					{
						
						$sql_checklmf = "SELECT * FROM lmf where upper(trim(loccd)) = upper('$loccd') ";
						$result_checklmf = mysqli_query($_SESSION['db_connect'],$sql_checklmf);
						$count_checklmf = mysqli_num_rows($result_checklmf);
						
						if ($count_checklmf > 0){
							$sql_savelmf = " update lmf set 
								 loc_name = '$loc_name', 
								 address1  = '$address1', 
								 address1  = '$address1', 
								 address2 = '$address2', 
								 xchar2  = '$xchar2'
								where trim(loccd) = '$loccd'";
								
							$dbobject->apptrail($user,'Location Master',$loc_name,date('d/m/Y H:i:s A'),'Modified');
						}else{
							$sql_savelmf = " insert into lmf (  
								loccd, loc_name,  
								address1, address2, xchar2 ) 
								 values ('$loccd', '$loc_name' ,  
								 '$address1' , '$address2', '$xchar2') ";
								 
							$dbobject->apptrail($user,'Location Master',$loc_name,date('d/m/Y H:i:s A'),'Created');
							
						}
						$result_savelmf = mysqli_query($_SESSION['db_connect'],$sql_savelmf);
						
					
						
						 ?>	
							<script>
								$('#item_error').html("<strong>Location Record Saved</strong>");
							</script>
				  <?php
						
					}
					
					
				}
//****			
			

		?>
		
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="thetablename" id="thetablename" value="location" />
		<input type="hidden" name="get_file" id="get_file" value="locationmaster" />
		
		<table border ="0"  style="padding:0px;">
			<tr>
				<td colspan="2" style="color:red;" id = "item_error" align = "left"  ></td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="input-group">
						<b>Search by: <i>Name or Code</i> </b>&nbsp;
						<input type="text" size="35px" id="search" placeholder="Search for Location" />
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
					<b>Location ID : </b>
				</td>
				<td>
					<input type="text" name="loccd" id="loccd" value="<?php echo $loccd; ?>" <?php if ($loccd != ''){echo 'readonly';} ?> placeholder="Enter Location ID" />
				</td>
				<td colspan="2">
				
					  <input type="button" name="refreshbutton" id="submit-button" value="Refresh" 
						onclick="javascript:  getpage('locationmaster.php?','page');" />
							
				</td>
			</tr>
				<td>
					<b>Location Name : </b>
				</td>
				<td>
					<input type="text" name="loc_name" id="loc_name" value="<?php echo $loc_name; ?>" placeholder="Enter Location Name" />
				</td>
			
				<td >
					<b>Address1 : </b>
				</td>
				<td>
					<input type="text" name="address1" id="address1" value="<?php echo $address1; ?>"  placeholder="Enter Address Line 1" />
				</td>
			</tr>
			
			<tr >	
				<td>
					<b>Address2 : </b>
				</td>
				<td>
					<input type="text" name="address2" id="address2" value="<?php echo $address2; ?>" placeholder="Enter Address Line 2" />
				</td>
			
				<td >
					<b>xchar2 : </b>
				</td>
				<td>
					<input type="text" name="xchar2" id="xchar2" value="<?php echo $xchar2; ?>"  title="Enter Two Character Code" />
				</td>
				
			</tr>
		</table>
		<table>
			
			<tr>
				
				
				<td >
				
					  <input type="button" name="deletebutton" id="submit-button" value="Delete" 
						onclick="deletelocation();" />
							
				</td>
				
				<td  >
				
					  <input type="button" name="savebutton" id="submit-button" value="Save" 
						onclick="savelocation();" />
							
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
	
	
	function savelocation(){
		if (confirm('Are you sure the entries are correct?')) 
		{
			
			var $form_loccd = $('#loccd').val();$form_address1 = $('#address1').val(); var $form_loc_name = $('#loc_name').val();
			var $form_address2 = $('#address2').val();var $form_xchar2 = $('#xchar2').val();
			var $form_address1 = $('#address1').val();
				
			

			var $goahead = 1;
					
			if ($form_loccd =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Location ID ");
			}	
		
			if ($form_loc_name =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Location Name ");
			}	

			if ($form_address1 =='')
			{
				$goahead = $goahead * 0;
				alert("Please specify the Address");
			}	
						
					
			
			if ($form_xchar2 =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter xchar2");
			}
			
			if ($goahead == 1) {
				getpage('locationmaster.php?op=saving&loccd='+$form_loccd
					+'&loc_name='+$form_loc_name
					+'&address1='+$form_address1+'&address2='+$form_address2
					+'&xchar2='+$form_xchar2,'page');						
			}
	
		}
	}


	function deletelocation(){
		if (confirm('Are you sure the entries are correct?')) 
		{
			
			var $form_loccd = $('#loccd').val(); var $form_loc_name = $('#loc_name').val();
			var $form_address2 = $('#address2').val();var $form_xchar2 = $('#xchar2').val();
			var $form_address1 = $('#address1').val();
				
			

			var $goahead = 1;
					
			if ($form_loccd =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Location ID ");
			}	
		
			
			if ($goahead == 1) {
				getpage('locationmaster.php?op=deletelocation&loccd='+$form_loccd
					+'&loc_name='+$form_loc_name
					+'&address1='+$form_address1+'&address2='+$form_address2
					+'&xchar2='+$form_xchar2,'page');						
			}
	
		}
	}	
</script>