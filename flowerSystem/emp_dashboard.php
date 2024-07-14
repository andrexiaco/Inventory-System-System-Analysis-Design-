<?php
require_once('function/functions.php');
require_once('validation/validations.php');
session_start();

$productReports = ProductReport();
$staffReports = StaffReport();

$errors = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Submit'])) {
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
        $errors['confirm_password'] = 'The password does not match!';
    }

    if (empty($errors)) {
        updateStaff($staff_id, $firstname, $lastname, $contact_no, $username, $password);

        header('Location: emp_dashboard.php');
    exit();
    }
}


if (isset($_SESSION['user'])) {
  $loggedInUser = $_SESSION['user'];
}

$tableCounts = getTableCounts();
$logs = getLogs();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  userLogout();
}



?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title>Staff Dashboard</title>
  <link rel="stylesheet" href="css/dashboard.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus icon'></i>
      <div class="logo_name">Carta Eliese Inventory</div>
      <i class='bx bx-menu' id="btn"></i>
    </div>
    <ul class="nav-list">
      <li>
        <i class='bx bx-search'></i>
        <input type="text" placeholder="Search...">
        <span class="tooltip">Search</span>
      </li>
      <li>
        <a href="#">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Dashboard</span>
        </a>
        <span class="tooltip">Dashboard</span>
      </li>
      <li>
        <a href="emp_category.php">
          <i class='bx bx-detail'></i>
          <span class="links_name">Category</span>
        </a>
        <span class="tooltip">Category</span>
      </li>
      <li>
        <a href="emp_product.php">
          <i class='bx bx-archive'></i>
          <span class="links_name">Product</span>
        </a>
        <span class="tooltip">Product</span>
      </li>
      <li class="profile">
        <div class="profile-details">
        <button style="background-color: #ccc; border-radius: 25px; padding: 3px;" type="button" class="Profile-btn" onclick="ProfileModal('ProfileModal')">
          <img src="img/user.png" alt="profileImg">
          </button>
          <div class="name_job">
            <div class="name"><?php echo $loggedInUser['firstname']; ?> <?php echo $loggedInUser['lastname']; ?></div>
            <div class="job">Staff</div>
          </div>
        </div>
        <form action="" method="POST">
          <button type="submit" style="font-size: 30px; color: red;" class='bx bx-log-out' id="log_out" name="logout"></button>
        </form>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <div class="text">
      <div class="text2">
        <h2>Welcome to Staff Dashboard!</h2>
        <img style="width: 110px;" src="img/robot.avif" alt="">
      </div>
    </div>
    <div class="container">
      <center>
        <h3 style="font-size: 25px;">Inventory Totals</h3>
      </center>
      <div class="cards">


        <a href="emp_category.php">
          <div class="card" style="background-color: #DBAE58;">
            <div class="box">
              <h2>Total Categories</h2>
              <h1><?php echo $tableCounts['category']; ?></h1>
              <div class="icon-design">
                <img src="img/category.png" alt="" style="width: 50px;">
              </div>
            </div>
          </div>
        </a>
        <a href="emp_product.php">
          <div class="card" style="background-color: #AC3E31;">
            <div class="box">
              <h2>Total Products</h2>
              <h1><?php echo $tableCounts['products']; ?></h1>
              <div class="icon-design">
                <img src="img/product.png" alt="" style="width: 50px;">
              </div>
            </div>
          </div>
        </a>
      </div>



      <div class="modal_box">
        <h3>LOGS AND REPORTS</h3>

        <!-- Slide 1: Audit Logs -->
        <div class="slide" style="display: block;">
          <h2>Audit Logs</h2>
          <div class="box_table">
            <div class="table_container">
              <table>
                <tr>
                  <th>Log ID</th>
                  <th>Table Name</th>
                  <th>Operation Type</th>
                  <th>Record ID</th>
                  <th>Username</th>
                  <th>Timestamp</th>
                </tr>
                <?php foreach ($logs as $log) : ?>
                  <tr>
                    <td><?= $log['log_id']; ?></td>
                    <td><?= $log['table_name']; ?></td>
                    <td><?= $log['operation_type']; ?></td>
                    <td><?= $log['record_id']; ?></td>
                    <td><?= $log['username']; ?></td>
                    <td><?= $log['timestamp']; ?></td>
                  </tr>
                <?php endforeach; ?>
              </table>
            </div>
          </div>
        </div>

        <!-- Slide 2: Reports -->
        <div class="slide" style="display: none;">
          <h2>Reports</h2>
          <div class="box_table">
            <div class="table_container">
            <h1>Reports</h1>
    <h2>Products Added in the Last 7 Days</h2>
    <?php displayTable($productReports['added']); ?>

    <h2>Products Deleted in the Last 7 Days</h2>
    <?php displayTable($productReports['deleted']); ?>

    <h2>Quantity Updated in the Last 7 Days</h2>
    <?php displayTable($productReports['quantityUpdated']); ?>

    <h1>Staff Report</h1>
    <h2>Staff Members Added in the Last 7 Days</h2>
    <?php displayTable($staffReports['added']); ?>

    <h2>Staff Members Deleted in the Last 7 Days</h2>
    <?php displayTable($staffReports['deleted']); ?>

    <h2>Staff Members Updated in the Last 7 Days</h2>
    <?php displayTable($staffReports['updated']); ?>
            </div>
          </div>
        </div>

        <!-- Navigation buttons for slides -->
        <button class="bx bx-chevron-left" onclick="showSlide(-1)"></button>
        <button class="bx bx-chevron-right" onclick="showSlide(1)"></button>
      </div>


    </div>
    </div>

  </section>



  <div id="ProfileModal" class="modal">
        <span class="close-btn" onclick="closeModal('ProfileModal')">&times;</span>
        <div class="modal-content">
    <div class="wrapper">
        <div class="user_card">
            <div class="user_card_img">
                <img src="img/user.png" alt="">
            </div>
            <div class="user_card_info">
                <h2><?php echo $loggedInUser['firstname']; ?> <?php echo $loggedInUser['lastname']; ?></h2>
                <h3>Staff</h3>
                <p><span>Name:</span> <?php echo $loggedInUser['firstname']; ?> <?php echo $loggedInUser['lastname']; ?></p>
                <p><span>Username:</span> <?php echo $loggedInUser['username']; ?></p>
                <p><span>Contact Number:</span> <?php echo $loggedInUser['contact_no']; ?></p>
                <button type="button" class="open-btn" onclick="openModal(
    <?php echo $loggedInUser['staff_id']; ?>,
    '<?php echo $loggedInUser['firstname']; ?>',
    '<?php echo $loggedInUser['lastname']; ?>',
    '<?php echo $loggedInUser['contact_no']; ?>',
    '<?php echo $loggedInUser['username']; ?>'
                         )">Settings</button>
            </div>
        </div>
    </div>
        </div>
</div>


    <?php $fNameError = isset($errors['edit_firstname']) ? $errors['edit_firstname'] : ''; ?>
    <?php $lNameError = isset($errors['edit_lastname']) ? $errors['edit_lastname'] : ''; ?>
    <?php $contactError = isset($errors['contact_no']) ? $errors['contact_no'] : ''; ?>
    <?php $uNameError = isset($errors['edit_username']) ? $errors['edit_username'] : ''; ?>
    <?php $passError = isset($errors['edit_password']) ? $errors['edit_password'] : ''; ?>



    <div id="openModal" class="modal">
        <span class="close-btn" onclick="closeModal('openModal')">&times;</span>
        <div class="modal-content">
            <h1>Edit Profile</h1>
            <div class="form">
            <form action="" method="POST">
                <div class="form-group">
                    <input type="hidden" name="edit_staff_id" id="edit_staff_id">
                    <label for="edit_firstname">First Name <?php if (!empty($fNameError)) {
                                                                echo "<span id = 'efname'>{$fNameError}</span>";
                                                            } ?></label>
                    <input type="text" name="edit_firstname" id="edit_firstname">
                </div>

                <div class="form-group">
                    <label for="edit_lastname">Last Name <?php if (!empty($lNameError)) {
                                                                echo "<span id = 'elname'>{$lNameError}</span>";
                                                            } ?></label>
                    <input type="text" name="edit_lastname" id="edit_lastname">
                </div>

                <div class="form-group">
                    <label for="edit_username">Username <?php if (!empty($uNameError)) {
                                                            echo "<span id = 'euname'>{$uNameError}</span>";
                                                        } ?></label>
                    <input type="text" name="edit_username" id="edit_username">
                </div>

                <div class="form-group">
                    <label for="edit_contact_no">Contact Number <?php if (!empty($contactError)) {
                                                                    echo "<span id = 'econtact'>{$contactError}</span>";
                                                                } ?></label>
                    <input type="text" name="edit_contact_no" id="edit_contact_no">
                </div>

                <div class="modal_btn">
                    <div class="btn">
                        <button type="button" class="btn-secondary" onclick="togglePasswordFields()">Change Password</button>
                    </div>
                </div>

                <div id="passwordFields" style="display: none;">
                    <div class="pass_form-group">
                        <label for="edit_password">New Password <?php if (!empty($passError)) {
                                                                    echo "<span id = 'epass'>{$passError}</span>";
                                                                } ?></label>
                        <input type="password" name="edit_password" id="edit_password">
                    </div>

                    <div class="pass_form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password">
                    </div>
                </div>

                <div class="modal_btn">
                    <div class="btn">
                        <button type="submit" name="Submit" class="btn-primary">Submit</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
  <script src="js/staff_dashboard.js"></script>
</body>

</html>

<style>
    .form-group span,
    .pass_form-group span {
        color: red;
        font-size: 13px;
    }

    .modal h1 {
        color: #2196f3;
        text-align: center;
        margin-bottom: 20px;
    }



    .edit-form {
        max-width: 700px;
        margin: 0 auto;
    }

    .form-group,
    .pass_form_group {
        margin-bottom: 20px;
    }

    .form label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    .form form input, .form form input  {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .modal_btn {
        text-align: center;
    }

    .btn {
        justify-content: space-between;
        margin: 10px;
    }

    .btn button {
        width: 48%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #2196f3;
        color: #fff;
    }

    .btn-secondary {
        background-color: #ccc;
        color: #000;
    }

    .btn:hover {
        opacity: 0.8;
    }



    .wrapper button {
        width: 100px;
        color: #fff;
        background-color: #2196f3;
        border-radius: 20px;
        padding: 5px;
        text-align: center;
        margin-top: 20px;
    }

    .wrapper button:hover {
        color: #fff;
        background-color: #1565c0;
    }


    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
        /* Ensure a higher z-index */
    }



    .modal-content {
      width: 800px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
    }

    .wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding-top: 12%;
    }

    .user_card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        border-radius: 10px;
        padding: 40px;
        width: 650px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 20px -5px rgba(0, 0, 0, 0.5);
    }

    .user_card::before {
        position: absolute;
        content: '';
        height: 300%;
        width: 173px;
        background: #262626;
        top: -60px;
        left: -125px;
        z-index: 0;
        transform: rotate(17deg);
    }

    .user_card_img {
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 3;
    }

    .user_card_img img {
        width: 150px;
        height: 200px;
        object-fit: cover;
    }

    .user_card_info {
        text-align: center;
    }

    .user_card_info h2 {
        font-size: 24px;
        margin: 0;
        margin-bottom: 10px;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }

    .user_card_info p {
        font-size: 14px;
        margin-bottom: 2px;
    }

    .user_card_info p span {
        font-weight: 700;
        margin-right: 10px;
    }


    @media only screen and (min-width: 768px) {
        .user_card {
            flex-direction: row;
            align-items: flex-start;
        }

        .user_card_img {
            margin-right: 20px;
            margin-bottom: 0;
        }

        .user_card_info {
            text-align: left;
        }
    }

    @media (max-width: 767px) {
        .wrapper {
            padding-top: 3%;
        }

        .user_card::before {
            width: 300%;
            height: 200px;
            transform: rotate(0);
        }

        .user_card_info h2 {
            margin-top: 25px;
            font-size: 25px;
        }

        .user_card_info p span {
            display: block;
            margin-bottom: 15px;
            font-size: 18px;
        }
    }
</style>
<script>
function ProfileModal() {
        var ProfileModal = document.getElementById('ProfileModal');
        if (ProfileModal) {
          ProfileModal.style.display = 'flex';
        }
    }

  function openModal(staff_id, firstname, lastname, contact_no, username, password) {
        var openModal = document.getElementById('openModal');
        if (openModal) {
            openModal.style.display = 'flex';

            document.getElementById('edit_staff_id').value = staff_id;
            document.getElementById('edit_firstname').value = firstname;
            document.getElementById('edit_lastname').value = lastname;
            document.getElementById('edit_contact_no').value = contact_no;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_password').value = password;
        }
    }


    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    }

    window.onclick = function(event) {
        var openModal = document.getElementById('openModal');
        var ProfileModal = document.getElementById('ProfileModal');

        if (event.target == openModal) {
            closeModal('openModal');
        }
        if (event.target == ProfileModal) {
            closeModal('ProfileModal');
        }
    }

    function togglePasswordFields() {
        var passwordFields = document.getElementById('passwordFields');
        if (passwordFields) {
            var displayValue = passwordFields.style.display;
            passwordFields.style.display = displayValue === 'none' ? 'block' : 'none';
        }
    }

// edit error timeout
setTimeout(function () {
    document.getElementById('efname').style.display = 'none';
    document.getElementById('elname').style.display = 'none';
    document.getElementById('econtact').style.display = 'none';
}, 5000);
setTimeout(function () {
    document.getElementById('euname').style.display = 'none';
    document.getElementById('epass').style.display = 'none';
    document.getElementById('conpass').style.display = 'none';
}, 5000);
</script>
