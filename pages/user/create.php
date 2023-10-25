<?php
include_once('../../includes/auth.php');
include_once('../../includes/db.php');

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($db, $sql);
$user = mysqli_fetch_assoc($result);

// if uer role is not admin, redirect to home page
if ($user['role'] != 'admin') {
    header('location: ../dashboard.php');
    exit();
}

if (isset($_POST['email']) && isset($_POST['name']) ) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password != $password_confirm) {
        $errors = 'Password does not match';
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, phone, role, password) VALUES ('$name', '$email', '$phone', '$role', '$password')";
        $result = mysqli_query($db, $sql);
        if ($result) {
            header('location: index.php');
        } else {
            $errors = 'Something went wrong';
        }
    }
}
?>

<?php
include_once('../../includes/header.php');;

?>

    <form action="#" method="post" class="bg-white shadow-md p-4 py-12 rounded mt-24">
        <h2 class="text-2xl text-teal-500 font-bold">Add a user</h2>
        <?php
            if (isset($errors)) {
                echo '<div class="rounded p-2 bg-red-50 alert">
                         <p class="text-red-500">' . $errors . '</p>
                    </div>';
            }
            ?>

        <div class="grid md:grid-cols-2 gap-4">
            <div class="mt-4">
                <label for="name">Name:</label>
                <input type="name" id="name" name="name" class="block w-full border border-teal-500 rounded px-2 py-1" required>
            </div>
            <div class="mt-4">
                <label for="email">email:</label>
                <input type="email" id="email" name="email" class="block w-full border border-teal-500 rounded px-2 py-1" required>
            </div>
            <div class="mt-4">
                <label for="phone">phone:</label>
                <input type="tell" id="phone" name="phone" class="block w-full border border-teal-500 rounded px-2 py-1" required>
            </div>
            <div class="mt-4">
                <label for="role">Role:</label>
                <select name="role" id="role" class="block w-full border border-teal-500 rounded px-2 py-1">
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                    <option value="user" selected>User</option>
                </select>
            </div>
            <div class="mt-4">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="block w-full border border-teal-500 rounded px-2 py-1" required>
            </div>
            <div class="mt-4">
                <label for="password">Confirm Password:</label>
                <input type="password" id="password_confirm" name="password_confirm" class="block w-full border border-teal-500 rounded px-2 py-1" required>
            </div>

        </div>
        <div>
            <button type="submit" class="block md:w-1/4 bg-teal-500 text-white px-2 py-1 mt-4 w-full rounded hover:bg-teal-700 transition">Submit</button>
        </div>
    </form>

<?php
include_once('../../includes/footer.php');
?>