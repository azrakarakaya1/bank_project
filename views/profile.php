<?php
include "../includes/session.php";
include "../includes/db.php";

if ($_SESSION['role'] !== 'admin') {
  header("Location: dashboard.php");
  exit();
}

$nameParts = explode(' ', $_SESSION['name']);
$first = $nameParts[0];
$last = $nameParts[1];

$stmt = $conn->prepare("SELECT * FROM admin WHERE first_name = ? AND last_name = ?");
$stmt->bind_param("ss", $first, $last);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Profile</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
  <h2>Admin Profile</h2>
  <p><strong>Username:</strong> <?php echo $admin['username']; ?></p>
  <p><strong>Name:</strong> <?php echo $_SESSION['name']; ?></p>
  <img src="../<?php echo $admin['photo']; ?>" width="100" height="100" alt="Profile Photo">
  <br>
  <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>