<template>
    <div class="flex-shrink-0 w-10 h-10 border border-green-300 bg-gray-900 rounded-full">
        <Transition>
            <img v-if="imageShow" class="w-10 h-10 rounded-full border border-green-300" :src="`/img/${imgSrc}/${imagePath}`" alt="" @click="$emit('showFull', imagePath)"/>
        </Transition>
    </div>
</template>

<script setup>
    import { ref } from "vue";

    const props = defineProps({
        imgSrc: String,
        imagePath: String
    });

    const imageShow = ref(false)
    setTimeout(() => {
        imageShow.value = true;
    }, Math.random() * 300 + 100);
</script>

<style scoped>
    .v-enter-active,
    .v-leave-active {
        transition: opacity 0.5s ease;
    }

    .v-enter-from,
    .v-leave-to {
        opacity: 0;
    }
</style>