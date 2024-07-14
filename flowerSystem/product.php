<?php
require_once('function/functions.php');
require_once('validation/validations.php');


$productsAndCategories = GetProductWithCategory();
$categories = GetCategory();



$errors = array();
session_start();

if (isset($_POST['Save'])) {
    $product_name = validate_required_data($_POST['product_name']);
    $quantity = validate_required_data($_POST['quantity']);
    $category_id = validate_required_data($_POST['category_id']);
    $price = validate_required_data($_POST['price']);

    if ($product_name === FALSE) {
        $errors['product_name'] = 'The product name is required!';
    }

    if ($quantity === FALSE) {
        $errors['quantity'] = 'The quantiy value is required!';
    }

    if ($category_id === FALSE) {
        $errors['category_id'] = 'The category is required!';
    }

    if ($price === FALSE) {
        $errors['price'] = 'The price value is required!';
    }

    if (count($errors) == 0) {
        insertProduct($product_name, $quantity, $category_id, $price);
        $_SESSION['flash_message'] = 'Product added successfully!';

        // Redirect to the same page to avoid form resubmission on page refresh
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Set a flash error message in the session
        $_SESSION['flash_message'] = 'There are errors in the form. Please check you credentials.';
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Edit'])) {
    $product_id = validate_required_data($_POST['edit_product_id']);
    $product_name = validate_required_data($_POST['edit_product_name']);
    $quantity = validate_required_data($_POST['edit_quantity']);
    $category_id = validate_required_data($_POST['edit_category_id']);
    $price = validate_required_data($_POST['edit_price']);

    if (empty($product_name)) {
        $errors['edit_product_name'] = 'The product name is required!';
    }

    if (empty($quantity)) {
        $errors['edit_quantity'] = 'The quantity value is required!';
    }

    if (empty($category_id)) {
        $errors['edit_category_id'] = 'The category is required!';
    }

    if (empty($price)) {
        $errors['edit_price'] = 'The price value is required!';
    }

    if (empty($errors)) {

        updateProduct($product_id, $product_name, $quantity, $category_id, $price);
        $_SESSION['flash_message'] = 'Product updated successfully!';

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
        $product_id = $_POST['product_id'];

        $result = deleteProduct($product_id);

        if ($result) {
            $_SESSION['flash_message'] = 'Product deleted successfully!';

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
    <title>Products</title>
</head>

<body>
    <div class="center">
        <a href="admin_dashboard.php">
            <button type="submit" style="font-size: 30px; color: red; background-color: transparent;" class='bx bx-arrow-back' id="log_out"></button>
        </a>
        <h2>Products</h2>
        <?php if (empty($productsAndCategories)) : ?>
            <p>No products available. click <button type="button" class="add-btn" onclick="openAddModal('addModal')">Add</button> to add product! </p>
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
                        <th>Products</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productsAndCategories as $product) : ?>
                        <tr>
                            <td><?= $product['product_name']; ?></td>
                            <td><?= $product['quantity']; ?></td>
                            <td><?= $product['category_name']; ?></td>
                            <td><?= $product['price']; ?></td>
                            <td>

                                <button type="button" class="edit-btn" onclick="openEditModal(
        <?= $product['product_id']; ?>,
        '<?= $product['product_name']; ?>',
        <?= $product['quantity']; ?>,
        <?= $product['category_id']; ?>,
        <?= $product['price']; ?>
    )">Edit</button>
                                <form action="" method="POST">
                                    <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                                    <button type="submit" name="Delete" class="delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php $productNameError = isset($errors['product_name']) ? $errors['product_name'] : ''; ?>
    <?php $quantityNameError = isset($errors['quantity']) ? $errors['quantity'] : ''; ?>
    <?php $categoryNameError = isset($errors['category_id']) ? $errors['category_id'] : ''; ?>
    <?php $priceNameError = isset($errors['price']) ? $errors['price'] : ''; ?>
    <style>
        .modal-content p {
            font-size: 12px;
            color: red;
        }
    </style>

    <!-- Add Product Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
            <h3>Add Product</h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="addForm">
                <label for="productName">Product Name: <?php echo "<p id='errormsg1'>$productNameError</p>"; ?></label>
                <input type="text" id="product_name" name="product_name">

                <label for="quantity">Quantity: <?php echo "<p id='errormsg2'>$quantityNameError</p>"; ?></label>
                <input type="number" id="quantity" name="quantity">

                <label for="category">Category: <?php echo "<p id='errormsg3'>$categoryNameError</p>"; ?></label><?php echo $categoryNameError; ?>
                <select name="category_id">
                    <?php
                    foreach ($categories as $category) {
                        echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
                    }
                    ?>
                </select>

                <label for="price">Price: <?php echo "<p id='errormsg4'>$priceNameError</p>"; ?></label>
                <input type="text" id="price" name="price">
                <button type="submit" name="Save">Add Product</button>
            </form>
        </div>
    </div>

    <?php $productNameError = isset($errors['edit_product_name']) ? $errors['edit_product_name'] : ''; ?>
    <?php $quantityNameError = isset($errors['edit_quantity']) ? $errors['edit_quantity'] : ''; ?>
    <?php $categoryNameError = isset($errors['edit_category_id']) ? $errors['edit_category_id'] : ''; ?>
    <?php $priceNameError = isset($errors['edit_price']) ? $errors['edit_price'] : ''; ?>
    <!-- Edit Product Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('editModal')">&times;</span>
            <h3>Edit Product</h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="editForm">
                <!-- You can dynamically populate these fields with the selected product's data -->
                <input type="hidden" name="edit_product_id" id="edit_product_id">
                <label for="edit_product_name">Product Name: <?php if (!empty($productNameError)) {
                                                                    echo "<p id = 'error1'>{$productNameError}</p>";
                                                                } ?> </label>
                <input type="text" id="edit_product_name" name="edit_product_name">

                <label for="edit_quantity">Quantity: <?php if (!empty($quantityNameError)) {
                                                            echo "<p id = 'error2'>{$quantityNameError}</p>";
                                                        }  ?></label>
                <input type="number" id="edit_quantity" name="edit_quantity">

                <label for="edit_category">Category: <?php if (!empty($categoryNameError)) {
                                                            echo "<p id = 'error3'>{$categoryNameError}</p>";
                                                        }  ?></label>
                <select name="edit_category_id" id="edit_category_id">
                    <?php
                    foreach ($categories as $category) {
                        echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
                    }
                    ?>
                </select>

                <label for="edit_price">Price: <?php if (!empty($priceNameError)) {
                                                    echo "<p id = 'error'>{$priceNameError}</p>";
                                                }  ?></label>
                <input type="text" id="edit_price" name="edit_price">
                <button type="submit" name="Edit">Save Changes</button>
            </form>
        </div>
    </div>
    <script src="js/product.js"></script>
</body>

</html>