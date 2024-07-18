<?php
include '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adoption_id']) && isset($_POST['action']) && $_POST['action'] === 'completed') {
    $adoption_id = $_POST['adoption_id'];

    $update_sql = "UPDATE tbl_adoption SET remarks = 'Completed' WHERE adoption_id = ?";
    $stmt = $conn->prepare($update_sql);
    $update_result = $stmt->execute([$adoption_id]);

    if ($update_result) {
        $response['status'] = 'success';
        $response['message'] = 'Adoption request marked as Completed.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to update adoption request.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request.';
}

header('Content-Type: application/json');
echo json_encode($response);
