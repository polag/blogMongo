<?php
include_once __DIR__.'/Comment.php';
include_once __DIR__ . '/globals.php';

$id = $_GET['id'];
$postId = $_GET['postId'];
$userId = $_SESSION['userId'];
\DataHandle\Comment::deleteComment($id, $userId, $postId);