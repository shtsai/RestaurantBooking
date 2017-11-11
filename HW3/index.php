<html>
<head>
</head>

<body>
<h1> Welcome to Sean's Restaurant Booking Website! </h1>

<p> You can check availability and make reservation here. </p>

<form action="query.php" method="post">
<table>
    <tr>
	<td>Customer Name: </td>
	<td><input type="text" name="cname"></td>
    </tr>
    <tr>
	<td>Keyword: </td>
	<td><input type="text" name="keyword"></td>
    </tr>
    <tr>
	<td>Number of people:</td>
	<td><input type="number" name="cquantity" value="1" min="1" max="30"></td>
    </tr>
    <tr>
	<td>Date:</td>
	<td><input type="date" name="date" value="<?php echo date('Y-m-d'); ?>"></td>
    </tr>
    <tr>
	<td>Time (0-23): </td>
	<td><input type="number" name="stime" value="0" min="0" max="23"></td>
    </tr>
</table>
<input type="submit">
</form>


</body>

</html>
