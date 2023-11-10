<template>
    <Link :href=artHomeLink>
        <div class="bg-gray-800 rounded-lg overflow-hidden hover:shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="w-full h-64">
                <Transition>
                    <img v-if="imageShow" :src=artHomeImage :alt=artHomeAlt class="object-cover object-center h-64 w-full">
                </Transition>
            </div>
            <div class="p-4 text-center">
                <h3 class="text-xl font-bold mb-1 text-white"><slot/></h3>
                <p class="text-gray-200 mb-1">
                    <slot name="content" />
                </p>
            </div>
        </div>
    </Link>
</template>

<script setup>
    import { ref } from "vue"

    const props = defineProps({
        artHomeLink: String,
        artHomeImage: String,
        artHomeAlt: String,
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