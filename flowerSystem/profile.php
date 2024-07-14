<?php
require_once('function/functions.php');
session_start();

if(isset($_SESSION['user'])){
    $loggedInUser = $_SESSION['user'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="cs/profile.css">
    <title>Staff Profile</title>
</head>
<body>

    <div class="container">
        <nav class="sidenav">
        <div class="top_button">
        <a href="emp_dashboard.php">
         <button type="submit" style="font-size: 30px; color: red;" class='bx bx-arrow-back' id="log_out" ></button>
        </a>
        </div>
            <div class="profile-info">
                <img class="myprofile" src="img/user.png" alt="">
                <h2><?php echo $loggedInUser['firstname']; ?> <?php echo $loggedInUser['lastname']; ?></h2>
                <h3>Staff</h3>
            </div>
        </nav>
        <div class="content">
            <section>
                <div class="box">
            
                
                <center><h1>Information</h1></center>
                
                <h3>Name:</h3> <p> <?php echo $loggedInUser['firstname']; ?> <?php echo $loggedInUser['lastname']; ?></p>
                <h3>Username:</h3> <p> <?php echo $loggedInUser['username']; ?></p>
                <h3>Contact Number:</h3> <p> <?php echo $loggedInUser['contact_no']; ?></p>
                <center><p style="font-size: 10px;">Contact the admin for updating your information</p><center>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
<style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    background-image: linear-gradient(-225deg, #473B7B 0%, #3584A7 51%, #30D2BE 100%);
    color: #2c3e50; /* Dark blue-gray text */
    display: flex;
    min-height: 100vh;
}

.container {
    display: flex;
    flex: 1;
}

.sidenav {
    width: 250px;
    background: #11101D;
    color: white;
    padding: 20px;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    max-height: 100%;
}

.profile-info {
    text-align: center;
    margin-bottom: 20px;
}

.profile-info h2 {
    margin-bottom: 10px;
    font-size: 1.5em;
}

.profile-info p {
    margin: 5px 0;
    font-size: 0.9em;
}

button{
    float: left;
}


.content {
    flex: 1;
    padding: 25px;
    
}

.box{
    background-color: #ccc;
    border-radius: 10px;
    padding: 25px;
}

section {
    background-color: #2c3e50;
    max-width: 700px;
    margin: 0 auto;
    padding: 30px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}


.top_button{
    width: 100%;
    display: flex;
    
}

.myprofile{
    width: 60px;
    border: 2px solid black;
    border-radius: 10px;
    background-color: #ccc;
}

@media only screen and (max-width: 600px) {
    .container {
        flex-direction: column;
    }

    .sidenav {
        width: 100%;
        max-height: none;
        box-shadow: none;
    }

    .content {
        padding: 10px;
    }

    section {
        max-width: 100%;
    }

}


</style>