<html>
<head>
</head>

<body>
<h1> Welcome to Sean's Restaurant ! </h1>

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
	<td><input type="number" name="cquantity" min="1" max="30"></td>
    </tr>
    <tr>
	<td>Date:</td>
	<td><input type="date" name="date"></td>
    </tr>
    <tr>
	<td>Time (0-23): </td>
	<td><input type="number" name="time" min="0" max="23"></td>
    </tr>
</table>
<input type="submit">
</form>


</body>

</html>
