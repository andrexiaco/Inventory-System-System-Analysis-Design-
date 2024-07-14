<?php
require_once('validation/validations.php');
require_once('function/functions.php');

// Initialize an array to store errors
$errors = array();
session_start();
if (isset($_POST['Register'])) {
    $firstname = validate_required_data($_POST['firstname']);
    $lastname = validate_required_data($_POST['lastname']);
    $contact_no = validate_required_data($_POST['contact_no']);
    $username = validate_required_data($_POST['username']);
    $password = validate_required_data($_POST['password']);

    if ($firstname === FALSE) {
        $errors['firstname'] = 'The first name is required!';
    }

    if ($lastname === FALSE) {
        $errors['lastname'] = 'The last name is required!';
    }

    if ($contact_no === FALSE) {
        $errors['contact_no'] = 'The contact number is required!';
    }

    if ($username === FALSE) {
        $errors['username'] = 'The username is required!';
    }

    if ($password === FALSE) {
        $errors['password'] = 'The password is required!';
    } elseif (strlen($password) < 10) {
        $errors['password'] = 'The password must be at least 10 characters long!';
    }

    if (count($errors) == 0) {
        insertStaff($firstname, $lastname, $contact_no, $username, $password);
        $_SESSION['flash_message'] = 'Staff added successfully!';

        // Redirect to the same page to avoid form resubmission on page refresh
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Set a flash error message in the session
        $_SESSION['flash_message'] = 'There are errors in the form. Please check you credentials.';
    }
}

?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php $firstNameError = isset($errors['firstname']) ? $errors['firstname'] : ''; ?>
    <?php $lastNameError = isset($errors['lastname']) ? $errors['lastname'] : ''; ?>
    <?php $contactNameError = isset($errors['contact_no']) ? $errors['contact_no'] : ''; ?>
    <?php $userNameError = isset($errors['username']) ? $errors['username'] : ''; ?>
    <?php $passwordError = isset($errors['password']) ? $errors['password'] : ''; ?>
    <div class="login-container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <h2>Staff Registration</h2>
            <div class="input-group">
                <label for="firstname">First Name: <?php echo "<span id='fname'>$firstNameError</span>"; ?></label>
                <input type="text" id="firstname" name="firstname">
            </div>
            <div class="input-group">
                <label for="lastname">Last Name: <?php echo "<span id='lname'>$lastNameError</span>"; ?></label>
                <input type="text" id="lastname" name="lastname">
            </div>
            <div class="input-group">
                <label for="contact_no">Contact Number: <?php echo "<span id='contactno'>$contactNameError</span>"; ?></label>
                <input type="text" id="contact_no" name="contact_no">
            </div>
            <div class="input-group">
                <label for="username">Username: <?php echo "<span id='uname'>$userNameError</span>"; ?></label>
                <input type="text" id="username" name="username">
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
    </style>
    <script src="js/reg.js"></script>
</body>

</html>