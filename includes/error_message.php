// error message

<?php
if (isset($_GET['error'])) {
    echo "<p style='color:red;'>".$_GET['error']."</p>";
}
?>