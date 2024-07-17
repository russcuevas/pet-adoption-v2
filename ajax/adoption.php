<?php
include '../database/connection.php';

$response = array();

// Check if pet_id and user_id are provided via POST
if (isset($_POST['pet_id']) && isset($_POST['user_id'])) {
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        $response['status'] = 'error';
        $response['message'] = 'You must be logged in to adopt a pet.';
    } else {
        // Retrieve pet_id and user_id from POST data
        $pet_id = $_POST['pet_id'];
        $user_id = $_POST['user_id'];

        // Insert adoption request into tbl_adoption
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

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
