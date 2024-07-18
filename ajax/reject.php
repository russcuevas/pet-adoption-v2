<?php
// Include your database connection file
include '../database/connection.php';

// Check if the request is POST and adoption_id is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adoption_id'])) {
    $adoption_id = $_POST['adoption_id'];

    // Delete the adoption request from tbl_adoption
    $delete_sql = "DELETE FROM tbl_adoption WHERE adoption_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $delete_result = $stmt->execute([$adoption_id]);

    if ($delete_result) {
        // Send success response
        $response['status'] = 'success';
        $response['message'] = 'Adoption request rejected successfully.';
    } else {
        // Send error response for deletion failure
        $response['status'] = 'error';
        $response['message'] = 'Failed to reject adoption request.';
    }
} else {
    // Handle invalid requests or direct accesses
    $response['status'] = 'error';
    $response['message'] = 'Invalid request.';
    http_response_code(400); // Bad Request
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
