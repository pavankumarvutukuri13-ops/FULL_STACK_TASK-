<?php
$host = "localhost";
$user = "root";
$password = ""; // default empty in XAMPP
$database = "membership_db";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();
?>