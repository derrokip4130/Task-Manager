<!-- registration.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f2f5;
    }
    .card {
      margin-top: 5%;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg">
          <div class="card-header bg-primary text-white text-center">
            <h4>User Registration</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="/register">
                @csrf
              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="name" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
              </div>
              <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" class="form-select">
                  <option value="user" selected>User</option>
                  <option value="admin">Admin</option>
                </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Register</button>
                @if($errors->any())
                    <div class="alert alert-danger mt-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
            <div class="text-center mt-3">
              Already have an account? <a href="/login">Login here</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
