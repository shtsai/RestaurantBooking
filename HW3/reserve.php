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
$rid = $_POST['rid'];
$date = date_parse_from_format("Y-m-d", $_POST['date']); 
$month = $date["month"];
$day = $date["day"];
$year = $date["year"];
$cquantity = $_POST['cquantity'];
$stime = sprintf("%02d", $_POST['stime']);  // prepend 0 if needed
$timestamp = $_POST['date'] . " " . $stime . ":00:00";

echo "Hi " . $cname . "!<br><br>";

$sql_verify_user = "SELECT * FROM customer WHERE cname = '$cname';";
$verify_result = $conn->query($sql_verify_user);
if ($verify_result->num_rows == 0) {
    echo "It looks like you haven't registered yet. Please register first.<br> Thank you! <br>";
} else {
    // add record into the booking table
    $temp = $verify_result->fetch_assoc();
    $cid = $temp['cid'];
    $sql_reserve = "INSERT INTO booking (cid, rid, btime, quantity) "
		    . "VALUES ('$cid', '$rid', '$timestamp', '$cquantity')";
    if (!$conn->query($sql_reserve)) {
	echo $conn->error;
    }
    echo "Your reversation has been created!<br><br>";

    // show previous bookings
    $sql_previous_bookings = "SELECT rname, btime, quantity FROM booking NATURAL JOIN restaurant "
			    . "WHERE cid = $cid ORDER BY btime;";
    $previous_bookings = $conn->query($sql_previous_bookings);
    echo "Here is a list of your recent bookings:<br>";   
    echo "<table>";
    echo "<tr><th>Restaurant</th><th>Booking Time</th><th>Quantity</th>";
    while ($row = $previous_bookings->fetch_assoc()) {
	echo "<tr>";
	echo "<td>" . $row['rname'] . "</td>";
	echo "<td>" . $row['btime'] . "</td>";
	echo "<td>" . $row['quantity'] . "</td>";
	echo "</tr>";
    }
    echo "</table>";

}


$conn->close();
?>

</body>
</html>
