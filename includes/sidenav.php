<nav class="flex gap-4 max-w-7xl mx-auto bg-teal-100/40 text-white px-4 rounded shadow-md my-4 backdrop-blur">
    <a href="#">
        <img src="logo.jpg" alt="logo" class="w-16">
    </a>
    <div class="flex-auto"></div>
    <div class="self-center hidden md:flex space-x-4 justify-end uppercase ">
        <a href="/" class="">home</a>
        <a href="/cars.php">cars</a>
    </div>
    <div class="self-center flex space-x-4 justify-end uppercase">
        <?php if(isset($_SESSION['name'])) : ?>
            <a href="pages/dashboard.php" class="flex gap-2"><i class="fas fa-user self-center"></i> <span class="hidden md:flex self-center">DASHBOARD</span></a>
            <a href="controllers/logout.php" class="flex gap-2"><i class="fas fa-sign-out-alt self-center"></i> <span class="hidden md:flex self-center">Logout</span></a>  
        <?php else : ?>
            <a href="pages/auth/login.php" ><i class="fas fa-sign-in-alt"></i> <span class="hidden md:flex self-center">Login</span></a>
            <a href="pages/auth/register.php" ><i class="fas fa-user-plus"></i> <span class="hidden md:flex self-center">Register</span></a>
        <?php endif; ?>
    </div>
    <!-- menu -->
    <div class="self-center flex space-x-4 justify-end uppercase">
        <a onclick="navOpen()" href="#" class="block md:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </a>
    </div>
</nav>

<div onclick="navClose()" class="hidden sidenav-cont w-full h-full bg-black/40 backdrop-blur top-0 left-0 z-50">
    <div class="sidenav w-3/4 md:w-1/4 bg-teal-500 h-full shadow-md text-white -translate-x-full transition duration-300">
        <img src="/logo.jpg" alt="logo" class="aspect-video w-full">
         <div class="uppercase ">
            <a href="/" class="py-2 px-4 hover:bg-teal-600 transition block">home</a>
            <a href="/cars.php" class="py-2 px-4 hover:bg-teal-600 transition block">cars</a>
        </div>
        <div class="uppercase">
            <?php if(isset($_SESSION['name'])) : ?>
                <a href="pages/dashboard.php"  class="py-2 px-4 hover:bg-teal-600 transition block"><i class="fas fa-user"></i> DASHBOARD</a>
                <a href="controllers/logout.php"  class="py-2 px-4 hover:bg-teal-600 transition block"><i class="fas fa-sign-out-alt"></i> Logout</a> 
            <?php else : ?>
                <a href="pages/auth/login.php"  class="py-2 px-4 hover:bg-teal-600 transition block"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="pages/auth/register.php"  class="py-2 px-4 hover:bg-teal-600 transition block"><i class="fas fa-user-plus"></i> Register</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    function navOpen() {
        document.querySelector('.sidenav-cont').classList.remove('hidden');
        document.querySelector('.sidenav-cont').classList.add('fixed');
        setTimeout(() => {
            document.querySelector('.sidenav').classList.remove('-translate-x-full');
        }, 30);
    }
    function navClose() {
            document.querySelector('.sidenav').classList.add('-translate-x-full');
        setTimeout(() => {
            document.querySelector('.sidenav-cont').classList.remove('fixed');
            document.querySelector('.sidenav-cont').classList.add('hidden');
        }, 300);
    }
</script>