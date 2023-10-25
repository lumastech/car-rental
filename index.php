<?php
    session_start();
    include_once('includes/db.php');

    $sql = "SELECT * FROM cars LIMIT 50";
    $result = mysqli_query($db, $sql);
    $cars = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // search cars
    if(isset($_POST['search'])){
        if(isset($_POST['pickup']) || isset($_POST['pickup_date']) || isset($_POST['dropoff_date'])){
            $pickup = isset($_POST['pickup'])? $_POST['pickup'] : '';
            $pickup_date = isset($_POST['pickup_date'])? $_POST['pickup_date'] : '';
            $dropoff_date = isset($_POST['dropoff_date'])? $_POST['dropoff_date'] : '';
            
            $sql = "SELECT * FROM cars WHERE pickup LIKE '%$pickup%' OR pickup_date = '$pickup_date' OR dropoff_date = '$dropoff_date' LIMIT 50";
            $result = mysqli_query($db, $sql);
            $cars = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="assets/fa/all.css">
    <script src="assets/fa/all.js"></script>
    <style>
        header {
            background-image: url('assets/img/car3.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
    <title>Car Rental</title>
</head>
<body class="bg-sky-50">
    <header class="p-2">
        <?php
            include_once('includes/sidenav.php');
        ?>

        <!-- search form -->
        <div class="max-w-7xl mx-auto text-white bg-white/40 backdrop-blur-sm p-4 rounded my-24">
            <h2 class="text-2xl mb-2">Search Available cars</h2>
            <form action="#" method="post" class="grid md:grid-cols-4 gap-4">
                <div class="form-group">
                    <label for="pickup">Pickup</label>
                    <input name="pickup" type="text" class="block px-2 py-1 rounded border border-teal-500 w-full text-teal-500">
                </div>
                <div class="form-group">
                    <label for="pickup-date">Pickup Date</label>
                    <input name="pickup_date" type="date" class="block px-2 py-1 rounded border border-teal-500 w-full text-teal-500">
                </div>
                <div class="form-group">
                    <label for="dropoff-date">Drop off Date</label>
                    <input name="dropoff_date" type="date" class="block px-2 py-1 rounded border border-teal-500 w-full text-teal-500">
                </div>
                <button type="submit" name="search" class="bg-teal-500 text-white rounded self-end px-2 py-1">Search</button>
            </form>
        </div>
    </header>

    <section class="">
        <div class="max-w-7xl mx-auto px-4 py-12 md:py-24">
            <div class="flex justify-between mb-4">
                <h1 class="text-teal-500 font-bold text-xl mb-4">Availlable cars</h1>
                <a href="/cars.php" class="bg-teal-500 text-white rounded px-2 py-1 self-end hover:bg-teal-600 transition">All Cars</a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
                <?php foreach ($cars as $car) : ?>
                <div class="shadow rounded overflow-hidden bg-white hover:bg-primary-100 hover:shadow-xl transition text-gray-500">
                    <img src="<?php echo isset($car['image'])? $car['image'] : 'assets/img/car1.jpg' ?>" alt="car" class="aspect-video w-full">
                    <div class="px-2">
                        <h1 class="text-primary text-xl font-bold"><?php echo $car['make'] ?> </h1>
                        <p class="text-gray-400 text-sm"><i class="fas fa-map-location-dot"></i> <?php echo $car['pickup'] ?></p>
                        <p class="text-gray-400 text-sm"><i class="fas fa-id-card"></i> Capacity <?php echo $car['capacity'] ?></p>
                        <p class="bg-primary-400 inline px-2 rounded text-white">10% off</p>
                    </div>
                    <hr class="mt-2">
                    <div class="md:flex justify-between p-2">
                        <p class="text-primary font-bold self-center">K <?php echo $car['price']; ?></p>
                        <p class="text-gray-400 self-center line-through">K <?php echo ($car['price']*1.1); ?></p>
                        <a href="order.php?id=<?php echo $car['id']; ?>" class="bg-teal-500 rounded text-white px-4 py-1 self-end hover:bg-teal-600 transition">Book Now</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    
    </section>

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