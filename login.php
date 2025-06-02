/processes login request: login.php/

<?php
session_start();
include "includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Admin login
    if (isset($_POST["admin_login"])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $admin = $result->fetch_assoc();

            // Use password_verify for hashed password
            if (password_verify($password, $admin['password'])) {
                $_SESSION['role'] = 'admin';
                $_SESSION['name'] = $admin['first_name'] . ' ' . $admin['last_name'];
                header("Location: views/main.php");
                exit();
            }
            else {
                header("Location: views/login_form.php?error=Incorrect+password");
                exit();
            }
        }
        else {
            header("Location: views/login_form.php?error=Admin+not+found");
            exit();
        }
    }
    // Visitor login
    elseif (isset($_POST['visitor_login'])) {
        $_SESSION['role'] = 'visitor';
        $_SESSION['name'] = 'Visitor';
        header("Location: views/main.php");
        exit();
    }
}
?>