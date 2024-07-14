<?php

require_once('function/functions.php');

if (isset($_POST['Login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = loginUser($username, $password);
    $admin = loginAdmin($username, $password);

    if ($user) {
        session_start();
        $_SESSION['user'] = $user;
        header('Location: emp_dashboard.php');
        exit;
    } elseif ($admin) {
        session_start();
        $_SESSION['admin'] = $admin;
        if ($admin['role_name'] === 'admin') {
            header('Location: admin_dashboard.php');
        } elseif ($admin['role_name'] === 'main admin') {
            header('Location: admin_dashboard.php');
        }
        exit;
    } else {
        $loginSuccess = false;
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="login-container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <h2>Login</h2>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>
            <button type="submit" name="Login">Login</button>
        </form>
        <div class="link">
            <a href="registration.php">Staff Registration</a>
        </div>
        <div class="theme-toggle" onclick="toggleTheme()">&#127774;</div>
    </div>
    <script>
        function toggleTheme() {
            const body = document.body;
            body.classList.toggle("dark-theme");
        }

        document.addEventListener("DOMContentLoaded", function() {
            var loginSuccess = <?php echo json_encode($loginSuccess); ?>;

            if (loginSuccess) {
                // Display an alert for successful login
                alert('Login Successful!');

            } else {
                // Display an error message box
                var errorBox = document.createElement("div");
                errorBox.className = "error-box";
                errorBox.textContent = "Login failed. Please check your credentials.";

                // Append the error box to the body or another container
                document.body.appendChild(errorBox);

                setTimeout(function() {
                    errorBox.parentNode.removeChild(errorBox);
                }, 1000);
            }
        });
    </script>
</body>

</html>