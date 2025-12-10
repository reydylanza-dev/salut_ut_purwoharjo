<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "salut_ut";
$database = "salut_ut";

$koneksi = mysqli_connect($servername, $username, $password,$db);
$link = mysqli_connect($servername, $username, $password, $database);

if (!$koneksi) {
die("Connection failed: " . mysqli_connect_error());
}
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
