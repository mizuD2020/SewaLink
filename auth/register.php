<?php
session_start();
require_once '../includes/dbconnection.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userType = $_POST['user_type'] ?? '';
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['pass'] ?? '';
    $cpass = $_POST['cpass'] ?? '';
    $phoneNumber = trim($_POST['phone_number'] ?? '');
    $latitude = $_POST['latitude'] ?? null;
    $longitude = $_POST['longitude'] ?? null;
    $serviceType = $_POST['service_type'] ?? null;

    // Validation
    if (empty($fullName) || empty($email) || empty($pass) || empty($phoneNumber)) {
        $_SESSION['error'] = "All fields are required!";
    } elseif ($pass !== $cpass) {
        $_SESSION['error'] = "Passwords do not match!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format!";
    } else {
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

        try {
            // Check email existence in appropriate table
            $table = ($userType === 'worker') ? 'tblperson' : 'users';
            $emailField = ($userType === 'worker') ? 'Email' : 'email';

            $stmt = $dbh->prepare("SELECT COUNT(*) FROM $table WHERE $emailField = ?");
            $stmt->execute([$email]);

            if ($stmt->fetchColumn() > 0) {
                $_SESSION['error'] = "Email already registered!";
            } else {
                // Insert into correct table
                if ($userType === 'worker') {
                    if (empty($serviceType)) {
                        $_SESSION['error'] = "Please select a service type!";
                    } else {
                        $sql = "INSERT INTO tblperson 
                                (Category, Name, Email, Password, MobileNumber, Latitude, Longitude) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute([
                            $serviceType,
                            $fullName,
                            $email,
                            $hashedPassword,
                            $phoneNumber,
                            $latitude,
                            $longitude
                        ]);
                        $_SESSION['success'] = "Worker registered successfully!";
                    }
                } else {
                    $sql = "INSERT INTO users 
                            (full_name, email, Password, phone_number, latitude, longitude) 
                            VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute([
                        $fullName,
                        $email,
                        $hashedPassword,
                        $phoneNumber,
                        $latitude,
                        $longitude
                    ]);
                    $_SESSION['success'] = "User registered successfully!";
                }
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Registration error: " . $e->getMessage();
        }
    }
}

header("Location: registerform.php");
exit();
?>