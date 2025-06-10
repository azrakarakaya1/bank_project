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
    
    /* Table Styling */
    .accounts-table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
      font-size: 0.95em;
    }
    
    .accounts-table th {
      background-color: #3498db;
      color: white;
      padding: 12px 15px;
      text-align: left;
    }
    
    .accounts-table td {
      padding: 12px 15px;
      border-bottom: 1px solid #ddd;
    }
    
    .accounts-table tr:nth-child(even) {
      background-color: #f8f9fa;
    }
    
    .accounts-table tr:hover {
      background-color: #ecf0f1;
    }
    
    .status-active {
      color: #27ae60;
      font-weight: bold;
    }
    
    .status-inactive {
      color: #e74c3c;
      font-weight: bold;
    }
    
    .currency {
      text-align: right;
      font-family: 'Courier New', monospace;
    }
    
    /* Button Styling */
    .btn {
      display: inline-block;
      padding: 10px 20px;
      background: #3498db;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      margin-top: 20px;
      transition: background 0.3s;
      border: none;
      cursor: pointer;
      font-size: 0.95em;
    }
    
    .btn:hover {
      background: #2980b9;
    }
    
    /* Responsive Table */
    @media (max-width: 768px) {
      .accounts-table {
        display: block;
        overflow-x: auto;
      }
      
      .container {
        padding: 15px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Account Records</h2>

    <table class="accounts-table">
      <thead>
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
      </thead>
      <tbody>
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
          $activityClass = ($row['activity'] == 'active') ? 'status-active' : 'status-inactive';
          echo "<tr>
                  <td>{$row['account_number']}</td>
                  <td>{$row['owner_name']}</td>
                  <td>{$row['owner_type']}</td>
                  <td class='currency'>$" . number_format($row['balance'], 2) . "</td>
                  <td class='{$activityClass}'>" . ucfirst($row['activity']) . "</td>
                  <td>{$row['email']}</td>
                  <td>{$row['phone']}</td>
                  <td>{$row['address']}</td>
                </tr>";
        }
        ?>
      </tbody>
    </table>

    <a href="dashboard.php" class="btn">Back to Dashboard</a>
  </div>
</body>
</html>