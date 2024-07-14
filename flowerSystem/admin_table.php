<?php
require_once('function/functions.php');
require_once('validation/validations.php');


$admins = GetAdmin();
$roles = GetRole();



$errors = array();
session_start();

if (isset($_SESSION['admin'])) {
    $loggedInUser = $_SESSION['admin'];
}

if (isset($_POST['Save'])) {
    $fullname = validate_required_data($_POST['fullname']);
    $username = validate_required_data($_POST['username']);
    $role_id = validate_required_data($_POST['role_id']);
    $password = validate_required_data($_POST['password']);

    if ($username === FALSE) {
        $errors['fullname'] = 'The name is required!';
    }

    if ($username === FALSE) {
        $errors['username'] = 'The username is required!';
    }

    if ($role_id === FALSE) {
        $errors['role_id'] = 'The role is required!';
    }

    if ($username === FALSE) {
        $errors['username'] = 'The username is required!';
    }

    if ($password === FALSE) {
        $errors['password'] = 'The password is required!';
    }

    if (strlen($password) < 10) {
        $errors['password'] = 'The password must be at least 10 characters long!';
    }

    if (count($errors) == 0) {
        insertAdmin($fullname, $username, $role_id, $password);
        $_SESSION['flash_message'] = 'Admin added successfully!';

        // Redirect to the same page to avoid form resubmission on page refresh
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Set a flash error message in the session
        $_SESSION['flash_message'] = 'There are errors in the form. Please check you credentials.';
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Edit'])) {
    $admin_id = validate_required_data($_POST['edit_admin_id']);
    $fullname = validate_required_data($_POST['edit_fullname']);
    $username = validate_required_data($_POST['edit_username']);
    $role_id = validate_required_data($_POST['edit_role_id']);
    $password = validate_required_data($_POST['edit_password']);
    $confirm_password = validate_required_data($_POST['confirm_password']);

    if (empty($fullname)) {
        $errors['edit_fullname'] = 'The name is required!';
    }

    if (empty($username)) {
        $errors['edit_username'] = 'The username is required!';
    }

    if (empty($role_id)) {
        $errors['edit_role_id'] = 'The role is required!';
    }

    if (empty($password)) {
        $errors['edit_password'] = 'The password is required!';
    }

    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "<script>alert('The password is not match!'); window.location='admin_table.php';</script>";
    }

    if (strlen($password) < 10) {
        $errors['edit_password'] = 'The password must be at least 10 characters long!';
    }

    if (empty($errors)) {
        updateAdmin($admin_id, $fullname, $username, $role_id, $password);
        $_SESSION['flash_message'] = 'Admin information updated successfully!';

        // Redirect to the same page to avoid form resubmission on page refresh
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Set a flash error message in the session
        $_SESSION['flash_message'] = 'There are errors in the form. Please check you credentials.';
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the Delete button is clicked
    if (isset($_POST['Delete'])) {
        $admin_id = $_POST['admin_id'];


        $result = deleteAdmin($admin_id);

        if ($result) {
            $_SESSION['flash_message'] = 'Admin deleted successfully!';

    // Redirect to the same page to avoid form resubmission on page refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
} else {
    // Set a flash error message in the session
    $_SESSION['flash_message'] = 'Failed!!! You cannot delete the main admin.';
}
}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/table.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title>Admin</title>
</head>

<body>
    <div class="center">
        <a href="admin_dashboard.php">
            <button type="submit" style="font-size: 30px; color: red; background-color: transparent;" class='bx bx-arrow-back' id="log_out"></button>
        </a>
        <h2>Admin</h2>
        <?php if (empty($admins)) : ?>
            <p>Empty! <button type="button" class="add-btn" onclick="openAddModal('addModal')">Add</button> </p>
        <?php else : ?>
            <table>
                <thead>
                    <?php
                    // Assuming you have a 'role_name' attribute in your admin session
                    if (!isset($loggedInUser) || $loggedInUser['role_name'] !== 'admin') {
                        echo '<button type="button" class="add-btn" onclick="openAddModal(\'addModal\')">Add</button>';
                    }
                    ?>


                    <?php if (isset($_SESSION['flash_message'])) : ?>
                        <span style="color: <?php echo (isset($errors) && count($errors) > 0) ? 'red' : 'green'; ?>; float: right; text-align: center; background-color: #dfd; border-radius: 10px; padding: 10px; margin: 10px;">
                            <?php echo $_SESSION['flash_message']; ?>
                        </span>
                        <?php unset($_SESSION['flash_message']); // Remove the flash message from the session 
                        ?>
                    <?php endif; ?>

                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Role</th>
                        <?php
                        if (!isset($loggedInUser) || $loggedInUser['role_name'] !== 'admin') {
                            echo '<th>Actions</th>';
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin) : ?>
                        <tr>
                            <td><?= $admin['fullname']; ?></td>
                            <td><?= $admin['username']; ?></td>
                            <td><?= $admin['role_name']; ?></td>
                            <?php
                            if (!isset($loggedInUser) || $loggedInUser['role_name'] !== 'admin') {
                                echo '<td>';


                                echo '<button type="button" class="edit-btn" onclick="openEditModal(' .
                                    $admin['admin_id'] . ', \'' .
                                    $admin['username'] . '\', \'' .
                                    $admin['role_id'] . '\', \'' .
                                    $admin['password'] . '\')">Edit</button>';
                                echo '<form action="" method="POST">';
                                echo '<input type="hidden" name="admin_id" value="' . $admin['admin_id'] . '">';
                                echo '<button type="submit" name="Delete" class="delete-btn">Delete</button>';
                                echo '</form>';

                                echo '</td>';
                            }
                            ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php $fullnameError = isset($errors['fullname']) ? $errors['fullname'] : ''; ?>
    <?php $usernameError = isset($errors['username']) ? $errors['username'] : ''; ?>
    <?php $roleError = isset($errors['role_id']) ? $errors['role_id'] : ''; ?>
    <?php $passwordError = isset($errors['password']) ? $errors['password'] : ''; ?>


    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
            <h3>Add Product</h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="addForm">

                <label for="user">Name: <?php echo "<p id='fname'>$fullnameError</p>"; ?></label>
                <input type="text" id="fullname" name="fullname">


                <label for="user">Username: <?php echo "<p id='uname'>$usernameError</p>"; ?></label>
                <input type="text" id="username" name="username">


                <label for="role_id">Role: <?php echo "<p id=''>$roleError</p>"; ?></label>
                <select name="role_id">
                    <?php
                    foreach ($roles as $role) {
                        echo "<option value='{$role['role_id']}'>{$role['role_name']}</option>";
                    }
                    ?>
                </select>

                <label for="password">Password: <?php echo "<p id='pass'>$passwordError</p>"; ?></label>
                <input type="password" id="password" name="password">
                <button type="submit" name="Save">Add admin</button>
            </form>
        </div>
    </div>

    <?php $editfullError = isset($errors['edit_fullname']) ? $errors['edit_fullname'] : ''; ?>
    <?php $edituserError = isset($errors['edit_username']) ? $errors['edit_username'] : ''; ?>
    <?php $editroleError = isset($errors['edit_role_id']) ? $errors['edit_role_id'] : ''; ?>
    <?php $editpassError = isset($errors['edit_password']) ? $errors['edit_password'] : ''; ?>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('editModal')">&times;</span>
            <h3>Edit Admin</h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="editForm">
                <!-- You can dynamically populate these fields with the selected staff's data -->
                <input type="hidden" name="edit_admin_id" id="edit_admin_id">

                <label for="edit_fullname">Name: <?php if (!empty($editfullError)) {
                                                            echo "<p id = 'efname'>{$editfullError}</p>";
                                                        } ?></label>
                <input type="text" id="edit_fullname" name="edit_fullname">

                <label for="edit_username">Username: <?php if (!empty($edituserError)) {
                                                            echo "<p id = 'euname'>{$edituserError}</p>";
                                                        } ?></label>
                <input type="text" id="edit_username" name="edit_username">

                <label for="edit_role_id">Role: <?php if (!empty($editroleError)) {
                                                    echo "<p id = '7'>{$editroleError}</p>";
                                                } ?></label>
                <select name="edit_role_id">
                    <?php
                    foreach ($roles as $role) {
                        echo "<option value='{$role['role_id']}'>{$role['role_name']}</option>";
                    }
                    ?>
                </select>

                <label for="edit_password">New Password: <?php if (!empty($editpassError)) {
                                                                echo "<p id = 'epass'>{$editpassError}</p>";
                                                            } ?></label>
                <input type="password" id="edit_password" name="edit_password">

                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password">
                <button type="submit" name="Edit">Save Changes</button>
            </form>
        </div>
    </div>
    <script src="js/admin.js"></script>

</body>
</html>