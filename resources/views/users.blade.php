<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users | Task Manager</title>
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
    .form-body {
      position: relative;
      min-height: 150px;
      padding-bottom: 70px;
    }
    .toast-flash {
      position: absolute;
      bottom: 0;
      left: 15px;
      right: 15px;
      z-index: 2;
      transition: opacity 0.4s ease;
    }
    .toast-flash.fade-out {
      opacity: 0;
    }
  </style>
</head>
<body>

  <div class="dashboard-header text-center">
    <h2>User Management</h2>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light mt-2">← Back to Dashboard</a>
  </div>

  <div class="container mt-4">
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">All Users</div>
      <div class="card-body form-body">
        @if(session('user_success'))
          <div id="user-flash" class="alert alert-success toast-flash">
            {{ session('user_success') }}
          </div>
        @endif

        <table class="table table-bordered table-hover">
          <thead class="table-light">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>
                  <!-- Edit Button -->
                  <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">Edit</button>

                  <!-- Delete Button -->
                  <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">Delete</button>
                </td>
              </tr>

              <!-- Edit Modal -->
              <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1">
                <div class="modal-dialog">
                  <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                      <div class="modal-header bg-warning">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-2">
                          <label>Name</label>
                          <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                        </div>
                        <div class="mb-2">
                          <label>Email</label>
                          <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Save Changes</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

              <!-- Delete Modal -->
              <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
                <div class="modal-dialog">
                  <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete <strong>{{ $user->name }}</strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                  </form>
                </div>
              </div>

            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const flash = document.getElementById('user-flash');
    if (flash) {
      setTimeout(() => {
        flash.classList.add('fade-out');
        setTimeout(() => flash.remove(), 400);
      }, 4000);
    }
  </script>
</body>
</html>
