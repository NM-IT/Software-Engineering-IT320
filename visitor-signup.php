<?php
session_start();
require_once 'config.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($full_name === '' || $email === '' || $password === '') {
        $message = 'Please fill in all required fields.';
        $message_type = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        $message_type = 'error';
    } else {
        $check_stmt = mysqli_prepare($conn, 'SELECT visitor_id FROM visitor WHERE email = ?');
        mysqli_stmt_bind_param($check_stmt, 's', $email);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $message = 'This email already exists. Please use another email.';
            $message_type = 'error';
        } else {
            $insert_stmt = mysqli_prepare($conn, 'INSERT INTO visitor (full_name, email, password) VALUES (?, ?, ?)');
            mysqli_stmt_bind_param($insert_stmt, 'sss', $full_name, $email, $password);

            if (mysqli_stmt_execute($insert_stmt)) {
                $message = 'Account created successfully. You can log in now.';
                $message_type = 'success';
            } else {
                $message = 'Something went wrong while creating the account.';
                $message_type = 'error';
            }

            mysqli_stmt_close($insert_stmt);
        }

        mysqli_stmt_close($check_stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Darbic - Visitor Sign Up</title>
  <link rel="stylesheet" href="visitor.css">

  <style>
    .signup-wrapper{
      min-height: calc(100vh - 260px);
      display:flex;
      justify-content:center;
      align-items:center;
      padding:40px 20px;
    }

    .signup-card{
      width:100%;
      max-width:520px;
      background:white;
      border-radius:18px;
      box-shadow:0 10px 25px rgba(0,0,0,0.08);
      padding:35px;
    }

    .signup-title{
      text-align:center;
      color:#7A1023;
      margin-bottom:10px;
      font-size:32px;
    }

    .signup-subtitle{
      text-align:center;
      color:#666;
      margin-bottom:30px;
      font-size:15px;
    }

    .form-group{
      display:flex;
      flex-direction:column;
      margin-bottom:18px;
    }

    .form-group label{
      margin-bottom:8px;
      font-weight:600;
      color:#444;
    }

    .form-group input{
      padding:12px 14px;
      border:1px solid #ddd;
      border-radius:10px;
      font-size:15px;
      outline:none;
      transition:0.3s;
    }

    .form-group input:focus{
      border-color:#8f0f1f;
      box-shadow:0 0 0 3px rgba(143,15,31,0.10);
    }

    .signup-actions{
      margin-top:25px;
      display:flex;
      justify-content:center;
    }

    .signup-actions .btn-darbic{
      width:100%;
      justify-content:center;
    }

    .login-text{
      text-align:center;
      margin-top:18px;
      color:#555;
      font-size:14px;
    }

    .login-text a{
      color:#7A1023;
      font-weight:600;
      text-decoration:none;
    }

    .login-text a:hover{
      text-decoration:underline;
    }

    .message-box{
      border-radius:10px;
      padding:12px;
      margin-bottom:18px;
      text-align:center;
      font-size:14px;
    }

    .message-box.error{
      background:#f9e7ed;
      color:#7A1023;
      border:1px solid #e7c8d0;
    }

    .message-box.success{
      background:#e8f6ee;
      color:#166534;
      border:1px solid #bde5c8;
    }
  </style>
</head>
<body>

  <header class="main-header">
    <img src="images/darbic-logo.jpg" alt="Darbic Logo" class="logo">
    <h1 class="Darbic-name">DARBIC</h1>
    <button class="signout-btn" type="button" onclick="window.location.href='index.php'">Home</button>
  </header>

  <section class="signup-wrapper">
    <div class="signup-card">

      <h2 class="signup-title">Visitor Sign Up</h2>
      <p class="signup-subtitle">
        Create your account to access the Darbic system.
      </p>

      <?php if ($message !== ''): ?>
        <div class="message-box <?php echo htmlspecialchars($message_type); ?>">
          <?php echo htmlspecialchars($message); ?>
        </div>
      <?php endif; ?>

      <form action="" method="post">

        <div class="form-group">
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" placeholder="Enter your full name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
        </div>

        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="Enter your email address" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password">
        </div>

        <div class="signup-actions">
          <button type="submit" class="btn-darbic">Create Account</button>
        </div>

        <div class="login-text">
          Already have an account?
          <a href="visitor-login.php">Log In</a>
        </div>

      </form>
    </div>
  </section>

  <footer class="main-footer">
    <div class="footer-content">
      <img src="images/darbic-logo.jpg" alt="Darbic Logo" class="footer-logo">

      <div class="contact-info">
        <p>Email: info@Darbic.com</p>
        <p>Phone: +966 50 000 0000</p>
        <p>Riyadh, Saudi Arabia</p>
      </div>
    </div>

    <div class="footer-bottom">
      &copy; 2026 Darbic. All rights reserved.
    </div>
  </footer>

</body>
</html>
