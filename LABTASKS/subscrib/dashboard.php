<?php
include 'db.php'; // session already started here

// Check login
if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

// Popup message
$popup = "";
if(isset($_SESSION['message'])){
    $popup = $_SESSION['message'];
    unset($_SESSION['message']);
}

$email = $_SESSION['email'];

// Get current plan
$stmt = $conn->prepare("SELECT plan FROM users WHERE email = ?");

if($stmt){
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    $currentPlan = $data['plan'] ?? "Basic";
} else {
    $currentPlan = "Basic";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<style>
body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background-color: #141414;
    color: white;
    text-align: center;
}

h2 {
    margin-top: 40px;
}

.plan-container {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-top: 40px;
}

.plan-card {
    background: #1f1f1f;
    padding: 30px;
    width: 200px;
    border-radius: 10px;
    transition: 0.3s;
    box-shadow: 0 0 10px rgba(255,0,0,0.3);
}

.plan-card:hover {
    transform: scale(1.05);
}

.plan-card h3 {
    color: #e50914;
}

button {
    background: #e50914;
    border: none;
    padding: 10px 20px;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 15px;
}

button:disabled {
    background: gray;
    cursor: not-allowed;
}

/* Modal */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.85);
  display: flex;
  justify-content: center;
  align-items: center;
  animation: fadeIn 0.4s ease-in-out;
}

.modal-content {
  background: #1f1f1f;
  padding: 40px;
  border-radius: 12px;
  text-align: center;
  width: 350px;
  box-shadow: 0 0 25px #e50914;
  transform: scale(0.8);
  animation: zoomIn 0.3s forwards;
}

.modal-content h2 {
  color: #e50914;
}

.modal-content button {
  margin-top: 20px;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes zoomIn {
  to { transform: scale(1); }
}
</style>

</head>
<body>

<?php if($popup != ""): ?>
<div id="premiumModal" class="modal">
  <div class="modal-content">
    <h2>🎉 Success!</h2>
    <p><?php echo $popup; ?></p>
    <button onclick="closeModal()">Continue</button>
  </div>
</div>
<?php endif; ?>

<h2>Welcome <?php echo htmlspecialchars($_SESSION['user']); ?></h2>
<p>Current Plan: <b><?php echo htmlspecialchars($currentPlan); ?></b></p>

<div class="plan-container">

<!-- Basic -->
<div class="plan-card">
<h3>Basic</h3>
<p>₹499 / month</p>
<ul style="text-align:left; font-size:14px;">
    <li>✔ Access to Gym Equipment</li>
    <li>✔ Locker Facility</li>
    <li>✔ 1 Hour Daily Access</li>
    <li>❌ Personal Trainer</li>
    <li>❌ Diet Plan</li>
</ul>
<a href="subscribe.php?plan=Basic">
<button <?php if($currentPlan=="Basic") echo "disabled"; ?>>
<?php echo ($currentPlan=="Basic") ? "Active" : "Subscribe"; ?>
</button>
</a>
</div>

<!-- Standard -->
<div class="plan-card">
<h3>Standard</h3>
<p>₹999 / month</p>
<ul style="text-align:left; font-size:14px;">
    <li>✔ All Basic Features</li>
    <li>✔ 2 Hours Daily Access</li>
    <li>✔ Group Workout Sessions</li>
    <li>✔ Basic Diet Plan</li>
    <li>❌ Personal Trainer</li>
</ul>
<a href="subscribe.php?plan=Standard">
<button <?php if($currentPlan=="Standard") echo "disabled"; ?>>
<?php echo ($currentPlan=="Standard") ? "Active" : "Subscribe"; ?>
</button>
</a>
</div>

<!-- Premium -->
<div class="plan-card">
<h3>Premium</h3>
<p>₹1499 / month</p>
<ul style="text-align:left; font-size:14px;">
    <li>✔ All Standard Features</li>
    <li>✔ Unlimited Gym Access</li>
    <li>✔ Personal Trainer</li>
    <li>✔ Advanced Diet Plan</li>
    <li>✔ Free Supplements Guidance</li>
</ul>
<a href="subscribe.php?plan=Premium">
<button <?php if($currentPlan=="Premium") echo "disabled"; ?>>
<?php echo ($currentPlan=="Premium") ? "Active" : "Subscribe"; ?>
</button>
</a>
</div>

</div>



<br><br>
<a href="logout.php"><button>Logout</button></a>

<script>
function closeModal(){
  document.getElementById("premiumModal").style.display = "none";
}
</script>

</body>
</html>