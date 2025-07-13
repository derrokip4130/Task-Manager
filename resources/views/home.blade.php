<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home | Task Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .hero-section {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
    }
    .btn-login {
      margin-top: 20px;
      padding: 10px 25px;
      font-size: 1.1rem;
    }
  </style>
</head>
<body>

  <div class="hero-section">
    <div class="container">
      <h1 class="display-4 mb-3">Welcome to the Task Manager Admin Panel</h1>
      <p class="lead text-muted">Manage users, assign tasks, and monitor team productivity with ease.</p>
      <a href="{{ route('login') }}" class="btn btn-primary btn-login">Login</a>
    </div>
  </div>

</body>
</html>
