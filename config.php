<?php
$databaseHost = 'localhost';
$databaseName = 'cobauas';
$databaseUsername = 'root';
$databasePasword = '';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePasword, $databaseName);

if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}

function enum($query){
    global $mysqli;
    $result = $mysqli->query("SHOW COLUMNS FROM antrian WHERE Field = '$query'");
    $row = $result->fetch_row();
    $enumList = explode(",", str_replace("'", "", substr($row[1], 5, (strlen($row[1])-6))));
    return $enumList;
}
?>