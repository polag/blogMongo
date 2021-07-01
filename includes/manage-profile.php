<?php
include_once __DIR__.'/globals.php';
include_once __DIR__ . '/util.php';
include_once __DIR__ . '/User.php';
$userId = $_SESSION['userId'];


if(isset($_GET['password'])){
    $password = $_POST['password'];
    $newPassword = $_POST['newPassword'];   
    \DataHandle\User::updatePassword($password, $newPassword, $userId);
} elseif(isset($_GET['delete'])){
    \DataHandle\User::deleteUser($userId);
}