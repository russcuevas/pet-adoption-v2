<?php
include '../database/connection.php';

$response = array();

if (isset($_POST['pet_id']) && isset($_POST['user_id'])) {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        $response['status'] = 'error';
        $response['message'] = 'You must be logged in to adopt a pet.';
    } else {
        $pet_id = $_POST['pet_id'];
        $user_id = $_POST['user_id'];

        $insert_query = "INSERT INTO tbl_adoption (user_id, pet_id, remarks, created_at, updated_at) VALUES (?, ?, 'Requesting', NOW(), NOW())";
        $stmt = $conn->prepare($insert_query);
        if ($stmt->execute([$user_id, $pet_id])) {
            $response['status'] = 'success';
            $response['message'] = 'Adopt request successfully submitted. Please wait for the owner to approve it.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to submit adopt request.';
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Pet ID or User ID not provided.';
}

header('Content-Type: application/json');
echo json_encode($response);
