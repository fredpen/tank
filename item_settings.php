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


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong><font size='10'>Stock Level Settings </font></strong></h3>
		<?php
			if ($_SESSION['ivmasters']==1)
			{
				include("lib/dbfunctions.php");
				$dbobject = new dbfunction();
				$role_id = "";
				
				$user = $_SESSION['username_sess'];
				$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
				$item = !isset($_REQUEST['item'])?'':$_REQUEST['item'];
				$itemdesc = !isset($_REQUEST['itemdesc'])?'':$dbobject->test_input($_REQUEST['itemdesc']);
				$minstock = !isset($_REQUEST['minstock'])?0:$dbobject->test_input($_REQUEST['minstock']);
				$maxstock = !isset($_REQUEST['maxstock'])?0:$dbobject->test_input($_REQUEST['maxstock']);
				$onhand = !isset($_REQUEST['onhand'])?0.00:$dbobject->test_input($_REQUEST['onhand']);
				$retslab = !isset($_REQUEST['retslab'])?'':$dbobject->test_input($_REQUEST['retslab']);
				$wiponhand = !isset($_REQUEST['wiponhand'])?0:$dbobject->test_input($_REQUEST['wiponhand']);
				$useable_onhand = !isset($_REQUEST['useable_onhand'])?0:$dbobject->test_input($_REQUEST['useable_onhand']);
				$reorderlvl = !isset($_REQUEST['reorderlvl'])?0:$dbobject->test_input($_REQUEST['reorderlvl']);
				$reorderqty = !isset($_REQUEST['reorderqty'])?0:$dbobject->test_input($_REQUEST['reorderqty']);
				$maxusage = !isset($_REQUEST['maxusage'])?0:$dbobject->test_input($_REQUEST['maxusage']);
				$minusage = !isset($_REQUEST['minusage'])?0:$dbobject->test_input($_REQUEST['minusage']);
				$minlead = !isset($_REQUEST['minlead'])?0:$dbobject->test_input($_REQUEST['minlead']);
				$maxlead = !isset($_REQUEST['maxlead'])?0:$dbobject->test_input($_REQUEST['maxlead']);
				$avgusage = !isset($_REQUEST['avgusage'])?0:$dbobject->test_input($_REQUEST['avgusage']);
				$avglead = !isset($_REQUEST['avglead'])?0:$dbobject->test_input($_REQUEST['avglead']);
				
				
					
				$selectitem = !isset($_REQUEST['selectitem'])?'':$dbobject->test_input($_REQUEST['selectitem']);
				
				
				$roleid = !isset($_REQUEST['roleid'])?0:$_REQUEST['roleid'];
				
				$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
				$searchin = !isset($_REQUEST['searchin'])?"":$dbobject->test_input($_REQUEST['searchin']);
				
				
				
				$sql_item = "select distinct * FROM icitem WHERE 1=1 order by itemdesc";
				$result_item = mysqli_query($_SESSION['db_connect'],$sql_item);
				$count_item = mysqli_num_rows($result_item);
				
				
									
				if($op=='getselectitem')
					{
						$filter = "";
						
						$sql_Q = "SELECT * FROM icitem where  ";
						$item = '';		
						if(trim($selectitem)<>'')
							{
								//echo $selectitem;
								$itemdetails = explode("*",$selectitem);
								$item = $itemdetails[0];
								
							}
						
							$filter="  upper(trim(item)) = upper('$item')  ";
						
												
						
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
							$item    = $row['item'];
							$itemdesc   = $row['itemdesc'];
							$reorderqty = $row['reorderqty'];
							$maxusage = $row['maxusage'];
							$minusage  = $row['minusage'];
							$minlead  = $row['minlead'];
							$maxlead  = $row['maxlead'];
							$avgusage  = $row['avgusage'];
							$avglead  = $row['avglead'];
							$prprvalid  = $row['prprvalid'];
							$minstock  = $row['minstock'];
							$maxstock  = $row['maxstock'];
							$onhand  = $row['onhand'];
							$wiponhand  = $row['wiponhand'];
							$useable_onhand  = $row['useable_onhand'];
							$reorderlvl  = $row['reorderlvl'];
							
							$selectitem = trim($row['item'])."*". trim($row['itemdesc']) ;
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>Item does not exist</strong>");
							</script>
						<?php	
						}	
						
						
					}			
					
				
			
			
				if($op=='searchkeyword')
					{
						$filter=" AND trim(item) like '%$keyword%'   ";
						
						
						$sql_Q = "SELECT * FROM icitem where ";
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
							$item    = $row['item'];
							$itemdesc   = $row['itemdesc'];
							$reorderqty = $row['reorderqty'];
							$maxusage = $row['maxusage'];
							$minusage  = $row['minusage'];
							$minlead  = $row['minlead'];
							$maxlead  = $row['maxlead'];
							$avgusage  = $row['avgusage'];
							$avglead  = $row['avglead'];
							$prprvalid  = $row['prprvalid'];
							$minstock  = $row['minstock'];
							$maxstock  = $row['maxstock'];
							$onhand  = $row['onhand'];
							$wiponhand  = $row['wiponhand'];
							$useable_onhand  = $row['useable_onhand'];
							$reorderlvl  = $row['reorderlvl'];
							
							
							$selectitem = trim($row['item'])."*". trim($row['itemdesc']) ;
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>Item does not exist</strong>");
							</script>
						<?php	
						}	
						
						
					}			
					
				
		
				if($op=='saving')
				{
					
					$goahead = 1;
					
					if (trim($item) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Item ID</strong>");
							</script>
				  <?php }
						
					
						  
								
					//echo $goahead;
					if ($goahead==1)
					{
						
						$sql_saveIcitem = " update icitem set 
								reorderqty = $reorderqty ,
								 maxusage = $maxusage ,
								 minusage  = $minusage, 
								 minlead  = $minlead ,
								 maxlead  = $maxlead ,
								 avgusage  = $avgusage ,
								 avglead  = $avglead ,
								 minstock  = $minstock ,
								 maxstock  = $maxstock ,
								 reorderlvl  = $reorderlvl 
								 where trim(item) = '$item'";
						
						$result_saveIcitem = mysqli_query($_SESSION['db_connect'],$sql_saveIcitem);
						
						
						//echo $sql_saveIcitem;
						
						
						$dbobject->apptrail($user,'Item Settings',$itemdesc,date('d/m/Y H:i:s A'),'Modified');
						
						 ?>	
							<script>
								$('#item_error').html("<strong>Item Record Saved</strong>");
							</script>
				  <?php
						
					}
					
					
				}
		
			

		?>
		
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="thetablename" id="thetablename" value="item" />
		<input type="hidden" name="get_file" id="get_file" value="item_settings" />
		<table border ="0"  style="padding:0px;">
			<tr>
				<td colspan="2" style="color:red;" id = "item_error" align = "left"  ></td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="input-group">
						<b>Search by: <i>Name or Code</i> </b>&nbsp;
						<input type="text" size="35px" id="search" placeholder="Search for Product" />
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
				<td nowrap="nowrap">
					<b>Item ID : </b>
				</td>
				<td colspan="2" >
					<?php echo $item; ?> <input type="hidden" name="item" id="item" value="<?php echo $item; ?>" />
				</td>
				
				<td >
				
					  <input type="button" name="refreshbutton" id="submit-button" value="Refresh" 
						onclick="javascript:  getpage('item_settings.php?','page');" />
							
				</td>
				
			</tr>
			<tr >
				
				<td>
					<b>Item Description : </b>
				</td>
				<td colspan="3">
					<?php echo $itemdesc; ?> <input type="hidden" name="itemdesc" id="itemdesc" value="<?php echo $itemdesc; ?>" />
				</td>
				
			</tr>
		
			<tr >
				<td colspan="4" nowrap="nowrap">
					<div title="WIP stands for Work in Progress"><b>Stock Position =></b>
				&nbsp;&nbsp;
					<b>Total :</b><?php echo number_format($onhand,2) ;?>
				&nbsp;&nbsp;<b>WIP :</b>
					<?php echo number_format($wiponhand,2) ;?>
				&nbsp;&nbsp;<b>Usable :</b>
					<?php echo number_format($useable_onhand,2) ;?></div>
				</td>
			</tr>
			<tr >
				<td colspan="3">
					<b>Maximum Sales/Consumption (A)</b>
				</td>
				<td >
					<input type="number" id="maxusage" name="maxusage" value="<?php echo $maxusage; ?>" onChange= "javascript: refreshoption();" />
				</td>
				
			</tr>
			<tr >
				<td colspan="3">
					<b>Minimum Sales/Consumption (B)</b>
				</td>
				<td >
					<input type="number" id="minusage" name="minusage" value="<?php echo $minusage; ?>"  onChange= "javascript: refreshoption();"  />
				</td>
				
			</tr>
			<tr >
				<td colspan="3">
					<b>Maximum Lead Time (C)</b>
				</td>
				<td >
					<input type="number" id="maxlead" name="maxlead" value="<?php echo $maxlead; ?>"   onChange= "javascript: refreshoption();" />
				</td>
				
			</tr>
			<tr >
				<td colspan="3">
					<b>Minimum Lead Time (D)</b>
				</td>
				<td >
					<input type="number" id="minlead" name="minlead" value="<?php echo $minlead; ?>"  onChange= "javascript: refreshoption();"  />
				</td>
				
			</tr>
			
		</table>
		<table>
			
			<tr>
				
				<td>
					<input type="button" name="closebutton" id="submit-button" value="Back" 
						onclick="javascript:  getpage('item_master.php?','page');"/>
				</td>
				<td nowrap="nowrap">
					<label>
					  <input type="button" name="spedisc" id="submit-button" value="Item Pricing" 
						onclick="javascript:  getpage('item_pricing.php?','page');">
					</label>
				</td>
				
				
				<td >
				
					  <input type="button" name="showtheinference" id="submit-button" value="Show Inferences" 
						onclick="javascript:  showinferences();" />
							
				</td>
				
				<td  >
				
					  <input type="button" name="savebutton" id="submit-button" value="Save" 
						onclick="saveicitem();" />
							
				</td>
				
			</tr>
		
		</table>
		<div id="showinferencesdiv" style="display:none">
			<table border="0"  style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
				<tr >
					<td colspan="4" align="center">
						<b>Stock Level Inferences</b>
					</td>
				</tr>
				
				<tr >
					<td colspan="3">
						<b>Normal Sales/Consumption (E) = (A+B)/2</b>
					</td>
					<td>
						<input  style="background-color:lightgray;" type="text" id="avgusage" name="avgusage" value="<?php echo $avgusage; ?>"  readonly />
					</td>
					
				</tr>
				<tr >
					<td colspan="3">
						<b>Normal Lead Time (F) = (C+D)/2</b>
					</td>
					<td>
						<input  style="background-color:lightgray;" type="text" id="avglead" name="avglead" value="<?php echo $avglead; ?>"  readonly />
					</td>
					
				</tr>
				<tr >
					<td colspan="3">
						<b>Reorder Level (G) = A*C</b>
					</td>
					<td>
						<input  style="background-color:lightgray;" type="text" id="reorderlvl" name="reorderlvl" value="<?php echo $reorderlvl; ?>"  readonly />
					</td>
					
				</tr>
				<tr >
					<td colspan="3">
						<b>Minimum Stock (Safety Stock) (H) = G - (E * F)</b>
					</td>
					<td>
						<input  style="background-color:lightgray;" type="text" id="minstock" name="minstock" value="<?php echo $minstock; ?>"  readonly />
					</td>
					
				</tr>
				<tr >
					<td colspan="3">
						<b>Reorder Quantity (I) = G + H</b>
					</td>
					<td>
						<input  style="background-color:lightgray;" type="text" id="reorderqty" name="reorderqty" value="<?php echo $reorderqty; ?>"  readonly />
					</td>
					
				</tr>
				<tr >
					<td colspan="3">
						<b>Maximum Stock (J) =  G + I - (B * D)</b>
					</td>
					<td>
						<input  style="background-color:lightgray;" type="text" id="maxstock" name="maxstock" value="<?php echo $maxstock; ?>"  readonly />
					</td>
					
				</tr>
				
			</table>
		</div?
		
	</div>	

			<?php } ?>
	</form>
</div>

<script>
	function showinferences()
	{
		
		var inferencebutton = document.getElementsByName('showtheinference');
		var inference = document.getElementById('showinferencesdiv');
		
		if (inferencebutton[0].value=="Show Inferences")
		{
			inference.style.display = "block";
			inferencebutton[0].value="Hide Inferences";
		}else
		{
			inference.style.display = "none";
			inferencebutton[0].value="Show Inferences";
		}
			
	}
	
	function refreshoption() 
	{
		var maxusage = document.getElementById('maxusage').value;
		var minusage = document.getElementById('minusage').value;
		var maxlead = document.getElementById('maxlead').value;
		var minlead = document.getElementById('minlead').value;
		
		var avglead = document.getElementById('avglead');
		var avgusage = document.getElementById('avgusage');
		var reorderlvl = document.getElementById('reorderlvl');
		var minstock = document.getElementById('minstock');
		var reorderqty = document.getElementById('reorderqty');
		var maxstock = document.getElementById('maxstock');
		
		avgusage.value = (Number(maxusage) + Number(minusage))/2;
		avglead.value = (Number(maxlead) + Number(minlead))/2;
		reorderlvl.value = Number(maxusage) * Number(maxlead) ;
		minstock.value = Number(reorderlvl.value) - (Number(avgusage.value) * Number(avglead.value));
		reorderqty.value = Number(reorderlvl.value) + Number(minstock.value);
		maxstock.value = Number(reorderlvl.value) + Number(reorderqty.value) - (Number(minusage) * Number(minlead));
		
		
    }
	
	
	
	function saveicitem(){
		if (confirm('Are you sure the entries are correct?')) 
		{
			var $form_itemdesc = $('#itemdesc').val();
			var $form_item = $('#item').val();$form_reorderqty = $('#reorderqty').val();
			var $form_minusage = $('#minusage').val();var $form_maxusage = $('#maxusage').val();
			var $form_minlead = $('#minlead').val();var $form_maxlead = $('#maxlead').val();
			var $form_avgusage = $('#avgusage').val();var $form_avglead = $('#avglead').val();
			var $form_minstock = $('#minstock').val();var $form_maxstock = $('#maxstock').val();
			var $form_reorderlvl = $('#reorderlvl').val();
			
			var $goahead = 1;
					
			if ($form_item.trim() =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Item ID ");
			}	
		
			
			
			
			if ($goahead == 1) {
				thegetpage='item_settings.php?op=saving&item='+$form_item+'&itemdesc='+$form_itemdesc
					+'&reorderqty='+$form_reorderqty+'&reorderqty='+$form_reorderqty
					+'&maxusage='+$form_maxusage+'&minlead='+$form_minlead
					+'&maxlead='+$form_maxlead+'&avgusage='+$form_avgusage
					+'&avglead='+$form_avglead+'&minusage='+$form_minusage
					+'&minstock='+$form_minstock+'&reorderlvl='+$form_reorderlvl
					+'&maxstock='+$form_maxstock;		
				//alert(thegetpage);	
				getpage(thegetpage,'page');						
			}
	
		}
	}


		
</script>