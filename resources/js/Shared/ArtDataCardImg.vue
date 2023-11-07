<template>
    <div class="w-full h-64">
        <Link :href="`/art-library/detail-${ArtLib.id}`">
            <Transition>
                <img
                    v-if="imageShow"
                    class="w-full h-64 object-cover rounded-t-lg filter grayscale transition duration-300 ease-in-out text-white"
                    :src="`/img/library/${ArtLib.image_path}`"
                    :class="[{'filter-none scale-105 shadow-xl': hiddenDivs}]"
                    @load="$event.target.complete ? $event.target.nextElementSibling.classList.add('hidden') : null;"
                    @mouseenter="$emit('inside')"
                    @mouseleave="$emit('outside')"
                    @mouseover="$emit('over', $event)"
                >
            </Transition>
            <PulseLoading class="absolute ml-[47%]"/>
        </Link>
    </div>
</template>

<script setup>
    import { ref } from "vue";
    import PulseLoading from "@/Shared/PulseLoading.vue";
    
    const props = defineProps({
        ArtLib: Object,
        hiddenDivs: Boolean
    });

    const imageShow = ref(false)
    setTimeout(() => {
        imageShow.value = true;
    }, Math.random() * 700 + 300);
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