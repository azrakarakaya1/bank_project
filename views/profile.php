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

// Get current admin's data
$stmt = $conn->prepare("SELECT * FROM admin WHERE first_name = ? AND last_name = ?");
$stmt->bind_param("ss", $first, $last);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Get all admins
$allAdminsQuery = $conn->query("SELECT * FROM admin");
$allAdmins = [];
if ($allAdminsQuery) {
    $allAdmins = $allAdminsQuery->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 20px;
      background-color: #f5f5f5;
      color: #333;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    
    h2 {
      color: #2c3e50;
      border-bottom: 2px solid #3498db;
      padding-bottom: 10px;
      margin-top: 0;
    }
    
    .profile-section {
      display: flex;
      align-items: center;
      margin-bottom: 30px;
      padding: 20px;
      background: #ecf0f1;
      border-radius: 8px;
    }
    
    .profile-photo {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      border: 5px solid #3498db;
      margin-right: 30px;
    }
    
    .profile-info {
      flex: 1;
    }
    
    .profile-info p {
      margin: 10px 0;
      font-size: 16px;
    }
    
    .profile-info strong {
      color: #2c3e50;
    }
    
    .btn {
      display: inline-block;
      padding: 10px 20px;
      background: #3498db;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      margin-top: 10px;
      transition: background 0.3s;
    }
    
    .btn:hover {
      background: #2980b9;
    }
    
    .admins-section {
      margin-top: 30px;
    }
    
    .admins-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }
    
    .admin-card {
      background: #ecf0f1;
      padding: 15px;
      border-radius: 8px;
      text-align: center;
      transition: transform 0.3s;
    }
    
    .admin-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .admin-photo {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #3498db;
      margin-bottom: 10px;
    }
    
    .no-admins {
      text-align: center;
      padding: 20px;
      background: #ecf0f1;
      border-radius: 8px;
      color: #7f8c8d;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Admin Profile</h2>
    
    <div class="profile-section">
      <img src="../<?php echo $admin['photo']; ?>" class="profile-photo" alt="Profile Photo">
      <div class="profile-info">
        <p><strong>Username:</strong> <?php echo htmlspecialchars($admin['username']); ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['name']); ?></p>
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
      </div>
    </div>
    
    <div class="admins-section">
      <h2>All Administrators</h2>
      
      <?php if (!empty($allAdmins)): ?>
        <div class="admins-grid">
          <?php foreach ($allAdmins as $admin): ?>
            <div class="admin-card">
              <img src="../<?php echo htmlspecialchars($admin['photo']); ?>" class="admin-photo" alt="Admin Photo">
              <h3><?php echo htmlspecialchars($admin['first_name'] . ' ' . htmlspecialchars($admin['last_name'])); ?></h3>
              <p><?php echo htmlspecialchars($admin['username']); ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="no-admins">
          <p>No administrators found.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>