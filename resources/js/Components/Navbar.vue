<template>
    <nav class="nav bg-gray-100/50 rounded py-2 px-4 flex max-w-7xl mx-auto">
        <!-- logo -->
        <div class="flex-auto">
            <a href="/">
                <img src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="logo" class="w-9 h-9 mr-4" />
            </a>
        </div>
        <ul class="self-center hidden md:flex">
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
</template>
