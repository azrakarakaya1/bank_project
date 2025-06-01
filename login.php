// processes login request

<?php
session_start();
include "includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["admin_login"])) {
        $username = $_POST['username'];
        $password = $_POSR['password'];

        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $admin = $result->fetch_assoc();
            if ($password == $admin['password']) {
                $_SESSION['role'] = 'admin';
                $_SESSION['name'] = $admin['first_name'] . ' ' . $admin['last_name'];
                header("Location: views/main.php");
                exit();
            }
            else {
                header("Location: index.php?error=Incorrect+password");
                exit();
            }
        }
        else {
            header("Location: index.php?error=Admin+not+found");
            exit();
        }
    }
    elseif (isset($_POST['visitor'])) {
        $_SESSION['role'] = 'visitor';
        $_SESSION['name'] = 'visitor';
        header("Location: views/main.php");
        exit();
    }
}
?>