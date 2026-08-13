<?php

session_start();


// Clear session variables

$_SESSION = [];


// Destroy session

session_destroy();


// Go back to login

header("Location: index.php");
exit();

?>