<?php
include 'database.php';

$firstname = $_POST['firstname'];
$lastname  = $_POST['lastname'];
$username  = $_POST['Username'];
$password  = $_POST['Password'];

$query = "INSERT INTO students (firstname, lastname, Username, Passord) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $firstname, $lastname, $username, $password);
$stmt->execute();
$stmt->close();

header('Location: index.php');
?>