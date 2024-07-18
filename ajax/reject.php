<?php
include '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adoption_id'])) {
    $adoption_id = $_POST['adoption_id'];

    $delete_sql = "DELETE FROM tbl_adoption WHERE adoption_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $delete_result = $stmt->execute([$adoption_id]);

    if ($delete_result) {
        $response['status'] = 'success';
        $response['message'] = 'Adoption request rejected successfully.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to reject adoption request.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request.';
    http_response_code(400); // Bad Request
}

header('Content-Type: application/json');
echo json_encode($response);
