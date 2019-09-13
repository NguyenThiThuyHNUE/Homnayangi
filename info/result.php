<?php
include_once '../connectDB/connectDB.php';
$userID = $_GET["id"];

$stmt = $conn->prepare('SELECT * FROM dataUsers where userID='.$userID);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();
$result = $result[0];
$conn = null
?>