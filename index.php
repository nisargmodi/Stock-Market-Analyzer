<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stock Market Analyzer</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-image: url(images/thumb.jpg);
	alignment-adjust: alphabetic;
	background-size: 100%;
	background-repeat: no-repeat;
}
td,th {
	color: #000;
	font-size: 20px;
	font-weight: bold;
	font-style: italic;
	background-color:white;
}
</style>
</head>

<body>
<p>&nbsp;</p>

<div class="details" style="width:600px; margin:auto; background-color:#fff">
<form id="form1" name="form1" method="post" action="stockDownloader.php">
<table width="270" height="203" border="2" align="right" cellpadding="5" cellspacing="2" >  
  <tr>
    <td width="77" height="67">Date :</td>
    <td width="159">
      <span id="sprytextfield1">
      <input type="text" name="Day" id="Date" />
      <span class="textfieldRequiredMsg">Please enter the date no.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
      <p><span id="sprytextfield2">
      <input type="text" name="Month" id="Month" />
      <span class="textfieldRequiredMsg">Please enter the month no.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></p>
      <p><span id="sprytextfield3">
        <input type="text" name="Year" id="Year" />
      <span class="textfieldRequiredMsg">Please enter the year no.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></p></td>
  </tr>
  <tr>
    <td height="62">Company name :</td>
    <td>
    <input list="company" name="name" style="width:200px" id="inp">
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
    
    
    <!--<span id="sprytextfield4">
      <input type="text" name="name" id="name" />
      <span class="textfieldRequiredMsg">A name is required.</span></span></td>-->
      </td>
  </tr>
  <tr><td colspan="2">Or choose from list</td>
  </tr>
  <tr>
  <td>Company List</td>
  <td><select name="name">
  <option selected>Select Company from here</option>
  <?php
  $query=mysql_query("select * from companyList");
  while ($row=mysql_fetch_array($query)) {
				# code...
				$name=$row['name'];
				$symbol=$row['symbol'];
				echo "<option value=\"$symbol\">$name</option>";
			}
			 ?>
			 </td></tr>
  <tr>
    <td colspan="2" height="62">
      <input align="right" type="submit" id="submit" value="Submit" /></td>
  </tr>
</table>
 </form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["blur"], hint:"date in number"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {validateOn:["blur"], hint:"month in number"});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur"], hint:"year in number "});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
</script>
</body>
</html>
