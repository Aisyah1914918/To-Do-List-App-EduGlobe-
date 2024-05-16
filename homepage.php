<?php
// Resume session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in yet
    header("Location: login.php");
    exit;
}

// Array list of quotes
$quotes = [
    "The secret of getting ahead is getting started. -Mark Twain-",
    "The best way to get something done is to begin. -Mark Twain-",
    "Don't watch the clock; do what it does. Keep going. -Sam Levensen-",
    "You don't have to be great to start, but you have to start to be great. -Zig Ziglar-",
    "The future depends on what you do today. -Mahatma Gandhi-"
];

// Select a random quote
$quote = $quotes[array_rand($quotes)];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3e5f5; /* Purple Lilac */
            text-align: center;
            padding-top: 50px;
        }

        .container {
            background-color: #fff;
            width: 60%;
            margin: auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #7b1fa2; /* Deep Purple */
        }

        p.quote {
            color: #5e35b1; /* Dark Deep Purple */
            font-size: 1.2em;
            margin: 20px 0;
        }

        .button {
            background-color: #7b1fa2; /* Deep Purple */
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            margin: 10px;
            text-decoration: none;
            font-size: 1em;
        }

        .button:hover {
            background-color: #5e35b1; /* Dark Deep Purple */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Your To-Do List App</h1>
        <p class="quote"><?php echo $quote; ?></p>
        <a href="login.php" class="button">Logout</a>
        <a href="addlist.php" class="button">Add My Lists</a>
    </div>
</body>
</html>
