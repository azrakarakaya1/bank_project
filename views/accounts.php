<!-- Accounts page -->

<?php
include "../includes/session.php";
include "../includes/db.php";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Accounts</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
  <h2>Account Records</h2>

  <table border="1">
    <tr>
      <th>Account No</th>
      <th>Owner Name</th>
      <th>Owner Type</th>
      <th>Balance</th>
      <th>Activity</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Address</th>
    </tr>

    <?php
    $query = "
      SELECT a.account_number, a.owner_name, a.owner_type, a.balance, a.activity,
             c.email, c.phone, c.address
      FROM account a
      LEFT JOIN contact_info c ON a.account_number = c.account_number
      ORDER BY a.account_number
    ";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
      echo "<tr>
              <td>{$row['account_number']}</td>
              <td>{$row['owner_name']}</td>
              <td>{$row['owner_type']}</td>
              <td>{$row['balance']}</td>
              <td>{$row['activity']}</td>
              <td>{$row['email']}</td>
              <td>{$row['phone']}</td>
              <td>{$row['address']}</td>
            </tr>";
    }
    ?>
  </table>

  <a href="main.php">Back to Dashboard</a>
</body>
</html>
