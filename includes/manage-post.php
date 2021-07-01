<?php
include_once __DIR__ . '/globals.php';

if (isset($_GET['update'])) {
    \DataHandle\Posts::updatePost($_POST, $_GET['id'], $_SESSION['userId']);
}elseif(isset($_GET['delete'])){
    if($_GET['delete'] == 1){
        \DataHandle\Posts::deletePost( $_SESSION['userId'], $_GET['id']);
    }
    elseif($_GET['delete'] == 2){
        \DataHandle\Posts::deletePost($_SESSION['userId']);
    }
}
 