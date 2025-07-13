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
    .form-body {
      position: relative;
      min-height: 120px;
      padding-bottom: 70px;
    }
    .toast-flash {
      position: absolute;
      bottom: 0px;
      left: 15px;
      right: 15px;
      z-index: 1;
      transition: opacity 0.4s ease;
    }
    .toast-flash.fade-out {
      opacity: 0;
    }
  </style>
</head>
<body>
  <div class="dashboard-header text-center">
    <h2>Admin Dashboard</h2>
    <p>Welcome, Administrator</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger">Logout</button>
    </form>
  </div><br>
  <div class="text-center mb-3">
    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#tasksModal">View All Tasks</button>
  </div>
  <div class="container mt-4">
    <div class="row">
      <!-- User Management Panel -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-primary text-white">User Management</div>
          <div class="card-body form-body">
            <form id="userForm" method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="mb-2">
                    <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                </div>
                <div class="mb-2">
                    <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                </div>
                <button type="submit" class="btn btn-success">Add User</button>
                @if(session('user_success'))
                  <div id="user-flash" class="alert alert-success toast-flash">
                    {{ session('user_success') }}
                  </div>
                @endif
            </form>
            <hr>
          <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary mb-3">Manage Users</a>
          </div>
        </div>
      </div>

      <!-- Task Assignment Panel -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-success text-white">Assign Task</div>
          <div class="card-body form-body">
            <form id="taskForm" method="POST" action="{{ route('tasks.store') }}">
              @csrf
              <div class="mb-2">
                <input type="text" name="title" class="form-control" placeholder="Task Title" required>
              </div>
              <div class="mb-2">
                <textarea name="description" class="form-control" placeholder="Task Description" rows="2" required></textarea>
              </div>
              <div class="mb-2">
                <select name="user_id" class="form-select" required>
                  <option selected disabled>Select User</option>
                  @foreach ($users as $user)
                    @if ($user->role !== 'admin')
                      <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="mb-2">
                <input type="date" name="deadline" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary">Assign Task</button>
              @if(session('task_success'))
                <div id="task-flash" class="alert alert-success toast-flash">
                  {{ session('task_success') }}
                </div>
              @endif
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Task Summary Section -->
    <!-- All Tasks Modal -->
    <div class="modal fade" id="tasksModal" tabindex="-1">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header bg-dark text-white">
            <h5 class="modal-title">All Tasks</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">

            <!-- Search & Filter -->
            <div class="row mb-3">
              <div class="col-md-6">
                <input type="text" id="taskSearch" class="form-control" placeholder="Search by title or assignee">
              </div>
              <div class="col-md-4">
                <select id="statusFilter" class="form-select">
                  <option value="">All Statuses</option>
                  <option value="Pending">Pending</option>
                  <option value="In Progress">In Progress</option>
                  <option value="Completed">Completed</option>
                </select>
              </div>
            </div>

            <!-- Task Table -->
            <table class="table table-bordered table-hover" id="tasksTable">
              <thead class="table-light">
                <tr>
                  <th>Title</th>
                  <th>Assigned To</th>
                  <th>Deadline</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tasks as $task)
                  <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->user->name }}</td>
                    <td>{{ $task->deadline }}</td>
                    <td>{{ $task->status }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    ['user-flash', 'task-flash'].forEach(id => {
      const flash = document.getElementById(id);
      if (flash) {
        setTimeout(() => {
          flash.classList.add('fade-out');
          setTimeout(() => flash.remove(), 400); // After fade-out
        }, 4000);
      }
    });

    const searchInput = document.getElementById('taskSearch');
    const statusFilter = document.getElementById('statusFilter');
    const tableRows = document.querySelectorAll('#tasksTable tbody tr');

    function filterTasks() {
      const search = searchInput.value.toLowerCase();
      const status = statusFilter.value;

      tableRows.forEach(row => {
        const title = row.children[0].textContent.toLowerCase();
        const assignee = row.children[1].textContent.toLowerCase();
        const rowStatus = row.children[3].textContent;

        const matchesSearch = title.includes(search) || assignee.includes(search);
        const matchesStatus = !status || rowStatus === status;

        row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
      });
    }

    searchInput.addEventListener('input', filterTasks);
    statusFilter.addEventListener('change', filterTasks);
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
