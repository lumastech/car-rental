<?php
include_once('../../includes/auth.php');
include_once('../../includes/db.php');

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $sql = "DELETE FROM orders WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    if ($result) {
        header('location: index.php');
    } else {
        $error = 'Something went wrong : ' . mysqli_error($db);
    }
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($db, $sql);
$user = mysqli_fetch_assoc($result);

// select all orders if user is admin
if ($user['role'] == 'admin') {
    $sql = "SELECT orders.*, cars.make, cars.model, users.name FROM orders 
    INNER JOIN cars ON orders.car_id = cars.id INNER JOIN users ON orders.user_id = users.id LIMIT 50";
} else {
    // $sql = "SELECT * FROM orders LIMIT 50";
    $sql = "SELECT orders.*, cars.make, cars.model, users.name FROM orders 
    INNER JOIN cars ON orders.car_id = cars.id INNER JOIN users ON orders.user_id = users.id WHERE orders.user_id = '$user_id' LIMIT 50";
}

$result = mysqli_query($db, $sql);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<?php
include_once('../../includes/header.php');;

?>

<!-- orders table -->
<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold">Orders</h2>
    <a href="create.php" class="bg-teal-500 hover:bg-teal-600 transition text-white px-4 py-2 rounded shadow-sm">
        <i class="fa-solid fa-plus"></i> Enter a new order
    </a>
</div>
<div class="overflow-x-auto bg-white rounded ">
    <table class="table-auto border-collapse border border-gray-400 w-full">
        <thead>
            <tr>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Car</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">User</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Pickup date</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Dropoff date</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Price</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Status</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order) : ?>
                <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <?php echo $order['make']; ?>
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <?php echo $order['name']; ?>
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <?php echo $order['pickup_date']; ?>
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <?php echo $order['dropoff_date']; ?>
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <?php echo $order['total_cost']; ?>
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <?php echo $order['status']; ?>
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <a href="edit.php?id=<?php echo $order['id']; ?>" class="text-teal-500 hover:text-teal-600 transition"><i class="fa-solid fa-edit"></i></a>
                        <a href="index.php?action=delete&id=<?php echo $order['id']; ?>" class="text-red-500 hover:text-red-600 transition"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?php
include_once('../../includes/footer.php');
?>