<template>
    <p class="text-gray-100 text-xs"><span class="text-gray-300">{{ textKey }}:</span> {{ textValue }}</p>
</template>

<script setup>

    const props = defineProps({
        textKey: String,
        textValue: String,
    });
</script>