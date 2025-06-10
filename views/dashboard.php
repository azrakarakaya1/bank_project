<!-- admin/visitor dashboard -->

<?php
session_start();
include "../includes/session.php";
if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Banking Control Panel</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .dashboard-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .welcome-section {
            text-align: center;
            margin-bottom: 30px;
            padding: 25px;
            background-color: #4a6fa5;
            color: white;
            border-radius: 8px;
        }
        
        .welcome-title {
            font-size: 2.2rem;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        .user-info {
            font-size: 1.1rem;
            margin-bottom: 8px;
        }
        
        .role-badge {
            display: inline-block;
            padding: 6px 15px;
            background-color: rgba(255,255,255,0.2);
            border-radius: 15px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9rem;
        }
        
        .dashboard-sections {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .dashboard-card {
            flex: 1;
            min-width: 280px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }
        
        .card-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #4a6fa5;
            border-bottom: 2px solid #4a6fa5;
            padding-bottom: 8px;
        }
        
        .card-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .card-links li {
            margin-bottom: 10px;
        }
        
        .card-links a {
            color: #495057;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            background-color: white;
            border-radius: 5px;
            border: 1px solid #dee2e6;
            transition: all 0.2s ease;
        }
        
        .card-links a:hover {
            background-color: #4a6fa5;
            color: white;
            border-color: #4a6fa5;
        }
        
        .admin-card {
            border-color: #4a6fa5;
            background-color: #f1f4f8;
        }
        
        .visitor-info {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 5px;
            color: #495057;
            line-height: 1.5;
            border-left: 4px solid #4a6fa5;
        }
        
        .logout-section {
            text-align: center;
            margin-top: 25px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        
        .logout-btn {
            background-color: #4a6fa5;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s ease;
        }
        
        .logout-btn:hover {
            background-color: #3a5a94;
        }
        
        @media (max-width: 768px) {
            .dashboard-container {
                margin: 15px;
                padding: 20px;
            }
            
            .dashboard-sections {
                flex-direction: column;
            }
            
            .dashboard-card {
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="welcome-section">
            <h1 class="welcome-title">Banking Record Control Panel</h1>
            <p class="user-info">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>
            <div class="role-badge">
                <?php echo htmlspecialchars($_SESSION['role']); ?>
            </div>
        </div>
        
        <div class="dashboard-sections">
            <div class="dashboard-card">
                <h3 class="card-title">View Records</h3>
                <ul class="card-links">
                    <li><a href="transaction_records.php">Transaction Records</a></li>
                    <li><a href="accounts.php">Account Records</a></li>
                    <li><a href="profile.php">Profile <small>(Admins Only)</small></a></li>
                </ul>
            </div>
            
            <?php if ($_SESSION['role'] === 'admin'): ?>
            <div class="dashboard-card admin-card">
                <h3 class="card-title">Admin Tools</h3>
                <ul class="card-links">
                    <li><a href="add_account.php">Add New Account</a></li>
                    <li><a href="add_transaction.php">Add Transaction</a></li>
                    <li><a href="manage_account.php">Manage Accounts</a></li>
                    <li><a href="manage_transaction.php">Manage Transactions</a></li>
                </ul>
            </div>
            <?php endif; ?>
            
            <?php if ($_SESSION['role'] === 'visitor'): ?>
            <div class="dashboard-card">
                <h3 class="card-title">Visitor Access</h3>
                <div class="visitor-info">
                    You have read-only access to view banking records and transaction history. 
                    Contact an administrator for additional permissions.
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="logout-section">
            <a href="../logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>