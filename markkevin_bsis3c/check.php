<?php

session_start();


// ==================================================
// ERROR REPORTING
// ==================================================

error_reporting(E_ALL);
ini_set("display_errors", 1);


// ==================================================
// DATABASE CONNECTION - LARAGON
// ==================================================

$host = "127.0.0.1";
$port = 3306;

$dbUser = "root";
$dbPassword = "";

$database = "kevinbsis3c";


// Create connection

$conn = new mysqli(
    $host,
    $dbUser,
    $dbPassword,
    $database,
    $port
);


// Check connection

if ($conn->connect_error) {

    die(
        "Database Connection Failed!<br><br>" .
        "Error: " . $conn->connect_error
    );

}


// Set UTF-8

$conn->set_charset("utf8mb4");


// ==================================================
// ONLY ALLOW POST REQUEST
// ==================================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");
    exit();

}


// ==================================================
// GET USERNAME AND PASSWORD
// ==================================================

$username = trim(
    $_POST["username"] ?? ""
);

$loginPassword = trim(
    $_POST["password"] ?? ""
);


// ==================================================
// CHECK EMPTY INPUT
// ==================================================

if ($username === "" || $loginPassword === "") {

    echo "<script>
            alert('Please enter your username and password.');
            window.location.href = 'index.php';
          </script>";

    exit();

}


// ==================================================
// FIND EMPLOYEE
// ==================================================

$sql = "
    SELECT
        EmployeeID,
        FirstName,
        LastName,
        Position,
        username,
        password
    FROM employee
    WHERE username = ?
    LIMIT 1
";


$stmt = $conn->prepare($sql);


// Check SQL

if (!$stmt) {

    die(
        "SQL Prepare Error: " .
        $conn->error
    );

}


// ==================================================
// BIND USERNAME
// ==================================================

$stmt->bind_param(
    "s",
    $username
);


// ==================================================
// EXECUTE
// ==================================================

if (!$stmt->execute()) {

    die(
        "SQL Execute Error: " .
        $stmt->error
    );

}


// ==================================================
// GET RESULT
// ==================================================

$result = $stmt->get_result();


// ==================================================
// CHECK EMPLOYEE
// ==================================================

if ($result->num_rows === 1) {

    $employee = $result->fetch_assoc();


    // ==================================================
    // CHECK PASSWORD
    // ==================================================

    /*
       This version assumes your database stores
       the password as normal text.

       Example:

       username: markkevin
       password: 12345
    */

    if ($loginPassword === $employee["password"]) {


        // ==================================================
        // CREATE NEW SESSION ID
        // ==================================================

        session_regenerate_id(true);


        // ==================================================
        // SAVE EMPLOYEE INFORMATION
        // ==================================================

        $_SESSION["EmployeeID"] =
            $employee["EmployeeID"];

        $_SESSION["FirstName"] =
            $employee["FirstName"];

        $_SESSION["LastName"] =
            $employee["LastName"];

        $_SESSION["Position"] =
            $employee["Position"];

        $_SESSION["username"] =
            $employee["username"];


        // ==================================================
        // LOGIN SUCCESSFUL
        // ==================================================

        header("Location: home.php");
        exit();

    }

}


// ==================================================
// LOGIN FAILED
// ==================================================

$stmt->close();
$conn->close();

echo "<script>
        alert('Invalid Username or Password!');
        window.location.href = 'index.php';
      </script>";

exit();

?>