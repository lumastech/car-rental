<?php
    include_once('../includes/auth.php');
    include_once('../includes/db.php');

    $user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($db, $sql);
$user = mysqli_fetch_assoc($result);

    // cars count
    if ($user['role'] == 'admin') {
        $sql = "SELECT COUNT(*) AS count FROM cars";
    } else {
        $sql = "SELECT COUNT(*) AS count FROM cars WHERE user_id = '$user_id'";
    }
    $result = mysqli_query($db, $sql);
    $cars_count = mysqli_fetch_assoc($result)['count'];

    // users count
    if ($user['role'] == 'admin') {
        $sql = "SELECT COUNT(*) AS count FROM users";
    } else {
        $sql = "SELECT COUNT(*) AS count FROM users WHERE id = '$user_id'";
    }
    $result = mysqli_query($db, $sql);
    $users_count = mysqli_fetch_assoc($result)['count'];

    // orders count
    if ($user['role'] == 'admin') {
        $sql = "SELECT COUNT(*) AS count FROM orders";
    } else {
        $sql = "SELECT COUNT(*) AS count FROM orders WHERE user_id = '$user_id'";
    }
    $result = mysqli_query($db, $sql);
    $orders_count = mysqli_fetch_assoc($result)['count'];
    
    // orders count with status approved as sales
    if ($user['role'] == 'admin') {
        $sql = "SELECT SUM(total_cost) AS total FROM orders WHERE status = 'approved'";
    } else {
        $sql = "SELECT SUM(total_cost) AS total FROM orders WHERE status = 'approved' AND user_id = '$user_id'";
    }
    $result = mysqli_query($db, $sql);
    $sales_amount = mysqli_fetch_assoc($result)['total'];

    // users
    if ($user['role'] == 'admin') {
        $sql = "SELECT * FROM users ORDER BY id DESC LIMIT 5";
    } else {
        $sql = "SELECT * FROM users WHERE id = '$user_id' ORDER BY id DESC LIMIT 5";
    }
    $result = mysqli_query($db, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // cars
    if ($user['role'] == 'admin') {
        $sql = "SELECT * FROM cars ORDER BY id DESC LIMIT 5";
    } else {
        $sql = "SELECT * FROM cars WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 5";
    }
    $result = mysqli_query($db, $sql);
    $cars = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // orders
    if ($user['role'] == 'admin') {
        $sql = "SELECT orders.*, cars.make, cars.model, users.name FROM orders INNER JOIN cars ON orders.car_id = cars.id INNER JOIN users ON orders.user_id = users.id ORDER BY orders.id DESC LIMIT 5";
    } else {
        $sql = "SELECT orders.*, cars.make, cars.model, users.name FROM orders INNER JOIN cars ON orders.car_id = cars.id INNER JOIN users ON orders.user_id = users.id WHERE orders.user_id = '$user_id' ORDER BY orders.id DESC LIMIT 5";
    }
    $result = mysqli_query($db, $sql);
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<?php
include_once('../includes/header.php');;

?>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <a href="user/" class="rounded shadow-sm bg-white hover:bg-teal-50 transition p-4 text-teal-500">
        <div class="flex gap-4 justify-between">
            <i class="text-4xl fa-solid fa-users self-center"></i>
            <div class="text-center">
                <h2 class="text-xl font-bold">Users</h2>
                <p><?php echo $users_count ?> </p>
            </div>
        </div>
    </a>
    <a href="car/" class="rounded shadow-sm bg-white hover:bg-teal-50 transition p-4 text-teal-500">
        <div class="flex gap-4 justify-between">
            <i class="text-4xl fa-solid fa-car self-center"></i>
            <div class="text-center">
                <h2 class="text-xl font-bold">Cars</h2>
                <p><?php echo $cars_count ?></p>
            </div>
        </div>
    </a>
    <a href="order/" class="rounded shadow-sm bg-white hover:bg-teal-50 transition p-4 text-teal-500">
        <div class="flex gap-4 justify-between">
            <i class="text-4xl fa-solid fa-file-invoice-dollar self-center"></i>
            <div class="text-center">
                <h2 class="text-xl font-bold">Orders</h2>
                <p><?php echo $orders_count ?></p>
            </div>
        </div>
    </a>
    <div class="rounded shadow-sm bg-white hover:bg-teal-50 transition p-4 text-teal-500">
        <div class="flex gap-4 justify-between">
            <i class="text-4xl fa-solid fa-sack-dollar self-center"></i>
            <div class="text-center">
                <h2 class="text-xl font-bold">Sales</h2>
                <p>ZMW <?php echo $sales_amount ?></p>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-4 my-12">
    <!-- users table -->
    <div class="shadow p-2 rounded bg-white w-full overflow-x-hidden">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Users</h2>
            <a href="user/" class="bg-teal-500 hover:bg-teal-600 transition text-white px-4 py-2 rounded shadow-sm">
                <i class="fa-solid fa-plus"></i> Manage Users
            </a>
        </div>
        <div class="overflow-x-auto w-full">
            <table class="w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-left">Name</th>
                        <th class="text-left">Email</th>
                        <th class="text-left">Phone</th>
                        <th class="text-left">Role</th>
                    </tr>
                </thead>
    
                <tbody>
                    <?php foreach ($users as $user) : ?>
                         <tr class="hover:bg-gray-100 border-b text-teal-400">
                        <td><i class="fa-solid fa-user"></i></td>
                        <td class="py-2 "><?php echo $user['name']; ?></td>
                        <td class="py-2 "><?php echo $user['email']; ?></td>
                        <td class="py-2 "><?php echo $user['phone']; ?></td>
                        <td class="py-2 text-center"><?php echo $user['role']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- orders -->
    <div class="shadow p-2 rounded bg-white">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Orders</h2>
            <a href="order/" class="bg-teal-500 hover:bg-teal-600 transition text-white px-4 py-2 rounded shadow-sm">
                <i class="fa-solid fa-plus"></i> Manage Orders
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="table-aut w-full">
                <thead>
                    <tr>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Car</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">User</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Pickup date</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Dropoff date</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Price</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) : ?>
                        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                                <?php echo $order['make']; ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                                <?php echo $order['name']; ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                                <?php echo $order['pickup_date']; ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                                <?php echo $order['dropoff_date']; ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                                <?php echo $order['total_cost']; ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                                <?php echo $order['status']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- cars table -->
<div class="bg-white rounded shadow-sm p-4 flex flex-col mt-12 mb-24">
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold text-teal-500"><i class="fa-solid fa-car"></i> Cars</h2>
        <a href="car/" class="bg-teal-500 text-white px-3 py-2 rounded hover:bg-teal-600 transition">
            <i class="fa-solid fa-plus"></i> Manage Cars
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border border-gray-400 w-full">
            <thead>
                <tr>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Image</th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Make</th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Model</th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Price/Day</th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Year</th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Status</th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Pickup date</th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Dropoff date</th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Year</th>
                </tr>
            </thead>
            <tbody>
                
                <?php foreach ($cars as $car) : ?>
                    <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                            <img src="<?php echo $car['image']; ?>" alt="" class="w-20 h-20 object-cover">
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                            <?php echo $car['make']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                            <?php echo $car['model']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                            <?php echo $car['price']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                            <?php echo $car['year']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                            <?php echo $car['status']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                            <?php echo $car['pickup_date']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                            <?php echo $car['dropoff_date']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border-b block lg:table-cell relative lg:static">
                            <?php echo $car['year']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php
include_once('../includes/footer.php');
?>

