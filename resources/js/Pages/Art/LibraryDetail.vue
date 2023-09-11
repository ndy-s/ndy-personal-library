<template>
    <Layout>
        <div class="relative w-[100%] h-auto">
            <img :src="`/img/library/${ArtLibrary.image_path}`" alt="" class="w-[100%] h-[60vh] object-cover blur-2xl z-[-10] clip-path opacity-50" loading="lazy">
            <div class="absolute top-0 mx-[27%] my-20 leading-7 w-[50%]">
                <h1 class="text-white font-semibold text-[30px] mb-1 leading-8">{{ ArtLibrary.title_en }}</h1>
                <span class="bg-yellow-300 border border-gray-300 px-1 rounded-lg text-xs">{{ ArtLibrary.type }}</span>
                <p class="text-gray-100 border-t border-gray-400 mt-2"><span class="font-semibold">Title (Romaji): </span> {{ ArtLibrary.title_jp }}</p>
                <p class="text-gray-100"><span class="font-semibold">Original: </span> {{ ArtLibrary.original }}</p>
                <p class="text-gray-100"><span class="font-semibold">Series: </span> {{ ArtLibrary.series }}</p>
                <p class="text-gray-100"><span class="font-semibold">Author / Character Designer: </span> {{ ArtLibrary.author }}</p>
                <p class="text-gray-100"><span class="font-semibold">Studio: </span> {{ ArtLibrary.studio }}</p>
                <p class="text-gray-100"><span class="font-semibold">Released Year: </span> {{ ArtLibrary.year }}</p>
                <p class="text-gray-100"><span class="font-semibold">Language: </span> {{ ArtLibrary.lang }}</p>
                <p class="text-gray-100"><span class="font-semibold">Page: </span> {{ ArtLibrary.page }}</p>
                <p class="text-gray-100"><span class="font-semibold">Status: </span> {{ ArtLibrary.status }}</p>
                <p class="text-gray-100 border-t border-gray-400 mt-2"><span class="font-semibold">Description: </span> {{ ArtLibrary.desc }}</p>
            </div>
            <div class="absolute top-0 w-[15%] h-[80%] mx-[10%] mt-14 rounded-lg">
                <img :src="`/img/library/${ArtLibrary.image_path}`" alt="" class="h-full w-full object-cover rounded-lg" loading="lazy">
            </div>
            <div class="absolute bg-gray-200 h-[55vh] w-[20%] top-0 right-0 bg-opacity-25 rounded-xl my-5 mx-5 p-5 overflow-auto">
                <div class="border-b-2 p-2 w-[100%]" v-for="(subArtLib, index) in SubArtLibrary" :key="index">
                    <p class="text-white text-lg font-semibold leading-6">{{ subArtLib.title }}</p>
                    <p class="text-white mb-2 text-xs font-semibold">{{ subArtLib.sub_desc }}</p>
                    <div class="flex justify-evenly">
                        <a :href="subArtLib.link" target="_blank" class="bg-yellow-300 hover:bg-yellow-200 text-gray-800 font-bold py-2 px-4 rounded-lg inline-flex items-center">
                            <svg class="mr-2" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 13C12.5523 13 13 12.5523 13 12V3C13 2.44771 12.5523 2 12 2H3C2.44771 2 2 2.44771 2 3V6.5C2 6.77614 2.22386 7 2.5 7C2.77614 7 3 6.77614 3 6.5V3H12V12H8.5C8.22386 12 8 12.2239 8 12.5C8 12.7761 8.22386 13 8.5 13H12ZM9 6.5C9 6.5001 9 6.50021 9 6.50031V6.50035V9.5C9 9.77614 8.77614 10 8.5 10C8.22386 10 8 9.77614 8 9.5V7.70711L2.85355 12.8536C2.65829 13.0488 2.34171 13.0488 2.14645 12.8536C1.95118 12.6583 1.95118 12.3417 2.14645 12.1464L7.29289 7H5.5C5.22386 7 5 6.77614 5 6.5C5 6.22386 5.22386 6 5.5 6H8.5C8.56779 6 8.63244 6.01349 8.69139 6.03794C8.74949 6.06198 8.80398 6.09744 8.85143 6.14433C8.94251 6.23434 8.9992 6.35909 8.99999 6.49708L8.99999 6.49738" fill="currentColor"/>
                            </svg>
                            <span class="text-xs">View</span>
                        </a>
                        <a :href="subArtLib.link" target="_blank" class="bg-green-300 hover:bg-green-200 text-gray-800 font-bold py-2 px-4 rounded-lg inline-flex items-center">
                            <svg class="fill-current w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                            <span class="text-xs">Download</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex mt-12">
            <h1 class="text-white flex text-[30px] font-bold w-[70%] ml-12">
                Recommended Books
            </h1>
        </div>

        <div class="flex bottom-0">
            <div class="grid 2xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 mt-5 gap-8 ml-10 mb-10 w-[75%]">
                <template v-for="(ArtLib, index) in AllArtLibrary" :key="index">
                    <div class="relative">
                        <div class="relative bg-gray-700 rounded-lg shadow-md transition duration-400 ease-in-out transform" :class="[{'-translate-y-2 shadow-lg': hiddenDivs[index]}]">
                            <button class="absolute font-bold text-xs m-2 text-gray-800 border-gray-900 bg-yellow-200 bg-opacity-80 border px-1 start-0 rounded-xl p-1 z-10" :title="'Category: '+ArtLib.type" :value="ArtLib.type">{{ ArtLib.type }}</button>
                            <Link :href="`/art/library/librarydetail-${ArtLib.id}`">
                                <img class="w-full h-64 object-cover rounded-t-lg filter grayscale transition duration-300 ease-in-out text-white" :src="`/img/library/${ArtLib.image_path}`" loading="lazy" @load="$event.target.complete ? $event.target.nextElementSibling.classList.add('hidden') : null;" @mouseover="showHiddenDiv(index, $event)" @mouseenter.once="infoLoad(index)" @mouseout="hiddenDivs[index] = false" :class="[{'filter-none scale-105 shadow-xl': hiddenDivs[index]}]" alt="">
                                <PulseLoading class="absolute ml-[47%]"/>
                            </Link>
                            <div class="p-4 border-t-8 border-green-400">
                                <h4 class="font-semibold text-white text-lg line-clamp-2 h-14 cursor-pointer hover:text-green-400 transition duration-400 ease-in-out" :title="ArtLib.title_en"><Link :href="`/art/library/librarydetail-${ArtLib.id}`">{{ ArtLib.title_en }}</Link></h4>
                            </div>
                        </div>
                        <div class="absolute rounded-xl left-3/4 z-10 w-[300px] h-auto right-0 p-3 bg-gray-600 transition duration-300 ease-in-out" :class="[{'top-32': !infoBellow}, {'top-[-100px]': infoBellow}]" v-if="hiddenDivs[index]" @mouseover="hiddenDivs[index] = true" @mouseout="hiddenDivs[index] = false">
                            <PulseLoading v-if="showLoader[index]" class="relative col-span-4 items-center origin-center mx-[49%]"/>
                            <div v-if="!showLoader[index]" class="min-h-[200px]">
                                <p class="text-white text-sm font-bold">
                                    {{ ArtLib.title_en }}
                                </p>
                                <div class="flex w-[100%] mb-3 mt-1 justify-between">
                                        <span class="text-xs text-gray-200 max-w-[60%]">
                                            {{ ArtLib.author }}
                                        </span>
                                    <span class="bg-yellow-300 border border-gray-800 px-1 rounded-lg text-xs h-fit justify-center text-center">{{ ArtLib.type }}</span>
                                </div>
                                <p class="text-white text-xs"><span class="text-gray-200">Title (Romaji): </span> {{ ArtLib.title_jp }}</p>
                                <p class="text-white text-xs"><span class="text-gray-200">Original: </span> {{ ArtLib.original }}</p>
                                <p class="text-white text-xs"><span class="text-gray-200">Series: </span> {{ ArtLib.series }}</p>
                                <p class="text-white text-xs"><span class="text-gray-200">Studio: </span> {{ ArtLib.studio }}</p>
                                <p class="text-white text-xs"><span class="text-gray-200">Released Year: </span> {{ ArtLib.year }}</p>
                                <p class="text-white text-xs"><span class="text-gray-200">Language: </span> {{ ArtLib.lang }}</p>
                                <p class="text-white text-xs"><span class="text-gray-200">Page: </span> {{ ArtLib.page }}</p>
                                <p class="text-white text-xs"><span class="text-gray-200">Status: </span> {{ ArtLib.status }}</p>
                                <p class="text-white text-xs"><span class="text-gray-200">Description: </span> {{ ArtLib.desc }}</p>
                                <div class="flex justify-evenly mt-4">
                                    <a :href="ArtLib.link" target="_blank" class="bg-yellow-300 hover:bg-yellow-200 text-gray-800 font-bold py-2 px-4 rounded-lg inline-flex items-center">
                                        <svg class="mr-2" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 13C12.5523 13 13 12.5523 13 12V3C13 2.44771 12.5523 2 12 2H3C2.44771 2 2 2.44771 2 3V6.5C2 6.77614 2.22386 7 2.5 7C2.77614 7 3 6.77614 3 6.5V3H12V12H8.5C8.22386 12 8 12.2239 8 12.5C8 12.7761 8.22386 13 8.5 13H12ZM9 6.5C9 6.5001 9 6.50021 9 6.50031V6.50035V9.5C9 9.77614 8.77614 10 8.5 10C8.22386 10 8 9.77614 8 9.5V7.70711L2.85355 12.8536C2.65829 13.0488 2.34171 13.0488 2.14645 12.8536C1.95118 12.6583 1.95118 12.3417 2.14645 12.1464L7.29289 7H5.5C5.22386 7 5 6.77614 5 6.5C5 6.22386 5.22386 6 5.5 6H8.5C8.56779 6 8.63244 6.01349 8.69139 6.03794C8.74949 6.06198 8.80398 6.09744 8.85143 6.14433C8.94251 6.23434 8.9992 6.35909 8.99999 6.49708L8.99999 6.49738" fill="currentColor"/>
                                        </svg>
                                        <span class="text-xs">View</span>
                                    </a>
                                    <a :href="ArtLib.link" target="_blank" class="bg-green-300 hover:bg-green-200 text-gray-800 font-bold py-2 px-4 rounded-lg inline-flex items-center">
                                        <svg class="fill-current w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                                        <span class="text-xs">Download</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <PulseLoading class="relative 2xl:col-span-4 lg:col-span-2 mb-10 ml-[49%]" :class="{ 'hidden' : ArtLibrary.current_page === ArtLibrary.last_page }"/>
            </div>
        </div>

    </Layout>
</template>

<script setup>
    import Layout from "../../Shared/Layout.vue";
    import PulseLoading from "../../Shared/PulseLoading.vue";
    import {ref} from "vue";

    console.log('dd')

    const hiddenDivs = ref({});
    const showLoader = ref({});
    const infoBellow = ref({});

    const props = defineProps({
        'AllArtLibrary': Object,
        'ArtLibrary': Object,
        'SubArtLibrary': Object,
    });

    const infoLoad = (index) => {
        const timeout = Math.round(Math.random() * 3) * 100 + 100;

        showLoader.value[index] = true;
        setTimeout(() => {
            showLoader.value[index] = false;
        }, timeout);
    }
    const showHiddenDiv = (index, e) => {
        hiddenDivs.value[index] = true;
        infoBellow.value = e.target.getBoundingClientRect().top > 500;
    };
</script>
