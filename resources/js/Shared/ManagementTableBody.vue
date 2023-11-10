<template>
    <td v-if="tableId == 'title_en'" class="py-3 px-6 whitespace-nowrap">
        <div class="flex items-center">
            <ManagementImg :imgSrc="imgSrc" :imagePath="ArtLib.image_path" @showFull="(val) => $emit('showFull', val)"/>

            <div class="ml-4">
                <div class="text-sm font-semibold text-white">
                    {{ ArtLib[tableId] }}
                </div>
                <div class="text-sm text-gray-200">
                    {{ ArtLib.title_jp ?? ArtLib.original}}
                </div>
            </div>
        </div>
    </td>  

    <td v-else class="py-2 px-6 text-sm text-gray-200 whitespace-nowrap">{{ ArtLib[tableId] }}</td>
</template>

<script setup>
    import ManagementImg from '@/Shared/ManagementImg.vue';

    const props = defineProps({
        imgSrc: String,
        tableId: String,
        ArtLib: Object,
    });
</script>