<?php
    include_once('../../includes/auth.php');
    include_once('../../includes/db.php');
    $user_id = $_SESSION['user_id'];

    // select user
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($db, $sql);
    $user = mysqli_fetch_assoc($result);
    
    // if uer role is admin, select all cars
    if ($user['role'] == 'admin') {
        $sql = "SELECT * FROM cars LIMIT 50";
    } else {
        $sql = "SELECT * FROM cars WHERE user_id = '$user_id' LIMIT 50";
    }
    $result = mysqli_query($db, $sql);
    $cars = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (isset($_GET['action']) && $_GET['action'] == 'deletecar') {
        $id = $_GET['id'];
        $sql = "DELETE FROM cars WHERE id = '$id'";
        $result = mysqli_query($db, $sql);
        if ($result) {
            header('location: index.php');
        } else {
            $error = 'Something went wrong : ' . mysqli_error($db);
        }
    }

?>
<?php
include_once('../../includes/header.php');;

?>

<!-- cars table -->
<div class="bg-white rounded shadow-sm p-4 flex flex-col mt-12">
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold text-teal-500"><i class="fa-solid fa-car"></i> Cars</h2>
        <a href="create.php" class="bg-teal-500 text-white px-3 py-2 rounded hover:bg-teal-600 transition">
            <i class="fa-solid fa-plus"></i> Add a Car
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
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Actions</th>
                </tr>
            </thead>
            <tbody>
                
                <?php foreach ($cars as $car) : ?>
                    <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <img src="<?php echo $car['image']; ?>" alt="" class="w-20 h-20 object-cover">
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <?php echo $car['make']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <?php echo $car['model']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <?php echo $car['price']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <?php echo $car['year']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <?php echo $car['status']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <?php echo $car['pickup_date']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <?php echo $car['dropoff_date']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <?php echo $car['year']; ?>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <a href="edit.php?id=<?php echo $car['id']; ?>" class="text-sky-500">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <a href="index.php?action=deletecar&id=<?php echo $car['id']; ?>" class="text-red-500">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php
include_once('../../includes/footer.php');
?>