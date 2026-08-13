<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (isset($_SESSION["EmployeeID"])) {
    header("Location: home.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Employee Login</title>

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet"
          href="style.css">

</head>

<body>

<div class="container">

    <span style="--i:0;"></span>
    <span style="--i:1;"></span>
    <span style="--i:2;"></span>
    <span style="--i:3;"></span>
    <span style="--i:4;"></span>
    <span style="--i:5;"></span>
    <span style="--i:6;"></span>
    <span style="--i:7;"></span>
    <span style="--i:8;"></span>
    <span style="--i:9;"></span>
    <span style="--i:10;"></span>
    <span style="--i:11;"></span>
    <span style="--i:12;"></span>
    <span style="--i:13;"></span>
    <span style="--i:14;"></span>
    <span style="--i:15;"></span>
    <span style="--i:16;"></span>
    <span style="--i:17;"></span>
    <span style="--i:18;"></span>
    <span style="--i:19;"></span>
    <span style="--i:20;"></span>
    <span style='--i:21;'></span>
    <span style='--i:22;'></span>
    <span style='--i:23;'></span>
    <span style='--i:24;'></span>
    <span style='--i:25;'></span>
    <span style='--i:26;'></span>
    <span style='--i:27;'></span>
    <span style='--i:28;'></span>
    <span style='--i:29;'></span>
    <span style='--i:30;'></span>
    <span style='--i:31;'></span>
    <span style='--i:32;'></span>
    <span style='--i:33;'></span>
    <span style='--i:34;'></span>
    <span style='--i:35;'></span>
    <span style='--i:36;'></span>
    <span style='--i:37;'></span>
    <span style='--i:38;'></span>
    <span style='--i:39;'></span>
    <span style="--i:40;"></span>
    <span style="--i:41;"></span>
    <span style="--i:42;"></span>
    <span style="--i:43;"></span>
    <span style="--i:44;"></span>
    <span style="--i:45;"></span>
    <span style="--i:46;"></span>
    <span style="--i:47;"></span>
    <span style="--i:48;"></span>
    <span style="--i:49;"></span>
    <span style="--i:50;"></span>
    <span style="--i:51;"></span>
    <span style="--i:52;"></span>
    <span style="--i:53;"></span>
    <span style="--i:54;"></span>
    <span style="--i:55;"></span>


    <div class="login-box">

        <form action="check.php" method="POST">

            <h2>Employee Login</h2>

            <div class="input-box">

                <input
                    type="text"
                    name="username"
                    required
                >

                <label>Username</label>

            </div>

            <div class="input-box">

                <input
                    type="password"
                    name="password"
                    required
                >

                <label>Password</label>

            </div>

            <div class="forgot-pass">

                <a href="#">
                    Forgot Password?
                </a>

            </div>

            <button
                type="submit"
                class="btn"
            >
                Login
            </button>

        </form>

    </div>

</div>

</body>

</html>