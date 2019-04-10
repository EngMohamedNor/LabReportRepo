<?php

//$servername = "localhost";
//$username = "root";
//$password = "";


$servername = "sql202.epizy.com";
$username = "epiz_23626301";
$password = "wtn2rmj3";
// Create connection
$con = new mysqli($servername, $username, $password,'epiz_23626301_lrr');

// Check connection
if ($con->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
} 
else
{

echo "Connected";
}
session_start();