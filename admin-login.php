<?php
session_start();
require_once 'config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $message = 'Please enter admin email and password.';
    } else {
        $stmt = mysqli_prepare($conn, 'SELECT admin_id, full_name, email, password FROM admin WHERE email = ? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admin = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($admin && $admin['password'] === $password) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['admin_email'] = $admin['email'];
            header('Location: admin_dashboard.html');
            exit;
        } else {
            $message = 'Invalid admin email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Darbic - Admin Login</title>
  <link rel="stylesheet" href="visitor.css">

  <style>
    .login-wrapper{
      min-height: calc(100vh - 260px);
      display:flex;
      justify-content:center;
      align-items:center;
      padding:40px 20px;
    }

    .login-card{
      width:100%;
      max-width:500px;
      background:white;
      border-radius:18px;
      box-shadow:0 10px 25px rgba(0,0,0,0.08);
      padding:35px;
    }

    .login-title{
      text-align:center;
      color:#7A1023;
      font-size:32px;
      margin-bottom:10px;
    }

    .login-subtitle{
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

    .login-actions{
      margin-top:25px;
      display:flex;
      justify-content:center;
    }

    .login-actions .btn-darbic{
      width:100%;
      justify-content:center;
    }

    .message-box{
      background:#f9e7ed;
      color:#7A1023;
      border:1px solid #e7c8d0;
      border-radius:10px;
      padding:12px;
      margin-bottom:18px;
      text-align:center;
      font-size:14px;
    }
  </style>
</head>

<body>

  <header class="main-header">
    <img src="images/darbic-logo.jpg" alt="Darbic Logo" class="logo">
    <h1 class="Darbic-name">DARBIC</h1>
<button class="signout-btn" type="button" onclick="window.location.href='index.html'">Home</button>
  </header>

  <section class="login-wrapper">
    <div class="login-card">

      <h2 class="login-title">Admin Login</h2>
      <p class="login-subtitle">
        Log in to manage events, zones, assignments, and notifications.
      </p>

      <?php if ($message !== ''): ?>
        <div class="message-box"><?php echo htmlspecialchars($message); ?></div>
      <?php endif; ?>

      <form action="" method="post">

        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="Enter admin email address" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter admin password">
        </div>

        <div class="login-actions">
     <button type="submit" class="btn-darbic">Login</button>
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
