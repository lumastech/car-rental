<?php

   $env = parse_ini_file(__DIR__ . '../../.env');
    // GET DB_HOST VALUE FROM .ENV
    $db_host = isset($env['DB_HOST'])? $env['DB_HOST'] : '';
    $db_user = isset($env['DB_USER'])? $env['DB_USER'] : '';
    $db_pass = isset($env['DB_PASSWORD'])? $env['DB_PASSWORD'] : '';
    $db_name = isset($env['DB_NAME'])? $env['DB_NAME'] : '';

    $errors = array();

    if(isset($_POST['submit'])){
        $db_host = $_POST['db_host'];
        $db_user = $_POST['db_user'];
        $db_pass = $_POST['db_pass'];
        $db_name = $_POST['db_name'];

        if(empty($db_host)){
            $errors['db_host'] = 'database host address is required!';
        }

        if(empty($db_user)){
            $errors['db_user'] = 'database user name is required!';
        }

        if(empty($db_name)){
            $errors['db_name'] = 'database name is required!';
        }

        if(count($errors) == 0){
            
            // write to .env file
            file_put_contents(__DIR__ . '../../.env', 'DB_HOST='.$db_host . "\n");
            file_put_contents(__DIR__ . '../../.env', 'DB_USER='.$db_user . "\n", FILE_APPEND);
            file_put_contents(__DIR__ . '../../.env', 'DB_PASSWORD='.$db_pass . "\n", FILE_APPEND);
            file_put_contents(__DIR__ . '../../.env', 'DB_NAME='.$db_name . "\n", FILE_APPEND);

            // import database from sql file
            $sql = file_get_contents(__DIR__ . '../../setup/database.sql');
            $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
            $result = $db->multi_query($sql);
            if($result){
                header('Location: /setup/success.php');
            }else{
                header('Location: /setup/index.php');
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
    <title>DATABASE SETUP</title>
</head>
<body class="bg-sky-50">
    <!-- database setup form -->
    <div class="shadow rounded-md p-4 bg-white thext-teal-500 max-w-sm mx-auto space-y-4 mt-24">
        <h2 class="text-2xl text-teal-500">DATABASE SETUP</h2>
        <!-- description -->
        <p class="text-gray-500">Please enter your database credentials</p>
        <p class="text-gray-500">This setup helps you to import this application's database tables and seed a supper admin user. Once complete, you can login with the details bellow</p>
        <p class="text-gray-500 mb-0">username : <span class="text-teal-500 font-bold">admin@gmail.com</span></p>
        <p class="text-gray-500 m-0">password : <span class="text-teal-500 font-bold">password</span></p>
    </div>
    <form action="#" method="post" class="shadow rounded-md p-4 bg-white thext-teal-500 max-w-sm mx-auto space-y-4 mt-7">
        <div>
            <label for="db_host"> DATABASE HOST ADDRESS</label>
            <input type="text" name="db_host" placeholder="DB_HOST" value="<?php echo $db_host; ?>" class="w-full block p-2 border border-teal-500 rounded">
            <?php
                if(isset($errors['db_host'])):
            ?>
                <span class="text-red-500 italic text-sm"><?php echo $errors['db_host']; ?></span>
            <?php
                endif;
            ?>
        </div>
        <div>
            <label for="db_host"> DATABASE USER NAME</label>
            <input type="text" name="db_user" placeholder="DB_USER" value="<?php echo $db_user; ?>" class="w-full block p-2 border border-teal-500 rounded">
            <?php
                if(isset($errors['db_user'])):
            ?>
                <span class="text-red-500 italic text-sm"><?php echo $errors['db_user']; ?></span>
            <?php
                endif;
            ?>
        </div>
        <div>
            <label for="db_host"> DATABASE PASSWORD</label>
            <input type="text" name="db_pass" placeholder="DB_PASSWORD" value="<?php echo $db_pass; ?>" class="w-full block p-2 border border-teal-500 rounded">
        </div>
        <div>
            <label for="db_host"> DATABASE NAME</label>
            <input type="text" name="db_name" placeholder="DB_NAME" value="<?php echo $db_name; ?>" class="w-full block p-2 border border-teal-500 rounded">
            <?php
                if(isset($errors['db_name'])):
            ?>
                <span class="text-red-500 italic text-sm"><?php echo $errors['db_name']; ?></span>
            <?php
                endif;
            ?>
        </div>
        <button type="submit" name="submit" class="bg-teal-500 text-white hover:bg-teal-600 transition rounded px-4 py-2">NEXT</button>
    </form>
</body>
</html>