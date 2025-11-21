<?php
$mysqli = new mysqli("localhost", "zipdam2020", "zip2020!", "zipdam2020");

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}
?>