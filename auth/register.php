<?php
session_start();
// Database connection (modify these credentials as per your setup)
include_once '../../includes/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard.php");
    exit;
}

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['password_confirm'];

    // Validate user input (you can add more validation here)
    if (!empty($name) && !empty($email) && !empty($password) && !empty($confirmPassword)) {
        // Check if the password and confirm password match
        if ($password === $confirmPassword) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert the user into the database
            $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

            $stmt = $db->prepare($query);
            $stmt->bind_param("sss", $name, $email, $hashedPassword);

            if ($stmt->execute()) {
                // Registration successful; you can redirect to a login page
                header("Location: login.php");
            } else {
                $registrationError = "Registration failed. Please try again later.";
            }

            $stmt->close();
        } else {
            $registrationError = "Password and confirm password do not match.";
        }
    } else {
        $registrationError = "All fields are required.";
    }
}

// Close the database connection
$db->close();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="assets/css/tailwind.css">
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function() {
            // Hide the error message after 5 seconds
            setTimeout(function() {
                $(".alert").hide(300);
            }, 5000);
            
        });
    </script>
    <title>Register</title>
</head>
<body class="bg-sky-50">
    <form action="register.php" method="post" class="max-w-md mx-auto bg-white shadow-md p-4 py-16 rounded mt-24">
        <div class="flex">
            <h2 class="text-2xl text-teal-500 font-bold">Register</h2>
            <!-- link to home page -->
            <a href="../../index.php" class="ml-auto text-teal-500 hover:text-teal-700 transition">Back Home</a>
        </div>
        <?php
            if (isset($errors)) {
                echo '<div class="rounded p-2 bg-red-50 alert">
                         <p class="text-red-500">' . $errors . '</p>
                    </div>';
            }
            ?>
        <div class="mt-4">
            <label for="name">Name:</label>
            <input type="name" id="name" name="name" class="block w-full border border-teal-500 rounded px-2 py-1" required>
        </div>
        <div class="mt-4">
            <label for="email">email:</label>
            <input type="email" id="email" name="email" class="block w-full border border-teal-500 rounded px-2 py-1" required>
        </div>
        <div class="mt-4">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="block w-full border border-teal-500 rounded px-2 py-1" required>
        </div>
        <div class="mt-4">
            <label for="password">Password:</label>
            <input type="password_confirm" id="password_confirm" name="password_confirm" class="block w-full border border-teal-500 rounded px-2 py-1" required>
        </div>
        <div class="pt-2 text-gray-400">Alread registered? <a href="login.php" class="text-sky-500 italic">Login here</a></div>
        <div>
            <button type="submit" class="block bg-teal-500 text-white px-2 py-1 mt-4 w-full rounded hover:bg-teal-700 transition">Register</button>
        </div>
    </form>
</body>
</html>
