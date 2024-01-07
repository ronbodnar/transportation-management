<?php

require 'header.php';
require 'src/config.php';

loadConfig();

?>

<?php if (isLoggedIn()) {
    include 'src/views/dashboard.php';
} else {
    include 'src/views/login-form.php';
} ?>

<?php include 'footer.php'; ?>