<?php
include_once __DIR__.'/Comment.php';
include_once __DIR__ . '/globals.php';

$id = $_GET['id'];
$content = $_POST['comment'];
\DataHandle\Comment::createComment($content, $id,$_SESSION['userId']);