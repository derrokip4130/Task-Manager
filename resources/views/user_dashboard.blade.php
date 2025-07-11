<!-- user_dashboard.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard | Task Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
    }
    .dashboard-header {
      background-color: #007bff;
      color: white;
      padding: 1rem;
    }
    .status-select {
      width: 160px;
    }
  </style>
</head>
<body>

  <div class="dashboard-header text-center">
    <h3>User Dashboard</h3>
    <p>Welcome, {{ auth()->user()->name }}</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger">Logout</button>
    </form>
  </div>

  <div class="container mt-4">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5>Your Assigned Tasks</h5>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-hover">
              <thead class="table-light">
                <tr>
                  <th>Task Title</th>
                  <th>Description</th>
                  <th>Deadline</th>
                  <th>Status</th>
                  <th>Update Status</th>
                </tr>
              </thead>
              <tbody>
                <!-- Example task row -->
                <tr>
                  <td>Fix frontend bug</td>
                  <td>Resolve issue in task view layout</td>
                  <td>2025-07-15</td>
                  <td><span class="badge bg-warning text-dark">Pending</span></td>
                  <td>
                    <form method="POST" action="/update-task-status">
                      <input type="hidden" name="task_id" value="123">
                      <select name="status" class="form-select form-select-sm status-select">
                        <option value="Pending" selected>Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                      </select>
                      <button type="submit" class="btn btn-sm btn-success mt-1">Update</button>
                    </form>
                  </td>
                </tr>
                <!-- More tasks dynamically loaded -->
              </tbody>
            </table>
            <p class="text-muted">Tasks are sorted by deadline. Make sure to update your progress regularly.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
