<?php

require 'includes/connect.php';
$symbol=$_GET{'symbol'];
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