<?php
include '../database/connection.php';

if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];

    if ($password !== $confirm_password) {
        $errors['password'] = "Password mismatch";
    }

    $stmt_check_email = $conn->prepare("SELECT COUNT(*) FROM tbl_users WHERE email = ?");
    $stmt_check_email->execute([$email]);
    $count = $stmt_check_email->fetchColumn();

    if ($count > 0) {
        $errors['email'] = "Email already exists";
    }

    if (!empty($errors)) {
        echo "<script>";
        foreach ($errors as $key => $message) {
            echo "window.alert('$message');";
        }
        echo "window.history.back();";
        echo "</script>";
        exit;
    }

    unset($_SESSION['register_users_error']);

    $hashed_password = sha1($password);
    $stmt_insert_user = $conn->prepare("INSERT INTO tbl_users (fullname, contact, email, address, password) VALUES (?, ?, ?, ?, ?)");
    $stmt_insert_user->execute([$fullname, $contact, $email, $address, $hashed_password]);

    echo "<script>";
    echo "window.alert('Registered successfully');";
    echo "window.location.href = '../home.php';";
    echo "</script>";
    exit;
}
