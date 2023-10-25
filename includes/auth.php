<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    // next page
    $_SESSION['next_page'] = $_SERVER['REQUEST_URI'];
    header("Location: ../pages/auth/login.php");
    exit;
}
?>