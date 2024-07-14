<?php
require_once('function/functions.php');

$productReports = ProductReport();
$staffReports = StaffReport();
$logs = getLogs();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title>Reports</title>
</head>
<body>
<section>
<h1>Product Report</h1>
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
</section>
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
</body>
</html>
