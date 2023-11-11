<template>
    <div class="grid 2xl:grid-cols-4 xl:grid-cols-3 lg:grid-cols-2 mt-5 gap-8 ml-12 mb-10 w-[70%]">
        <template
            v-for="(ArtLib, index) in filteredArtLibraryData"
            :key="index"
        >
            <div class="relative">
                <div
                    class="relative bg-gray-800 rounded-lg shadow-md transition duration-400 ease-in-out transform"
                    :class="[{'-translate-y-2 shadow-lg': hiddenDivs[index]}]"
                >
                    <button
                        @click="$emit('update:typeCat', $event.target.value)"
                        @mouseenter="isInsideCard[index]=true; hiddenDivs[index]=true;showHiddenDiv(index)"
                        @mouseleave="isInsideCard[index]=false; isInsideHiddenDiv[index]=false; hideHiddenDiv(index)"
                        class="absolute font-bold text-xs m-2 text-white bg-custom-black-pearl bg-opacity-70 border border-green-400 start-0 rounded-sm p-1 bottom-28 z-10"
                        :title="'Category: '+ (ArtLib.type ?? ArtLib.publisher)"
                        :value="ArtLib.type ?? ArtLib.publisher"
                    >
                        {{ ArtLib.type ?? ArtLib.publisher }}
                    </button>

                    <DataCardImg 
                        :imgSrc="imgSrc"
                        :ArtLib="ArtLib"
                        v-model:hiddenDivs="hiddenDivs[index]"
                        @inside="isInsideCard[index]=true; hiddenDivs[index]=true;showHiddenDiv(index)"
                        @outside="isInsideCard[index]=false; hideHiddenDiv(index)"
                        @over="infoBellow = $event.target.getBoundingClientRect().top > 500"
                    />
                    <div class="p-4 border-t-8 border-green-400">
                        <h4
                            class="font-semibold text-white text-md line-clamp-2 h-12 cursor-pointer"
                            :title="ArtLib.title_en"
                        ><Link :href="`/art-${imgSrc}/detail-${ArtLib.id}`">{{ ArtLib.title_en }}</Link></h4>
                        <div class="flex justify-between">
                            <p class="text-gray-200 text-xs mt-2">{{ ArtLib.author }}</p>
                            <p class="text-gray-200 text-xs mt-2">{{ ArtLib.year }}</p>
                        </div>
                    </div>
                </div>
                <Transition>
                    <div
                        class="absolute rounded-xl left-3/4 z-10 w-[300px] h-auto right-0 p-3 bg-gray-700 transition duration-300 ease-in-out"
                        :class="[{'top-32': !infoBellow}, {'top-[-100px]': infoBellow}]"
                        v-show="hiddenDivs[index]"
                        @mouseenter="isInsideHiddenDiv[index]=true; hiddenDivs[index] = true; showHiddenDiv(index)"
                        @mouseleave="isInsideHiddenDiv[index]=false; hideHiddenDiv(index)"
                    >
                        <div class="min-h-[200px]">
                            <p class="text-white text-sm font-bold">
                                {{ ArtLib.title_en }}
                            </p>
                            <div class="flex w-[100%] mt-2 mb-3 justify-between">
                                <span class="text-xs text-gray-100 max-w-[60%]">
                                    {{ ArtLib.author }}
                                </span>
                                <span class="cursor-default text-gray-100 bg-green-400 bg-opacity-20 px-2 border border-green-400 rounded-sm text-xs font-bold h-fit justify-center text-center">{{ ArtLib.type ?? ArtLib.publisher }}</span>
                            </div>
                            <DataCardDivText v-for="(detail, index) in cardDetailData" :key="index" :textKey="detail.title" :textValue="ArtLib[detail.id]"/>
    
                            <div class="flex justify-evenly mt-4">
                                <a :href="ArtLib.link" target="_blank" class="bg-green-400 text-custom-black-pearl font-bold py-2 px-6 rounded-md inline-flex items-center">
                                    <svg class="mr-2" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 13C12.5523 13 13 12.5523 13 12V3C13 2.44771 12.5523 2 12 2H3C2.44771 2 2 2.44771 2 3V6.5C2 6.77614 2.22386 7 2.5 7C2.77614 7 3 6.77614 3 6.5V3H12V12H8.5C8.22386 12 8 12.2239 8 12.5C8 12.7761 8.22386 13 8.5 13H12ZM9 6.5C9 6.5001 9 6.50021 9 6.50031V6.50035V9.5C9 9.77614 8.77614 10 8.5 10C8.22386 10 8 9.77614 8 9.5V7.70711L2.85355 12.8536C2.65829 13.0488 2.34171 13.0488 2.14645 12.8536C1.95118 12.6583 1.95118 12.3417 2.14645 12.1464L7.29289 7H5.5C5.22386 7 5 6.77614 5 6.5C5 6.22386 5.22386 6 5.5 6H8.5C8.56779 6 8.63244 6.01349 8.69139 6.03794C8.74949 6.06198 8.80398 6.09744 8.85143 6.14433C8.94251 6.23434 8.9992 6.35909 8.99999 6.49708L8.99999 6.49738" fill="currentColor"/>
                                    </svg>
                                    <span class="text-xs">View</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </Transition>

            </div>
        </template>
        <PulseLoading
            class="relative 2xl:col-span-4 lg:col-span-2 mb-10 ml-[49%]"
            :class="{ 'hidden' : ArtLibrary.current_page === ArtLibrary.last_page }"
        />
    </div>
</template>

<script setup>
    import { ref } from "vue";
    import PulseLoading from "@/Shared/PulseLoading.vue";
    import DataCardDivText from "@/Shared/DataCardDivText.vue";
    import DataCardImg from "@/Shared/DataCardImg.vue"

    const props = defineProps({
        imgSrc: String,
        cardDetailData: Array,
        ArtLibrary: Object,
        filteredArtLibraryData: Object,
    });

    const hiddenDivs = ref({});
    const infoBellow = ref({});

    const isInsideCard = ref({});
    const isInsideHiddenDiv = ref({});
    const showHiddenDiv = (index) => {
        if (isInsideCard.value[index] && isInsideHiddenDiv.value[index]) {
            hiddenDivs.value[index] = true;
        }
    };

    const hideHiddenDiv = (index) => {
        if (!isInsideCard.value[index] && !isInsideHiddenDiv.value[index]) {
            hiddenDivs.value[index] = false;
        }
    };
</script>

<style scoped>
    .v-enter-active,
    .v-leave-active {
        transition: opacity 0.1s ease;
    }

    .v-enter-from,
    .v-leave-to {
        opacity: 0;
    }
</style>