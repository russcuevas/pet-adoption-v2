<?php
include '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adoption_id'])) {
    $adoption_id = $_POST['adoption_id'];

    $update_sql = "UPDATE tbl_adoption SET remarks = 'Ready to pick up' WHERE adoption_id = ?";
    $stmt = $conn->prepare($update_sql);
    $update_result = $stmt->execute([$adoption_id]);

    if ($update_result) {
        $select_pet_id_sql = "SELECT pet_id FROM tbl_adoption WHERE adoption_id = ?";
        $stmt = $conn->prepare($select_pet_id_sql);
        $stmt->execute([$adoption_id]);
        $pet_id = $stmt->fetchColumn();

        $delete_sql = "DELETE FROM tbl_adoption WHERE pet_id = ? AND adoption_id != ? AND remarks != 'Ready to pick up'";
        $stmt = $conn->prepare($delete_sql);
        $delete_result = $stmt->execute([$pet_id, $adoption_id]);

        if ($delete_result) {
            $update_pet_status_sql = "UPDATE tbl_pets SET pet_status = 'Already adopt' WHERE pet_id = ?";
            $stmt = $conn->prepare($update_pet_status_sql);
            $update_pet_status_result = $stmt->execute([$pet_id]);

            if ($update_pet_status_result) {
                $response['status'] = 'success';
                $response['message'] = 'Adoption request approved successfully.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to update pet status.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to delete other adoption requests.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to update adoption request.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request.';
    http_response_code(400);
}

header('Content-Type: application/json');
echo json_encode($response);
