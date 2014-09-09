<html>
<head><title>Analysis</title>
</head>
<body>
<script type='text/javascript' src='graphAPI.js'></script>
    <script type='text/javascript'>


var lows = new Array();
var highs=new Array();
var year=new Array();
var month=new Array();
var day=new Array();
var i=0;

<?php
  include("includes/connect.php");
 $ticker=$_GET["ticker"];
getFiles();

  function getFiles(){
     $ticker=$_GET["ticker"];
     
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

<h1>Showing Data of : <?php echo $ticker?></h1>

<div id='chart_div' style='width: 700px; height: 400px;position:relative;margin:auto;'></div>
</body>
