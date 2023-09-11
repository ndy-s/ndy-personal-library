<template>
    <div class="h-16">

    </div>
    <div class="bg-gray-200">
        <nav class="h-16 text-white bg-gray-800 bg-opacity-[80%] flex fixed z-50 w-full top-0 items-center shadow">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center">
                    <div class="flex flex-col items-center">
                        <h1 class="text-3xl font-bold text-gradient bg-gradient-to-r from-gray-400 to-gray-300 bg-clip-text text-transparent">NdyApp</h1>
                        <small class="text-gray-400">Ndy's Personal Website</small>
                    </div>
                    <div class="flex">
                        <a href="/" class="text-white font-semibold rounded-lg px-4 py-2 | hover:bg-gray-600">
                            Home
                        </a>
                        <Link href="/art" class="text-white font-semibold rounded-lg px-4 py-2 | hover:bg-gray-600">
                            Art
                        </Link>
                    </div>
                    <div class="flex">
                        <div class="relative">
                            <button class="rounded-full overflow-hidden border-2 border-green-500 w-10 h-10 flex justify-center items-center | hover:border-white focus:outline-none focus:border-white"
                                    @click="isOpen1 = true"
                            >
                                <img src="https://i.pravatar.cc/150?u=1" alt="User's avatar">
                            </button>
                            <div v-if="isOpen1" class="fixed inset-0 w-full h-screen z-20 bg-black opacity-25" @click="isOpen1 = false"></div>
                            <div v-if="isOpen1" class="absolute z-30 right-0 mt-2" :class="{'hidden': !isOpen1}">
                                <div class="bg-white rounded-lg shadow-lg py-2 w-48">
                                    <a href="#" class="block text-gray-600 font-semibold px-4 py-2 | hover:text-white hover:bg-gray-600">Your profile</a>
                                    <Link href="/settings" class="block text-gray-600 font-semibold px-4 py-2 | hover:text-white hover:bg-gray-600">Settings</Link>
                                    <a href="#" class="block text-gray-600 font-semibold px-4 py-2 | hover:text-white hover:bg-gray-600">Sign out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>
<script setup>
    import { ref } from "vue";

    const isOpen1 = ref(false);
    // const app = new Vue({
    //     el: '#app',
    //     data: {
    //         isOpen1: true,
    //         isOpen2: false,
    //     }
    // })
</script>

