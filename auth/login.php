<?php
session_start();
if (isset($_SESSION['login_error'])) {
  $loginError = $_SESSION['login_error'];
  unset($_SESSION['login_error']);
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Login | SewaLink</title>
  <style>
    /* Base styles */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f2f5;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: white;
      padding: 2rem 2.5rem;
      border-radius: 12px;
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
      width: 360px;
      max-width: 100%;
      text-align: center;
    }

    .toggle-switch {
      position: relative;
      width: 240px;
      height: 40px;
      background: #ddd;
      border-radius: 20px;
      margin: 0 auto 1.5rem;
      user-select: none;
      display: flex;
      cursor: pointer;
      box-shadow: inset 0 1px 3px rgba(255, 255, 255, 0.7);
    }

    .toggle-switch input {
      display: none;
    }

    .slider {
      position: absolute;
      top: 3px;
      left: 3px;
      width: 114px;
      height: 34px;
      background: #4CAF50;
      border-radius: 20px;
      transition: left 0.3s ease;
      box-shadow: 0 2px 8px rgba(76, 175, 80, 0.4);
      z-index: 0;
    }

    label {
      flex: 1;
      line-height: 40px;
      font-weight: 600;
      color: #555;
      z-index: 1;
      cursor: pointer;
      user-select: none;
      transition: color 0.3s ease;
    }

    #toggle-user:checked~.slider {
      left: 3px;
    }

    #toggle-worker:checked~.slider {
      left: 123px;
    }

    #toggle-user:checked~label[for="toggle-user"] {
      color: white;
    }

    #toggle-worker:checked~label[for="toggle-worker"] {
      color: white;
    }

    form {
      display: none;
      flex-direction: column;
      margin-top: 1rem;
    }

    form.active {
      display: flex;
    }

    input[type="email"],
    input[type="password"] {
      margin-bottom: 1rem;
      padding: 0.6rem 1rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      transition: border-color 0.2s ease;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
      border-color: #4CAF50;
      outline: none;
    }

    button {
      background: #4CAF50;
      border: none;
      padding: 0.75rem;
      color: white;
      font-weight: 700;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1rem;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #45a045;
    }

    .alert {
      background-color: #f8d7da;
      border: 1px solid #f5c6cb;
      color: #721c24;
      padding: 0.75rem 1rem;
      margin-bottom: 1rem;
      border-radius: 5px;
      font-size: 0.9rem;
      text-align: center;
    }

    .links {
      margin-top: 1rem;
      font-size: 0.9rem;
    }

    .links a {
      color: #4CAF50;
      text-decoration: none;
      margin: 0 0.25rem;
    }

    .links a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="container">
    <?php if (!empty($loginError)): ?>
      <div class="alert"><?php echo htmlspecialchars($loginError); ?></div>
    <?php endif; ?>

    <div class="toggle-switch" role="radiogroup" aria-label="Toggle User or Worker login">
      <input type="radio" id="toggle-user" name="user_toggle" checked>
      <label for="toggle-user">User Login</label>
      <input type="radio" id="toggle-worker" name="user_toggle">
      <label for="toggle-worker">Worker Login</label>
      <div class="slider"></div>
    </div>

    <!-- User Login Form -->
    <form class="form user-form active" action="login_process.php" method="POST" aria-label="User Login Form">
      <input type="hidden" name="user_type" value="user" />
      <input type="email" name="email" placeholder="Email" required autocomplete="username" />
      <input type="password" name="pass" placeholder="Password" required autocomplete="current-password" />
      <button type="submit">Login</button>
    </form>

    <!-- Worker Login Form -->
    <form class="form worker-form" action="login_process.php" method="POST" aria-label="Worker Login Form">
      <input type="hidden" name="user_type" value="worker" />
      <input type="email" name="email" placeholder="Email" required autocomplete="username" />
      <input type="password" name="pass" placeholder="Password" required autocomplete="current-password" />
      <button type="submit">Login</button>
    </form>

    <div class="links">
      <a href="registerform.php">Register New Account</a> |
      <a href="forgetpass.php">Forgot Password?</a>
    </div>
  </div>

  <script>
    const toggleUser = document.getElementById('toggle-user');
    const toggleWorker = document.getElementById('toggle-worker');
    const userForm = document.querySelector('.user-form');
    const workerForm = document.querySelector('.worker-form');

    toggleUser.addEventListener('change', () => {
      if (toggleUser.checked) {
        userForm.classList.add('active');
        workerForm.classList.remove('active');
      }
    });

    toggleWorker.addEventListener('change', () => {
      if (toggleWorker.checked) {
        workerForm.classList.add('active');
        userForm.classList.remove('active');
      }
    });
  </script>
</body>

</html>