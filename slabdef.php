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
		<h3><strong><font size='10'>Slab Discount Definition  
		</font></strong></h3>
		<?php
			if ($_SESSION['somasters']==1){
				
				$thelbound = Array();
				$theubound = Array();
				$thedisc = Array();
				$thetargetdisc = Array();
				
				
				
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";
			$branch_code = "";
			$periodyear = $_SESSION['periodyear'];
			$periodmonth = $_SESSION['periodmonth'];
			$reqst_by = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
			$selectslab = !isset($_REQUEST['selectslab'])?'':$dbobject->test_input($_REQUEST['selectslab']);
			$user = $_SESSION['username_sess'];
			
			$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin'])?"":$dbobject->test_input($_REQUEST['searchin']);

			$slabid = !isset($_REQUEST['slabid'])?'':$dbobject->test_input($_REQUEST['slabid']);
			$slabdesc = !isset($_REQUEST['slabdesc'])?'':$dbobject->test_input($_REQUEST['slabdesc']);
			$item_count = !isset($_REQUEST['item_count'])?0:$dbobject->test_input($_REQUEST['item_count']);
			$iftarget = !isset($_REQUEST['iftarget'])?0:$dbobject->test_input($_REQUEST['iftarget']);
			
			$sql_slabdef = "select distinct * FROM slabdef WHERE 1=1 order by trim(slabdesc)";
			$result_slabdef = mysqli_query($_SESSION['db_connect'],$sql_slabdef);
			$count_slabdef = mysqli_num_rows($result_slabdef);
				
			$k=0;
			while ($k<$count_slabdef){
				$row = mysqli_fetch_array($result_slabdef);
				$slabdef_var[$k]['slabid']=$row['slabid'];
				$slabdef_var[$k]['slabdesc']=$row['slabdesc'];
				
				$k++;
			}
				
				
			$sql_for_report = "select * from reptable where reportid = 59";
				$result_for_report = mysqli_query($_SESSION['db_connect'],$sql_for_report);
				$count_for_report = mysqli_num_rows($result_for_report);
				
				if ($count_for_report > 0){
					$rowreport = mysqli_fetch_array($result_for_report);
					
				}
				
				
			
			if($op=='searchkeyword'){
				if (trim($keyword) !=''){
					
					$sql_request = "select *  from slabdef where trim(slabid)  = '$keyword'";
					$result_request = mysqli_query($_SESSION['db_connect'],$sql_request);
					$count_request = mysqli_num_rows($result_request);
					//echo "<br/>".$sql_request."<br/>";
					if ($count_request >=1){
						$row = mysqli_fetch_array($result_request);
						$slabid    = $row['slabid'];
						$slabdesc   = $row['slabdesc'];
						$iftarget = $row['iftarget'];
						
					}else 	
					{
					?>
						<script>
						
						$('#item_error').html("<strong>Slab Definition does not exist</strong>");
						</script>
					<?php	
					}
				}
				else
				{
					?>
						<script>
						
						$('#item_error').html("<strong>Keyword is empty</strong>");
						</script>
					<?php
				}
			}	

			if($op=='getselectslab')
				{
					$filter = "";
					
					$sql_Q = "SELECT * FROM slabdef where  ";
									
					$filter="  upper(trim(slabid)) = upper('$slabid')  ";
					
											
					
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
						$slabid    = $row['slabid'];
						$slabdesc   = $row['slabdesc'];
						$iftarget = $row['iftarget'];
						

					}else 	
					{
					?>
						<script>
						
						$('#item_error').html("<strong>Slab Definition does not exist</strong>");
						</script>
					<?php	
					}	
					
					
				}			
		
		
			
			if($op=='saveslabdef')
			{
				$saverecord = 1;
					
					//obtain Slab discount details
					for ($i=0; $i < $item_count; $i++)
					{
						$thelbound[$i] = $_REQUEST['lbound'.$i];
						$theubound[$i] = $_REQUEST['ubound'.$i];
						$thedisc[$i] = $_REQUEST['disc'.$i];
						$thetargetdisc[$i] = $_REQUEST['targetdisc'.$i];
	
					}	
					
					
					
					
					
					if ($saverecord == 1 ){	
						//records can be saved
						
						$sql_checkslab = "select distinct * FROM slabdef WHERE trim(slabid) = '$slabid'";
						$result_checkslab = mysqli_query($_SESSION['db_connect'],$sql_checkslab);
						$count_checkslab = mysqli_num_rows($result_checkslab);
						if ($count_checkslab > 0)
						{
							$sql_SaveSlab = " update slabdef set  
								slabdesc = '$slabdesc',  
								iftarget  = $iftarget.VALUE 
								where trim(slabid) = '$slabid'";
								
							$dbobject->apptrail($user,'Slab Discount',$slabdesc,date('d/m/Y H:i:s A'),'Modified');
						}else
						{
							$sql_SaveSlab = " insert into slabdef ( slabid, slabdesc, iftarget ) 
								 values ('$slabid', '$slabdesc' , $iftarget  ) ";
							
							$dbobject->apptrail($user,'Slab Discount',$slabdesc,date('d/m/Y H:i:s A'),'Created');	 
			
						}
						
						
						$result_SaveSlab = mysqli_query($_SESSION['db_connect'],$sql_SaveSlab);			
						
						$sql_deleteSlabdisc = " delete from slabdisc where trim(slabid) = '$slabid'";
						$result_deleteSlabdisc = mysqli_query($_SESSION['db_connect'],$sql_deleteSlabdisc);	
						
						//save product details to loadings
						for ($i=0; $i < $item_count; $i++)
						{
							$sql_SaveSlabDetails = " insert into slabdisc ( slabid, lbound, ubound, disc, targetdisc )  
								 values ('$slabid', "  . $thelbound[$i] .  " , " . $theubound[$i] . ", ". $thedisc[$i] .
								  ",  " . $thetargetdisc[$i] .  " ) ";
							
							
							$result_SaveSlabDetails = mysqli_query($_SESSION['db_connect'],$sql_SaveSlabDetails);
						
						}
						
						
						
						?>
							<script>
							
							$('#item_error').html("<strong>The Slab Definition was saved </strong>");
							</script>
						<?php	
						
					}else
						{
							
							?>
								<script>
								
								$('#item_error').html("<strong>Slab Definition not Saved</strong>");
								</script>
							<?php	
							
						}
					
					
					
			}	

	//obtain slab discounts if any
				$sql_slabdisc = "select distinct * FROM slabdisc WHERE trim(slabid) = '$slabid'";
				$result_slabdisc = mysqli_query($_SESSION['db_connect'],$sql_slabdisc);
				$count_slabdisc = mysqli_num_rows($result_slabdisc);
				
			
				$k=0;
				while ($k<$count_slabdisc){
					$row = mysqli_fetch_array($result_slabdisc);
					$slabdisc_var[$k]['slabid']=$row['slabid'];
					$slabdisc_var[$k]['lbound']=$row['lbound'];
					$slabdisc_var[$k]['ubound']=$row['ubound'];
					$slabdisc_var[$k]['disc']=$row['disc'];
					$slabdisc_var[$k]['targetdisc']=$row['targetdisc'];
					
					$k++;
				}
			
			
				


			
// ****		
		?>
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		
		<input type="hidden" id="no_itemsincart" value="<?php echo $count_slabdisc;?>" />
		<input type="hidden" name="thetablename" id="thetablename" value="slabs" />
		<input type="hidden" name="get_file" id="get_file" value="slabdef" />
		
		<div id="items_in_cart">
		
		<?php 
			//create hidden inputs to hold vital discount details
				$itemsincart = '';
				for ($k=0;$k<$count_slabdisc;$k++)
				{
					$itemsincart = $itemsincart.'lbound'.$slabdisc_var[$k]['lbound'].'*';
					?>
						
						<input type="hidden" name="<?php echo 'lbound'.$slabdisc_var[$k]['lbound'];?>" 
												id="<?php echo 'lbound'.$slabdisc_var[$k]['lbound'];?>" 
												value ="<?php echo $slabdisc_var[$k]['lbound'];?>" />
												
						<input type="hidden" name="<?php echo 'ubound'.$slabdisc_var[$k]['lbound'];?>" 
												id="<?php echo 'ubound'.$slabdisc_var[$k]['lbound'];?>" 
												value ="<?php echo $slabdisc_var[$k]['ubound'];?>" />
												
						<input type="hidden" name="<?php echo 'disc'.$slabdisc_var[$k]['lbound'];?>" 
												id="<?php echo 'disc'.$slabdisc_var[$k]['lbound'];?>" 
												value ="<?php echo $slabdisc_var[$k]['disc'];?>" />
												
						<input type="hidden" name="<?php echo 'targetdisc'.$slabdisc_var[$k]['lbound'];?>" 
												id="<?php echo 'targetdisc'.$slabdisc_var[$k]['lbound'];?>" 
												value ="<?php echo $slabdisc_var[$k]['targetdisc'];?>" />						
				<?php
				}	
		
		?>
		
		</div>
		<input type="hidden" id="itemsincart" value="<?php echo $itemsincart; ?>" />
		<table >
			<tr>
				<td colspan="2" style="color:red;" id = "item_error" align = "left"  ></td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="input-group">
						<b>Search by: <i>Name or Code</i> </b>&nbsp;
						<input type="text" size="35px" id="search" placeholder="Search for Discount" />
						<input name="keyword" type="hidden" class="table_text1"  id="keyword" value="<?php echo $keyword; ?>" />
					
					</div>
					<!-- Suggestions will be displayed in below div. -->
					
					   <div id="display"></div>
				</td>  
				
			</tr>
			
		</table>

		
		<table border="0"  style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
			<tr >
				<td nowrap="nowrap">
					<b>Slab ID : </b>
				</td>
				<td colspan="2">
					<input type="text" name="slabid" id="slabid" value="<?php echo $slabid; ?>" <?php if ($slabid != ''){echo "style='color:gray'" ;echo 'readonly';} ?> placeholder="Enter Slab ID" />
				</td>
				<td  align="right" nowrap="nowrap">
				
					  <input type="button" name="refreshbutt" id="submit-button" value="Refresh" title ="Click to Prepare for fresh record"
						onclick= "javascript:  getpage('slabdef.php?','page');">
				
				</td>
			</tr>
			<tr>
				<td nowrap="nowrap">
					<b>Slab Description : </b>
				</td>
				<td  colspan="2">
					<input type="text" size="40%" name="slabdesc" id="slabdesc" value="<?php echo $slabdesc; ?>"  placeholder="Enter Slab Description" />
				</td>
				<td>
					<b>Target Based Slab</b>&nbsp;&nbsp;<input title="Tick if this is a Target Based Slab" type="checkbox" id="iftarget" <?php if ($iftarget==1){echo 'checked';} ?> />
				</td>
			</tr>
			
			<tr >
				<td  valign="top">
					<b>Lower Bound</b>
				</td>
				<td>
					<input type="number" name="lbound" id="lbound" title ="Enter Lower Bound Volume or Quantity"  value="" />
				</td>
				<td  valign="top">
					<b>Upper Bound</b>
				</td>
				<td>
					<input type="number" title ="Enter Upper Bound Volume or Quantity" name="ubound" id="ubound"  value="" />
				</td>
			</tr>
			<tr>
				<td  >
					<b>Discount %</b>
				</td>
				<td>
					<input type="number" title ="Default Discount %" name="disc" id="disc" max="100"  value="" />
				</td>
				<td >
					<b>Target Discount %</b>
				</td>
				<td>
					<input title ="Target Based Discount %" type="number" name="targetdisc" id="targetdisc" max="100" value="" />
				</td>
			</tr>
				<tr>
				<td colspan="4">
					<input type="button" name="addproduct" id="submit-button" value="Add Details" onclick="myAddItem();">				
					
				</td>
			</tr>
		</table>
		
		<div style="overflow-x:auto;" >
		<table  border="1"  style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px" id="productlistTable">
			
			<thead>
				<tr class="right_backcolor">
					<th nowrap="nowrap" class="Corner">&nbsp;</th>
					<th nowrap="nowrap" class="Odd">Lower Bound</th>
					<th nowrap="nowrap" class="Odd">Upper Bound</th>
					<th nowrap="nowrap" class="Odd">Discount %</th>
					<th nowrap="nowrap" class="Odd">Target Based Discount</th>
					<th nowrap="nowrap">&nbsp;</th>
				</tr>
			</thead>
			<?php 
						$k = 0;
						

						while($k< $count_slabdisc) 
						{
							
						?>
							<tr id="<?php echo $slabdisc_var[$k]['lbound']; ?>">
								<td></td>
								<td>
									<?php echo $slabdisc_var[$k]['lbound']; ?>
								</td>
								<td>
									<?php echo $slabdisc_var[$k]['ubound']; ?>
								</td>
								<td>
									<?php echo $slabdisc_var[$k]['disc']; ?>
								</td>
								<td>
									<?php echo $slabdisc_var[$k]['targetdisc']; ?>
								</td>
								<td> <input type="button" id="<?php echo 'but'.$slabdisc_var[$k]['lbound']; ?>" onclick="myremoveitem(this.id);" value="X"/>'</td>
							</tr>
						<?php 
							$k++;
							} //End If Result Test	
						?>								
						
			
		</table>
		</div>
		
		
		<table>
		 
			<tr>
				
				<td  align="right" nowrap="nowrap">
					
					  <input type="button" name="approvebutton" id="submit-button" value="Save" 
						onclick="mysavefunction();">
					
				</td>
				
					
				
		  	<?php if ($count_for_report > 0){ ?>
				<td nowrap="nowrap">
					
					<input type="hidden" id="the_reportname" value="<?php echo trim($rowreport['procname']);?>" />
					<input type="hidden" id="the_reportdesc" value="<?php echo trim($rowreport['reportdesc']);?>" />
					<input type="hidden" id="thestartdate" value="<?php echo trim($rowreport['startdate']);?>" />
					<input type="hidden" id="the_location" value="<?php echo trim($rowreport['location']);?>" />													
					<input type="hidden" id="the_product" value="<?php echo trim($rowreport['product']);?>" />		
					<input type="hidden" id="the_purchaseorder" value="<?php echo trim($rowreport['purchaseorder']);?>" />	
					<input type="hidden" id="the_vendor" value="<?php echo trim($rowreport['vendor']);?>" />	
					<input type="hidden" id="the_customer" value="<?php echo trim($rowreport['customer']);?>" />														
					<input type="hidden" id="the_salesperson" value="<?php echo trim($rowreport['salespsn']);?>" />													
																		
																		
					
					  <input type="button" name="closebutton" id="submit-button" value="Report" 
						onclick="javascript: 
							var reportname = $('#the_reportname').val();var reportdesc = $('#the_reportdesc').val();
							var startdate = $('#the_startdate').val();var location = $('#the_location').val();
							var product = $('#the_product').val();var purchaseorder = $('#the_purchaseorder').val();
							var vendor = $('#the_vendor').val();var customer = $('#the_customer').val();var salespsn = $('#the_salespsn').val();
							
						getpage('reportheader.php?calledby=slabdef&reportname='+reportname+'&reportdesc='+reportdesc+'&thestartdate='+startdate+'&location='+location+'&product='+product+'&purchaseorder='+purchaseorder+'&vendor='+vendor+'&customer='+customer+'&salesperson='+salespsn,'page');" />
				</td>
				<?php } ?>
		  </tr>
		  
		</table>
		


			<?php } ?>
	</form>
	<br/>
					
		  <input type="button" name="closebutton" id="submit-button" value="Back" 
			onclick="javascript:  getpage('s_and_d.php?','page');
				">
		
	<br/>
</div>

<script>


function mysavefunction(){
	if (confirm('Are you sure the entries are correct?')) {
		var $goahead = 1;
		
		 //determine how many products are in the cart
		var $item_count = $('#no_itemsincart').val();
		
		 var $form_slabid = $('#slabid').val();
		 var $form_slabdesc = $('#slabdesc').val();

		 if (Number($item_count) == 0){$goahead = $goahead * 0;alert('Slab Discount Details Not Provided');}
		 if ($form_slabid==''){$goahead = $goahead * 0;alert('Specify Slab ID');}
		 if ($form_slabdesc==''){$goahead = $goahead * 0;alert('Specify Slab Description');}
		
		
		if (document.getElementById("iftarget").checked){
				var $form_iftarget = 1;
			}else {var $form_iftarget = 0;}
		
				
				
		if($goahead == 1)
		{
			//prepare to save 
						
			//obtain the items in the cart
			var theitemsincart = document.getElementById("itemsincart").value;
			//split to individual products
			const myArrayOfSlabs = theitemsincart.split("*");
			
			var productstring = '';
			var id_number = '';
			
			for(i=0;i< $item_count;i++){
				id_number = myArrayOfSlabs[i].substring(6);
				thelbound = $('#lbound'+id_number).val();
				theubound = $('#ubound'+id_number).val();
				thedisc = $('#disc'+id_number).val();
				thetargetdisc = $('#targetdisc'+id_number).val();
				//alert('the control name is #lbound'+id_number+' and value is '+thelbound);
				productstring = productstring +'&lbound'+i+'='+thelbound+'&ubound'+i+'='+theubound
							+'&disc'+i+'='+thedisc+'&targetdisc'+i+'='+thetargetdisc;
			}
			
			
			
			getpagestring='slabdef.php?op=saveslabdef';
			getpagestring = getpagestring +'&slabid='+$form_slabid+'&iftarget='+$form_iftarget+'&item_count='+$item_count+'&slabdesc='+$form_slabdesc+productstring;
			
			
			
			//alert('the getpage string '+getpagestring);
			
			getpage(getpagestring,'page');
			
			
		}else {
			alert('Cannot Save This Slab Definition');
		}
		
	}	
}


function myremoveitem(clicked) {
	
	if (confirm('Are you sure of this action?')) {
		
		var therowid = clicked.substring(3);
		
		var row = document.getElementById(therowid);
		row.parentNode.removeChild(row);
		

		var thehiddenlbound = document.getElementById('lbound'+therowid);
		var thehiddenubound = document.getElementById('ubound'+therowid);
		var thehiddendisc = document.getElementById('disc'+therowid);
		var thehiddentargetdisc = document.getElementById('targetdisc'+therowid);
		

		thehiddenlbound.parentNode.removeChild(thehiddenlbound);
		thehiddenubound.parentNode.removeChild(thehiddenubound);
		thehiddendisc.parentNode.removeChild(thehiddendisc);
		thehiddentargetdisc.parentNode.removeChild(thehiddentargetdisc);
		
		alert(therowid+' Slab Line Item Removed');
		
		var addeditems = document.getElementById("itemsincart");
		var thevalue = addeditems.value;
		
		
		var newvalue = thevalue.replace('lbound'+therowid+'*','');
		//alert(newvalue);
		addeditems.value = newvalue;
		
		

		//deduct from number of items in cart
		var item_count = document.getElementById("no_itemsincart");
		
		item_count.value = Number($('#no_itemsincart').val()) - 1;
	}
}






function myAddItem() {
  var $form_lbound = $('#lbound').val();
  var $form_ubound = $('#ubound').val();
  var $form_disc = $('#disc').val();
  var $form_targetdisc = $('#targetdisc').val();
  var $form_slabid = $('#slabid').val();
 
   let $addrow = 1;

  if ($form_lbound==''){$addrow = $addrow * 0; alert('Specify Lower Bound Value');}
 if ($form_disc==''){$addrow = $addrow * 0;alert('Specify Upper Bound Value');}
  if ($form_ubound==''){$addrow = $addrow * 0;alert('Specify Discount');}
   if ($form_slabid==''){$addrow = $addrow * 0;alert('Specify Slab ID');}
  if (Number($form_lbound) >= Number($form_ubound)){$addrow = $addrow * 0;alert('Lower Bound cannot be greater than Upper Bound');}
  
  var no_of_addeditems = document.getElementById("no_itemsincart");
  var addeditems = document.getElementById("itemsincart");
  var x = addeditems.value;
  let noofaddeditems = no_of_addeditems.value;
			
	if (Number(noofaddeditems) != 0){
			//obtain the slabid
			//split to individual slabs
			const myArrayOfSlabs = x.split("*");
			 
			var id_number = '';
			for(i=0;i< noofaddeditems;i++){
				
				id_number = myArrayOfSlabs[i].substring(6);
				
				prev_lbound = $('#lbound'+id_number).val();
				prev_ubound = $('#ubound'+id_number).val();
				
				// if the upper and lower bounds are contained in as existing slab
				
				if (Number($form_lbound) >= Number(prev_lbound) && Number($form_lbound) <= Number(prev_ubound) ) {
					$addrow = $addrow * 0;
					alert('The Lower Bound is already contained in an existing Range');
					
				}
				if (Number($form_ubound) >= Number(prev_lbound) && Number($form_ubound) <= Number(prev_ubound) ){
					$addrow = $addrow * 0;
					alert('The Upper Bound is already contained in an existing Range');
					
				}
			}
			
	
		
	}
			
  if ($addrow==1){
	  
	  //Attempt to get the product element using document.getElementById
    var element = document.getElementById("lbound"+$form_lbound);

    //If it isn't "undefined" and it isn't "null", then it exists.
    if(typeof(element) != 'undefined' && element != null){
        alert('Slab already added!');
    } else{
        
		
			//add the control
			var container = document.getElementById("items_in_cart");
			//purpose is to track  items while adding
			var $lbound_to_add = '<input type="text" id="lbound'+$form_lbound+'" name ="lbound'+$form_lbound+'" value="'+$form_lbound+'" />';
			var $ubound_to_add = '<input type="hidden" id="ubound'+$form_lbound+'" name ="ubound'+$form_lbound+'" value="'+$form_ubound+'" />';
			var $disc_to_add = '<input type="hidden" id="disc'+$form_lbound+'" name ="disc'+$form_lbound+'" value="'+$form_disc+'" />';
			var $targetdisc_to_add = '<input type="hidden" id="targetdisc'+$form_lbound+'" name ="targetdisc'+$form_lbound+'" value="'+$form_targetdisc+'" />';
			
			container.innerHTML += $lbound_to_add;
			container.innerHTML += $ubound_to_add;
			container.innerHTML += $disc_to_add;
			container.innerHTML += $targetdisc_to_add;
			
			//to identify items_in_cart for processing
			//var addeditems = document.getElementById("itemsincart");
			addeditems.value += 'lbound'+$form_lbound+'*';
			
						
			//var no_of_addeditems = document.getElementById("no_itemsincart");
			
			no_of_addeditems.value = Number(no_of_addeditems.value) +1;
			
			//var $therowid = Number($('#no_itemsincart').val());
			
			  var table = document.getElementById("productlistTable");
			  var row = table.insertRow();
			  row.id = $form_lbound;
			  var cell1 = row.insertCell(0);
			  var cell2 = row.insertCell(1);
			  var cell3 = row.insertCell(2);
			  var cell4 = row.insertCell(3);  
			  var cell5 = row.insertCell(4);
			  var cell6 = row.insertCell(5); 
			  
		  
			  //cell1.innerHTML = $therowid;
			  cell2.innerHTML = $form_lbound;
			  cell3.innerHTML = $form_ubound+'&nbsp;&nbsp;';
			  cell4.innerHTML = $form_disc;
			  cell5.innerHTML = $form_targetdisc;
			  
			  var $forbutton = '<input type="button" id="but'+$form_lbound+'" onclick="myremoveitem(this.id);" value="X"/>';
			  cell6.innerHTML = $forbutton;
			 
			 
		
				
    }
	
  
  }else {alert('Cannot Add Slab Details')}


  
}


</script>