<?php

require 'src/header.php';
require 'src/config.php';

loadConfig();

if (isLoggedIn()) {
    include 'src/views/dashboard.php';
} else {
    include 'src/views/login-form.php';
}

include 'src/footer.php';
