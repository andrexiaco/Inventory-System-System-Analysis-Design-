<?php
require_once('validation/validations.php');
require_once('function/functions.php');

$roles = GetRole();

$errors = array();
session_start();
if (isset($_POST['Register'])) {
    $fullname = validate_required_data($_POST['fullname']);
    $username = validate_required_data($_POST['username']);
    $role_id = validate_required_data($_POST['role_id']);
    $password = validate_required_data($_POST['password']);

    if ($fullname === FALSE) {
        $errors['fullname'] = 'The name is required!';
    }

    if ($username === FALSE) {
        $errors['username'] = 'The username is required!';
    }

    if ($role_id === FALSE) {
        $errors['role_id'] = 'The role is required!';
    }

    if ($password === FALSE) {
        $errors['password'] = 'The password is required!';
    } elseif (strlen($password) < 10) {
        $errors['password'] = 'The password must be at least 10 characters long!';
    }

    if (count($errors) == 0) {
        insertAdmin($fullname, $username, $role_id, $password);
        $_SESSION['flash_message'] = 'New Admin added successfully!';

        // Redirect to the same page to avoid form resubmission on page refresh
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Set a flash error message in the session
        $_SESSION['flash_message'] = 'There are errors in the form. Please check you credentials.';
    }
}


//<?php
//foreach ($roles as $role) {
   // echo "<option value='{$role['role_id']}'>{$role['role_name']}</option>";
//}
//
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php $fullNameError = isset($errors['fullname']) ? $errors['fullname'] : ''; ?>
    <?php $roleError = isset($errors['role_id']) ? $errors['role_id'] : ''; ?>
    <?php $userNameError = isset($errors['username']) ? $errors['username'] : ''; ?>
    <?php $passwordError = isset($errors['password']) ? $errors['password'] : ''; ?>
    <div class="login-container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <h2>Admin Registration</h2>
            <div class="input-group">
                <label for="fullname">First Name: <?php echo "<span id='fname'>$fullNameError</span>"; ?></label>
                <input type="text" id="fullname" name="fullname">
            </div>

            <div class="input-group">
                <label for="username">Username: <?php echo "<span id='uname'>$userNameError</span>"; ?></label>
                <input type="text" id="username" name="username">
            </div>

            <div class="input-group">
                <label for="role_id">Role: <?php echo "<span id='role'>$roleError</span>"; ?></label>
                <select name="role_id" id="role_id">
                    <option value="admin">Admin</option>
                </select>
                </select>
            </div>

            <div class="input-group">
                <label for="password">Set Password: <?php echo "<span id='pass'>$passwordError</span>"; ?></label>
                <input type="password" id="password" name="password">
            </div>

            <button type="submit" name="Register">Register</button>
        </form>
        <div class="link">
            <a href="index.php">Return to Login</a>
        </div>
        <div class="theme-toggle" onclick="toggleTheme()">&#127774;</div>
    </div>
    <style>
        .input-group span {
            font-size: 10px;
            color: red;
        }

        label {
            float: left;
        }

        select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 2px solid #fff;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
        }
    </style>
    <script src="js/admin_reg.js"></script>
</body>

</html>


