<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head><title>Analysis</title>
</head>
<body>
<script type='text/javascript' src='graphAPI.js'></script>
<script type="text/javascript">
var lows = new Array();
var highs=new Array();
var year=new Array();
var month=new Array();
var day=new Array();
var i=0;
<?php
include("includes/connect.php");
global $companyTickerGlobal;
function createURL($ticker){
	$currentMonth = date("n");
	$currentMonth = $currentMonth - 1;
	$currentDay = date("j");
	$currentYear = date("Y");
	$day=$_POST['Day'];
	$month=$_POST['Month'];
	$month = $month - 1;
	$year=$_POST['Year'];
	
	return "http://ichart.finance.yahoo.com/table.csv?s=$ticker&a=$month&b=$day&c=$year&d=$currentMonth&e=$currentDay&f=$currentYear&g=d&ignore=.csv";
}

function getCSVFile($url, $outputFile){
	$content = file_get_contents($url);
	$content = str_replace("Date,Open,High,Low,Close,Volume,Adj Close", "", $content);
	$content = trim($content);
	htmlspecialchars_decode($content);
	file_put_contents($outputFile, $content);
}

function fileToDatabase($txtFile, $tableName){
	$file = fopen($txtFile,"r");
	while(!feof($file)){
		$line = fgets($file);
		$pieces = explode(",", $line);
		
		$date = $pieces[0];
		$open = $pieces[1];
		$high = $pieces[2];
		$low = $pieces[3];
		$close = $pieces[4];
		$volume = $pieces[5];
		$amount_change = $close-$open;
		$percent_change = ($amount_change/$open)*100;
		
		$sql = "SELECT * FROM $tableName";
		$result = mysql_query($sql);
		
		if(!$result){
			$sql2 = "CREATE TABLE $tableName (date DATE, PRIMARY KEY(date), open FLOAT, high FLOAT, low FLOAT, close FLOAT, volume INT, amount_change FLOAT, percent_change FLOAT)";
			mysql_query($sql2);
		}
		
		$sql3 = "INSERT INTO $tableName (date, open, high, low, close, volume, amount_change, percent_change) VALUES ('$date','$open','$high','$low','$close','$volume','$amount_change','$percent_change')";
		mysql_query($sql3);
	}
	fclose($file);
}

function main(){
	$mainTickerFile = fopen("tickerMaster.txt","r");
	while(!feof($mainTickerFile)){
		$companyTicker = fgets($mainTickerFile);
		$companyTicker=$_POST['name'];
		$companyTicker = trim($companyTicker);
		$fileURL = createURL($companyTicker);
		$companyTxtFile = "txtFiles/".$companyTicker.".txt";
		getCSVFile($fileURL, $companyTxtFile);
		fileToDatabase($companyTxtFile, $companyTicker);
		$companyTickerGlobal=$companyTicker;
		echo "var ticker=\"$companyTicker\";\n";
		 
		getFiles($companyTicker);
	}
}

main();

  function getFiles($ticker){
     
     
  $txtFile="txtFiles/".$ticker.".txt";


//echo "hello";

  $file = fopen($txtFile,"r");
  while(!feof($file)){
    $line = fgets($file);
    $pieces = explode(",", $line);
    
    $date = $pieces[0];
    $open = $pieces[1];
    $high = $pieces[2];
    $low = $pieces[3];
    $close = $pieces[4];
    $volume = $pieces[5];

    $dateFormat=explode("-", $date);
    $year=$dateFormat[0];
    $month=$dateFormat[1];
    $day=$dateFormat[2];

    //echo $low;

   // echo "document.write(".$low.");\n";
    echo "lows[i]=$low;\n";
    echo "highs[i]=$high;\n";
    echo "year[i]=$year;\n";
    echo "month[i]=$month;\n";
    echo "day[i]=$day;\n";
    
    //echo "document.write(month[i]+\" \");\n";
    //echo "document.write(day[i]+\"<br>\");\n";
    echo "i++;\n";
    
  }
}

?>
  
 
</script>
<script type="text/javascript">

      google.load('visualization', '1', {'packages':['annotatedtimeline']});
      google.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', 'Low');
        data.addColumn('string', 'title1');
        data.addColumn('string', 'text1');
        data.addColumn('number', 'High');
        data.addColumn('string', 'title2'); 
        data.addColumn('string', 'text2');
        var min=700;
        for(var j=lows.length-1;j>=0;j--){
          data.addRows([
          [new Date(year[j], month[j]-1 ,day[j]), lows[j], undefined, undefined, highs[j], undefined, undefined]
            ]);
        }

        var chart = new google.visualization.AnnotatedTimeLine(document.getElementById('chart_div'));
        chart.draw(data, {displayAnnotations: true, scaleType: 'maximized', wmode: 'transparent'});
      }

    </script>
	<?php

require 'includes/connect.php';
$symbol=$_POST['name'];
$query=mysql_query("select * from companyList where symbol='$symbol';");
$row=mysql_fetch_array($query);
$name=$row['name'];
$sym=$row['symbol'];
$sector=$row['sector'];
$ind=$row['industry'];
?>
Go back to <a href="http://iloveexpressions.com/Stocks/">HOME</a>
<br>
<h1>Showing data of <?php echo $name;?></h1>
<div id='chart_div' style='width: 700px; height:400px;position:relative;margin:auto;'></div>

<div id="details" style='width: 700px; height:400px;position:relative;margin:auto;'><br><br>

<?php
echo "<table>
<tr>
<td>Name : </td>
<td>$name</td>
</tr>

<tr>
<td>Symbol: </td>
<td>$sym</td>
</tr>

<tr>
<td>Sector: </td>
<td>$sector</td>
</tr>

<tr>
<td>Industry: </td>
<td>$ind</td>
</tr>
</table>";


?>
	</div>	
</body>
</html>