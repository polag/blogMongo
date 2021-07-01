<?php
include_once __DIR__.'/globals.php';


\DataHandle\Posts::createPost($_POST, $_SESSION['userId']);