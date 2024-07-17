<?php
include '../../database/connection.php';

$response = array();

if (isset($_POST['pet_id'])) {
    $pet_id = $_POST['pet_id'];

    $update_status = "UPDATE tbl_pets SET pet_status = 'For adoption' WHERE pet_id = ?";
    $stmt = $conn->prepare($update_status);
    $result = $stmt->execute([$pet_id]);

    if ($result) {
        $response['status'] = 'success';
        $response['message'] = 'Pet approved successfully!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to approve pet.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Pet ID not provided.';
}

header('Content-Type: application/json');
echo json_encode($response);
