<!-- admin/visitor dashboard -->

<?php
include "../includes/session.php";

if (!isset($_SESSION['name']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Main Page</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>Banking Record Control Panel</h2>
    <h3>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h3>
    <p>You are logged in as: <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong></p>

    <div class="dashboard">
        <h3>Overview</h3>
        <ul>
            <li><a href="transaction_records.php">View Transactions</a></li>
            <li><a href="accounts.php">View Accounts</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <h3>Admin Tools</h3>
            <ul>
                <li><a href="add_account.php">Add Account</a></li>
                <li><a href="add_transaction.php">Add Transaction</a></li>
                <li><a href="manage_account.php">Manage Account</a></li>
                <li><a href="manage_transaction.php">Manage Transaction</a></li>
            </ul>
        <?php endif; ?>
    </div>

    <br>
    <a href="../logout.php">Logout</a>
</body>
</html>
