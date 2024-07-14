<?php
require_once('function/functions.php');
require_once('validation/validations.php');
$staffs = GetStaff();


$errors = array();
session_start();
if (isset($_POST['Save'])) {
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Edit'])) {
    $staff_id = validate_required_data($_POST['edit_staff_id']);
    $firstname = validate_required_data($_POST['edit_firstname']);
    $lastname = validate_required_data($_POST['edit_lastname']);
    $contact_no = validate_required_data($_POST['edit_contact_no']);
    $username = validate_required_data($_POST['edit_username']);
    $password = validate_required_data($_POST['edit_password']);
    $confirm_password = validate_required_data($_POST['confirm_password']);

    if (empty($firstname)) {
        $errors['edit_firstname'] = 'The first name is required!';
    }

    if (empty($lastname)) {
        $errors['edit_lastname'] = 'The last name is required!';
    }

    if (empty($contact_no)) {
        $errors['edit_contact_no'] = 'The contact number is required!';
    }

    if (empty($username)) {
        $errors['edit_username'] = 'The username is required!';
    }

    if ($password == FALSE) {
        $errors['edit_password'] = 'The password is required!';
    }

    if (strlen($password) < 10) {
        $errors['edit_password'] = 'The password must be at least 10 characters long!';
    }

    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "<script>alert('The password is not match!'); window.location='staff.php';</script>";
    }

    if (empty($errors)) {
        updateStaff($staff_id, $firstname, $lastname, $contact_no, $username, $password);
        $_SESSION['flash_message'] = 'Staff information updated successfully!';

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
        $staff_id = $_POST['staff_id'];

        $result = deleteStaff($staff_id);

        if ($result) {
            $_SESSION['flash_message'] = 'Staff deleted successfully!';

            // Redirect to the same page to avoid form resubmission on page refresh
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            // Set a flash error message in the session
            $_SESSION['flash_message'] = 'There are errors. Please fix them.';
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
    <title>Staff</title>
</head>

<body>
    <div class="center">
        <a href="admin_dashboard.php">
            <button type="submit" style="font-size: 30px; color: red; background-color: transparent;" class='bx bx-arrow-back' id="log_out"></button>
        </a>
        <h2>Staffs</h2>
        <?php if (empty($staffs)) : ?>
            <p>Empty. click <button type="button" class="add-btn" onclick="openAddModal('addModal')">Add</button> to add staff! </p>
        <?php else : ?>
            <table>
                <thead>
                    <button type="button" class="add-btn" onclick="openAddModal('addModal')">Add</button>

                    <?php if (isset($_SESSION['flash_message'])) : ?>
                        <span style="color: <?php echo (isset($errors) && count($errors) > 0) ? 'red' : 'green'; ?>; float: right; text-align: center; background-color: #dfd; border-radius: 10px; padding: 10px; margin: 10px;">
                            <?php echo $_SESSION['flash_message']; ?>
                        </span>
                        <?php unset($_SESSION['flash_message']); // Remove the flash message from the session 
                        ?>
                    <?php endif; ?>

                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Contact Number</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($staffs as $staff) : ?>
                        <tr>
                            <td><?= $staff['firstname']; ?></td>
                            <td><?= $staff['lastname']; ?></td>
                            <td><?= $staff['contact_no']; ?></td>
                            <td><?= $staff['username']; ?></td>
                            <td>

                                <button type="button" class="edit-btn" onclick="openEditModal(
    <?= $staff['staff_id']; ?>,
    '<?= $staff['firstname']; ?>',
    '<?= $staff['lastname']; ?>',
    '<?= $staff['contact_no']; ?>',
    '<?= $staff['username']; ?>',
    '<?= $staff['password']; ?>'
)">Edit</button>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    <input type="hidden" name="staff_id" value="<?= $staff['staff_id']; ?>">
                                    <button type="submit" name="Delete" class="delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>


    <?php $firstNameError = isset($errors['firstname']) ? $errors['firstname'] : ''; ?>
    <?php $lastNameError = isset($errors['lastname']) ? $errors['lastname'] : ''; ?>
    <?php $contactNameError = isset($errors['contact_no']) ? $errors['contact_no'] : ''; ?>
    <?php $userNameError = isset($errors['username']) ? $errors['username'] : ''; ?>
    <?php $passwordError = isset($errors['password']) ? $errors['password'] : ''; ?>

    <!-- Add Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
            <h3>Add Staff</h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="addForm">
                <label for="firstName">First Name: <?php echo "<p id='fname'>$firstNameError</p>"; ?></label>
                <input type="text" id="firstname" name="firstname">

                <label for="lastName">Last Name: <?php echo "<p id='lname'>$lastNameError</p>"; ?></label>
                <input type="text" id="lastname" name="lastname">

                <label for="contactNumber">Contact Number: <?php echo "<p id='contactno'>$contactNameError</p>"; ?></label>
                <input type="number" id="contact_no" name="contact_no">

                <label for="username">Username: <?php echo "<p id='uname'>$userNameError</p>"; ?></label>
                <input type="text" id="username" name="username">

                <label for="password">Password: <?php echo "<p id='pass'>$passwordError</p>"; ?> </label>
                <input type="password" id="password" name="password">

                <button type="submit" name="Save">Add Staff</button>
            </form>
        </div>
    </div>


    <?php $fNameError = isset($errors['edit_firstname']) ? $errors['edit_firstname'] : ''; ?>
    <?php $lNameError = isset($errors['edit_lastname']) ? $errors['edit_lastname'] : ''; ?>
    <?php $contactError = isset($errors['contact_no']) ? $errors['contact_no'] : ''; ?>
    <?php $uNameError = isset($errors['edit_username']) ? $errors['edit_username'] : ''; ?>
    <?php $passError = isset($errors['edit_password']) ? $errors['edit_password'] : ''; ?>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('editModal')">&times;</span>
            <h3>Edit Staff</h3>
            <form action="" method="post" id="editForm">
                <!-- You can dynamically populate these fields with the selected staff's data -->
                <input type="hidden" name="edit_staff_id" id="edit_staff_id">

                <label for="edit_firstname">First Name: <?php if (!empty($fNameError)) {
                                                            echo "<p id = 'efname'>{$fNameError}</p>";
                                                        } ?></label>
                <input type="text" id="edit_firstname" name="edit_firstname">

                <label for="edit_lastname">Last Name: <?php if (!empty($lNameError)) {
                                                            echo "<p id = 'elname'>{$lNameError}</p>";
                                                        } ?></label>
                <input type="text" id="edit_lastname" name="edit_lastname">

                <label for="edit_contact_no">Contact Number: <?php if (!empty($contactError)) {
                                                                    echo "<p id = 'econtact'>{$contactError}</p>";
                                                                } ?></label>
                <input type="text" id="edit_contact_no" name="edit_contact_no">

                <label for="edit_username">Username: <?php if (!empty($uNameError)) {
                                                            echo "<p id = 'euname'>{$uNameError}</p>";
                                                        } ?></label>
                <input type="text" id="edit_username" name="edit_username">

                <label for="edit_password">New Password:<span style="color: blue;">/(Current)</span> <?php if (!empty($passError)) {
                                                                                                            echo "<p id = 'epass'>{$passError}</p>";
                                                                                                        } ?></label>
                <input type="password" id="edit_password" name="edit_password">

                <label for="confirm_password">Confirm New Password: / <span style="color: blue;">Confirm Current Password Before Updating</span></label>
                <input type="password" id="confirm_password" name="confirm_password">
                <button type="submit" name="Edit">Save Changes</button>
            </form>
        </div>
    </div>
    <script src="js/staff.js"></script>

</body>

</html>