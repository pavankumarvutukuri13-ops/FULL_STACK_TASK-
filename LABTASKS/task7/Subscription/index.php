<?php
include 'db.php'; // session already started

// If user already logged in → redirect to dashboard
if(isset($_SESSION['email'])){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Membership System</title>
<link rel="stylesheet" href="style.css">

<style>
body {
    background: #141414;
    color: white;
    font-family: Arial;
    text-align: center;
}

.container {
    margin-top: 100px;
}

h1 {
    font-size: 40px;
    color: #e50914;
}

button {
    padding: 12px 25px;
    margin: 10px;
    border: none;
    background: #e50914;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background: #b00610;
}
</style>

</head>
<body>

<div class="container">
    <h1>Membership System</h1>
    <p>Welcome! Please Register or Login to continue</p>

    <a href="register.php"><button>Register</button></a>
    <a href="login.php"><button>Login</button></a>
</div>

</body>
</html>