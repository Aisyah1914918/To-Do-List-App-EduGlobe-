<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit;
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "to_do_list_app"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Message variable definition
$message = "";

// Process form submission for adding a new task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_task'])) {
    if (isset($_POST['description']) && isset($_POST['due_date'])) {
        $description = $_POST['description'];
        $due_date = $_POST['due_date'];
        $is_completed = 0; // Default value for incomplete task is 0 

        // Insert new task into the database
        $sql = "INSERT INTO todo_lists (user_id, description, due_date, is_completed) VALUES ('$user_id', '$description', '$due_date', '$is_completed')";
        if ($conn->query($sql) === TRUE) {
            $message = "New task added successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Process form submission for updating task completion status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
    if (isset($_POST['list_id'])) {
        $list_id = $_POST['list_id'];
        $is_completed = isset($_POST['is_completed']) ? 1 : 0;

        // Update task status in the database
        $sql = "UPDATE todo_lists SET is_completed='$is_completed' WHERE list_id='$list_id' AND user_id='$user_id'";
        if ($conn->query($sql) === TRUE) {
            $message = "Task updated successfully";
        } else {
            $message = "Error updating task: " . $conn->error;
        }
    }
}

// SQL command to retrieve previous to-do lists for the logged-in user
$sql = "SELECT * FROM todo_lists WHERE user_id = '$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3e5f5; /* Purple Lilac */
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 50px;
        }

        .centered-buttons {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-left: 400px; 
            gap: 10px;
        }

        .left-buttons .button {
            background-color: #7b1fa2; /* Deep Purple */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1em;
        }

        .container {
            background-color: #fff;
            width: 60%;
            margin: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .small-container {
            background-color: #fff;
            width: 30%;
            margin: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #7b1fa2; /* Deep Purple */
        }

        p {
            color: #5e35b1; /* Dark Deep Purple */
        }

        .message {
            background-color: #4caf50; /* Green color */
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
        }

        .button {
            background-color: #7b1fa2; /* Deep Purple */
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1em;
        }

        .button:hover {
            background-color: #5e35b1; /* Dark Deep Purple */
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"], input[type="date"] {
            margin-bottom: 10px;
        }

        .task-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .task-item form {
            display: flex;
            align-items: center;
        }

        .task-item input[type="checkbox"] {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<!-- Display form to add new to-do lists -->
    <div class="container">
    <div class="centered-buttons">
        <a href="homepage.php" class="button">Homepage</a>
        <a href="login.php" class="button">Logout</a>
    </div>
        <?php
        if ($message) {
            echo "<div class='message'>$message</div>";
        }
        ?>
        <h2>Add New Task</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="hidden" name="add_task" value="1">
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" required>
            
            <label for="due_date">Due Date:</label>
            <input type="date" id="due_date" name="due_date" required>
            
            <button type="submit" class="button">Add To-Do</button>
        </form>
    </div>

    <!-- Display existing to-do list items -->
    <div class="small-container">
        <h2>My To-Do List</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $list_id = $row['list_id'];
                $description = $row['description'];
                $due_date = $row['due_date'];
                $is_completed = $row['is_completed'] ? "checked" : "";
                echo "<div class='task-item'>
                        <form action='".$_SERVER['PHP_SELF']."' method='POST'>
                            <input type='hidden' name='update_task' value='1'>
                            <input type='hidden' name='list_id' value='$list_id'>
                            <input type='checkbox' name='is_completed' value='1' $is_completed onchange='this.form.submit()'>
                            <label>$description (Due: $due_date)</label>
                        </form>
                    </div>";
            }
        } else {
            echo "<p>No to-do items found.</p>";
        }
        ?>
    </div>
</body>
</html>
