<?php
include '../../database/connection.php';

$response = array();

if (isset($_POST['pet_id'], $_POST['pet_image'])) {
    $pet_id = $_POST['pet_id'];
    $pet_image = $_POST['pet_image'];

    $image_path = '../../images/pet-images/' . basename($pet_image);
    if (unlink($image_path)) {
        $delete_pet = "DELETE FROM tbl_pets WHERE pet_id = ?";
        $stmt = $conn->prepare($delete_pet);
        $result = $stmt->execute([$pet_id]);

        if ($result) {
            $response['status'] = 'success';
            $response['message'] = 'Pet rejected and image deleted successfully!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to delete pet from database.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to delete pet image.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Pet ID or image not provided.';
}

header('Content-Type: application/json');
echo json_encode($response);
