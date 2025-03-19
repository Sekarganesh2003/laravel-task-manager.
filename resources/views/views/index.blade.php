<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
        }
        .task-title {
            font-weight: bold;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .status-completed {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Task Manager</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Task Manager</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Add Task Form -->
        <div class="card shadow">
            <div class="card-header bg-primary text-white">Add New Task</div>
            <div class="card-body">
                <form id="taskForm" action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Task Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter task title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Task Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter task description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Add Task</button>
                </form>
            </div>
        </div>

        <!-- Task List Table -->
        <div class="mt-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">Task List</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
    @foreach($tasks as $task)
    <tr>
        <td class="task-title">{{ $task->title }}</td>
        <td>{{ $task->description }}</td>
        <td>
    <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
        @csrf
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>
    </form>
</td>


        <td>
            <!-- Delete Button -->
            <form class="delete-form d-inline" action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>

                    </table>
                    @if(count($tasks) == 0)
                        <p class="text-center text-muted">No tasks available. Add a new task above.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function(){
            // Form Validation
            $("#taskForm").submit(function(e){
                if ($("#title").val().trim() === "") {
                    alert("Task title is required.");
                    e.preventDefault();
                }
            });

            // Confirm Before Deleting
            $(".delete-form").submit(function(e){
                if (!confirm("Are you sure you want to delete this task?")) {
                    e.preventDefault();
                }
            });
        });
    </script>

</body>
</html>
