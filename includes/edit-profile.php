<?php
include_once __DIR__.'/globals.php';
include_once __DIR__ . '/util.php';
include_once __DIR__ . '/User.php';
$userId = $_GET['id'];
\DataHandle\User::updateUser($_POST, $userId);