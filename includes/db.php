<?php

$mysqli = new mysqli('localhost', 'root', '', 'blog');

if ($mysqli->connect_errno) {
    echo 'Connessione al database fallita: ' . $mysqli->connect_error;
    exit();
}
