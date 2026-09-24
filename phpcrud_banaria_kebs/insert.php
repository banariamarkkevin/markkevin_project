<?php
include 'database.php';

$firstname  = $_POST['firstname'];
$lastname   = $_POST['lastname'];
$cource     = $_POST['cource'];
$year_level = $_POST['year_level'];

$query = "INSERT INTO students (firstname, lastname, cource, year_level) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $firstname, $lastname, $cource, $year_level);
$stmt->execute();
$stmt->close();

header('Location: index.php');
?>