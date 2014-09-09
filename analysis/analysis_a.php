<?php
include("../includes/connect.php");

function masterLoop(){
	$mainTickerFile = fopen("../tickerMaster.txt","r");
	while(!feof($mainTickerFile)){
		$companyTicker = fgets($mainTickerFile);
		$companyTicker = trim($companyTicker);
		//$companyTicker = goog;
		$nextDayIncrease = 0;
		$nextDayDecrease = 0;
		$nextDayNoChange = 0;
		$total = 0;
		
		$sumOfIncreases = 0;
		$sumOfDecreases = 0;
		
		$sql = "SELECT date, percent_change FROM $companyTicker WHERE percent_change < '0' ORDER BY date ASC";
		$result = mysql_query($sql);
		
		if($result){
			while($row = mysql_fetch_array($result)){
				$date = $row['date'];
				$percent_change = $row['percent_change'];
				$sql2 = "SELECT date, percent_change FROM $companyTicker WHERE date > '$date' ORDER BY date ASC LIMIT 1";
				$result2 = mysql_query($sql2);
				$numberOfRows = mysql_num_rows($result2);
				
				if($numberOfRows==1){
					$row2 = mysql_fetch_row($result2);
					$tom_date = $row2[0];
					$tom_percent_change = $row2[1];
					
					if($tom_percent_change > 0){
						$nextDayIncrease++;
						$sumOfIncreases += $tom_percent_change;
						$total++;
					}else if($tom_percent_change < 0){
						$nextDayDecrease++;
						$sumOfDecreases += $tom_percent_change;
						$total++;
					}else{
						$nextDayNoChange++;
						$total++;
					}
				}else if($numberOfRows==0){
					//no data after today
				}else{
					echo "You have an error in analysis_a";
				}
				
			}
		}else{
			echo "unable to select $companyTicker <br />";
		}
		
		$nextDayIncreasePercent = ($nextDayIncrease/$total) * 100;
		$nextDayDecreasePercent = ($nextDayDecrease/$total) * 100;
		$averageIncreasePercentage = $sumOfIncreases/$nextDayIncrease;
		$averageDecreasePercentage = $sumOfDecreases/$nextDayDecrease;
		
		insertIntoResultTable($companyTicker, $nextDayIncrease, $nextDayIncreasePercent, $averageIncreasePercentage, $nextDayDecrease, $nextDayDecreasePercent, $averageDecreasePercentage);
	}
}

function insertIntoResultTable($companyTicker, $nextDayIncrease, $nextDayIncreasePercent, $averageIncreasePercentage, $nextDayDecrease, $nextDayDecreasePercent, $averageDecreasePercentage){
	
	$buckysBuyValue = $nextDayIncreasePercent * $averageIncreasePercentage;
	$buckysSellValue = $nextDayDecreasePercent * $averageDecreasePercentage;
	
	$query="SELECT * FROM analysisA WHERE ticker='$companyTicker' ";
	$result=mysql_query($query);
	$numberOfRows = mysql_num_rows($result);
	
	if($numberOfRows==1){
		$sql = "UPDATE analysisA SET ticker='$companyTicker',daysInc='$nextDayIncrease',pctOfDaysInc='$nextDayIncreasePercent',avgIncPct='$averageIncreasePercentage',daysDec='$nextDayDecrease',pctOfDaysDec='$nextDayDecreasePercent',avgDecPct='$averageDecreasePercentage',buckysBuyValue='$buckysBuyValue',buckysSellValue='$buckysSellValue' WHERE ticker='$companyTicker' ";
		mysql_query($sql);
	}else{
		$sql="INSERT INTO analysisA (ticker,daysInc,pctOfDaysInc,avgIncPct,daysDec,pctOfDaysDec,avgDecPct,buckysBuyValue,buckysSellValue) VALUES ('$companyTicker', '$nextDayIncrease', '$nextDayIncreasePercent', '$averageIncreasePercentage', '$nextDayDecrease', '$nextDayDecreasePercent', '$averageDecreasePercentage', '$buckysBuyValue', '$buckysSellValue')";
		mysql_query($sql);
	}
}

masterLoop();
?>