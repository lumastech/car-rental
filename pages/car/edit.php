<?php
include_once('../../includes/auth.php');
include_once('../../includes/db.php');


    $status = '';
    $errors = array();
    $image = '';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT * FROM cars WHERE id = '$id'";
        $result = mysqli_query($db, $sql);
        $car = mysqli_fetch_assoc($result);
        if($car){
            $make = $car['make'];
            $model = $car['model'];
            $year = $car['year'];
            $price = $car['price'];
            $status = $car['status'];
            $capacity = $car['capacity'];
            $image = $car['image'];
            $pickup = $car['pickup'];
            $pickup_date = $car['pickup_date'];
            $dropoff_date = $car['dropoff_date'];
        }else{
            $error = 'Car not found';
        }
    }

    if(isset($_POST['submit'])){
        $make = $_POST['make'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        $capacity = $_POST['capacity'];
        $pickup = $_POST['pickup'];
        $pickup_date = $_POST['pickup_date'];
        $dropoff_date = $_POST['dropoff_date'];

        if(empty($make)){
            $errors['make'] = 'Make is required';
        }
        if(empty($model)){
            $errors['model'] = 'Model is required';
        }

        if(empty($year)){
            $errors['year'] = 'Year is required';
        }

        if(empty($price)){
            $errors['price'] = 'Price is required';
        }

        if(empty($status)){
            $errors['status'] = 'Status is required';
        }

        if(empty($capacity)){
            $errors['capacity'] = 'Capacity is required';
        }

        if(!empty($_FILES['image']['name'])){
            $image = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $path = '../../assets/img/';
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            $allowed = array('png', 'jpg', 'jpeg', 'gif');
            if(!in_array($ext, $allowed)){
                $errors['image'] = 'Image must be png, jpg, jpeg or gif';
            }

            // image size should be <= 2 mb
            if(filesize($tmp_name) > 2097152){
                $errors['image'] = 'Image size should be <= 2 MB';
            }

            if(empty($errors)){
                $new_name = uniqid('car', false) . '.' . $ext;
                move_uploaded_file($tmp_name, $path . $new_name);
                $image = $path.$new_name;
            }

        }

        // UPDATE CAR
        if(count($errors) == 0){
            $sql = "UPDATE cars SET  make 
                    = '$make', model 
                    = '$model', year 
                    = '$year', price 
                    = '$price', status 
                    = '$status', image = '$image', capacity = '$capacity', pickup = '$pickup', pickup_date 
                    = '$pickup_date', dropoff_date = '$dropoff_date' WHERE id = '$id'";
            $result = mysqli_query($db, $sql);
            if ($result) {
                header('location: index.php');
            } else {
                $error = 'Something went wrong : '. mysqli_error($db);
            }
        }

        

    }
?>

<?php
include_once('../../includes/header.php');;

?>
<!-- add car form -->
<form action="#" method="post" class="bg-white shadow-sm p-4 py-12 rounded mt-24"  enctype="multipart/form-data" >
    <h2 class="text-2xl text-teal-500 font-bold">Update car</h2>
    <?php
    if (isset($error)) {
        echo '<div class="rounded p-2 bg-red-50 alert">
                 <p class="text-red-500">' . $error . '</p>
            </div>';
    }
    ?>
    <div class="grid md:grid-cols-3 gap-2">
        <div class="mt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="make">
                Make
            </label>
            <input class="block w-full border border-teal-500 rounded px-2 py-1 <?php echo isset($errors['make']) ? 'border-red-500' : ''; ?>" id="make" name="make" type="text" placeholder="Make" value="<?php echo isset($make) ? $make : ''; ?>">
            <?php
            if (isset($errors['make'])) {
                echo '<p class="text-red-500 text-xs italic">' . $errors['make'] . '</p>';
            }
            ?>
        </div>
        <div class="mt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 capitalize" for="model">
                Model
            </label>
            <input class="block w-full border border-teal-500 rounded px-2 py-1 <?php echo isset($errors['model']) ? 'border-red-500' : ''; ?>" id="model" name="model" type="text" placeholder="model" value="<?php echo isset($model) ? $model : ''; ?>">
            <?php
            if (isset($errors['model'])) {
                echo '<p class="text-red-500 text-xs italic">' . $errors['model'] . '</p>';
            }
            ?>
        </div>
        <div class="mt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 capitalize" for="year">
                Year
            </label>
            <input class="block w-full border border-teal-500 rounded px-2 py-1 <?php echo isset($errors['year']) ? 'border-red-500' : ''; ?>" id="year" name="year" type="text" placeholder="year" value="<?php echo isset($year) ? $year : ''; ?>">
            <?php
            if (isset($errors['year'])) {
                echo '<p class="text-red-500 text-xs italic">' . $errors['year'] . '</p>';
            }
            ?>
        </div>
        <div class="mt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 capitalize" for="price">
                Price
            </label>
            <input class="block w-full border border-teal-500 rounded px-2 py-1 <?php echo isset($errors['price']) ? 'border-red-500' : ''; ?>" id="price" name="price" type="decimal" placeholder="500" value="<?php echo isset($price) ? $price : ''; ?>">
            <?php
            if (isset($errors['price'])) {
                echo '<p class="text-red-500 text-xs italic">' . $errors['price'] . '</p>';
            }
            ?>
        </div>
        <div class="mt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 capitalize" for="status">
                Status
            </label>
            <select name="status" id="status" class="block w-full border border-teal-500 rounded px-2 py-1 <?php echo isset($errors['status']) ? 'border-red-500' : ''; ?>">
                <option value="available" <?php echo $status == 'available' ? 'selected' : ''; ?> >Available</option>
                <option value="booked" <?php echo $status == 'booked' ? 'selected' : ''; ?> >Booked</option>
                <option value="reserved" <?php echo $status == 'reserved' ? 'selected' : ''; ?> >Reserved</option>
            </select>
            <?php
            if (isset($errors['status'])) {
                echo '<p class="text-red-500 text-xs italic">' . $errors['status'] . '</p>';
            }
            ?>
        </div>
        <div class="mt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 capitalize" for="capacity">
                Capacity
            </label>
            <input class="block w-full border border-teal-500 rounded px-2 py-1 <?php echo isset($errors['capacity']) ? 'border-red-500' : ''; ?>" id="capacity" name="capacity" type="decimal" placeholder="5" value="<?php echo isset($capacity) ? $capacity : ''; ?>">
            <?php
            if (isset($errors['capacity'])) {
                echo '<p class="text-red-500 text-xs italic">' . $errors['capacity'] . '</p>';
            }
            ?>
        </div>
        <div class="mt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 capitalize" for="pickup">
                Pickup Location
            </label>
            <input class="block w-full border border-teal-500 rounded px-2 py-1 <?php echo isset($errors['pickup']) ? 'border-red-500' : ''; ?>" id="pickup" name="pickup" type="text" placeholder="Makeni, Lusaka" value="<?php echo isset($pickup) ? $pickup : ''; ?>">
            <?php
            if (isset($errors['pickup'])) {
                echo '<p class="text-red-500 text-xs italic">' . $errors['pickup'] . '</p>';
            }
            ?>
        </div>
        <div class="mt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 capitalize" for="pickup_date">
                Pickup Date
            </label>
            <input class="block w-full border border-teal-500 rounded px-2 py-1 <?php echo isset($errors['pickup_date']) ? 'border-red-500' : ''; ?>" id="pickup_date" name="pickup_date" type="datetime-local" value="<?php echo isset($pickup_date) ? $pickup_date : ''; ?>">
            <?php
            if (isset($errors['pickup_date'])) {
                echo '<p class="text-red-500 text-xs italic">' . $errors['pickup_date'] . '</p>';
            }
            ?>
        </div>
        <div class="mt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 capitalize" for="dropoff_date">
                Dropoff Date
            </label>
            <input class="block w-full border border-teal-500 rounded px-2 py-1 <?php echo isset($errors['dropoff_date']) ? 'border-red-500' : ''; ?>" id="dropoff_date" name="dropoff_date" type="datetime-local" value="<?php echo isset($dropoff_date) ? $dropoff_date : ''; ?>">
            <?php
            if (isset($errors['dropoff_date'])) {
                echo '<p class="text-red-500 text-xs italic">' . $errors['dropoff_date'] . '</p>';
            }
            ?>
        </div>
        <div class="mt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 capitalize" for="image">
                Image (image shuold be less the 2Mb)
            </label>
            <input class="block w-full border border-teal-500 rounded px-2 py-1 <?php echo isset($errors['image']) ? 'border-red-500' : ''; ?>" id="image" name="image" type="file" placeholder="image" value="<?php echo isset($image) ? $image : ''; ?>">
            <?php
            if (isset($errors['image'])) {
                echo '<p class="text-red-500 text-xs italic">' . $errors['image'] . '</p>';
            }
            ?>
        </div>
    </div>

    <button type="submit" name="submit" class="md:w-1/3 bg-teal-500 text-white px-2 py-1 mt-7 w-full rounded hover:bg-teal-700 transition">Submit</button>

</form>
<?php
include_once('../../includes/footer.php');
?>