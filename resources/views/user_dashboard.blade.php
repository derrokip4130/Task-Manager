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
    .toast-alert {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1050;
      min-width: 250px;
      opacity: 1;
      transition: opacity 0.5s ease;
    }
    .toast-alert.fade-out {
      opacity: 0;
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
    @if (session('success'))
      <div id="flash-message" class="alert alert-success toast-alert">
        {{ session('success') }}
      </div>
    @endif
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5>Your Assigned Tasks</h5>
          </div>
          <div class="card-body">
            <p class="text-muted">Tasks are sorted by deadline. Make sure to update your progress regularly.</p>
            <div class="mb-3 d-flex justify-content-between flex-wrap gap-2">
              <input type="text" id="taskSearch" class="form-control w-50" placeholder="Search tasks...">

              <select id="statusFilter" class="form-select w-auto" placeholder="Filter by status">
                <option value="">All Statuses</option>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
              </select>
            </div>
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
                    <td data-deadline="{{ $task->deadline }}" class="{{ $isOverdue ? 'table-danger' : '' }}">
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
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Custom Confirmation Modal -->
  <div class="modal fade" id="confirmStatusModal" tabindex="-1" aria-labelledby="confirmStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title" id="confirmStatusModalLabel">Confirm Status Change</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to change the task status to <strong id="selectedStatusText"></strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button id="confirmStatusBtn" class="btn btn-success">Yes, Update</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let currentFormToSubmit = null;
    const modal = new bootstrap.Modal(document.getElementById('confirmStatusModal'));
    const confirmBtn = document.getElementById('confirmStatusBtn');
    const selectedStatusText = document.getElementById('selectedStatusText');

    document.querySelectorAll('form[action="{{ route('tasks.updateStatus') }}"]').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault(); // Stop default submission

        const select = form.querySelector('select[name="status"]');
        selectedStatusText.textContent = select.value;
        currentFormToSubmit = form;
        modal.show(); // Show modal
      });
    });

    // If user confirms, submit the form
    confirmBtn.addEventListener('click', () => {
      if (currentFormToSubmit) {
        currentFormToSubmit.submit();
        modal.hide();
      }
    });

    @if(session('updated_task_id'))
      const updatedRow = document.querySelector('input[value="{{ session('updated_task_id') }}"]')?.closest('tr');
      if (updatedRow) {
        updatedRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
        updatedRow.style.transition = 'background-color 0.5s';
        updatedRow.style.backgroundColor = '#d4edda'; // light green flash
        setTimeout(() => updatedRow.style.backgroundColor = '', 2000);
      }
    @endif

    document.querySelectorAll('td[title="Past Deadline"]').forEach(td => {
        td.closest('tr')?.classList.add('table-danger');
      });
      document.querySelectorAll('td[data-deadline]').forEach(td => {
      const isPast = new Date(td.dataset.deadline) < new Date();
      if (isPast && td.textContent.indexOf('Completed') === -1) {
        td.setAttribute('title', 'Past Deadline');
      }
    });

    // Auto-dismiss flash message after 4 seconds
    const flash = document.getElementById('flash-message');
    if (flash) {
      setTimeout(() => {
        flash.classList.add('fade-out');
        setTimeout(() => flash.remove(), 500); // Wait for fade transition
      }, 4000);
    };

    const searchInput = document.getElementById('taskSearch');
    const statusFilter = document.getElementById('statusFilter');
    const tableRows = document.querySelectorAll('tbody tr');

    function filterTasks() {
      const searchText = searchInput.value.toLowerCase();
      const selectedStatus = statusFilter.value;

      tableRows.forEach(row => {
        const title = row.children[0].textContent.toLowerCase();
        const description = row.children[1].textContent.toLowerCase();
        const status = row.children[3].textContent.trim();

        const matchesSearch = title.includes(searchText) || description.includes(searchText);
        const matchesStatus = !selectedStatus || status === selectedStatus;

        row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
      });
    }

    searchInput.addEventListener('input', filterTasks);
    statusFilter.addEventListener('change', filterTasks);
  </script>
</body>
</html>
