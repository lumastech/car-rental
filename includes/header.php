<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/tailwind.css">
    <link rel="stylesheet" href="../../assets/fa/all.css">
    <script src="../assets/js/jquery-3.7.1.js"></script>
    <script src="../../assets/fa/all.js"></script>

    <script>
        $(document).ready(function() {
            // Hide the error message after 5 seconds
            setTimeout(function() {
                $(".alert").hide(300);
            }, 5000);
            
        });
    </script>
    <title>Car rental</title>
</head>
<body class="bg-sky-50">
    <div class="fixed w-full h-full">
        <div class="md:flex h-full">
            <div class="sidebar z-99 fixed md:relative md:translate-x-0 md:m-2 top-0 left-0 -translate-x-full w-[50px] lg:w-[200px] transition hover:w-[200px] shrink-0 bg-white shadow-md rounded-md h-full overflow-x-hidden overflow-y-auto">
                <a href="#" class="flex text-teal-500 px-4 py-3 hover:text-white hover:bg-teal-500 space-x-2 border-b">
                    <i class="fa-solid fa-user self-center w-7 mr-4 flex-0"></i>
                    <span class="flex-auto self-center">
                        <?php echo explode(" ", $_SESSION['name'])['0'] ?>
                    </span>
                </a>
                <a href="/pages/dashboard.php" class="flex text-teal-500 px-4 py-2 hover:text-white hover:bg-teal-500 space-x-2">
                    <i class="fa-solid fa-dashboard self-center w-7 mr-4"></i>
                    <span class="flex-auto self-center">Dashboard</span>
                </a>
                <a href="/pages/user/" class="flex text-teal-500 px-4 py-2 hover:text-white hover:bg-teal-500 space-x-2">
                    <i class="fa-solid fa-users self-center w-7 mr-4"></i>
                    <span class="flex-auto self-center">Users</span>
                </a>
                <a href="/pages/car/" class="flex text-teal-500 px-4 py-2 hover:text-white hover:bg-teal-500 space-x-2">
                    <i class="fa-solid fa-car self-center w-7 mr-4"></i>
                    <span class="flex-auto self-center">Cars</span>
                </a>
                <a href="/pages/order/" class="flex text-teal-500 px-4 py-2 hover:text-white hover:bg-teal-500 space-x-2">
                    <i class="fa-solid fa-file-invoice-dollar self-center w-7 mr-4"></i>
                    <span class="flex-auto self-center">Bookigs</span>
                </a>
                <a href="/" class="flex text-teal-500 px-4 py-2 hover:text-white hover:bg-teal-500 space-x-2 border-t">
                    <i class="fa-solid fa-home self-center w-7 mr-4"></i>
                    <span class="flex-auto self-center">Website</span>
                </a>
            </div>

            <!-- dashboard -->
            <div class="md:flex-auto rounded-md m-2 h-full overflow-x-hidden overflow-y-auto">
                <div class="flex justify-between items-center px-4 py-2 bg-white shadow">
                    <div class="flex gap-2">
                        <button onclick="navOpen()" href="#" class="menu block md:hidden self-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h2 class="text-2xl text-teal-500 font-bold self-center">Dashboard</h2>
                    </div>
                    <div class="space-x-2">
                        <span class="w-7 h-7 shadow bg-teal-500 rounded-full p-2 hover:scale-110 transition text-white">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <a href="../../controllers/logout.php" class="text-red-500 hover:text-red-700 transition">Logout</a>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto p-4">
                    <script>
                        function navOpen() {
                            document.querySelector('.sidebar').classList.remove('-translate-x-full');
                            document.querySelector('.sidebar').classList.add('w-[200px]');
                            document.querySelector('.sidebar').classList.remove('w-[50px]');
                            document.querySelector('.sidebar').classList.add('hover:w-[200px]');
                        }
                        function navClose() {
                            document.querySelector('.sidebar').classList.add('-translate-x-full');
                            document.querySelector('.sidebar').classList.remove('w-[200px]');
                            document.querySelector('.sidebar').classList.add('w-[50px]');
                            document.querySelector('.sidebar').classList.remove('hover:w-[200px]');
                        }

                        document.querySelector('body').addEventListener('click', function() {
                            navClose();
                        });

                        document.querySelector('.sidebar').addEventListener('click', function(e) {
                            e.stopPropagation();
                        });

                        document.querySelector('.menu').addEventListener('click', function(e) {
                            e.stopPropagation();
                        });
                    </script>