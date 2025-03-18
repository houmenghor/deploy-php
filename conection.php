<?php 
//     $con = new mysqli("localhost","root","","php1");
// if ($con->connect_error) {
//     die("". $con->connect_error);
// }

$host = "on4dh.h.filess.io";
$port = 61002;
$username = "testdeployvercel_threewest";
$password = "3215ea003174e8c9cbb06ef1248b6ff57dad0ea5";
$database = "testdeployvercel_threewest";

// Create connection
$con = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "";
?>
