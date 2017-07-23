<?php
$mysqli = new mysqli('localhost', 'root', '', 'shop');

if ($mysqli->connect_error) {
    echo 'Error connecting to database';
    die('Connection failed: ' . $mysqli->connect_error);
}
return $mysqli;
