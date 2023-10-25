<?php
// Path: controllers/auth.php
//start session
session_start();

if(!isset($_SESSION['user_id'])) {
    $_SESSION['next_page'] = $_SERVER['REQUEST_URI'];
    header("Location: ../pages/auth/login.php");
    exit;
}

?>