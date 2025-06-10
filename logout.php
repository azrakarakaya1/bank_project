// handles logout

<?php
// Start session
session_start();

// Destroy all session data
session_destroy();

// Redirect to login form instead of index.php
header("Location: views/login_form.php");
exit();
?>