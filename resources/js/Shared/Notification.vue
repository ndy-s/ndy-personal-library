<template>
    <div
        class="bg-green-500 fixed bottom-4 right-4 w-56 p-3 rounded-lg font-semibold text-white flex items-center justify-center space-x-2 shadow-md success-notification"
        :class="{ 'visible': successNotification === true}"
    >
        <svg height="20" width="20" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 310.277 310.277" xml:space="preserve">
            <g><path style="fill:white;" d="M155.139,0C69.598,0,0,69.598,0,155.139c0,85.547,69.598,155.139,155.139,155.139 c85.547,0,155.139-69.592,155.139-155.139C310.277,69.598,240.686,0,155.139,0z M144.177,196.567L90.571,142.96l8.437-8.437 l45.169,45.169l81.34-81.34l8.437,8.437L144.177,196.567z"/></g>
        </svg>
        <span>{{ messageNotification }}</span>
    </div>
</template>

<script setup>
    const props= defineProps({
        successNotification: Boolean,
        messageNotification: String,
    });
</script>

<style>
    .success-notification {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
    }

    .success-notification.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>