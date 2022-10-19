<?php
$host = "localhost";
$user = "colt";
$password = "colt";
$database = "kit";

$conn = mysqli_connect($host, $user, $password, $database);
// Проверяем соединение
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}