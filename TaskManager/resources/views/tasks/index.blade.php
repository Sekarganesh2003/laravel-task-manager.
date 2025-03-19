<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .task-container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background-color: #007bff;
            color: white;
        }
        .btn-primary {
            width: 100%;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body class="mt-4">

    <div class="container task-container">
        <h2 class="text-center text-primary mb-4">Task Manager</h2>

        <!-- Add Task Form -->
        <form id="taskForm" action="/tasks" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Task Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter task title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Task Description</label>
                <textarea name="description" class="form-control" placeholder="Enter task details"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>

        <!-- Task List Table -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover">
                <thead>
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
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>
                            <span class="badge bg-{{ $task->status == 'completed' ? 'success' : 'warning' }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>
                        <td>
                            <!-- Delete Button -->
                            <form class="delete-form d-inline-block" action="/tasks/{{ $task->id }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // Form Validation
            $("#taskForm").submit(function(e){
                if ($("#title").val().trim() === "") {
                    alert("Title is required.");
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
