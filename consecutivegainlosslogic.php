<?php

//&& CHECK IF WE HAVE MORE THAN 1 RECORD TO START COMPIRING
	$consecutivecount = 0;$consecutive_array = Array();
	if ($unique_date_count > 1)
	{
		$mCapturedPrevious = 0;
		//** Note the current record
		$prev_dayoftheyear = $dailytankarray[1]['dayoftheyear'];
		$prev_index = 1;
		$u = 1;

			while($u<$unique_date_count) 
			{
				$u++;
				
				//** CHECK IF CURRENT DATE IS THE DAY AFTER YESTERDAY
				if (($prev_dayoftheyear - 1) == $dailytankarray[$u]['dayoftheyear'])
				{
					$consecutivecount++;
					//&& CHECK IF PREVIOUS RECORD IS ALREADY CAPTURED
					if ($mCapturedPrevious == 1)
					{
						//&& CAPTURE ONLY THE CURRENT RECORD
						$consecutive_array[$consecutivecount]=$u;
					}
					else
					{
						//&& CAPTURE BOTH RECORDS
						$consecutive_array[$consecutivecount]=$prev_index;
						$consecutivecount++;
						$consecutive_array[$consecutivecount]=$u;
						
					}
					$mCapturedPrevious = 1;
					
				}
				else
				{
					$mCapturedPrevious = 0;
				}
				//** Note the current record
				$prev_index = $u;
				$prev_dayoftheyear = $dailytankarray[$u]['dayoftheyear'];
				
			}
		
		
		
	}
	?>