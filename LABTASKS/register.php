<?php
include 'db.php'; // session already started here

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $plan = "Basic";

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");

    if($check){
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if($result->num_rows > 0){
            $error = "❌ Email already registered!";
        } else {

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, plan) VALUES (?, ?, ?, ?)");

            if($stmt){
                $stmt->bind_param("ssss", $name, $email, $hashedPassword, $plan);

                if($stmt->execute()){
                    $_SESSION['message'] = "🎉 Registration Successful! You are now a Basic Member!";
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "❌ Registration Failed!";
                }

            } else {
                $error = "❌ Database Error!";
            }
        }

    } else {
        $error = "❌ Database Error!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2>Register</h2>

<?php if(isset($error)) { ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php } ?>

<form method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>

</div>

</body>
</html>