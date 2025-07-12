<h2>Hello {{ $task->user->name }},</h2>

<p>You have been assigned a new task:</p>

<ul>
  <li><strong>Title:</strong> {{ $task->title }}</li>
  <li><strong>Description:</strong> {{ $task->description }}</li>
  <li><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($task->deadline)->format('F j, Y') }}</li>
</ul>

<p>Please log in to your account to view and manage your tasks.</p>

<p>Thanks,<br>Task Manager Admin</p>
