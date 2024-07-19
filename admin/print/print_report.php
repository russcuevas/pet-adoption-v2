<?php
include '../../database/connection.php';

session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:admin_login.php');
}

// DISPLAY REPORTS
$get_reports = "SELECT * FROM `tbl_reports`";
$get_stmt = $conn->query($get_reports);
$reports = $get_stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Adoption Report</h1>
    <table>
        <thead>
            <tr>
                <th>Adopter Details</th>
                <th>Pet Details</th>
                <th>Adoptor Details</th>
                <th>Date Adopted</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report) : ?>
                <tr>
                    <td>
                        <?php echo $report['owner_fullname'] ?> <br>
                        <?php echo $report['owner_address'] ?> <br>
                        <?php echo $report['owner_contact'] ?> <br>
                        <?php echo $report['owner_email'] ?>
                    </td>
                    <td>
                        <?php echo $report['pet_name'] ?> <br>
                        <?php echo $report['pet_type'] ?> <br>
                        <?php echo $report['pet_breed'] ?> <br>
                        <?php echo $report['pet_condition'] ?>
                    </td>
                    <td>
                        <?php echo $report['adoptor_fullname'] ?> <br>
                        <?php echo $report['adoptor_address'] ?> <br>
                        <?php echo $report['adoptor_contact'] ?> <br>
                        <?php echo $report['adoptor_email'] ?>
                    </td>
                    <td>
                        <?php echo date('F j, Y / g:ia', strtotime($report['date'])) ?>
                    </td>
                    <td>
                        <?php echo $report['status'] ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>