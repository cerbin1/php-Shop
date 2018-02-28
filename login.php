<?php
$mysqli = include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'login') {
        $login = $_POST['login'];
        $password = $_POST['password'];
        if ($login === 'admin' && $password === 'admin') { // TODO implement database checking
            echo json_encode(['login' => true]);
        } else {
            echo json_encode(['login' => false]);
        }
    }
}
