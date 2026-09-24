<?php
session_start();
include 'database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'login';

    // ------------------ LOGIN ------------------
    if ($action === 'login') {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $query = "SELECT id, firstname, lastname, Username, Password FROM students WHERE Username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if ($password === $user['Password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['Username'];
                
                header('Location: index.php');
                exit();
            } else {
                $error = 'Invalid username or password.';
            }
        } else {
            $error = 'Invalid username or password.';
        }
        $stmt->close();
    }

    // ------------------ CREATE ACCOUNT ------------------
    elseif ($action === 'register') {
        $firstname = trim($_POST['firstname'] ?? '');
        $lastname  = trim($_POST['lastname'] ?? '');
        $username  = trim($_POST['username'] ?? '');
        $password  = trim($_POST['password'] ?? '');

        // Check if username exists
        $checkQuery = "SELECT id FROM students WHERE Username = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $error = 'Username is already taken.';
        } else {
            $insertQuery = "INSERT INTO students (firstname, lastname, Username, Password) VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("ssss", $firstname, $lastname, $username, $password);

            if ($insertStmt->execute()) {
                $success = 'Account created successfully! Please log in.';
            } else {
                $error = 'Registration failed. Try again.';
            }
            $insertStmt->close();
        }
        $checkStmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="login-body">

    <div class="login-card">
        
        <?php if ($error): ?>
            <div class="alert alert-danger p-2 text-center"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success p-2 text-center"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <!-- LOGIN FORM -->
        <div id="loginBox">
            <h3 class="text-center mb-4 text-white">Login</h3>
            <form action="login.php" method="POST">
                <input type="hidden" name="action" value="login">
                
                <div class="mb-3">
                    <label for="login_username" class="form-label">Username</label>
                    <input type="text" name="username" id="login_username" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label for="login_password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="login_password" class="form-control" required>
                        <button class="btn btn-outline-light" type="button" id="toggleLoginPassword">
                            <i class="bi bi-eye" id="toggleLoginIcon"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mt-2">Login</button>
            </form>
            <p class="text-center mt-3 mb-0 small">
                Don't have an account? <a href="#" id="showRegister" class="text-info text-decoration-none fw-bold">Create Account</a>
            </p>
        </div>

        <!-- CREATE ACCOUNT FORM -->
        <div id="registerBox" style="display: none;">
            <h3 class="text-center mb-4 text-white">Create Account</h3>
            <form action="login.php" method="POST">
                <input type="hidden" name="action" value="register">
                
                <div class="mb-3">
                    <label for="reg_firstname" class="form-label">First Name</label>
                    <input type="text" name="firstname" id="reg_firstname" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="reg_lastname" class="form-label">Last Name</label>
                    <input type="text" name="lastname" id="reg_lastname" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="reg_username" class="form-label">Username</label>
                    <input type="text" name="username" id="reg_username" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label for="reg_password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="reg_password" class="form-control" required>
                        <button class="btn btn-outline-light" type="button" id="toggleRegPassword">
                            <i class="bi bi-eye" id="toggleRegIcon"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mt-2">Sign Up</button>
            </form>
            <p class="text-center mt-3 mb-0 small">
                Already have an account? <a href="#" id="showLogin" class="text-info text-decoration-none fw-bold">Login</a>
            </p>
        </div>

    </div>

    <script>
        const loginBox = document.getElementById('loginBox');
        const registerBox = document.getElementById('registerBox');
        const showRegister = document.getElementById('showRegister');
        const showLogin = document.getElementById('showLogin');

        showRegister.addEventListener('click', (e) => {
            e.preventDefault();
            loginBox.style.display = 'none';
            registerBox.style.display = 'block';
        });

        showLogin.addEventListener('click', (e) => {
            e.preventDefault();
            registerBox.style.display = 'none';
            loginBox.style.display = 'block';
        });

        function setupPasswordToggle(buttonId, inputId, iconId) {
            const button = document.getElementById(buttonId);
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            button.addEventListener('click', () => {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        }

        setupPasswordToggle('toggleLoginPassword', 'login_password', 'toggleLoginIcon');
        setupPasswordToggle('toggleRegPassword', 'reg_password', 'toggleRegIcon');
    </script>
</body>
</html>