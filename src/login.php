<?php
ini_set('session.gc_maxlifetime', 30*60); // expires in 30 minutes
session_start();

require 'Database.class.php';

$database = new Database();

if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 1800) { // session started more than 30 minutes ago
    session_unset();
    session_destroy();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = strtolower($_POST['username']);
    if ($database->validateLogin($username, $_POST['password'])) {
        $userId = $database->getUserId($username);
        $_SESSION['id'] = $userId;
        die(json_encode(array('result' => 'success', 'userId' => $userId)));
    } else {
        die(json_encode(array('result' => 'error')));
    }
} else {
    session_start();
    session_unset();
    session_destroy();
    die();
}
?>