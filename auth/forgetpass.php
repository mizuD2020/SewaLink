<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $fullname = $_POST['fullname'];
  $phone = $_POST['phone'];
  $showerror = false;
  $showlogin = false;

  require_once '../config/db.php';

  $sql = "SELECT `password` FROM `users` WHERE `fullname` = ? AND `email` = ? AND `phonenumber` = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sss", $fullname, $email, $phone);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;

    if ($num == 1) {
      $showlogin = true;
      $stmt->bind_result($password);
      $stmt->fetch();
    } else {
      $showerror = true;
    }

    $stmt->close();
  } else {
    $showerror = true;
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Forgot Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-sm-8">
        <div class="card">
          <div class="card-header bg-primary text-white text-center">
            <h4>Retrieve Your Password</h4>
          </div>
          <div class="card-body">
            <?php
            if (!empty($showlogin)) {
              echo '<div class="alert alert-success" role="alert">
                            <strong>Success!</strong> Your password is: <strong>' . htmlspecialchars($password) . '</strong>
                        </div>';
            }

            if (!empty($showerror)) {
              echo '<div class="alert alert-danger" role="alert">
                            <strong>Error!</strong> Invalid credentials. Account not found.
                        </div>';
            }
            ?>

            <form action="forgetpass.php" method="POST">
              <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" name="fullname" class="form-control" required placeholder="Enter your full name">
              </div>
              <div class="form-group">
                <label for="email">Registered Email</label>
                <input type="email" name="email" class="form-control" required placeholder="Enter your email">
              </div>
              <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" class="form-control" required placeholder="Enter your phone number">
              </div>
              <button type="submit" class="btn btn-success btn-block">Get Password</button>
            </form>
            <div class="text-center mt-3">
              <a href="login.php">Back to Login</a> |
              <a href="registerform.php">Create New Account</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>