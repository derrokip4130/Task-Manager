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
                @foreach ($tasks as $task)
                  @php
                      $isOverdue = \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'Completed';
                  @endphp
                  <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td title="{{ $isOverdue ? 'Past Deadline' : '' }}">
                      {{ $task->deadline }}
                    </td>
                    <td>
                      <span class="badge 
                        @if($task->status === 'Pending') bg-warning text-dark
                        @elseif($task->status === 'In Progress') bg-info text-dark
                        @else bg-success @endif">
                        {{ $task->status }}
                      </span>
                    </td>
                    <td>
                      <form method="POST" action="{{ route('tasks.updateStatus') }}">
                        @csrf
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <select name="status" class="form-select form-select-sm">
                          <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                          <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                          <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-success mt-1">Update</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
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
