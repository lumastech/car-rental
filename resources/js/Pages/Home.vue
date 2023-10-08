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
                <header class="header-h pb-24 pt-2">
                    <Navbar />
                    <div class="max-w-7xl mx-auto">
                        <form action="#" class="shadow bg-white/80 rounded-md px-4 pt-4 my-16">
                            <h1 class="text-4xl text-primary px-4">Search And Compare</h1>
                            <div class=" grid md:grid-cols-4 gap-4 p-4">
                                <div class="form-group">
                                    <label for="pick-up">Pick up Location</label>
                                    <input type="text" id="pick-up" class="block w-full rounded bg-white/20 border-primary focus:border-primary transition" placeholder="Kabulonga">
                                </div>
                                <div class="form-group">
                                    <label for="pick-up">Pick up Date</label>
                                    <input type="date" id="pick-up" class="block w-full rounded bg-white/20 border-primary focus:border-primary transition" placeholder="Kabulonga">
                                </div>
                                <div class="form-group">
                                    <label for="pick-up">Drop off Date</label>
                                    <input type="date" id="pick-up" class="block w-full rounded bg-white/20 border-primary focus:border-primary transition" placeholder="Kabulonga">
                                </div>

                                <button type="submit" class="bg-teal-500 rounded text-white px-4 py-2 self-end">Search</button>
                            </div>
                        </form>

                    </div>
                </header>

                <section class="">
                    <div class="max-w-7xl mx-auto px-4 py-12 md:py-24">
                        <h1 class="text-primary text-xl mb-4">Availlable cars</h1>
                        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
                            <div v-for="i in 10" :key="i" class="shadow rounded overflow-hidden hover:bg-primary-100 hover:shadow-xl transition">
                                <img src="../../assets/cars/car1.jpg" alt="car" class="aspect-video w-full">
                                <div class="px-2">
                                    <h1 class="text-primary text-xl font-bold">Toyota</h1>
                                    <p class="text-gray-400 text-sm"><i class="fas fa-location"></i> Kabulonga</p>
                                    <p class="text-gray-400 text-sm"><i class="fas fa-users"></i> Capacity 5</p>
                                    <p class="bg-primary-400 inline px-2 rounded text-white">10% off</p>
                                </div>
                                <hr class="mt-2">
                                <div class="flex justify-between p-2">
                                    <p class="text-primary font-bold self-center">K 200</p>
                                    <p class="text-gray-400 self-center line-through">K 300</p>
                                    <button class="bg-teal-500 rounded text-white px-4 py-1 self-end">Book</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
    <Footer />
</template>

<script>
    import Footer from '@/Components/Footer.vue';
import Navbar from '@/Components/Navbar.vue';
import { Link, Head } from '@inertiajs/vue3';
    import {Datetimepicker, Input, initTE,} from "tw-elements";

    export default {
        components: {
    Link, Head, Datetimepicker, Input,
    Footer,
    Navbar
},
    }
</script>

<style>
 .header-h{
    background-image: url('../../assets/images/car6.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% ;
 }
</style>
