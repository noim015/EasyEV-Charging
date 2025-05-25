<?php
session_start();

function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['type'] === 'admin';
}

function isUser() {
    return isset($_SESSION['user']) && $_SESSION['user']['type'] === 'user';
}

function isLoggedIn() {
    return isset($_SESSION['user']);
}
?>
