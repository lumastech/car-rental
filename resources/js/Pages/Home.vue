<template>
    <Head title="Home" />
    <div class="w-full h-full block">
        <div class="flex">
            <div class="side-bar-con fixed w-full h-full backdrop-blur-md bg-black/40 hidden">
                <div class="side-bar w-3/4 h-full bg-teal-500 -translate-x-full transition">
                    <!-- logo -->
                    <img src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="logo" class="w-9 h-9 mr-4 aspect-video" />
                    <hr>
                    <ul class="text-white py-7">
                        <li class="mr-6 flex space-x-4 w-full px-4 py-2 hover:bg-teal-700/70 transition">
                            <!-- fontawesom icon hom -->
                            <i class="fa-solid fa-home w-7 text-xl self-center"></i>
                            <Link href="/" class="text-xl self-center w-full">Home</Link>
                        </li>
                        <li class="mr-6 flex space-x-4 w-full px-4 py-2 hover:bg-teal-700/70 transition">
                            <i class="fa-solid fa-globe w-7 text-xl self-center"></i>
                            <Link href="/about" class="text-xl self-center w-full">About</Link>
                        </li>
                        <li class="mr-6 flex space-x-4 w-full px-4 py-2 hover:bg-teal-700/70 transition">
                            <i class="fa-solid fa-id-card w-7 text-xl self-center"></i>
                            <Link href="/contact" class="text-xl self-center w-full">Contact</Link>
                        </li>
                        <!-- LOGIN -->
                        <li class="mr-6 flex space-x-4 w-full px-4 py-2 hover:bg-teal-700/70 transition">
                            <i class="fa-solid fa-lock w-7 text-xl self-center" />
                            <Link href="/login" class="text-xl self-center w-full">Login</Link>
                        </li>
                        <!-- REGISTER -->
                        <li class="mr-6 flex space-x-4 w-full px-4 py-2 hover:bg-teal-700/70 transition">
                            <i class="fa-solid fa-user w-7 text-xl self-center" />
                            <Link href="/register" class="text-xl self-center w-full">Register</Link>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content flex-auto">
                <nav class="nav bg-gray-100 py-2 px-4 flex">
                    <!-- logo -->
                    <div class="flex-auto">
                        <a href="/">
                            <img src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="logo" class="w-9 h-9 mr-4" />
                        </a>
                    </div>
                    <ul class="flex self-center">
                        <li class="mr-6">
                            <Link href="/">Home</Link>
                        </li>
                        <li class="mr-6">
                            <Link href="/about">About</Link>
                        </li>
                        <li class="mr-6">
                            <Link href="/contact">Contact</Link>
                        </li>
                        <!-- LOGIN -->
                        <li class="mr-6">
                            <Link href="/login">Login</Link>
                        </li>
                        <!-- REGISTER -->
                        <li class="mr-6">
                            <Link href="/register">Register</Link>
                        </li>
                    </ul>
                    <button class="toggle md:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <line x1="4" y1="6" x2="20" y2="6" />
                            <line x1="4" y1="12" x2="20" y2="12" />
                            <line x1="4" y1="18" x2="20" y2="18" />
                        </svg>
                    </button>
                </nav>
                <h1 class="text-4xl container text-teal-500">Home</h1>
            </div>
        </div>
    </div>
</template>

<script>
    import { Link, Head } from '@inertiajs/vue3'

    export default {
        components: {
            Link, Head
        },
    }
</script>
