<?php

$conn = new mysqli('localhost', 'root', '', 'phpcrud_banaria_kebs');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}