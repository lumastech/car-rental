<?php
    session_start();
    include_once('includes/db.php');

    if(!isset($_SESSION['user_id'])){
        $_SESSION['next_page'] = $_SERVER['REQUEST_URI'];
        header('location: pages/auth/login.php');
    }


$errors = array();
$pickup_date = '';
$dropoff_date = '';
$car_id = $_GET['id'];
$order_success = false;

$car = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM cars WHERE id = '$car_id'"));

if (isset($_POST['submit'])) {
    $car_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $pickup_date = $_POST['pickup_date'];
    $dropoff_date = $_POST['dropoff_date'];
    $days = (strtotime($dropoff_date) - strtotime($pickup_date)) / (60 * 60 * 24);


    if (empty($pickup_date)) {
        $errors['pickup_date'] = 'Pickup date is required';
    }

    if (empty($dropoff_date)) {
        $errors['dropoff_date'] = 'Dropoff date is required';
    }

    // if pickup date is less than dropoff date then show error
   if (strtotime($pickup_date) > strtotime($dropoff_date)) {
       $errors['pickup_date'] = 'Pickup date must be less than dropoff date';
   }

    if (count($errors) == 0) {

        $total_cost = $car['price'] * $days;

        $sql = "INSERT INTO orders (car_id, user_id, pickup_date, dropoff_date, total_cost) VALUES ('$car_id', '$user_id', '$pickup_date', '$dropoff_date', '$total_cost')";
        $result = mysqli_query($db, $sql);
        if ($result) {
            $order_success = true;
        } else {
            $error = 'Something went wrong : ' . mysqli_error($db);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="assets/fa/all.css">
    <script src="assets/fa/all.js"></script>
    <style>
        header {
            background-image: url('assets/img/car2.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
    <title>Car Rental</title>
</head>
<body class="bg-sky-50">
    <header class="p-2 pb-24">
        <?php
            include_once('includes/sidenav.php');
        ?>

    </header>

    <?php if($order_success) : ?>
        <div class="max-w-7xl mx-auto px-4 py-12 md:py-24">
            <div class="bg-teal-50 rounded shadow-sm p-4">
                <h2 class="text-2xl font-bold uppercase text-teal-500">Order successful</h2>
                <p class="text-sm">Your order has been placed successfully. You will be contacted shortly.</p>
                <a href="index.php" class="text-sky-500 text-xl">Go to home</a>
            </div>
        </div>
    <?php else : ?>
    <section class="">
        <div class="max-w-7xl mx-auto px-4 py-12 md:py-24">
            <!-- order form -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold uppercase text-teal-500">make an order</h2>
                <a href="index.php" class="bg-teal-500 hover:bg-teal-600 transition text-white px-4 py-2 rounded shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i> Back to Home
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
            <div class="bg-teal-50 rounded shadow-sm p-4">
                <form action="#" method="post" class="flex flex-col gap-4">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label for="pickup_date" class="block mb-2">Pickup Location</label>
                            <p><?php echo $car['pickup'] ?></p>
                        </div>
                        <div class="flex-1">
                            <label for="dropoff_date" class="block mb-2 capitalize">price/day</label>
                            <p class="text-2xl text-teal-500">ZMW <?php echo $car['price'] ?></p>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label for="pickup_date" class="block mb-2">Pickup date</label>
                            <input type="date" name="pickup_date" id="pickup_date"  value="<?php echo $pickup_date ?>" class="block w-full border border-gray-300 rounded shadow-sm p-2">
                            <!-- error -->
                            <?php
                            if (isset($errors['pickup_date'])) {
                                echo '<p class="text-red-500 text-xs italic">' . $errors['pickup_date'] . '</p>';
                            }
                            ?>
                        </div>
                        <div class="flex-1">
                            <label for="dropoff_date" class="block mb-2">Dropoff date</label>
                            <input type="date" name="dropoff_date" id="dropoff_date" value="<?php echo $dropoff_date ?>" class="block w-full border border-gray-300 rounded shadow-sm p-2">
                            <!-- error -->
                            <?php
                            if (isset($errors['dropoff_date'])) {
                                echo '<p class="text-red-500 text-xs italic">' . $errors['dropoff_date'] . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-4">
                    </div>
                    <button type="submit" name="submit" class="bg-teal-500 hover:bg-teal-600 transition text-white px-4 py-2 rounded shadow-sm self-end">Save</button>
                </form>
            </div>
        </div>
    
    </section>
    <?php endif; ?>
    <!-- footer section -->
    <footer class="bg-teal-500 text-white">
        <div class="max-w-7xl mx-auto px-4 py-12 md:py-24">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="col-span-2 md:col-span-1">
                    <h1 class="text-xl font-bold mb-4">About us</h1>
                    <p class="text-sm">
                    Search, Compare and Save Using the World's Biggest Online Car Rental Service. Book Online Today With the World's Biggest Online Car Rental Service. We Speak Your Language. Unbeatable Prices. No Credit Card Fees. Types: Economy, Mini, Compact, People carrier, Intermediate, Premium, 4x4, Estate, SUV, Convertible.
                    </p>
                    <div class="flex gap-4 mt-4">
                        <a href="#" class="text-white"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <h1 class="text-xl font-bold mb-4">Contact us</h1>
                    <p class="text-sm">
                        <i class="fas fa-phone"></i> +260 971 864 421 <br>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:lumastech@gmail.com" class="text-white">lumastech@gmail.com</a>
                    </p>
                    <div class="flex gap-4 mt-4">
                        <a href="#" class="text-white"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <h1 class="text-xl font-bold mb-4">Quick links</h1>
                    <ul class="text-sm">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Cars</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Contact us</a></li>
                    </ul>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <h1 class="text-xl font-bold mb-4">Subscribe</h1>
                    <form action="#" method="post" class="flex gap-4">
                        <input type="email" class="block px-2 py-1 rounded border border-teal-500 w-full text-teal-500" placeholder="Enter email">
                        <button type="submit" class="bg-white shadow text-teal-500 rounded self-end px-2 py-1">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="bg-primary-600 text-white">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <p class="text-sm text-center">&copy; 2021 Car Rental. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>