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

$errors = array();
$car_id = '';
$user_id = '';
$pickup_date = '';
$dropoff_date = '';
$status = '';


// $sql = "SELECT * FROM cars LIMIT 50";
$sql = "SELECT * FROM cars WHERE status = 'available' LIMIT 50";
$result = mysqli_query($db, $sql);
$cars = mysqli_fetch_all($result, MYSQLI_ASSOC);

// $sql = "SELECT * FROM users LIMIT 50";
$sql = "SELECT * FROM users LIMIT 50";
$result = mysqli_query($db, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    $car_id = $_POST['car_id'];
    $user_id = $_POST['user_id'];
    $pickup_date = $_POST['pickup_date'];
    $dropoff_date = $_POST['dropoff_date'];
    $status = $_POST['status'];
    $days = (strtotime($dropoff_date) - strtotime($pickup_date)) / (60 * 60 * 24);

   

    if (empty($car_id)) {
        $errors['car_id'] = 'Car is required';
    }

    if (empty($user_id)) {
        $errors['user_id'] = 'User is required';
    }

    if (empty($pickup_date)) {
        $errors['pickup_date'] = 'Pickup date is required';
    }

    if (empty($dropoff_date)) {
        $errors['dropoff_date'] = 'Dropoff date is required';
    }

    if (empty($status)) {
        $errors['status'] = 'Status is required';
    }

    // if pickup date is less than dropoff date then show error
   if (strtotime($pickup_date) > strtotime($dropoff_date)) {
       $errors['pickup_date'] = 'Pickup date must be less than dropoff date';
   }

    if (count($errors) == 0) {

        $selected_car = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM cars WHERE id = '$car_id'"));

        $total_cost = $selected_car['price'] * $days;

        $sql = "INSERT INTO orders (car_id, user_id, pickup_date, dropoff_date, status, total_cost) 
            VALUES ('$car_id', '$user_id', '$pickup_date', '$dropoff_date', '$status', '$total_cost')";
        $result = mysqli_query($db, $sql);
        if ($result) {
            header('location: index.php');
        } else {
            $error = 'Something went wrong : ' . mysqli_error($db);
        }
    }
}
?>

<?php
include_once('../../includes/header.php');;

?>

<!-- order form -->
<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold">Enter a new order</h2>
    <a href="index.php" class="bg-teal-500 hover:bg-teal-600 transition text-white px-4 py-2 rounded shadow-sm">
        <i class="fa-solid fa-arrow-left"></i> Back to orders
    </a>
</div>
<!-- show $error -->
<?php
if (isset($error)) {
    echo '<div class="rounded p-2 bg-red-50 alert">
             <p class="text-red-500">' . $error . '</p>
        </div>';
}
?>
<div class="bg-white rounded shadow-sm p-4">
    <form action="create.php" method="post" class="flex flex-col gap-4">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label for="car_id" class="block mb-2">Car</label>
                <select name="car_id" id="car_id" class="block w-full border border-gray-300 rounded shadow-sm p-2">
                    <option value="">Select a car</option>
                    <?php foreach ($cars as $car) : ?>
                        <option value="<?php echo $car['id']; ?>" <?php $car['id'] == $car_id ? 'selected' : '' ?>><?php echo $car['make'] . ' ' . $car['model']; ?></option>
                    <?php endforeach; ?>
                </select>
                <!-- error -->
                <?php
                if (isset($errors['car_id'])) {
                    echo '<p class="text-red-500 text-xs italic">' . $errors['car_id'] . '</p>';
                }
                ?>
            </div>
            <div class="flex-1">
                <label for="user_id" class="block mb-2">User</label>
                <select name="user_id" id="user_id" class="block w-full border border-gray-300 rounded shadow-sm p-2">
                    <option value="">Select a user</option>
                    <?php foreach ($users as $user) : ?>
                        <option value="<?php echo $user['id']; ?>" <?php $user['id'] == $user_id ? 'selected' : '' ?> ><?php echo $user['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <!-- error -->
                <?php
                if (isset($errors['user_id'])) {
                    echo '<p class="text-red-500 text-xs italic">' . $errors['user_id'] . '</p>';
                }
                ?>
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label for="pickup_date" class="block mb-2">Pickup date</label>
                <input type="date" name="pickup_date" id="pickup_date"  value="<?php $pickup_date ?>" class="block w-full border border-gray-300 rounded shadow-sm p-2">
                <!-- error -->
                <?php
                if (isset($errors['pickup_date'])) {
                    echo '<p class="text-red-500 text-xs italic">' . $errors['pickup_date'] . '</p>';
                }
                ?>
            </div>
            <div class="flex-1">
                <label for="dropoff_date" class="block mb-2">Dropoff date</label>
                <input type="date" name="dropoff_date" id="dropoff_date" value="<?php $dropoff_date ?>" class="block w-full border border-gray-300 rounded shadow-sm p-2">
                <!-- error -->
                <?php
                if (isset($errors['dropoff_date'])) {
                    echo '<p class="text-red-500 text-xs italic">' . $errors['dropoff_date'] . '</p>';
                }
                ?>
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label for="status" class="block mb-2">Status</label>
                <select name="status" id="status" class="block w-full border border-gray-300 rounded shadow-sm p-2">
                    <option value="">Select a status</option>
                    <option value="pending" <?php echo $status == 'pending'? 'selected' : ''?> >Pending</option>
                    <option value="approved" <?php echo $status == 'approved'? 'selected' : ''?> >Approved</option>
                    <option value="cancelled" <?php echo $status == 'cancelled'? 'selected' : ''?> >Cancelled</option>
                </select>
                <!-- error -->
                <?php
                if (isset($errors['status'])) {
                    echo '<p class="text-red-500 text-xs italic">' . $errors['status'] . '</p>';
                }
                ?>
            </div>
        </div>
        <button type="submit" name="submit" class="bg-teal-500 hover:bg-teal-600 transition text-white px-4 py-2 rounded shadow-sm self-end">Save</button>
    </form>
</div>

<?php
include_once('../../includes/footer.php');
?>