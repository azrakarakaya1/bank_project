<!--processes login request: login.php -->

<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "includes/db.php";

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // --- Admin Login ---
    if (isset($_POST["admin_login"])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            if (password_verify($password, $admin['password'])) {
                $_SESSION['role'] = 'admin';
                $_SESSION['name'] = $admin['first_name'] . ' ' . $admin['last_name'];
                header("Location: views/dashboard.php");
                exit();
            } else {
                header("Location: views/login_form.php?error=Incorrect+password");
                exit();
            }
        } else {
            header("Location: views/login_form.php?error=Admin+not+found");
            exit();
        }

    // --- Visitor Login ---
    } elseif (isset($_POST['visitor_login'])) {
        $_SESSION['role'] = 'visitor';
        $_SESSION['name'] = 'Visitor';
        header("Location: views/dashboard.php");
        exit();
    }

} else {
    // If accessed directly without POST
    header("Location: views/login_form.php?error=Invalid+request");
    exit();
}
?>
