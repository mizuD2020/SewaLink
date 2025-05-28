<?php
session_start();
require_once '../includes/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $pass = $_POST['pass'] ?? '';
    $userType = $_POST['user_type'] ?? '';

    try {
        // Debug output (remove after testing)
        error_log("Login attempt - Email: $email, Type: $userType");

        if ($userType === 'worker') {
            $table = 'tblperson';
            $emailColumn = 'Email';
            $nameColumn = 'Name';
            $passwordColumn = 'Password';
        } else {
            $table = 'users';
            $emailColumn = 'email';
            $nameColumn = 'full_name';
            $passwordColumn = 'password'; // Change if different in users table
        }

        // Debug: Show the actual query being executed
        $query = "SELECT * FROM $table WHERE $emailColumn = :email";
        error_log("Executing query: $query");

        $stmt = $dbh->prepare($query);
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debug: Show what was actually fetched
        error_log("Fetched row: " . print_r($row, true));

        if ($row) {
            // Debug: Show password verification details
            error_log("Input password: $pass");
            error_log("Stored hash: " . $row[$passwordColumn]);
            error_log("Verification result: " . password_verify($pass, $row[$passwordColumn]));

            if (password_verify($pass, $row[$passwordColumn])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_type'] = $userType;
                $_SESSION['username'] = $row[$nameColumn];

                // Debug: Successful login
                error_log("Login SUCCESS for $email");

                header("Location: ../index.php");
                exit;
            }
        }

        // If we reach here, login failed
        error_log("Login FAILED for $email");
        $_SESSION['login_error'] = "Invalid credentials!";
        header("Location: login.php");
        exit;

    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        $_SESSION['login_error'] = "Database error: " . $e->getMessage();
        header("Location: login.php");
        exit;
    }
}
?>