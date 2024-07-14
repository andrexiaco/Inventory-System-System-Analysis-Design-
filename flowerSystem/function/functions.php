<?php
function getDatabaseConnection(){

    $host = 'localhost';
    $dbname = 'inventorysystem';
    $user = 'root';
    $password = '';
    $dsn = "mysql:dbname=$dbname;host=$host";

    try{
        $conn = new PDO($dsn, $user, $password);
        return $conn;
    }
    catch (PDOException $e)
    {
        echo 'Connection Failed!: ' . $e->getMessage();
    }
}


function insertStaff($firstname, $lastname, $contact_no , $username, $hashed_password){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("INSERT INTO staff (firstname, lastname, username, contact_no, password)
                            VALUES (:firstname, :lastname, :username, :contact_no, :password)");

    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':contact_no', $contact_no);
    $stmt->bindParam(':password', $hashed_password);

    $respose = $stmt->execute();

    if( $respose )
    {
        return $conn->lastInsertId();
    }
    else
    {
        return FALSE;
    }
}


function updateStaff($staff_id, $firstname, $lastname, $contact_no, $username, $password){
    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("UPDATE staff 
                            SET firstname = :firstname, lastname = :lastname, contact_no = :contact_no, username = :username, password = :password
                            WHERE staff_id = :staff_id");

    $stmt->bindParam(':staff_id', $staff_id);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':contact_no', $contact_no);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    $respose = $stmt->execute();

    if( $respose )
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}




function loginUser($username, $password) {
    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("SELECT * FROM staff WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Login successful
        return $user;
    } else {
        // Login failed
        return FALSE;
    }
}

function userLogout() {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

function GetLoginUser($staff_id){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("SELECT * FROM staff WHERE staff_id = :staff_id");
    $stmt->bindParam(':staff_id', $staff_id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}



function GetUser() {
    $conn = getDatabaseConnection();

    // Fetch user data using username
    $stmt = $conn->prepare("SELECT * FROM staff");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result; 
}



function insertCategory($category_name){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("INSERT INTO category (category_name)
                            VALUES (:category_name)");

    $stmt->bindParam(':category_name', $category_name);

    $respose = $stmt->execute();

    if( $respose )
    {
        return $conn->lastInsertId();
    }
    else
    {
        return FALSE;
    }
}


function updateCategory($category_id, $category_name){
    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("UPDATE category
                            SET category_name = :category_name
                            WHERE category_id = :category_id");

    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':category_name', $category_name);

    $respose = $stmt->execute();

    if( $respose )
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}





function GetCategory(){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("SELECT * FROM category");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}



function GetProduct(){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}


function GetProductWithCategory() {
    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("SELECT p.*, c.*
                            FROM products p
                            LEFT JOIN category c ON p.category_id = c.category_id");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}




function insertProduct($product_name, $quantity, $category_id, $price) {
    
    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("INSERT INTO products (product_name, quantity, category_id, price)
                            VALUES (:product_name, :quantity, :category_id, :price)");

    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':price', $price);

    $respose = $stmt->execute();

    if ( $respose ) {
        return $conn->lastInsertId();
    } else {
        return FALSE;
    }
}


function updateProduct($product_id, $product_name, $quantity, $category_id, $price){
    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("UPDATE products 
                            SET product_name = :product_name, quantity = :quantity, category_id = :category_id, price = :price
                            WHERE product_id = :product_id");

    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':price', $price);

    $respose = $stmt->execute();

    if( $respose )
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}





//Staff Dashboard
function getTableCounts() {
    $conn = getDatabaseConnection();
    
    $counts = array();

    // Get total count for the category table
    $stmt = $conn->prepare("SELECT COUNT(*) AS category_count FROM category");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $counts['category'] = $result['category_count'];

    // Get total count for the products table
    $stmt = $conn->prepare("SELECT COUNT(*) AS product_count FROM products");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $counts['products'] = $result['product_count'];

    // Add more sections for other tables if needed

    return $counts;
}


//Admin DashBoard
function getTablesCounts() {
    $conn = getDatabaseConnection();
    
    $counts = array();

    // Get total count for the category table
    $stmt = $conn->prepare("SELECT COUNT(*) AS category_count FROM category");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $counts['category'] = $result['category_count'];

    // Get total count for the products table
    $stmt = $conn->prepare("SELECT COUNT(*) AS product_count FROM products");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $counts['products'] = $result['product_count'];

    // Get total count for the admin table
    $stmt = $conn->prepare("SELECT COUNT(*) AS admin_count FROM admins");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $counts['admin'] = $result['admin_count'];

    // Get total count for the staff table
    $stmt = $conn->prepare("SELECT COUNT(*) AS staff_count FROM staff");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $counts['staff'] = $result['staff_count'];

    // Add more sections for other tables if needed

    return $counts;
}







//Admin side
function GetStaff(){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("SELECT * FROM staff");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}


function insertAdmin($fullname, $username, $role_id, $password) {
    
    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("INSERT INTO admins (fullname, username, role_id, password)
                            VALUES (:fullname, :username, :role_id, :password)");

    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':role_id', $role_id);
    $stmt->bindParam(':password', $password);

    $respose = $stmt->execute();

    if ( $respose ) {
        return $conn->lastInsertId();
    } else {
        return FALSE;
    }
}


function GetAdmin(){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("
    SELECT a.*, r.role_name
    FROM admins a
    JOIN roles r ON a.role_id = r.role_id
");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}


function GetRole(){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("SELECT * FROM roles");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}




function GetLogs(){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("SELECT * FROM auditlogs");
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}





function updateAdmin($admin_id, $fullname, $username, $role_id, $password){
    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("UPDATE admins 
                            SET fullname = :fullname, username = :username, role_id = :role_id, password = :password
                            WHERE admin_id = :admin_id");

    $stmt->bindParam(':admin_id', $admin_id);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':role_id', $role_id);
    $stmt->bindParam(':password', $password);

    $respose = $stmt->execute();

    if( $respose )
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}




function loginAdmin($username, $password) {
    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("
    SELECT a.*, r.role_name
    FROM admins a
    JOIN roles r ON a.role_id = r.role_id
    WHERE a.username = :username AND a.password = :password
");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        // Login successful
        return $admin;
    } else {
        // Login failed
        return FALSE;
    }
}

function adminLogout() {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

function GetLoginAdmin($admin_id){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("SELECT * FROM admins WHERE admin_id = :admin_id");
    $stmt->bindParam(':admin_id', $admin_id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}




//Delete Tables

function deleteStaff($staff_id){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("DELETE FROM staff WHERE staff_id = :staff_id");
    $stmt->bindParam(':staff_id', $staff_id);
    $respose = $stmt->execute();

    if( $respose )
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}


function deleteProduct($product_id){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id);
    $respose = $stmt->execute();

    if( $respose )
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function deleteCategory($category_id){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("DELETE FROM category WHERE category_id = :category_id");
    $stmt->bindParam(':category_id', $category_id);
    $respose = $stmt->execute();

    if( $respose )
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}


function deleteAdmin($admin_id) {
    $conn = getDatabaseConnection();

    // Check if the admin being deleted has the main admin role
    $stmtCheckMainAdmin = $conn->prepare("SELECT role_id FROM admins WHERE admin_id = :admin_id");
    $stmtCheckMainAdmin->bindParam(':admin_id', $admin_id);
    $stmtCheckMainAdmin->execute();

    $adminData = $stmtCheckMainAdmin->fetch(PDO::FETCH_ASSOC);

    if ($adminData['role_id'] === '1') {
        // Main admin cannot be deleted
        return FALSE;
    }

    // Proceed with the deletion if not the main admin
    $stmt = $conn->prepare("DELETE FROM admins WHERE admin_id = :admin_id");
    $stmt->bindParam(':admin_id', $admin_id);
    $response = $stmt->execute();

    if ($response) {
        return TRUE;
    } else {
        return FALSE;
    }
}




function deleteaudit($log_id){

    $conn = getDatabaseConnection();

    $stmt = $conn->prepare("DELETE FROM auditlogs WHERE log_id = :log_id");
    $stmt->bindParam(':log_id', $log_id);
    $respose = $stmt->execute();

    if( $respose )
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}



//Reports//
function ProductReport() {
    $conn = getDatabaseConnection();
    $counts = array();

    // Products added in the last 7 days
    $addedQuery = "SELECT
                        product_id,
                        product_name,
                        quantity,
                        category_id,
                        price,
                        created_at
                    FROM
                        Products
                    WHERE
                        created_at >= NOW() - INTERVAL 7 DAY";

    $stmt = $conn->prepare($addedQuery);
    $stmt->execute();
    $counts['added'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Products deleted in the last 7 days
    $deletedQuery = "SELECT
                        product_id,
                        product_name,
                        quantity,
                        category_id,
                        price,
                        updated_at AS deleted_at
                    FROM
                        Products
                    WHERE
                        updated_at >= NOW() - INTERVAL 7 DAY
                        AND created_at < NOW() - INTERVAL 7 DAY";

    $stmt = $conn->prepare($deletedQuery);
    $stmt->execute();
    $counts['deleted'] = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $quantityUpdatedQuery = "SELECT
    product_id,
    product_name,
    quantity,
    category_id,
    price,
    updated_at AS updated_at
FROM
    Products
WHERE
    updated_at >= NOW() - INTERVAL 7 DAY
    AND created_at < NOW() - INTERVAL 7 DAY";

$stmt = $conn->prepare($quantityUpdatedQuery);
$stmt->execute();
$counts['quantityUpdated'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close the connection
    $conn = null;

    // Return the results as an associative array
    return $counts;
}

function displayTable($data) {
    if (empty($data)) {
        echo "<p>No records found</p>";
        return;
    }

    echo "<table border='1'>";
    echo "<tr>";
    foreach ($data[0] as $key => $value) {
        echo "<th>$key</th>";
    }
    echo "</tr>";

    foreach ($data as $row) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
}


function StaffReport() {
    $conn = getDatabaseConnection();
    $counts = array();

    // Staff members added in the last 7 days
    $addedQuery = "SELECT
                        staff_id,
                        firstname,
                        lastname,
                        contact_no,
                        username
                    FROM
                        staff
                    WHERE
                        created_at >= NOW() - INTERVAL 7 DAY";

    $stmt = $conn->prepare($addedQuery);
    $stmt->execute();
    $counts['added'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Staff members deleted in the last 7 days
    $deletedQuery = "SELECT
                        staff_id,
                        firstname,
                        lastname,
                        contact_no,
                        username
                    FROM
                        staff
                    WHERE
                        updated_at >= NOW() - INTERVAL 7 DAY
                        AND created_at < NOW() - INTERVAL 7 DAY";

    $stmt = $conn->prepare($deletedQuery);
    $stmt->execute();
    $counts['deleted'] = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // Staff members updated in the last 7 days
    $updatedQuery = "SELECT
                        staff_id,
                        firstname,
                        lastname,
                        contact_no,
                        username,
                        updated_at AS updated_at
                    FROM
                        staff
                    WHERE
                        updated_at >= NOW() - INTERVAL 7 DAY
                        AND created_at < NOW() - INTERVAL 7 DAY";

    $stmt = $conn->prepare($updatedQuery);
    $stmt->execute();
    $counts['updated'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close the connection
    $conn = null;

    // Return the results as an associative array
    return $counts;
}










function searchProducts($searchTerm) {
    $conn = getDatabaseConnection();

    try {
        $stmtProducts = $conn->prepare("SELECT * FROM products WHERE product_name LIKE :searchTerm");
        $stmtProducts->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
        $stmtProducts->execute();
        $products = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    } catch (PDOException $e) {
        // Handle database errors here
        return [];
    } finally {
        // Close the database connection
        $conn = null;
    }
}

?>

