<!-- Transaction records page -->

<?php
include "../include/sessions.php";
include "../includes/db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transactions</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>Transaction Records</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Amount</th>
            <th>Sender</th>
            <th>Receiver</th>
            <th>Tags</th>
        </tr>

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
            GROUN BY t.id DESC
        ";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['amount']}</td>
                    <td>{$row['sender']}</td>
                    <td>{$row['receiver']}</td>
                    <td>{$row['tags']}</td>
                 </tr>";
        }
        ?>
    </table>
    
    <a href="main.php">Back to Dashboard</a>
</body>
</html>