<template>
    <th scope="col" class="text-xs font-semibold tracking-wider text-white uppercase py-4 font-mono">{{ columnTitle }}</th>
</template>

<script setup>
    const props = defineProps({
        columnTitle: String,
    });
</script>