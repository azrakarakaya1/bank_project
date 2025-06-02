<!-- database connection -->

<?php
$conn = new mysqli("localhost", "root", "", "bank_project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>