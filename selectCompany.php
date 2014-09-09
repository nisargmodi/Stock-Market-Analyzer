<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
	<title>Select a company</title>
	<style type="text/css">
	.container{
		width: 300px;	
		margin:auto;	
	}

	</style>
<script src="http://code.jquery.com/jquery-latest.min.js"
        type="text/javascript"></script>
<script type="text/javascript">

function display(){
	var company=document.getElementById("inp").value;
	console.log(company);
	$.ajax({
		url: "getCompanyDetails.php?symbol="+company,
		type: "GET",
		success: function(result){
			$("#details").html(result);
		}
	});
}

</script>
</head>
<body>
<div class="container">
	Select a company of our choice to view details
	<br>
	<form>
		<input list="company" name="company" style="width:200px" id="inp">
		<datalist id="company">
			<?php require 'includes/connect.php';

			$query=mysql_query("select * from companyList");
			while ($row=mysql_fetch_array($query)) {
				# code...
				$name=$row['name'];
				$symbol=$row['symbol'];
				echo "<option value=\"$symbol\">$name";
			}
			 ?>
			</datalist>
			<button>Search</button>

	</form>
	<div id="details">
	<?php

require 'includes/connect.php';
$symbol=$_GET['company'];
$query=mysql_query("select * from companyList where symbol='$symbol';");
$row=mysql_fetch_array($query);
$name=$row['name'];
$sym=$row['symbol'];
$sector=$row['sector'];
$ind=$row['industry'];

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
</div>
	
</body>
</html>