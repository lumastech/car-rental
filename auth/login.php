<?php
session_start();
include_once('../../includes/db.php');

if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard.php");
    exit;
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate user input (you can add more validation here)
    if (!empty($email) && !empty($password)) {
        // Query to fetch user details from the database
        $query = "SELECT id, email, name, password FROM users WHERE email = ?";

        $stmt = $db->prepare($query);
        echo $db->error;
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Store user data in a session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
                
                // Redirect user
                if (isset($_SESSION['next_page'])) {
                    header("Location: " . $_SESSION['next_page']);
                    unset($_SESSION['next_page']);
                }else{
                    header("Location: ../dashboard.php");
                }

            } else {
                $loginError = "Incorrect password.";
            }
        } else {
            $loginError = "User not found.";
        }

        $stmt->close();
    } else {
        $loginError = "Both email and password are required.";
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
    <title>Login</title>
</head>
<body class="bg-sky-50">
    <form action="login.php" method="post" class="max-w-md mx-auto bg-white shadow-md p-4 py-16 rounded mt-24">
        <div class="flex">
            <h2 class="text-2xl text-teal-500 font-bold">Login</h2>
            <!-- link to home page -->
            <a href="../../index.php" class="ml-auto text-teal-500 hover:text-teal-700 transition">Back Home</a>
        </div>
        
        <?php
            if (isset($loginError)) {
                echo '<div class="rounded p-2 bg-red-50 alert">
                         <p class="text-red-500">' . $loginError . '</p>
                    </div>';
            }
        ?>
        <div class="mt-4">
            <label for="email">email:</label>
            <input type="email" id="email" name="email" class="block w-full border border-teal-500 rounded px-2 py-1" required>
        </div>
        <div class="mt-4">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="block w-full border border-teal-500 rounded px-2 py-1" required>
        </div>
        <div class="pt-2 text-gray-400">Not registered? <a href="register.php" class="text-sky-500 italic">Register here</a></div>
        <div>
            <button type="submit" class="block bg-teal-500 text-white px-2 py-1 mt-4 w-full rounded hover:bg-teal-700 transition">Login</button>
        </div>
    </form>
</body>
</html>
