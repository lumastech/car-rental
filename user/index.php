<?php
include_once('../../includes/auth.php');
include_once('../../includes/db.php');
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($db, $sql);
$user = mysqli_fetch_assoc($result);

//select all users if user is admin
if ($user['role'] == 'admin') {
    $sql = "SELECT * FROM users ORDER BY id DESC limit 100";
} else {
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
}
$stmt = $db->prepare($sql);
$stmt->execute();
$users = $stmt->get_result();

if (isset($_GET['action']) && $_GET['action'] == 'deleteuser') {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = '$id'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    header("Location: index.php");
}

?>

<?php
include_once('../../includes/header.php');;

?>


<div class="shadow rounded bg-white p-4 overflow-x-auto">
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold text-teal-500"><i class="fa-solid fa-user-plus"></i> Users</h2>
        <a href="create.php" class="bg-teal-500 text-white px-3 py-2 rounded hover:bg-teal-600 transition">
            <i class="fa-solid fa-user-plus"></i> Add User
        </a>
    </div>
    <table class="w-full ">
        <thead>
            <tr class="border-b-2 text-gray-500">
                <th class="text-left"><i class="fa-solid fa-user"></i></th>
                <th class="text-left">Name</th>
                <th class="text-left">Email</th>
                <th class="text-left">Phone</th>
                <th>Role</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($user = $users->fetch_assoc()) {
            ?>
                <tr class="hover:bg-gray-100 border-b text-teal-400">
                    <td><i class="fa-solid fa-user"></i></td>
                    <td class="py-2 "><?php echo $user['name']; ?></td>
                    <td class="py-2 "><?php echo $user['email']; ?></td>
                    <td class="py-2 "><?php echo $user['phone']; ?></td>
                    <td class="py-2 text-center"><?php echo $user['role']; ?></td>
                    <td class="py-2 text-right">
                        <a href="edit.php?id=<?php echo $user['id']; ?>" class="text-sky-500">
                            <i class="fa-solid fa-edit"></i>    
                        </a>
                        <a href="index.php?action=deleteuser&id=<?php echo $user['id']; ?>" class="text-red-500">
                            <i class="fa-solid fa-trash-can"></i>    
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include_once('../../includes/footer.php');
?>