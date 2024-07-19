<?php
include '../database/connection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adoption_id']) && isset($_POST['action']) && $_POST['action'] === 'completed') {
    $adoption_id = $_POST['adoption_id'];
    $owner_fullname = $_SESSION['user_fullname'];
    $owner_email = $_SESSION['user_email'];
    $owner_contact = $_SESSION['user_contact'];
    $owner_address = $_SESSION['user_address'];

    try {
        $conn->beginTransaction();
        $update_sql = "UPDATE tbl_adoption SET remarks = 'Completed' WHERE adoption_id = ?";
        $stmt = $conn->prepare($update_sql);
        $update_result = $stmt->execute([$adoption_id]);

        if ($update_result) {
            $adoption_sql = "
            SELECT 
                p.pet_name,
                p.pet_age,
                p.pet_type,
                p.pet_breed,
                p.pet_condition,
                a.created_at AS adoption_created_at,
                u2.fullname AS adoptor_fullname,
                u2.email AS adoptor_email,
                u2.contact AS adoptor_contact,
                u2.address AS adoptor_address
            FROM tbl_adoption a
            JOIN tbl_pets p ON a.pet_id = p.pet_id
            JOIN tbl_users u2 ON a.user_id = u2.user_id
            WHERE a.adoption_id = ?";
            $stmt = $conn->prepare($adoption_sql);
            $stmt->execute([$adoption_id]);
            $adoption_data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($adoption_data) {
                $report_sql = "
                INSERT INTO tbl_reports (
                    owner_fullname, owner_email, owner_contact, owner_address, 
                    pet_name, pet_age, pet_type, pet_breed, pet_condition, date,
                    adoptor_fullname, adoptor_email, adoptor_contact, adoptor_address, status
                ) VALUES (
                    ?, ?, ?, ?, 
                    ?, ?, ?, ?, ?, ?, 
                    ?, ?, ?, ?, 'Completed'
                )";
                $stmt = $conn->prepare($report_sql);
                $insert_result = $stmt->execute([
                    $owner_fullname, $owner_email, $owner_contact, $owner_address,
                    $adoption_data['pet_name'], $adoption_data['pet_age'], $adoption_data['pet_type'],
                    $adoption_data['pet_breed'], $adoption_data['pet_condition'], $adoption_data['adoption_created_at'],
                    $adoption_data['adoptor_fullname'], $adoption_data['adoptor_email'],
                    $adoption_data['adoptor_contact'], $adoption_data['adoptor_address']
                ]);


                if ($insert_result) {
                    $conn->commit();
                    $response['status'] = 'success';
                    $response['message'] = 'Adoption request marked as completed';
                } else {
                    $conn->rollBack();
                    $response['status'] = 'error';
                    $response['message'] = 'Failed to insert report.';
                }
            } else {
                $conn->rollBack();
                $response['status'] = 'error';
                $response['message'] = 'Failed to retrieve adoption data.';
            }
        } else {
            $conn->rollBack();
            $response['status'] = 'error';
            $response['message'] = 'Failed to update adoption request.';
        }
    } catch (Exception $e) {
        $conn->rollBack();
        $response['status'] = 'error';
        $response['message'] = 'Transaction failed: ' . $e->getMessage();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request.';
}

header('Content-Type: application/json');
echo json_encode($response);
