<!-- error message -->

<?php
if (isset($_GET['error'])) {
    echo '<p class="error">' . htmlspecialchars($_GET['error']) . '</p>';
}
?>