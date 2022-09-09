		<input type="hidden" name="username" />
		<input type="hidden" name="op" />
		<input type="hidden" name="VAR1" />
		<input type="hidden" name="data" id="data" />
		<input type="hidden" name="datafilename" id="datafilename" />
		<input name="fpage" type="hidden"  id="fpage" value="<?php echo $pageNo; ?>" size="3"/>
		<input name="tpages" type="hidden"  id="tpages" value="<?php echo $npages; ?>" size="3"/>
		
		<input type = 'hidden' name = 'sql' id='sql' value="<?php echo $download_query;?>" />
		<input type = 'hidden' name = 'filename' id='filename' value="AwaitingApprovals" />
		<input type = 'hidden' name = 'pageNo' id="pageNo" value = "<?php echo $pageNo; ?>">		
		<input type = 'hidden' name = 'rowCount' value = "<?php echo $count; ?>">
		<input type = 'hidden' name = 'skipper' value = "<?php echo $skip; ?>">
		<input type = 'hidden' name = 'pageEnd' value = "<?php echo $npages; ?>">
		
		<input type = 'hidden' name = 'custno' value = "<?php echo $custno; ?>">
		<input type = 'hidden' name = 'item' value = "<?php echo $item; ?>">
		<input type = 'hidden' name = 'loccd' value = "<?php echo $loccd; ?>">
		<input type = 'hidden' name = 'purchaseorderno' value = "<?php echo $purchaseorderno; ?>">
		<input type = 'hidden' name = 'vendorno' value = "<?php echo $vendorno; ?>">
		<input type = 'hidden' name = 'salespsn' value = "<?php echo $salespsn; ?>">
		<input type = 'hidden' name = 'startdate' value = "<?php echo $startdate; ?>">
		<input type = 'hidden' name = 'enddate' value = "<?php echo $enddate; ?>">
		<input type = 'hidden' name = 'reportname' value = "<?php echo $reportname; ?>">

		
		<input type = 'hidden' name = 'sel' />		
		<div align ="left" id="data-form_rptheader" >
		<table>
			<tr>
				<td>
					Limit :
						<select name="limit" class="table_text1"  id="limit" onchange="javascript:doSearch('<?php echo trim($reportname) ;?>.php');">
							<option value="1" <?php echo ($limit=="1"?"selected":""); ?>>1</option>
							<option value="10" <?php echo ($limit=="10"?"selected":""); ?>>10</option>
							<option value="20" <?php echo ($limit=="20"?"selected":""); ?>>20</option>
							<option value="50" <?php echo ($limit=="50"?"selected":""); ?>>50</option>
							<option value="100" <?php echo ($limit=="100"?"selected":""); ?>>100</option>
							<option value="200" <?php echo ($limit=="200"?"selected":""); ?>>200</option>
							<option value="500" <?php echo ($limit=="500"?"selected":""); ?>>500</option>
							<option value="700" <?php echo ($limit=="700"?"selected":""); ?>>700</option>
							<option value="1000" <?php echo ($limit=="1000"?"selected":""); ?>>1000</option>
						</select>
				</td>
			</tr>

			
			<tr>

				<td >No of Records : <?php echo $count; ?></td>
				<td>&nbsp;&nbsp;Page <?php echo $pageNo; ?> of <?php echo $npages; ?> </td>
				
				<td >&nbsp; &nbsp; &nbsp;&nbsp;<a href="javascript: printDiv('print_div');">Print</a>
				</td>
				
			</tr>
			<tr>
				<td >
						<?php include "navigator.php";?>
				
				</td>
				<td>&nbsp; &nbsp; &nbsp;&nbsp;
						<input type="button" name="getreport" id="submit-button" value="Back" 
							onclick="javascript: getpage('reportheader.php','page');">
				</td>
			</tr>			
		</table>
		</div>