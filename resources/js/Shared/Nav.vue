<template>
    <div class="bg-gray-200">
        <nav class="h-16 text-white bg-custom-black-pearl bg-opacity-[80%] flex fixed z-30 w-full top-0 items-center shadow">
            <div class="container mx-auto px-4">
                <div class="flex justify-around items-center">
                    <Link href="/" class="flex flex-col items-center">
                        <h1 class="text-3xl font-bold text-gradient bg-gradient-to-r from-green-200 to-green-400 bg-clip-text text-transparent">NdyApp</h1>
                        <small class="text-green-400">Ndy's Personal Website</small>
                    </Link>

                    <div v-if="ArtLibrary" class="flex ml-12 w-[70%] border border-green-400">
                        <select
                            :value="typeCat"
                            @change="$emit('update:typeCat', $event.target.value)"
                            class="flex-shrink-0 inline-flex items-center py-2.5 px-4 text-sm font-semibold text-white text-center border-r border-green-400 bg-gray-800 hover:bg-gray-900"
                            title="Category Option"
                        >
                            <option
                                value=""
                                selected
                            >No Category</option>
                            <option
                                v-for="(type, index) in types"
                                :key="index"
                                :value="Object.values(type).toString()"
                            >{{ Object.values(type).toString() }}</option>
                        </select>
                        <div class="relative w-full">
                            <input
                                type="search"
                                :value="search"
                                @input="$emit('update:search', $event.target.value)"
                                class="block p-2.5 pr-8 w-full text-md text-white bg-gray-800 placeholder:text-gray-400"
                                placeholder="Type to search..."
                                required
                            >
                            <button
                                v-show="search != undefined && search != ''"
                                @click="$emit('update:clear')"
                                class="absolute top-1 right-0 pr-2 text-2xl font-extrabold text-green-400 w-8 h-8 hover:text-green-500"
                                title="Clear"
                            >
                                <b>&times;</b>
                            </button>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="relative">
                            <button 
                                class="rounded-full overflow-hidden border-2 border-green-400 w-10 h-10 flex justify-center items-center | hover:animate-spin hover:border-gray-200 focus:animate-spin focus:border-gray-200 ease-in-out"
                                @click="dropdownOpen = true"
                            >
                                <img src="https://yt3.ggpht.com/S1CwKMvi9D8aebYrU0F495z7gsKrPWKYB7SVQi0xLDC5FLS0aIlcNWVQz2a2qSa92pBzcqsMeAM=s88-c-k-c0x00ffffff-no-rj" alt="Logo">
                            </button>
                            <div v-show="dropdownOpen" class="fixed inset-0 w-full h-screen z-20 bg-black opacity-25" @click="dropdownOpen = false"></div>
                            <div v-show="dropdownOpen" class="absolute z-30 mt-2 left-0" :class="{'hidden': !dropdownOpen, 'right-0 left-auto': ArtLibrary }">
                                <div class="bg-custom-prussian-blue rounded-lg shadow-lg py-2 w-60">
                                    <Link href="/art-library-management" class="block text-gray-200 font-semibold px-4 py-2 | hover:bg-gray-700 hover:text-white">Art Library Management</Link>
                                    <Link href="/art-course-management" class="block text-gray-200 font-semibold px-4 py-2 | hover:bg-gray-700 hover:text-white">Art Course Management</Link>
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

    const props = defineProps({
        ArtLibrary: Object,
        types: Object,
        search: String,
        typeCat: String,
    });

    const dropdownOpen = ref(false);
</script>

