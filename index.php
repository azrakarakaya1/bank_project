<!-- main entry file that shows login form -->

<?php
session_start();
if (isset($_SESSION['role'])) {
    header("Location: views/dashboard.php");
    exit();
}
include "views/login_form.html";
?>