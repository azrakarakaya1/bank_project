// main entry file that shows login form

<?php
session_start();
if (isset($_SESSTION['role'])) {
    header("Location: views/main.php");
    exit();
}
include "views/login_form.html";
?>