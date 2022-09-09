<?php 
	ob_start();
	include_once "session_track.php";
?>

<script type="text/javascript" src="js/Filevalidation.js"></script>
<script type="text/javascript" src="js/dynamic_search_script.js"></script>
<div align ="center" id="data-form" > 
	<input type="button" name="closebutton" id="submit-button" title="Close"  value="Close" onclick="javascript:  $('#data-form').hide();">	
	<?php 
		require_once("lib/mfbconnect.php"); 
	?>

	

	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="POST" id="form1"  enctype="multipart/form-data" >
		<h3><strong><font size='12'>Receive Product</font></strong></h3>
		<?php
			
			if ($_SESSION['receiveprod']==1){
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";
			$branch_code = "";
			$periodyear = $_SESSION['periodyear'];
			$periodmonth = $_SESSION['periodmonth'];
			$reqst_by = $_SESSION['username_sess'];
			
			$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin'])?"":$dbobject->test_input($_REQUEST['searchin']);

			$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
			
			
			$item_count = !isset($_REQUEST['item_count'])?0:$_REQUEST['item_count'];
			$selectlocation = !isset($_REQUEST['selectlocation'])?"":$_REQUEST['selectlocation'];
			
			$theitems = Array();
			$theitemsQty = Array();
			$thebaseprice = Array();
			$thesubloc = Array();	
			$thevatduprice = Array();
			$theprice = Array();
			$thetax = Array();
			$thecost = Array();
			$theitemsavgcost = Array();
			$theitemsonhand = Array();
			$item_var  = Array();
			$location_var = Array();
			$vendor_var = Array();
			
			$vat = !isset($_REQUEST['vat'])?0:$_REQUEST['vat'];	
			$company = !isset($_REQUEST['company'])?'':$_REQUEST['company'];
			
			$vendorno = !isset($_REQUEST['vendorno'])?"":$_REQUEST['vendorno'];
			$selectvendor = !isset($_REQUEST['selectvendor'])?'':$_REQUEST['selectvendor'];
			
			$selectproduct = !isset($_REQUEST['selectproduct'])?'':$dbobject->test_input($_REQUEST['selectproduct']);
			$vesselname = !isset($_REQUEST['vesselname'])?'':$dbobject->test_input($_REQUEST['vesselname']);
			$captain = !isset($_REQUEST['captain'])?'':$dbobject->test_input($_REQUEST['captain']);
			$rec_remark = !isset($_REQUEST['rec_remark'])?'':$dbobject->test_input($_REQUEST['rec_remark']);
			$receivd_dt = !isset($_REQUEST['receivd_dt'])?date("Y-m-d"):$_REQUEST['receivd_dt'];
			$item = !isset($_REQUEST['item'])?"":$_REQUEST['item'];
			$selectitem = !isset($_REQUEST['selectitem'])?$item:$_REQUEST['selectitem'];
			$item = !empty($item)?$item:$selectitem;
			
			$selectitemsubloc = !isset($_REQUEST['selectitemsubloc'])?"":$_REQUEST['selectitemsubloc'];
			
			$count_getpmtdetails = 0;
			
			// obtain next refno
				$sql_const = "select next_inv_rcpt_no from const where 1=1";
				//echo $sql_const;
				$result_const = mysqli_query($db_connect,$sql_const);
				$count_const = mysqli_num_rows($result_const);
				
				$next_refno = 1;
				if ($count_const>0)
				{
					$row = mysqli_fetch_array($result_const);
					if ($row['next_inv_rcpt_no'] == 99999)
					{
						$next_refno = 1;
					}
						else{
							$next_refno = $row['next_inv_rcpt_no'];
						}
				}
				
				$transdate = date("d/m/Y H:i:s");
				$refnoday = substr($transdate,0,2);$refnomonth = substr($transdate,3,2);$refnoyear = substr($transdate,6,4); 
				
				$refno =  "INVRCV". $refnoday.$refnomonth.$refnoyear.$next_refno;
				$lpo_no = !isset($_REQUEST['lpo_no'])?$refno:$_REQUEST['lpo_no'];
				
							$sql_item = "select distinct * from icitem order by itemdesc";
				$result_item = mysqli_query($_SESSION['db_connect'],$sql_item);
				$count_item = mysqli_num_rows($result_item);
				$item_var_count = $count_item ;
				
				$k=0;
				while ($k<$count_item){
					$row = mysqli_fetch_array($result_item);
					$item_var[$k]['item']=$row['item'];
					$item_var[$k]['itemdesc']=$row['itemdesc'];
					
					$k++;
				}
			
			
			
				$sql_location = "select distinct * from lmf order by loc_name";
				$result_location = mysqli_query($_SESSION['db_connect'],$sql_location);
				$count_location = mysqli_num_rows($result_location);
				$location_var_count = $count_location ;
				//if ($count_location > 0) {$location_var = mysqli_fetch_all($result_location,MYSQLI_ASSOC);}
				$k=0;
				while ($k<$count_location){
					$row = mysqli_fetch_array($result_location);
					$location_var[$k]['loccd']=$row['loccd'];
					$location_var[$k]['loc_name']=$row['loc_name'];
					$k++;
				}
				
				
			
			
				$sql_vendor = "select distinct * from vendors order by company";
				$result_vendor = mysqli_query($_SESSION['db_connect'],$sql_vendor);
				$count_vendor = mysqli_num_rows($result_vendor);
				$vendor_var_count = $count_vendor ;
				//if ($count_vendor > 0) {$vendor_var = mysqli_fetch_all($result_vendor,MYSQLI_ASSOC);}
				$k=0;
				while ($k<$count_vendor){
					$row = mysqli_fetch_array($result_vendor);
					$vendor_var[$k]['vendorno'] = $row['vendorno'];
					$vendor_var[$k]['company']=$row['company'];
					$k++;
				}
				
			
			
			
			
						
			if($op=='searchkeyword'){
				if (trim($keyword) !=''){
					
					$sql_request = "select *  from vendors where vendorno  like '%".trim($keyword)."%'";
					$result_request = mysqli_query($_SESSION['db_connect'],$sql_request);
					$count_request = mysqli_num_rows($result_request);
					
					if ($count_request >=1){
						$row = mysqli_fetch_array($result_request);
						$selectvendor= $row['vendorno'];
						$vendorno= $row['vendorno'];
						$selectvendor = trim($row['vendorno'])."*  ". trim($row['company']) ;
					}else 	
					{
						$selectvendor= '';
					?>
						<script>
						
						$('#item_error').html("<strong>Vendor does not exist</strong>");
						</script>
					<?php	
					}	
				}
			}	

			if($op=='save_inv_recceipt'){
				$saverecord = 1;
			
			
				//check if submitted vendor exists
				$sql_checkvendor = "select * from vendors where trim(vendorno) = '$vendorno'";
				//echo $sql_checkvendor;
				$result_checkvendor = mysqli_query($_SESSION['db_connect'],$sql_checkvendor);
				$count_checkvendor = mysqli_num_rows($result_checkvendor);
					
				if ($count_checkvendor >=1)
				{
					$row       = mysqli_fetch_array($result_checkvendor);
					$vendorno    = $row['vendorno'];
					$company   = $row['company'];

				}else { 
					$saverecord = 0;
					?>
						<script>
						
						$('#item_error').html("<strong>Vendor does not exist</strong>");
						</script>
					<?php	
				}
				
				//check if the receiving reference has been used before
				$sql_checkreceipt = "select * from rec_invent where trim(inv_recpt_no) = '$lpo_no'";
				//echo $sql_checkreceipt;
				$result_checkreceipt = mysqli_query($_SESSION['db_connect'],$sql_checkreceipt);
				$count_checkreceipt = mysqli_num_rows($result_checkreceipt);
					
				if ($count_checkreceipt >=1)
				{
					$saverecord = 0;
					?>
						<script>
						
						$('#item_error').html("<strong>This Document has already been received</strong>");
						</script>
					<?php	
				}	

				//get the items
				$thetotalcost = 0;
				//echo "item count ".$item_count;
				for ($i=0; $i < $item_count; $i++)
				{
					$itemdetails = explode("_",$_REQUEST['item'.$i]);
					$theitems[$i] = $itemdetails[0];
					
					$theitemsQty[$i] = $_REQUEST['itemqty'.$i];
					$thebaseprice[$i] = $_REQUEST['itembaseprice'.$i];
					$thesubloc[$i] = $_REQUEST['itemsubloc'.$i];
					//obtain material account
					$sql_getaccount = "select * from icitem where trim(item) = '".$theitems[$i]."'";
					//echo "<br />".$sql_getaccount;
					$result_getaccount = mysqli_query($_SESSION['db_connect'],$sql_getaccount);
					$count_getaccount = mysqli_num_rows($result_getaccount);
					if ($count_getaccount > 0) {
						$row       = mysqli_fetch_array($result_getaccount);
						$theitemsDescription[$i]    = $row['itemdesc'];
						$theitemschartcode[$i]    = $row['chartcode'];
						//echo "<br />".$theitemschartcode[$i];
						$theitemschartdescription[$i]    = $row['description'];
						$theitemsavgcost[$i]    = $row['avgcost'];
						$theitemsonhand[$i]    = $row['onhand'];
						$thetax[$i] = $theitemsQty[$i] * $thebaseprice[$i] * $vat/100;
						$theprice[$i] = $theitemsQty[$i] * $thebaseprice[$i];
						
						$thecost[$i] = $theprice[$i] + $thetax[$i];
						
						$thetotalcost += $thecost[$i];
						
					}else {
							$saverecord = 0;
							?>
								<script>
								
								$('#item_error').html("<strong>Item Not Found</strong>");
								</script>
							<?php	
						}
		
				}
				
				//$target_dir = $_SERVER['DOCUMENT_ROOT']."/tmpfolder/";
				$source_dir = $_SESSION['tmp_target_dir'];
				$source_file = $source_dir . md5($lpo_no).".pdf";
				$source_picture_file = $source_dir . md5($lpo_no).".jpg";
				
				//$target_dir = $_SERVER['DOCUMENT_ROOT']."/documents/";
				$target_dir = $_SESSION['target_dir'];
				$target_file = $target_dir . md5($lpo_no).".pdf";
				$target_picture_file = $target_dir . md5($lpo_no).".jpg";
				
				$supportdoc = '';
				if (! (file_exists($source_file) || file_exists($source_picture_file)) )
				{
					$saverecord = 0;
					?>
						<script>
						
						$('#item_error').html("<strong>Please Verify Supporting Document</strong>");
						</script>
					<?php	
				}
				$thefileextention = '';
				if (file_exists($source_file)){$thefileextention = 'pdf';$supportdoc = md5($lpo_no).".pdf";}
				if (file_exists($source_picture_file)){$thefileextention = 'jpg';$supportdoc = md5($lpo_no).".jpg";}
				$receivd_dt_tosave = substr($receivd_dt,8,2)."/".substr($receivd_dt,5,2)."/".substr($receivd_dt,0,4);
				if ($saverecord == 1){
					
						for ($i=0; $i < $item_count; $i++)
						{
							
							
							// **saving inventory transaction
							$sql_rec_invent = " insert into rec_invent  
									   (rec_remark,supportdoc,vesselname,captain,purchaseorderno,item,qtyreceived,unitprice,totalcost,itemdesc,prodcost,tax,taxpercent,  
										  periodmonth,periodyear,loccd,subloc,inv_recpt_no,receivd_dt,vendorno,company,chartcode,description,receivd_by) 
										  values ('$rec_remark','$supportdoc','$vesselname','$captain', '$lpo_no','" . $theitems[$i] . "'," . $theitemsQty[$i] . " ," . $thebaseprice[$i] . " ," .
										 $thecost[$i] . " ,'" . $theitemsDescription[$i] . "'," .$theprice[$i] . " ," . $thetax[$i] .
										 ",$vat, '$periodmonth','$periodyear','$selectlocation','".
										 $thesubloc[$i] . "','$lpo_no','$receivd_dt_tosave','$vendorno','$company','" . $theitemschartcode[$i] .
										 "','" . $theitemschartdescription[$i] . "','$reqst_by')";
												
							$result_rec_invent = mysqli_query($_SESSION['db_connect'],$sql_rec_invent);
						
							//echo "<br />".$sql_rec_invent;
							$average_cost = ($theitemsavgcost[$i]==0)? $thecost[$i]/$theitemsQty[$i]:
																 (($theitemsavgcost[$i] * $theitemsonhand[$i]) + $thecost[$i])/($theitemsonhand[$i] + $theitemsQty[$i]);
							$sql_QueryStr_icitem = " update icitem set 
								  onhand = onhand + " . $theitemsQty[$i] .
								", useable_onhand = useable_onhand + " . $theitemsQty[$i] .
								", avgcost = " . $average_cost .
								 " where trim(item) = '" . $theitems[$i] ."'";

							$result_QueryStr_icitem = mysqli_query($_SESSION['db_connect'],$sql_QueryStr_icitem);
							//echo "<br />".$sql_QueryStr_icitem;
						

							// **updating itemloc onhand 

							$sql_itemloc = " update itemloc set 
								  onhand = onhand + " . $theitemsQty[$i] .
								", useable_onhand = useable_onhand + ".  $theitemsQty[$i] .
								 " where trim(item) = '" . $theitems[$i] ."' and " .
								 " trim(loccd) = '$selectlocation'";

									
							$result_itemloc = mysqli_query($_SESSION['db_connect'],$sql_itemloc);

							// **updating itemsubloc onhand 
						
							$sql_itemsubloc = " update itemsubloc set 
								  onhand = onhand + " .  $theitemsQty[$i] .
								", useable_onhand = useable_onhand + " .  $theitemsQty[$i] .
								 " where trim(item) = '"  . $theitems[$i] . "' and  
								 trim(loccd) = '$selectlocation' and  
								 trim(subloc) = '" . $thesubloc[$i] ."'";

							$result_itemsubloc = mysqli_query($_SESSION['db_connect'],$sql_itemsubloc);			
						
							$sql_const_next_inv_rcpt_no = " update const set 
								  next_inv_rcpt_no = $next_refno + 1 where 1=1" ;

							$result_const_next_inv_rcpt_no = mysqli_query($_SESSION['db_connect'],$sql_const_next_inv_rcpt_no);
							
							// ** creating journal entry
							$sql_CreateJournal2 = "call CreateJournalEntries('INVENTORYRECV','".$theitemschartcode[$i]."','". $theitemschartdescription[$i] .' - ' .$theitemsDescription[$i] ."'," . $thecost[$i] .",'".date('d/m/Y H:i:s A')."','$periodmonth','$periodyear')";
									
							$result_CreateJournal2 = mysqli_query($_SESSION['db_connect'],$sql_CreateJournal2);	
						
						}
						
						if ($thefileextention == 'pdf'){
							if (copy ($source_file, $target_file))
							{
								unlink($source_file);
							}
						}
						
						
						if ($thefileextention == 'jpg'){
							if (copy ($source_picture_file, $target_picture_file))
							{
								unlink($source_picture_file);
							}
						}
						
						$dbobject->apptrail($reqst_by,'Inventory',$lpo_no,date('d/m/Y H:i:s A'),'Inventory Receipt');
						
						echo "<h3>The Inventory Receipt Number is <b>$lpo_no</b></h3>";
						?>
							<script>
							
							$('#item_error').html("<strong>The Transaction was saved </strong>");
							</script>
						<?php
						
				}

				
				
			}
	
			
			$sql_itemsubloc = "select *  from itemsubloc where trim(loccd) = '".trim($selectlocation)."'";
			$result_itemsubloc = mysqli_query($_SESSION['db_connect'],$sql_itemsubloc);
			$count_itemsubloc = mysqli_num_rows($result_itemsubloc);
			//if ($count_itemsubloc > 0) {$itemsubloc_var = mysqli_fetch_all($result_itemsubloc,MYSQLI_ASSOC);}
			//echo $sql_itemsubloc;
			$k=0;
			while ($k<$count_itemsubloc){
				$row = mysqli_fetch_array($result_itemsubloc);
				$itemsubloc_var[$k]['loccd'] = $row['loccd'];
				$itemsubloc_var[$k]['item']=$row['item'];
				$itemsubloc_var[$k]['subloc']=$row['subloc'];
				$k++;
			}
			
			//create hidden inputs to hold vital subinventory details
				for ($k=0;$k<$count_itemsubloc;$k++)
				{
					
					?>
						<input type="hidden" name="<?php echo 'subloc'.$itemsubloc_var[$k]['loccd'].$itemsubloc_var[$k]['item'].$itemsubloc_var[$k]['subloc'];?>" 
												id="<?php echo 'subloc'.$itemsubloc_var[$k]['loccd'].$itemsubloc_var[$k]['item'].$itemsubloc_var[$k]['subloc'];?>" 
												value ="" />
						
				<?php
				}	
			
		?>
		<input type="hidden" name="periodmonth" id="periodmonth" value="<?php echo $periodmonth; ?>" />
		<input type="hidden" name="periodyear" id="periodyear" value="<?php echo $periodyear; ?>" />
		
		<input type="hidden" id="no_itemsincart" value=0 />
		<input type="hidden" id="itemsincart" value="" />
		<input type="hidden" name="thetablename" id="thetablename" value="vendor" />
		<input type="hidden" name="get_file" id="get_file" value="inventory_receipt" />
		
		<div id="items_in_cart"></div>
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<table  border="0"  style="border:1px solid black;padding:2px;border-collapse:separate;border-radius:15px">
			<tr>
				<td colspan="4" style="color:red;" id = "item_error" align = "left"  ></td>
			</tr>
			<tr>
				<td colspan="4">
					<div class="input-group">
						<b>Search by: <i>Name or Code or Phone Number</i> </b>&nbsp;
						<input type="text" size="35px" id="search" placeholder="Search for Vendor" />
						<input name="keyword" type="hidden" class="table_text1"  id="keyword" value="<?php echo $keyword; ?>" />
					
					</div>
					<!-- Suggestions will be displayed in below div. -->
					<br />
					   <div id="display"></div>
				</td>  
				
			</tr>
			
			
			<tr>
				<td>
					<b>Ref. Doc:</b>
				</td>
				<td align="center" ><input type="text" name="lpo_no" id="lpo_no" value="<?php echo $lpo_no; ?>"  > </td>
				<td colspan="2" >
					&nbsp;&nbsp;&nbsp;
					<b>Select Vendor</b>
					&nbsp;&nbsp;
						<?php 
						$k = 0;
						?>
						<select name="selectvendor"   id="selectvendor" >
							<option  value="" ></option>
						<?php

						while($k< $vendor_var_count) 
						{
							//$row = mysqli_fetch_array($result_client);
							$theselectedvendor = trim($vendor_var[$k]['vendorno'])."*  ". trim($vendor_var[$k]['company']) ;
						?>
							<option  value="<?php echo trim($vendor_var[$k]['vendorno']) ;?>" <?php  echo ($keyword== trim($vendor_var[$k]['vendorno']) ?"selected":""); ?>>
								<?php echo trim($vendor_var[$k]['company']) ;?> 
							</option>
							
						<?php 
							$k++;
							} //End If Result Test	
						?>								
						</select>
					
				</td>
			</tr>
			
			<tr>
				<td>
					<b>Vessel Name:</b>
				</td>
				<td align="center" ><input type="text" name="vesselname" id="vesselname" value="<?php echo $vesselname; ?>"  > </td>
				<td   colspan="2">
					&nbsp;&nbsp;&nbsp;&nbsp;<b>Captain</b> 
				&nbsp;&nbsp;&nbsp;		
					<input type="text" name="captain" id="captain" value="<?php echo $captain; ?>"  >
				</td>
			</tr>
		</table>
		<br />
		
		<div style="overflow-x:auto;" >
		<table border="0"  style="border:1px solid black;padding:2px;border-collapse:separate;border-radius:15px">
			<tr >
				<td  align="center" ><strong>Location:</strong>
					&nbsp;
					<?php 
						$k = 0;
						?>
						<select name="selectlocation"   id="selectlocation" onChange="getsublocation()">
							<option  value="" ></option>
						<?php

						while($k< $location_var_count) 
						{
								
						?>
							<option  value="<?php echo trim($location_var[$k]['loccd']) ;?>"  <?php echo ($selectlocation==trim($location_var[$k]['loccd'])?"selected":""); ?>  ><?php echo trim($location_var[$k]['loc_name']) ;?> </option>
							
						<?php 
							$k++;
							} //End If Result Test	
						?>								
						</select>
				</td>
				<td ><strong>Sub Location :</strong>
				
				&nbsp;&nbsp;
					<?php 
						$k = 0;
						?>
						<select name="selectitemsubloc"   id="selectitemsubloc" onChange="checksubloc()" >
							<option  value="" ></option>
						<?php

						while($k< $count_itemsubloc) 
						{
								
						?>
							<option  value="<?php echo trim($itemsubloc_var[$k]['subloc']) ;?>"  <?php echo ($selectitemsubloc==trim($itemsubloc_var[$k]['subloc'])?"selected":""); ?>  ><?php echo trim($itemsubloc_var[$k]['subloc']) ;?> </option>
							
						<?php 
							$k++;
							} //End If Result Test	
						?>								
						</select>
				</td>
				

			</tr>
			<tr >
				<td  >
					<b>Select Product</b>&nbsp;&nbsp;
				
				
					<?php 
					$k = 0;
					?>
					<select name="selectproduct"   id="selectproduct" onChange="checksubloc()" >
						<option  value="" ></option>
					<?php

					while($k< $item_var_count) 
					{
						//$row = mysqli_fetch_array($result_client);
						$theselectedproduct = trim($item_var[$k]['item'])."*  ". trim($item_var[$k]['itemdesc']) ;
					?>
						<option  value="<?php echo trim($theselectedproduct) ;?>" <?php  echo ($selectproduct== $theselectedproduct ?"selected":""); ?>>
							<?php echo trim($item_var[$k]['itemdesc']) ;?> 
						</option>
						
					<?php 
						$k++;
						} //End If Result Test	
					?>								
					</select>
				</td>
				<td >
					<b>Quantity</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" size="10px"  id="productqty" name="productqty"  value = "0.00" />
					
					
				</td>
				

			</tr>
			<tr >
				
				<td>
					<!--<b>Vat/Tax %</b> --> &nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;	
						<input type="hidden" min="0" max="50" step="0.01" id="taxpercent" name="taxpercent" value = "0.00" />
					
				</td>
				<td >
						<b>Landing Cost</b> 
								&nbsp;&nbsp;&nbsp;;&nbsp
					<input type="text"  size="10px" id="baseprice" name="baseprice"  value = "0.00" />
					&nbsp;<input type="button" name="addproduct" id="submit-button" value="Add Product" onclick="myAddItem();">			
					
				</td>
				
			</tr>
		</table>
		
		</div>
		
		<br>
		
		<div style="overflow-x:auto;" >
		<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="productlistTable">
			<thead>
			<tr class="right_backcolor">
					<th nowrap="nowrap" class="Corner">&nbsp;</th>
					<td nowrap="nowrap" class="Odd" colspan="6" align="right"><b>Total Cost</b></td>
					<td id="totalcost" nowrap="nowrap" class="Odd" colspan="2" ><input align="right" type="text" id="hold_totalcost" value=0 readonly/></td>
					<th nowrap="nowrap">&nbsp;</th>
			</tr>
			</thead>
			
				<tr class="right_backcolor">
					<th nowrap="nowrap" class="Corner">&nbsp;</th>
					<th nowrap="nowrap" class="Odd">Item</th>
					<th nowrap="nowrap" class="Odd">Description</th>
					<th nowrap="nowrap" class="Odd">Sub Inventory</th>
					<th nowrap="nowrap" class="Odd">Qty Req</th>
					<th nowrap="nowrap" class="Odd">Base Price</th>
					<th nowrap="nowrap" class="Odd">Tax</th>
					<th nowrap="nowrap" class="Odd">Unit Price</th>
					<th nowrap="nowrap" class="Odd">Cost</th>
					<th nowrap="nowrap">&nbsp;</th>
				</tr>
			
			
			
		</table>
		</div>
		<br/>
		<table width="95%" cellpadding="2px">
			<tr >
				<td><p id="size"><b>Supporting Document </b></p> </td>
				<td   align="left">
					 <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*,.pdf" onchange="Filevalidation()" >
				</td>
				<td  align="center">				
					<div style="overflow-x:auto;"  id="confirmupload"></div>
					
				</td>
				
			</tr>
			<tr>
				<td> <b>Remark</b></td>
				<td > <input type="text" title="Enter a Remark"  size="30px" id="rec_remark" name="rec_remark" value="<?php echo $rec_remark; ?>" /></td>
				<td> <b>Date</b>&nbsp;<input type="date" name="receivd_dt" id="receivd_dt" value="<?php echo $receivd_dt;?>" ></td>
			</tr>
		</table>
		<hr>
		<br>
		<table>
		  <tr>
			
			
				<td  align="right" nowrap="nowrap">
					
					  <input type="button" name="savebutton" id="submit-button"  value="Save Receipt" 
						onclick="mysavefunction()">
					
				</td>
				
						
				
			
				<td  align="right">
					<a href="javascript:getpage('lookupreport.php?reportname=rec_invent','page')">List Transactions</a>
				</td>
		  
		  </tr>
		  
		</table>
		<div style="overflow-x:auto;"  id="imagePreview"></div>
			<?php } ?>
	</form>
	<br />
	 <input type="button" name="closebutton" id="submit-button" value="Back" 
						onclick="javascript:  getpage('inventory.php','page');
							">
	<br />
</div>

<script>
	function getsublocation(){
		
		var $form_selectlocation = $('#selectlocation').val();  var $form_selectvendor = $('#selectvendor').val();
		var $vesselname = $('#vesselname').val();var $captain = $('#captain').val();
		getpage('inventory_receipt.php?op=getsublocation&selectlocation='+$form_selectlocation+'&keyword='+$form_selectvendor
		+'&vesselname='+$vesselname+'&captain='+$captain,'page');
	}
	
	function checksubloc(){
		 var $form_selectlocation = $('#selectlocation').val();
		 var $form_selectproduct = $('#selectproduct').val();
		 var $pos = $form_selectproduct.indexOf("*");
		 var $itemcode = $form_selectproduct.substring(0, $pos);
			
		 var $form_selectitemsubloc = $('#selectitemsubloc').val();
		 var $return_value = 1;
		 if ($form_selectlocation !='')
		 {
			 if ($form_selectproduct !='' && $form_selectitemsubloc != '')
			 {
				 var element = document.getElementById("subloc"+$form_selectlocation+$itemcode+$form_selectitemsubloc);

				//If it isn't "undefined" and it isn't "null", then it exists.
				if(typeof(element) == 'undefined' || element == null)
				{
					alert('Product Not Found at Selected Sub Inventory!');
					$return_value *= 0;
				}
			 }
		}else {
			 alert('Select Receiving Location!');
			 $return_value *= 0;
		 }
		return $return_value;
	}
	

	function myAddItem() {
		var $form_productqty = $('#productqty').val();
		var $baseprice = $('#baseprice').val();
		
		
		var $form_selectproduct = $('#selectproduct').val(); 
		var $form_selectitemsubloc = $('#selectitemsubloc').val();
		var $vat = $('#taxpercent').val();
		var $form_selectlocation = $('#selectlocation').val();
		
	   let $addrow = 1;
	  
	   if ($form_productqty==0){$addrow = $addrow * 0; alert('Please Enter Quantity');}
	   if (isNaN($form_productqty)){$addrow = $addrow * 0; alert('Please Enter Numberic Quantity');}
		
	   if ($baseprice==0){$addrow = $addrow * 0;alert('Please Enter Landing Cost');}
	   if (isNaN($baseprice)){$addrow = $addrow * 0;alert('Please Enter Numeric Landing Cost');}
	   
	   if ($form_selectproduct==''){$addrow = $addrow * 0;alert('Please Select Product');}
	   if ($form_selectitemsubloc==''){$addrow = $addrow * 0;alert('Please Select Sub Inventory');}
	   if (isNaN($vat)){$addrow = $addrow * 0;}
	   
	  
	  var $pos = $form_selectproduct.indexOf("*");
	  var $itemcode = $form_selectproduct.substring(0, $pos);
	  var $itemdescription = $form_selectproduct.substring($pos+1);
			
	  var $check_item_at_loc = document.getElementById("subloc"+$form_selectlocation+$itemcode+$form_selectitemsubloc);
		//If it isn't "undefined" and it isn't "null", then it exists.
		if(typeof($check_item_at_loc) == 'undefined' || $check_item_at_loc == null){
			alert('Product Not Found at Selected Sub Inventory!');
			$addrow = $addrow * 0;
		}
		
		if ($addrow==1)
		{
		
			
		  
		  //Attempt to get the product element using document.getElementById
			var element = document.getElementById("product"+$itemcode+"_"+$form_selectitemsubloc);

			//If it isn't "undefined" and it isn't "null", then it exists.
			if(typeof(element) != 'undefined' && element != null){
				alert('Product already added!');
			} else
			{
			
				var $vatduprice = Number($baseprice) * Number($vat)/100;
				var $price = Number($baseprice) + Number($vatduprice);
				
				var $cost = Number($form_productqty) * Number($price);
				

					//add the control
				var container = document.getElementById("items_in_cart");
				//purpose is to track  items while adding
				var $control_to_add = '<input type="hidden" id="product'+$itemcode+"_"+$form_selectitemsubloc+'" name ="product'+$itemcode+$form_selectitemsubloc+'" value="'+$itemcode+'" />';
				var $control_baseprice = '<input type="hidden" id="baseprice'+$itemcode+"_"+$form_selectitemsubloc+'" name ="cost'+$itemcode+$form_selectitemsubloc+'" value="'+$baseprice+'" />';
				var $control_req_qty = '<input type="hidden" id="qty'+$itemcode+"_"+$form_selectitemsubloc+'" name ="qty'+$itemcode+$form_selectitemsubloc+'" value="'+$form_productqty+'" />';
				var $control_subloc = '<input type="hidden" id="subloc'+$itemcode+"_"+$form_selectitemsubloc+'" name ="qty'+$itemcode+$form_selectitemsubloc+'" value="'+$form_selectitemsubloc+'" />';
				var $control_vat = '<input type="hidden" id="vat'+$itemcode+"_"+$form_selectitemsubloc+'" name ="qty'+$itemcode+$form_selectitemsubloc+'" value="'+$vat+'" />';
				
				container.innerHTML += $control_to_add;
				container.innerHTML += $control_baseprice;
				container.innerHTML += $control_req_qty;
				container.innerHTML += $control_subloc;
				container.innerHTML += $control_vat;
				//to identify items_in_cart for processing
				var addeditems = document.getElementById("itemsincart");
				addeditems.value += $itemcode+"_"+$form_selectitemsubloc+'*';
				
				//add to total cost
				var add_to_total_cost = document.getElementById("hold_totalcost");
				add_to_total_cost.value = Number(add_to_total_cost.value) + $cost;
				
				var no_of_addeditems = document.getElementById("no_itemsincart");
				
				no_of_addeditems.value = Number($('#no_itemsincart').val()) +1;
				
				//var $therowid = Number($('#no_itemsincart').val());
			
			  var table = document.getElementById("productlistTable");
			  var row = table.insertRow();
			  row.id = $itemcode+"_"+$form_selectitemsubloc;
			  var cell1 = row.insertCell(0);
			  var cell2 = row.insertCell(1);
			  var cell3 = row.insertCell(2);
			  var cell4 = row.insertCell(3);  
			  var cell5 = row.insertCell(4);
			  var cell6 = row.insertCell(5); 
			  var cell7 = row.insertCell(6)
			  var cell8 = row.insertCell(7);
			  var cell9 = row.insertCell(8); 
			  var cell10 = row.insertCell(9)
		  
			  //cell1.innerHTML = $therowid;
			  cell2.innerHTML = '&nbsp;&nbsp;'+$itemcode+'&nbsp;&nbsp;';
			  cell3.innerHTML = $itemdescription+'&nbsp;&nbsp;';
			  cell4.innerHTML = $form_selectitemsubloc;
			  cell5.innerHTML = $form_productqty;
			  cell6.innerHTML = $baseprice;
			  cell7.innerHTML = $vatduprice;
			  cell8.innerHTML = $price;	
			  cell9.innerHTML = $cost;
			  var $forbutton = '<input type="button" id="but'+$itemcode+"_"+$form_selectitemsubloc+'" onclick="myremoveitem(this.id);" value="X"/>';
			  cell10.innerHTML = $forbutton;
			} 
		}
	}	


	function myremoveitem(clicked) {
		
		if (confirm('Are you sure of this action?')) {
			
			var therowid = clicked.substring(3);
			var row = document.getElementById(therowid);
			row.parentNode.removeChild(row);
			

			var thehiddenproducttextbox = document.getElementById('product'+therowid);
			var thehiddenbasepricetextbox = document.getElementById('baseprice'+therowid);
			var thehiddenqtytextbox = document.getElementById('qty'+therowid);
			var thehiddensubloctextbox = document.getElementById('subloc'+therowid);
			var thehiddenvattextbox = document.getElementById('vat'+therowid);
			//obtain cost
			var productcost = thehiddenbasepricetextbox.value;
			var productqty = thehiddenqtytextbox.value;
			var productvat = thehiddenvattextbox.value;
			
			thehiddenproducttextbox.parentNode.removeChild(thehiddenproducttextbox);
			thehiddenbasepricetextbox.parentNode.removeChild(thehiddenbasepricetextbox);
			thehiddenqtytextbox.parentNode.removeChild(thehiddenqtytextbox);
			thehiddensubloctextbox.parentNode.removeChild(thehiddensubloctextbox);
			thehiddenvattextbox.parentNode.removeChild(thehiddenvattextbox);
			
			alert(therowid+' Product Line Item Removed');
			
			var addeditems = document.getElementById("itemsincart");
			var thevalue = addeditems.value;
			
			
			var newvalue = thevalue.replace(therowid+'*','');
			//alert('new value '+newvalue);
			addeditems.value = newvalue;
			
			
			//var obtaincost = document.getElementById('cost'+therowid);
			
			
			//substract from total cost
			var add_to_total_cost = document.getElementById("hold_totalcost");
			 add_to_total_cost.value = Number(add_to_total_cost.value) - ( (1+ (Number(productvat)/100)) * Number(productcost) * Number(productqty));
			
			//deduct from number of items in cart
			var item_count = document.getElementById("no_itemsincart");
			
			item_count.value = Number($('#no_itemsincart').val()) - 1;
		}
	}


function mysavefunction(){
	if (confirm('Are you sure the entries are correct?')) {
		var $goahead = 1;
		//check active period
		var $form_periodyear = $('#periodyear').val();var $form_periodmonth = $('#periodmonth').val();
		
		var $receivd_dt = $('#receivd_dt').val();
		var $form_receivd_dt = new Date($receivd_dt);
		//var today = new Date();
		var thismonth = ($form_receivd_dt.getMonth()+1);
		var thisyear = $form_receivd_dt.getFullYear();
		if(Number($form_periodyear)!= Number(thisyear) || Number($form_periodmonth) != Number(thismonth)){
			alert('Date is not within the current period');
			$goahead *= 0;
		}
		//alert($form_periodyear);
		//obtain total requested cost
		
		
		
		var $form_totalcost = $('#hold_totalcost').val();
		var supportfileInput = document.getElementById('fileToUpload');
		
		var supportfile = supportfileInput.value.split("\\");
		var supportfileName = supportfile[supportfile.length-1];
		
		if (supportfileName == '' ){
				$goahead *= 0;
				alert('Support Document not provided');
			
		}
		var $vesselname = $('#vesselname').val(); var $captain = $('#captain').val(); var $rec_remark = $('#rec_remark').val();
		if ($vesselname == '' ){
				$goahead *= 0;
				alert('Vessel Name not provided');
			
		}
		if ($rec_remark == '' ){
				$goahead *= 0;
				alert('Remark not provided');
			
		}
		if ($captain == '' ){
				$goahead *= 0;
				alert('Captain Name not provided');
			
		}
		
		var $form_selectlocation = $('#selectlocation').val();
				
		
		if ($form_selectlocation == '' ){
				$goahead *= 0;
				alert('Receiving Location Not Provided');
			
		}
		
		var $form_vendor = $('#selectvendor').val();
		var $form_lpo_no = $('#lpo_no').val();
		
		if ($form_vendor == '' ){
				$goahead *= 0;
				alert('Vendor Not Provided');
			
		}
		if ($form_lpo_no == '' ){
				$goahead *= 0;
				alert('Reference Document Not Provided');
			
		}
		
		if($form_totalcost <=0){
			$goahead *= 0;
				alert('Product cost should not be zero');
		}
		
	
				
		if($goahead == 1){
			//prepare to save 
			//determine how many products are in the cart
			var item_count = document.getElementById("no_itemsincart").value;
			
			//obtain the items in the cart
			var theitemsincart = document.getElementById("itemsincart").value;
			//split to individual products
			const myArrayOfItems = theitemsincart.split("*");
			
			//obtain itemcode and qtyreq pair
			var productstring = '';
			for(i=0;i< item_count;i++){
				//alert(myArrayOfItems[i]);
				var theqty = document.getElementById('qty'+myArrayOfItems[i]).value;
				var thebaseprice = document.getElementById('baseprice'+myArrayOfItems[i]).value;
				var thesubloc = document.getElementById('subloc'+myArrayOfItems[i]).value;
				//alert('The quantity'+theqty);
				productstring = productstring +'&item'+i+'='+myArrayOfItems[i]+'&itemqty'+i+'='+theqty+'&itembaseprice'+i+'='+thebaseprice+'&itemsubloc'+i+'='+thesubloc;
			}
			//alert('Product String '+productstring);
			
			getpagestring='inventory_receipt.php?op=save_inv_recceipt';
			var $vat = $('#taxpercent').val();
			
			
			getpagestring = getpagestring +'&selectlocation='+$form_selectlocation+'&vat='+$vat+'&receivd_dt='+$receivd_dt
											+'&vesselname='+$vesselname+'&captain='+$captain;
			
			
			getpagestring = getpagestring +'&vendorno='+$form_vendor+'&lpo_no='+$form_lpo_no;
			getpagestring = getpagestring +'&item_count='+item_count+'&rec_remark='+$rec_remark;
			getpagestring = getpagestring +productstring;
			
			
			
			///alert('the getpage string '+getpagestring);
			
			getpage(getpagestring,'page');
			
			
		}else {
			alert('Cannot Save This Product Receipt');
		}
		
	}	
}


	
</script>