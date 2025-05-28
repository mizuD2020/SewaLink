<?php
session_start();
require_once '../includes/dbconnection.php';

// Initialize variables
$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['error'], $_SESSION['success']);

// Fetch services for worker dropdown
try {
    $stmt = $dbh->query("SELECT ID, Category FROM tblcategory ORDER BY Category ASC");
    $serviceOptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $serviceOptions = [];
    $error = "Error fetching services: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register | SewaLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="../css/register.css">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow-sm" style="width: 100%; max-width: 550px;">
            <h3 class="text-center mb-4">SewaLink Registration</h3>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST" action="register.php">
                <div class="mb-3 text-center">
                    <div class="user-worker-toggle">
                        <input type="radio" id="userRadio" name="user_type" value="user" required checked>
                        <label for="userRadio">User</label>
                        <input type="radio" id="workerRadio" name="user_type" value="worker" required>
                        <label for="workerRadio">Worker</label>
                        <div class="slider"></div>
                    </div>
                </div>

                <!-- Common Fields -->
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="full_name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="pass" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="cpass" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone_number" required>
                </div>

                <!-- Worker-Specific Field -->
                <div class="mb-3" id="serviceField" style="display: none;">
                    <label class="form-label">Service Type (for Workers)</label>
                    <select class="form-select" name="service_type">
                        <option value="">-- Select Service --</option>
                        <?php foreach ($serviceOptions as $service): ?>
                            <option value="<?= htmlspecialchars($service['ID']) ?>">
                                <?= htmlspecialchars($service['Category']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Location -->
                <div class="mb-3">
                    <label class="form-label">Select Your Location on Map</label>
                    <div id="map" style="height: 300px;"></div>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Register</button>
                </div>
            </form>
            <div class="already-registered">
                Already registered? <a href="login.php">Login here</a>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/register.js"></script>
</body>

</html>