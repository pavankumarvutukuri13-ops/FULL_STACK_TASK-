<?php
session_start();
include 'db.php';

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit;
}

$plan = $_GET['plan'];
$email = $_SESSION['email'];

$stmt = $conn->prepare("UPDATE users SET plan=? WHERE email=?");
$stmt->bind_param("ss",$plan,$email);
$stmt->execute();

// Set popup message
$_SESSION['message'] = "🎉 You are now a $plan Member!";

header("Location: dashboard.php");
exit;
?> 