<?php

include 'database.php';

$id         = $_POST['id'];
$firstname  = $_POST['firstname'];
$lastname   = $_POST['lastname'];
$cource     = $_POST['cource'];
$year_level = $_POST['year_level'];

$query = "UPDATE students SET firstname = ?, lastname = ?, cource = ?, year_level = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $firstname, $lastname, $cource, $year_level, $id);
$stmt->execute();
$stmt->close();

header('Location: index.php');