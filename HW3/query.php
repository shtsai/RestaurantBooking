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
    

echo "Hi " . $_POST['cname'] . "!<br><br>" ;

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
    $query .= "AND description LIKE '%{$_POST['keyword']}%'";
}
$query .= ";";

$result = $conn->query($query);
if ($result->num_rows > 0) {
    echo "Below is a list of available restaurant that you might be interested in:<br>";
    echo "<table>";
    while ($row = $result->fetch_assoc()) {
	echo "<tr>";
	echo "<td>" . $row['rname'] . "</td><td>" . $row['raddress'] . "</td><td>" . $row['description'] . "</td><td>" . "1" . "</td>";
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
