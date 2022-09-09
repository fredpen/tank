<?php 
		$startdate = substr($startdate,8,2)."/".substr($startdate,5,2)."/".substr($startdate,0,4);
		$enddate = substr($enddate,8,2)."/".substr($enddate,5,2)."/".substr($enddate,0,4);

		$additionalwhereclause = $dbobject->docase($startdate,$enddate,$custno,$salespsn,$item,$loccd,$vendorno,$purchaseorderno,$periodyear,$periodmonth,
					$datefield,$custnofield,$salespsnfield,$itemfield,$loccdfield,$vendornofield,$po_field,$periodyearfield,$periodmonthfield);
	
		$holdadditionalwhereclause = $additionalwhereclause <> ""?" and " . $additionalwhereclause :"";

?>