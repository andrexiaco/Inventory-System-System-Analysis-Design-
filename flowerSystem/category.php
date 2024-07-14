<?php
require_once('function/functions.php');
require_once('validation/validations.php');

$categories = GetCategory();


$errors = array();
session_start();

if (isset($_POST['Save'])) {
    $category_name = validate_required_data($_POST['category_name']);

    if ($category_name === FALSE) {
        $errors['category_name'] = 'The category name is required!';
    }

    if (count($errors) === 0) {
        insertCategory($category_name);
        $_SESSION['flash_message'] = 'Category added successfully!';

        // Redirect to the same page to avoid form resubmission on page refresh
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Set a flash error message in the session
        $_SESSION['flash_message'] = 'There are errors in the form. Please check you credentials.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Edit'])) {
    $category_id = validate_required_data($_POST['edit_category_id']);
    $category_name = validate_required_data($_POST['edit_category_name']);

    if (empty($category_name)) {
        $errors['edit_category_name'] = 'The category name is required!';
    }

    if (empty($errors)) {
        updateCategory($category_id, $category_name);
        $_SESSION['flash_message'] = 'Category updated successfully!';

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
        $category_id = $_POST['category_id'];

        $result = deleteCategory($category_id);

        if ($result) {
            $_SESSION['flash_message'] = 'Category deleted successfully!';

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
    <title>Categories</title>
</head>

<body>
    <div class="center">
        <a href="admin_dashboard.php">
            <button type="submit" style="font-size: 30px; color: red; background-color: transparent;" class='bx bx-arrow-back' id="log_out"></button>
        </a>
        <h2>Categories</h2>
        <?php if (empty($categories)) : ?>
            <p>No category available. click <button type="button" class="add-btn" onclick="openAddModal('addModal')">Add</button> to add category! </p>
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
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category) : ?>
                        <tr>
                            <td><?= $category['category_name']; ?></td>
                            <td>

                                <button type="button" class="edit-btn" onclick="openEditModal(
        <?= $category['category_id']; ?>,
        '<?= $category['category_name']; ?>',
    )">Edit</button>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    <input type="hidden" name="category_id" value="<?= $category['category_id']; ?>">
                                    <button type="submit" name="Delete" class="delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>



    <?php $categoryNameError = isset($errors['category_name']) ? $errors['category_name'] : ''; ?>
    <style>
        .modal-content p {
            font-size: 12px;
            color: red;
        }
    </style>
    <!-- Add C Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
            <h3>Add Category</h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="addForm">
                <label for="categoryName">Category Name: <?php echo "<p id='categorymsg'>$categoryNameError</p>"; ?></label>
                <input type="text" id="category_name" name="category_name">
                <button type="submit" name="Save">Add Category</button>
            </form>
        </div>
    </div>


    <?php $categoryNameError = isset($errors['edit_category_name']) ? $errors['edit_category_name'] : ''; ?>

    <!-- Edit C Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('editModal')">&times;</span>
            <h3>Edit Category</h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="editForm">
                <!-- You can dynamically populate these fields with the selected product's data -->
                <input type="hidden" name="edit_category_id" id="edit_category_id">
                <label for="edit_category_name">Category Name: <?php if (!empty($categoryNameError)) {
                                                                    echo "<p id = 'catmsg'>{$categoryNameError}</p>";
                                                                } ?></label>
                <input type="text" id="edit_category_name" name="edit_category_name">

                <button type="submit" name="Edit">Save Changes</button>
            </form>
        </div>
    </div>
    <script src="js/category.js"></script>
</body>

</html>