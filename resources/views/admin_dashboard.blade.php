<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | Task Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .dashboard-header {
      background-color: #343a40;
      color: white;
      padding: 1rem;
    }
    .card {
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <div class="dashboard-header text-center">
    <h2>Admin Dashboard</h2>
    <p>Welcome, Administrator</p>
  </div>

  <div class="container mt-4">
    <div class="row">

      <!-- User Management Panel -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-primary text-white">User Management</div>
          <div class="card-body">
            <form id="userForm">
              <div class="mb-2">
                <input type="text" class="form-control" placeholder="Full Name" required>
              </div>
              <div class="mb-2">
                <input type="email" class="form-control" placeholder="Email Address" required>
              </div>
              <div class="mb-2">
                <select class="form-select">
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
              <button type="submit" class="btn btn-success">Add User</button>
            </form>
            <hr>
            <h6>Existing Users</h6>
            <ul class="list-group">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                John Doe (User)
                <div>
                  <button class="btn btn-sm btn-warning">Edit</button>
                  <button class="btn btn-sm btn-danger">Delete</button>
                </div>
              </li>
              <!-- More users here -->
            </ul>
          </div>
        </div>
      </div>

      <!-- Task Assignment Panel -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-success text-white">Assign Task</div>
          <div class="card-body">
            <form id="taskForm">
              <div class="mb-2">
                <input type="text" class="form-control" placeholder="Task Title" required>
              </div>
              <div class="mb-2">
                <textarea class="form-control" placeholder="Task Description" rows="2" required></textarea>
              </div>
              <div class="mb-2">
                <select class="form-select">
                  <option selected disabled>Select User</option>
                  <option value="1">John Doe</option>
                  <!-- Dynamically populate -->
                </select>
              </div>
              <div class="mb-2">
                <input type="date" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary">Assign Task</button>
            </form>
          </div>
        </div>
      </div>

    </div>

    <!-- Task Summary Section -->
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-dark text-white">All Tasks</div>
          <div class="card-body">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Assigned To</th>
                  <th>Deadline</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Fix Login Bug</td>
                  <td>John Doe</td>
                  <td>2025-07-15</td>
                  <td><span class="badge bg-warning text-dark">Pending</span></td>
                  <td>
                    <button class="btn btn-sm btn-warning">Edit</button>
                    <button class="btn btn-sm btn-danger">Delete</button>
                  </td>
                </tr>
                <!-- More tasks -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

</body>
</html>
