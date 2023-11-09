<template>
    <td class="py-2 px-6 text-sm text-gray-200 whitespace-nowrap">{{ columnData }}</td>
</template>

<script setup>
    const props = defineProps({
        columnData: String,
    });
</script>