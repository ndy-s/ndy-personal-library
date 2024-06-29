<template>
    <Link :href="linkHref" class="back-button absolute top-5 left-5 bg-gray-800 text-white py-2 px-4 text-lg rounded-md flex items-center gap-2 border border-green-400 hover:shadow-lg hover:bg-gray-700 hover:border-green-500 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#E5E7EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left h-5 w-5 flex-shrink-0">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        <span class="hidden sm:inline align-middle">Back</span>
    </Link>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    linkHref: String
});
</script>

<style scoped>
.back-button {
    transition: all 0.3s ease;
}

.back-button:hover {
    transform: translateX(-2px);
}
</style>
