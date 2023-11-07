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
                <Link
                    :href="`/art-library/detail-${subRecent.id}`"
                    class="mx-5 my-auto"
                >
                    <img
                        :src="`/img/library/${subRecent.image_path}`"
                        class="w-[50px] h-[50px] min-w-[50px] min-h-[50px] rounded-lg transition duration-100 ease-in-out text-white hover:scale-110 shadow-xl"
                    >
                </Link>
                <div class="w-[100%]">
                    <Link
                        :href="`/art-library/detail-${subRecent.id}`"
                        class="text-white font-semibold text-sm mb-1 hover:text-green-400 transition duration-400 ease-in-out line-clamp-2"
                        :title="subRecent.title_en"
                    >{{ subRecent.title_en }}</Link>
                    <div class="flex justify-between">
                        <p class="text-gray-300 text-[12px]">{{ formatTime(subRecent.updated_at) }}</p>
                        <button
                            @click="$emit('update:typeCat', $event.target.value)"
                            class="cursor-default text-gray-100 bg-green-400 bg-opacity-20 px-2 border border-green-400 rounded-sm text-xs font-bold mr-1 text-[12px]"
                            :title="'Category: '+subRecent.type"
                            :value="subRecent.type"
                        >
                            {{ subRecent.type }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import moment from "moment";

    const props = defineProps({
        recent: Object,
    });

    const formatTime = (value) => moment(String(value)).fromNow();
</script>