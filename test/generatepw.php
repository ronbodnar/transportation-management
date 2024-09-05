<?php

$unencrypted_password = isset($_GET['password']) ? $_GET['password'] : '90kills';

$hash = password_hash($unencrypted_password, PASSWORD_DEFAULT);

echo $hash;