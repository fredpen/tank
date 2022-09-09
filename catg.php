<?php 
	ob_start();
	include_once "session_track.php";
?>


<style>
	td {padding:5px;}
	
</style>
<script type="text/javascript" src="js/dynamic_search_script.js"></script>
<div align ="center" id="data-form" > 

	<?php 
		require_once("lib/mfbconnect.php"); 
	?>

	<?php require 'lib/aesencrypt.php'; ?>

	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong><font size='10'>Category Definition </font></strong></h3>
		<?php
			if ($_SESSION['somasters']==1)
			{
				include("lib/dbfunctions.php");
				$dbobject = new dbfunction();
				$role_id = "";
				
				$user = $_SESSION['username_sess'];
				$reqst_by = $_SESSION['username_sess'];
				$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
				$catcd = !isset($_REQUEST['catcd'])?'':$dbobject->test_input($_REQUEST['catcd']);
				$catdesc = !isset($_REQUEST['catdesc'])?'':$dbobject->test_input($_REQUEST['catdesc']);
				$cattype = !isset($_REQUEST['cattype'])?'':$dbobject->test_input($_REQUEST['cattype']);
				
				$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
				$searchin = !isset($_REQUEST['searchin'])?"":$dbobject->test_input($_REQUEST['searchin']);
				
				
				
			
				if($op=='searchkeyword')
					{
						$filter=" AND trim(catcd) like '%$keyword%'   ";
						
						$sql_Q = "SELECT * FROM catg where ";
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
							$cattype    = $row['cattype'];
							$catdesc = $row['catdesc'];
							$catcd = $row['catcd'];
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>Category does not exist</strong>");
							</script>
						<?php	
						}	
						
						
					}			
					
				if($op=='deletecatg')
				{
					$goahead = 1;
					
					if (trim($catcd) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Category ID</strong>");
							</script>
						<?php 
						}else {
							
								$sql_checkusage =  "select * from invoice where trim(py) = '$catcd' or trim(bu) = '$catcd' or trim(mv) = '$catcd' limit 1";
								$result_checkusage = mysqli_query($_SESSION['db_connect'],$sql_checkusage);
								$count_checkusage = mysqli_num_rows($result_checkusage);
									
								if ($count_checkusage >0)
								{
									$goahead = $goahead * 0;
								 ?>	
									<script>
										$('#item_error').html("<strong>This Category cannot be deleted because it has been used in transactions.</strong>");
									</script>
						  <?php }
															
						}
					
					if ($goahead ==1 ){
						$sql_deletetrans =  "delete from catg where trim(catcd) = '$catcd'";
						$result_deletetrans = mysqli_query($_SESSION['db_connect'],$sql_deletetrans);
								
						
						$dbobject->apptrail($reqst_by,'Category Definition',$catcd ." ".$catdesc,date('d/m/Y H:i:s A'),'Deleted');
						
						 ?>	
							<script>
								$('#item_error').html("<strong>Category Record Deleted</strong>");
							</script>
				  <?php
						
					}
				
				}
		
		
		
				if($op=='saving')
				{
					
					$goahead = 1;
					
					if (trim($catcd) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Category ID</strong>");
							</script>
				  <?php }
						
					if (trim($cattype) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Category Type</strong>");
							</script>
				  <?php }
						
					
						
								
					//echo $goahead;
					if ($goahead==1)
					{
						
						$sql_checktrans = "SELECT * FROM catg where upper(trim(catcd)) = upper('$catcd') ";
						$result_checktrans = mysqli_query($_SESSION['db_connect'],$sql_checktrans);
						$count_checktrans = mysqli_num_rows($result_checktrans);
						
						if ($count_checktrans > 0){
							$sql_savetrans = " update catg set 
								 catdesc  = '$catdesc', 
								 cattype  = '$cattype' 
								 where trim(catcd) = '$catcd'";
							
							$dbobject->apptrail($reqst_by,'Category',$catcd ." ".$catdesc,date('d/m/Y H:i:s A'),'Modified');	 
								 
						}else{
							$sql_savetrans = " insert into catg (  
								cattype, catdesc, catcd ) 
								 values ('$cattype',   '$catdesc', '$catcd' ) ";
								 
							$dbobject->apptrail($reqst_by,'Category',$catcd ." ".$catdesc,date('d/m/Y H:i:s A'),'Created');	 
							
						}
						$result_savetrans = mysqli_query($_SESSION['db_connect'],$sql_savetrans);
						
						
						//echo $sql_QueryStmt;
						
						
						
						 ?>	
							<script>
								$('#item_error').html("<strong>Category Record Saved</strong>");
							</script>
				  <?php
						
					}
					
					
				}
//****			
			

		?>
		
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="thetablename" id="thetablename" value="catg" />
		<input type="hidden" name="get_file" id="get_file" value="catg" />
		<table border ="0"  style="padding:0px;">
			<tr>
				<td colspan="2" style="color:red;" id = "item_error" align = "left"  ></td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="input-group">
						<b>Search by: <i>Name or Code</i> </b>&nbsp;
						<input type="text" size="35px" id="search" placeholder="Search for Category" />
						<input name="keyword" type="hidden" class="table_text1"  id="keyword" value="<?php echo $keyword; ?>" />
					
					</div>
					<!-- Suggestions will be displayed in below div. -->
					<br />
					   <div id="display"></div>
				</td>  
				
			</tr>
			
		</table>
		<br/>
		<div style="overflow-x:auto;" >
		<table border="0"  style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
			<tr >
				<td >
					<b>Category ID : </b>
				</td>
				<td >
					<input type="text" name="catcd" id="catcd" value="<?php echo $catcd; ?>" <?php if ($catcd != ''){echo 'style="background-color:lightgray" readonly';} ?> placeholder="Enter Category ID" />
				</td>
				<td >
				
				  <input type="button" name="refreshbutton" id="submit-button" value="Refresh" 
					onclick="javascript:  getpage('catg.php?','page');" />
						
				</td>
			</tr>
			
			<tr>
				<td>
					<b>Category Description : </b>
				</td>
				<td colspan="2">
					<input type="text" name="catdesc" id="catdesc" value="<?php echo $catdesc; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Category Type: </b>
				</td>
				<td colspan="2">
					<?php 
						$k = 0;
						?>
						<select name="cattype"   id="cattype"  >
							<option  value="" ></option>
							<option  value="T" <?php  echo (($cattype== 'T') ?"selected":""); ?>>Transport</option>
							<option  value="B" <?php  echo (($cattype== 'B') ?"selected":""); ?>>Business</option>
							<option  value="P" <?php  echo (($cattype== 'P') ?"selected":""); ?>>Payment</option>
							<option  value="C" <?php  echo (($cattype== 'C') ?"selected":""); ?>>Customer</option>
												
						</select>
				</td>
			</tr>
			
		</table>
		<table>
			
			<tr>
				
				<td>
					<input type="button" name="closebutton" id="submit-button" value="Back" 
						onclick="javascript:  getpage('systemconfig.php?','page');"/>
				</td>
				<td >
				
					  <input type="button" name="deletebutton" id="submit-button" value="Delete" 
						onclick="deletecatg();" />
							
				</td>
				
				<td  >
				
					  <input type="button" name="savebutton" id="submit-button" value="Save" 
						onclick="savecatg();" />
							
				</td>
				
			</tr>
		
	</table>
	</div>	

			<?php } ?>
	</form>
</div>

<script>
	
	
	function savecatg(){
		if (confirm('Are you sure the entries are correct?')) 
		{
			
			var $cattype = $('#cattype').val();$catcd = $('#catcd').val(); 
			var $catdesc = $('#catdesc').val();
				
			

			var $goahead = 1;
					
			if ($catcd =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Category ID ");
			}	
		
			if ($cattype =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Category Name ");
			}	

			
						
			if ($catdesc.trim() =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter catdesc");
			}
			
			if ($goahead == 1) {
				getpage('catg.php?op=saving&cattype='+$cattype
					+'&catdesc='+$catdesc+'&catcd='+$catcd,'page');						
			}
	
		}
	}


	function deletecatg(){
		if (confirm('Are you sure the entries are correct?')) 
		{
			
			var $cattype = $('#cattype').val();$catcd = $('#catcd').val(); 
			var $catdesc = $('#catdesc').val();
				
			

			var $goahead = 1;
					
			if ($catcd =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Category ID ");
			}	
		
			
			if ($goahead == 1) {
				getpage('catg.php?op=deletecatg&cattype='+$cattype
					+'&catdesc='+$catdesc+'&catcd='+$catcd,'page');						
			}
	
		}
	}	
</script>