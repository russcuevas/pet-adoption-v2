<?php
// INCLUDING CONNECTION TO DATABASE
include '../database/connection.php';

// SESSION IF NOT LOGIN YOU CANT GO TO DIRECT PAGE
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit;
}

// GET ADMIN
$fetch_admin = $conn->prepare("SELECT * FROM `tbl_admin` WHERE admin_id = ?");
$fetch_admin->execute([$admin_id]);
$admin = $fetch_admin->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (!empty($password)) {
        if ($password === $confirmPassword) {
            $hashed_password = sha1($password);
            $update_query = "UPDATE `tbl_admin` SET fullname = ?, email = ?, address = ?, contact = ?, password = ? WHERE admin_id = ?";
            $stmt = $conn->prepare($update_query);
            $success = $stmt->execute([$fullname, $email, $address, $contact, $hashed_password, $admin_id]);

            if ($success) {
                $_SESSION['profile_update_success'] = "Updated successfully";
            } else {
                $_SESSION['profile_update_error'] = "Not updated successfully";
            }
        } else {
            $_SESSION['profile_update_error'] = "Password and confirm password do not match";
        }
    } else {
        $update_query = "UPDATE `tbl_admin` SET fullname = ?, email = ?, address = ?, contact = ? WHERE admin_id = ?";
        $stmt = $conn->prepare($update_query);
        $success = $stmt->execute([$fullname, $email, $address, $contact, $admin_id]);

        if ($success) {
            $_SESSION['profile_update_success'] = "Updated successfully";
        } else {
            $_SESSION['profile_update_error'] = "Not updated successfully";
        }
    }

    header('location:dashboard.php');
    exit;
}
