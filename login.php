<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Calling file style.css to apply the page design -->
</head>
<body>
    <div class="containerlogin">
        <img src="logo.jpg" alt="Logo" class="logo"> 
        <h2>Login</h2>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            
            <button type="submit">Login</button>
            <br><br>
            <a href="register.php"><button type="button">Register</button></a>
        </form>
        <div class="error-message">
        <?php
            // Start or resume session
            session_start();

            if(isset($_SESSION['error_message'])) {
                // Display the error message
                echo $_SESSION['error_message'];
                // Clear the session variable to prevent displaying the message again on refresh
                unset($_SESSION['error_message']);
            }

            // Login authentication
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $servername = "localhost";
                $username_db = "root"; // MySQL username
                $password_db = ""; 
                $dbname = "to_do_list_app"; // Database name

                // Create connection
                $conn = new mysqli($servername, $username_db, $password_db, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Get username and password from the form inserted by user
                $username = isset($_POST["username"]) ? $_POST["username"] : "";
                $password = isset($_POST["password"]) ? $_POST["password"] : "";

                // Check if the username and password are in the database 
                $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Authentication successful, retrieve user_id and redirect to homepage
                    $row = $result->fetch_assoc();
                    $_SESSION['user_id'] = $row['user_id']; // Store user_id in session
                    header("Location: homepage.php");
                    exit; // Terminate script after redirect
                } else {
                    // Authentication failed, display error message
                    $_SESSION['error_message'] = "Invalid username or password. Please try again.";
                }

            $conn->close();
            }
        ?>
        </div>
    </div>
</body>
</html>
