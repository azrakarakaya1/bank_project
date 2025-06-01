// database connection

<?php
$conn = new mysqli("localhost", "root", "", "bank_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>