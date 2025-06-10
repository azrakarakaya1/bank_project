<!-- main entry file that shows login form -->

<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug: Show current session data
echo "<!-- Debug Info: ";
echo "Session ID: " . session_id() . " | ";
echo "POST data: " . print_r($_POST, true) . " | ";
echo "Session data: " . print_r($_SESSION, true);
echo " -->";

include "includes/db.php";

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "<!-- Processing POST request -->";
    
    // --- Admin Login ---
    if (isset($_POST["admin_login"])) {
        echo "<!-- Admin login attempt -->";
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
                $_SESSION['loggedin'] = true;
                $_SESSION['role'] = 'admin';
                $_SESSION['name'] = $admin['first_name'] . ' ' . $admin['last_name'];
                
                echo "<!-- Login successful, redirecting to dashboard -->";
                header("Location: views/dashboard.php");
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
    // --- Visitor Login ---
    } 
    elseif (isset($_POST['visitor_login'])) {
        echo "<!-- Visitor login attempt -->";
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = 'visitor';
        $_SESSION['name'] = 'Visitor';
        
        echo "<!-- Visitor login successful, redirecting to dashboard -->";
        header("Location: views/dashboard.php");
        exit();
    }
    else {
        echo "<!-- No recognized POST action -->";
        header("Location: views/login_form.php?error=Invalid+request");
        exit();
    }
}
else {
    // Not a POST request, check if already logged in
    if (isset($_SESSION['role'])) {
        echo "<!-- Already logged in, redirecting to dashboard -->";
        header("Location: views/dashboard.php");
        exit();
    }
    else {
        echo "<!-- Not logged in, showing login form -->";
        include "views/login_form.html";
    }
}
?>