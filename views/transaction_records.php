<!-- Transaction records page -->


<?php
include "../includes/session.php";
include "../includes/db.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transaction Records - Banking Control Panel</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        
        .page-container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 25px;
            background-color: #4a6fa5;
            color: white;
            border-radius: 8px;
        }
        
        .page-title {
            font-size: 2.2rem;
            margin: 0;
            font-weight: bold;
        }
        
        .page-subtitle {
            font-size: 1rem;
            margin-top: 8px;
            opacity: 0.9;
        }
        
        .table-container {
            overflow-x: auto;
            margin-bottom: 25px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }
        
        .records-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }
        
        .records-table th {
            background-color: #4a6fa5;
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #3a5a94;
        }
        
        .records-table td {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
            color: #495057;
        }
        
        .records-table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .records-table tbody tr:nth-child(even) {
            background-color: #fdfdfd;
        }
        
        .amount-cell {
            font-weight: bold;
            color: #28a745;
        }
        
        .id-cell {
            font-weight: bold;
            color: #4a6fa5;
        }
        
        .tags-cell {
            font-style: italic;
            color: #6c757d;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        .navigation-section {
            text-align: center;
            margin-top: 25px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        
        .back-btn {
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
        
        .back-btn:hover {
            background-color: #3a5a94;
        }
        
        .table-info {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #4a6fa5;
        }
        
        .table-info p {
            margin: 0;
            color: #495057;
            font-size: 0.95rem;
        }
        
        @media (max-width: 768px) {
            .page-container {
                margin: 15px;
                padding: 20px;
            }
            
            .page-title {
                font-size: 1.8rem;
            }
            
            .records-table th,
            .records-table td {
                padding: 8px 6px;
                font-size: 0.9rem;
            }
            
            .table-container {
                font-size: 0.85rem;
            }
        }
        
        @media (max-width: 600px) {
            .records-table th:nth-child(n+4),
            .records-table td:nth-child(n+4) {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="page-header">
            <h1 class="page-title">Transaction Records</h1>
            <p class="page-subtitle">View all banking transactions and transfers</p>
        </div>
        
        <div class="table-info">
            <p><strong>Info:</strong> This table shows all transaction records including sender, receiver, amounts, and associated tags.</p>
        </div>
        
        <div class="table-container">
            <table class="records-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Tags</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "
                        SELECT t.id, t.amount,
                            CONCAT(t.sender_name, ' (', t.sender_type, ')') AS sender,
                            CONCAT(t.receiver_name, ' (', t.receiver_type, ')') AS receiver,
                            GROUP_CONCAT(tt.name) AS tags
                        FROM transaction t
                        LEFT JOIN transaction_tag_link ttl ON t.id = ttl.transaction_id
                        LEFT JOIN transaction_tags tt ON ttl.tag_id = tt.id
                        GROUP BY t.id
                        ORDER BY t.id DESC
                    ";
                    $result = $conn->query($query);
                    
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td class='id-cell'>#{$row['id']}</td>
                                    <td class='amount-cell'>$" . number_format($row['amount'], 2) . "</td>
                                    <td>" . htmlspecialchars($row['sender']) . "</td>
                                    <td>" . htmlspecialchars($row['receiver']) . "</td>
                                    <td class='tags-cell'>" . ($row['tags'] ? htmlspecialchars($row['tags']) : 'No tags') . "</td>
                                 </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='empty-state'>No transaction records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="navigation-section">
            <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>