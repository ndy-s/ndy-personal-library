<template>
    <div class="scroll-buttons fixed bottom-10 right-10 z-50">
        <button @click="scrollToTop" class="scroll-button bg-gray-800 bg-opacity-75 text-green-500 hover:bg-gray-700 hover:bg-opacity-75 hover:text-white hover:border-green-500 border border-green-400 mr-2">↑</button>
        <button @click="scrollToBottom" class="scroll-button bg-gray-800 bg-opacity-75 text-green-500 hover:bg-gray-700 hover:bg-opacity-75 hover:text-white hover:border-green-500 border border-green-400">↓</button>
    </div>
</template>

<script setup>
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}

function scrollToBottom() {
    window.scrollTo({
        top: document.documentElement.offsetHeight,
        behavior: "smooth"
    });
}
</script>

<style scoped>
.scroll-button {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 20px;
    border: 1px solid;
    cursor: pointer;
    outline: none;
    margin-bottom: 10px;
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
}
</style>
