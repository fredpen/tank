<?php 
	$sql_for_report = "select * from reptable where reportid = $reportid ";
	$result_for_report = mysqli_query($_SESSION['db_connect'],$sql_for_report);
	$count_for_report = mysqli_num_rows($result_for_report);
	
	if ($count_for_report > 0){
		$rowreport = mysqli_fetch_array($result_for_report);
		
	 ?>
				
					
	<input type="hidden" id="the_reportname" value="<?php echo trim($rowreport['procname']);?>" />
	<input type="hidden" id="the_reportdesc" value="<?php echo trim($rowreport['reportdesc']);?>" />
	<input type="hidden" id="thestartdate" value="<?php echo trim($rowreport['startdate']);?>" />
	<input type="hidden" id="the_location" value="<?php echo trim($rowreport['location']);?>" />													
	<input type="hidden" id="the_product" value="<?php echo trim($rowreport['product']);?>" />		
	<input type="hidden" id="the_purchaseorder" value="<?php echo trim($rowreport['purchaseorder']);?>" />	
	<input type="hidden" id="the_vendor" value="<?php echo trim($rowreport['vendor']);?>" />	
	<input type="hidden" id="the_customer" value="<?php echo trim($rowreport['customer']);?>" />														
	<input type="hidden" id="the_salesperson" value="<?php echo trim($rowreport['salespsn']);?>" />													
	<input type="hidden" id="calledby" value="<?php echo $calledby;?>" />														
														
	
	  <input type="button" name="closebutton" id="submit-button" value="Report" 
		onclick="javascript: 
			var reportname = $('#the_reportname').val();var reportdesc = $('#the_reportdesc').val();
			var startdate = $('#thestartdate').val();var location = $('#the_location').val();var calledby = $('#calledby').val();
			var product = $('#the_product').val();var purchaseorder = $('#the_purchaseorder').val();
			var vendor = $('#the_vendor').val();var customer = $('#the_customer').val();var salespsn = $('#the_salesperson').val();
			
		getpage('reportheader.php?calledby='+calledby+'&reportname='+reportname+'&reportdesc='+reportdesc+'&thestartdate='+startdate+'&location='+location+'&product='+product+'&purchaseorder='+purchaseorder+'&vendor='+vendor+'&customer='+customer+'&salesperson='+salespsn,'page');" />

<?php } ?>