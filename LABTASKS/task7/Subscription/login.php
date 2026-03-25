<?php
include 'db.php'; // this already has session_start()

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");

    if($stmt){
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $user = $result->fetch_assoc();

            if(password_verify($password, $user['password'])){
                $_SESSION['user'] = $user['name'];
                $_SESSION['email'] = $user['email'];

                header("Location: dashboard.php");
                exit();
            } else {
                $error = "❌ Wrong Password!";
            }

        } else {
            $error = "❌ User Not Found!";
        }

    } else {
        $error = "❌ Database Error!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>Login</h2>

<?php if(isset($error)) { ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php } ?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

</div>

</body>
</html>