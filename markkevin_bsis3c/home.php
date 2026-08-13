<?php

session_start();


// ==================================================
// CHECK IF EMPLOYEE IS LOGGED IN
// ==================================================

if (!isset($_SESSION["EmployeeID"])) {

    header("Location: index.php");
    exit();

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Employee Home</title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Your CSS -->

    <link rel="stylesheet" href="style.css">

</head>


<body>


<div class="container">


    <div class="welcome-box text-center">


        <!-- Login message -->

        <h1>
            Successfully Logged In!
        </h1>


        <!-- Employee name -->

        <h3>

            Welcome,

            <?php
            echo htmlspecialchars(
                $_SESSION["FirstName"]
            );
            ?>

            <?php
            echo htmlspecialchars(
                $_SESSION["LastName"]
            );
            ?>

        </h3>


        <!-- Username -->

        <p>

            Username:

            <strong>

                <?php
                echo htmlspecialchars(
                    $_SESSION["username"]
                );
                ?>

            </strong>

        </p>


        <!-- Employee ID -->

        <p>

            Employee ID:

            <strong>

                <?php
                echo htmlspecialchars(
                    $_SESSION["EmployeeID"]
                );
                ?>

            </strong>

        </p>


        <!-- Position -->

        <p>

            Position:

            <strong>

                <?php
                echo htmlspecialchars(
                    $_SESSION["Position"]
                );
                ?>

            </strong>

        </p>


        <p>
            You have successfully logged in
            as an employee.
        </p>


        <!-- Logout -->

        <a
            href="logout.php"
            class="btn btn-danger mt-3"
        >
            Logout
        </a>


    </div>


</div>


</body>

</html>