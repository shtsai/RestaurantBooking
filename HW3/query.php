<html>
<head>
</head>

<body>
<h1> Welcome to Sean's Restaurant Booking Website! </h1>

<?php 
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "RestaurantBooking";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    

$cname = $_POST['cname'];
$date = date_parse_from_format("Y-m-d", $_POST['date']); 
$month = $date["month"];
$day = $date["day"];
$year = $date["year"];
$cquantity = $_POST['cquantity'];
$stime = $_POST['stime'];

$query = "SELECT DISTINCT rid, rname, raddress, description
	  FROM restaurant NATURAL JOIN booking 
	  WHERE rid NOT IN (SELECT rid
			FROM restaurant NATURAL JOIN booking
			WHERE YEAR(btime) = $year 
			AND MONTH(btime) = $month
			AND DAY(btime) = $day
			AND HOUR(btime) = $stime
			GROUP BY rid
			HAVING capacity - SUM(quantity) < $cquantity)";
if (strlen($_POST['keyword']) > 0) {
    $query .= "AND (description LIKE '%{$_POST['keyword']}%' OR rname LIKE '%{$_POST['keyword']}%')";
}
$query .= ";";

echo "Hi " . $cname . "!<br><br>" ;
$result = $conn->query($query);
if ($result->num_rows > 0) {
    echo "Below is a list of available restaurant that you might be interested in:<br><br>";
    echo "<table>";
    while ($row = $result->fetch_assoc()) {
	$tmp = "<input type=\"hidden\" name=\"rid\" value=" . $row["rid"] . ">"
	      . "<input type=\"hidden\" name=\"cname\" value= '$cname'>"
	      . "<input type=\"hidden\" name=\"cquantity\" value=" . $cquantity . ">"
	      . "<input type=\"hidden\" name=\"date\" value=" . $_POST['date'] . ">"
	      . "<input type=\"hidden\" name=\"stime\" value=" . $stime . ">";

	$tmp2 = "<input type=\"submit\" value=\"Reserve\">";
	echo "<tr>";
	echo "<td>" . $row['rname'] . "</td><td>" . $row['raddress'] . "</td><td>" . $row['description'] 
	     . "</td><td><form action=\"reserve.php\" method=\"post\">" . $tmp . $tmp2 . "</form></td>";
	echo "</tr>";
    }
    echo "</table>";
} else {
    echo "There is no result.";
}

$conn->close();
?>

</body>
</html>
