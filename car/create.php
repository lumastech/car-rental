<?php
include_once('../../includes/auth.php');
include_once('../../includes/db.php');
    $status = '';
    $errors = array();
    $image = '';
    if(isset($_POST['submit'])){
        $make = $_POST['make'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        $capacity = $_POST['capacity'];
        $user_id = $_SESSION['user_id'];

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

            if(empty($errors)){
                $new_name = uniqid('car', false) . '.' . $ext;
                move_uploaded_file($tmp_name, $path . $new_name);
                $image = $path.$new_name;
            }

        }



        if(count($errors) == 0){
            $sql = "INSERT INTO cars (user_id, make, model, year, price, status, image, capacity) 
            VALUES ('$user_id', '$make', '$model', '$year', '$price', '$status', '$image', '$capacity')";
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
    <h2 class="text-2xl text-teal-500 font-bold">Add car</h2>
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
            <input class="block w-full border border-teal-500 rounded px-2 py-1 <?php echo isset($errors['capacity']) ? 'border-red-500' : ''; ?>" id="capacity" name="capacity" type="number" placeholder="5" value="<?php echo isset($capacity) ? $capacity : ''; ?>">
            <?php
            if (isset($errors['capacity'])) {
                echo '<p class="text-red-500 text-xs italic">' . $errors['capacity'] . '</p>';
            }
            ?>
        </div>
        <div class="mt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 capitalize" for="image">
                Image
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