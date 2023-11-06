<template>
    <div class="bg-gray-200">
        <nav class="h-16 text-white bg-custom-black-pearl bg-opacity-[80%] flex fixed z-50 w-full top-0 items-center shadow">
            <div class="container mx-auto px-4">
                <div class="flex justify-around items-center">
                    <Link href="/" class="flex flex-col items-center">
                        <h1 class="text-3xl font-bold text-gradient bg-gradient-to-r from-custom-gainsboro to-gray-200 bg-clip-text text-transparent">NdyApp</h1>
                        <small class="text-custom-gainsboro">Ndy's Personal Website</small>
                    </Link>
                    <div class="flex">
                        <div class="relative">
                            <button 
                                class="rounded-full overflow-hidden border-2 border-custom-gainsboro w-10 h-10 flex justify-center items-center | hover:animate-spin hover:border-gray-200 focus:animate-spin focus:border-gray-200 ease-in-out"
                                @click="dropdownOpen = true"
                            >
                                <img src="https://yt3.ggpht.com/S1CwKMvi9D8aebYrU0F495z7gsKrPWKYB7SVQi0xLDC5FLS0aIlcNWVQz2a2qSa92pBzcqsMeAM=s88-c-k-c0x00ffffff-no-rj" alt="Logo">
                            </button>
                            <div v-show="dropdownOpen" class="fixed inset-0 w-full h-screen z-20 bg-black opacity-25" @click="dropdownOpen = false"></div>
                            <div v-show="dropdownOpen" class="absolute z-30 mt-2 left-0" :class="{'hidden': !dropdownOpen}">
                                <div class="bg-custom-prussian-blue rounded-lg shadow-lg py-2 w-60">
                                    <Link href="art-library-management" class="block text-gray-200 font-semibold px-4 py-2 | hover:bg-gray-700 hover:text-white">Art Library Management</Link>
                                    <Link href="#" class="block text-gray-200 font-semibold px-4 py-2 | hover:bg-gray-700 hover:text-white">#</Link>
                                    <Link href="#" class="block text-gray-200 font-semibold px-4 py-2 | hover:bg-gray-700 hover:text-white">#</Link>
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
    const dropdownOpen = ref(false);
</script>

