<html>
<head><title>Analysis</title>
</head>
<body>






<?php
	include("includes/connect.php");
	$tableName=$_GET['$companyTicker'];
	$query=mysql_query("select * from ".$tableName);
	echo "<script language='JavaScript'>\n"; 
	echo "var js_array = new Array();\n"; 
	$key=0;
	while($row= mysql_fetch_array($query)){
	
	
  	echo "js_array[$key] = ".$row['low'].";\n";
  	echo "document.write(js_array[$key]+\"<br>\");\n" ;
  	$key=$key+1;
	 }
	# .....rest of JavaScript..... 
	echo "</script>\n"; 


	
?>
	<input type="button" onclick="createLayout();" value="Click here."></input>
	<canvas id="myCanvas" width="800" height="1000" style="position:absolute; top:10; left:130; border:1px solid black"></canvas>

<script type="text/javascript">
	
	function createLayout(){

		var c=document.getElementById('myCanvas');
		var ctx=c.getContext('2d');
		ctx.moveTo(10,0);
		ctx.lineTo(10,600);
		ctx.stroke();
		ctx.moveTo(10,600);
		ctx.lineTo(800,600);
		ctx.stroke();

	}

	function drawGraph(){

	var x=50;
	var cons=50;
	var trans=calcRange();
	var c=document.getElementById('myCanvas');
	var height=600;
	var ctx=c.getContext('2d');
	ctx.moveTo(10,height);
	var i=0;
	var ycord=js_array[i];
	//document.write(ycord);
	ctx.font="18px Arial";
	ctx.fillText(trans,0,height);
	

	 for(var i=0;i<js_array.length;i++){

	var ycord=js_array[i];
	var scaleY=height/(ycord-trans);
	var y=600-(ycord-trans)*scaleY;
	//document.write(y);
	ctx.lineTo(x,y);
	
	ctx.fillText(ycord,x,y);
	ctx.stroke();
	 ctx.moveTo(x,y);

	 x=x+cons;

	}
}

	function calcRange(){
		var max=0;
		var min=js_array[0];
		for(var i=0;i<js_array.length;i++){

			if(max<js_array[i]){
				max=js_array[i];
			}

			else if(min>js_array[i]){
				min=js_array[i];
			}
		}
		//document.write(min + " "+max);
		min=Math.floor(min);
		max=Math.ceil(max);
		
		return max-(max-min);
	}
	</script>

	

	
</body>
</html>