<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">  <!-- Calling file style.css to apply the page design -->
</head>
<body>
    <div class="header">
        <h1>To Do List</h1>
    </div>
    <div class="container">
        <h2>User Registration</h2>
        <link rel="stylesheet" href="style.css">
        <form method="post" action="">
            <input type="hidden" id="user_id" name="user_id" value="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>
            
            <button type="submit">Register</button>
            <br><br>
            <button type="button" onclick="window.location.href='login.php';">Login</button>
        </form>
        <div id="errorContainer" class="error"></div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"]; // #Need to upgrade strong password loop
        $confirmPassword = $_POST["confirm_password"];

        if ($password !== $confirmPassword) {
            echo "<p class='error'>Passwords do not match.</p>";
        } else {
            // Simplified database insertion (assuming you have a database connection)
            $servername = "localhost";
            $username_db = "root"; // MySQL username
            $password_db = ""; // No password needed, #Need to set strong password
            $dbname = "to_do_list_app"; // Database name

            // Create connection
            $conn = new mysqli($servername, $username_db, $password_db, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Insert user data into database
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

            if ($conn->query($sql) === TRUE) {
                // Redirect to login.php after successful registration
                echo "<script>window.location.href = 'login.php';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
    }
    ?>
</body>
</html>
