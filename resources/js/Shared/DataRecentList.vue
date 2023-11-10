<template>
    <div class="top-0 w-[25%] mx-5 mt-5">
        <div class="bg-gray-800 rounded-lg p-3">
            <div
                class="flex w-[100%] py-3 group"
                :class="{'border-b border-gray-400': index < 9}"
                v-for="(subRecent, index) in recent"
                :key="index"
            >
                <h1
                    class="text-white my-auto text-xl font-bold border-b-4 border-green-300 leading-8 group-hover:text-green-400"
                    v-if="index < 3"
                > 0{{index+1}} </h1>
                <h1
                    class="text-gray-300 my-auto text-xl font-bold group-hover:text-green-400"
                    v-if="index > 2 && index < 9"
                > 0{{index+1}} </h1>
                <h1
                    class="text-gray-300 my-auto text-xl font-bold group-hover:text-green-400"
                    v-if="index === 9"
                > {{index+1}} </h1>
                
                <DataRecentImg :artRecentLink="`/art-${imgSrc}/detail-${subRecent.id}`" :artRecentImage="`/img/${imgSrc}/${subRecent.image_path}`"/>


                <div class="w-[100%]">
                    <Link
                        :href="`/art-${imgSrc}/detail-${subRecent.id}`"
                        class="text-white font-semibold text-sm mb-1 hover:text-green-400 transition duration-400 ease-in-out line-clamp-2"
                        :title="subRecent.title_en"
                    >{{ subRecent.title_en }}</Link>
                    <div class="flex justify-between">
                        <p class="text-gray-300 text-[12px]">{{ formatTime(subRecent.updated_at) }}</p>
                        <button
                            @click="$emit('update:typeCat', $event.target.value)"
                            class="cursor-default text-gray-100 bg-green-400 bg-opacity-20 px-2 border border-green-400 rounded-sm text-xs font-bold mr-1 text-[12px]"
                            :title="'Category: '+subRecent.type ?? subRecent.publisher"
                            :value="subRecent.type ?? subRecent.publisher"
                        >
                            {{ subRecent.type ?? subRecent.publisher }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import moment from "moment";
    import DataRecentImg from "@/Shared/DataRecentImg.vue";

    const props = defineProps({
        imgSrc: String,
        recent: Object,
    });

    const formatTime = (value) => moment(String(value)).fromNow();
</script>