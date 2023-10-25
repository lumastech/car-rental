<?php
include_once('../../includes/auth.php');
include_once('../../includes/db.php');



$user = null;
$id = null;
$errors = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    $user = mysqli_fetch_assoc($result);
}

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name = '$name', email = '$email', phone = '$phone', role = '$role' WHERE id = '$id'";
    $result = mysqli_query($db, $sql);

    if ($result) {
        // updating the password hash
        if (isset($_POST['password'])) {
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
        
            if ($password != $password_confirm) {
                $errors = 'Password does not match';
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password = '$password' WHERE id = '$id'";
                $result = mysqli_query($db, $sql);
                if (!$result) {
                    $errors = 'Something went wrong';
                } else {
                }
            }
        }
        if (!$errors) {
            header("Location: index.php");
        }
    } else {
        $errors = 'Something went wrong';
    }
}

?>

<?php
include_once('../../includes/header.php');;

?>

    <form action="#" method="post" class="bg-white shadow-md p-4 py-12 rounded mt-24">
        <h2 class="text-2xl text-teal-500 font-bold">Update user</h2>
        <?php
            if (isset($errors)) {
                echo '<div class="rounded p-2 bg-red-50 alert">
                         <p class="text-red-500">' . $errors . '</p>
                    </div>';
            }
            ?>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label for="name">Name:</label>
                <input type="name" id="name" name="name" class="block w-full border border-teal-500 rounded px-2 py-1" value="<?php echo $user['name'] ?>" required>
            </div>
            <div>
                <label for="email">email:</label>
                <input type="email" id="email" name="email" class="block w-full border border-teal-500 rounded px-2 py-1" value="<?php echo $user['email'] ?>" required>
            </div>
            <div>
                <label for="phone">phone:</label>
                <input type="tell" id="phone" name="phone" class="block w-full border border-teal-500 rounded px-2 py-1" value="<?php echo $user['phone'] ?>" required>
            </div>
            <div>
                <label for="role">Role:</label>
                <select name="role" id="role" class="block w-full border border-teal-500 rounded px-2 py-1">
                    <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : '' ?> >Admin</option>
                    <option value="staff"  <?php echo $user['role'] == 'staff' ? 'selected' : '' ?> >Staff</option>
                    <option value="user"  <?php echo $user['role'] == 'user' ? 'selected' : '' ?> >User</option>
                </select>
            </div>
            <div class="mt-4 md:col-span-2 text-red-500">
                <h4>RESET USER'S PASSWORD</h4>
            </div>
            <div>
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" class="block w-full border border-teal-500 rounded px-2 py-1">
            </div>
            <div>
                <label for="password">Confirm Password:</label>
                <input type="password" id="password_confirm" name="password_confirm" class="block w-full border border-teal-500 rounded px-2 py-1">
            </div>

        </div>
        <div>
            <button type="submit" class="block md:w-1/4 bg-teal-500 text-white px-2 py-1 mt-4 w-full rounded hover:bg-teal-700 transition">Submit</button>
        </div>
    </form>

<?php
include_once('../../includes/footer.php');
?>