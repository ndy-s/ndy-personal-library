<template>
    <Link
        :href="artRecentLink"
        class="mx-5 my-auto"
    >
        <div class="w-[50px] h-[50px]">
            <Transition>
            <img
                v-if="imageShow"
                :src="artRecentImage"
                class="w-[50px] h-[50px] min-w-[50px] min-h-[50px] rounded-lg transition duration-100 ease-in-out text-white hover:scale-110 shadow-xl"
            >
        </Transition>
        </div>
    </Link>
</template>

<script setup>
    import { ref } from "vue";

    const props = defineProps({
        artRecentLink: String,
        artRecentImage: String,
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