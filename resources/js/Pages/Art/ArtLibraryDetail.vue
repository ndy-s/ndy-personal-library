<template>
    <Layout>
        <template #nav>
            <Nav />
        </template>

        <div class="mt-16 relative w-[100%] h-auto">
            <img :src="`/img/library/${ArtLibrary.image_path}`" class="w-[100%] h-[60vh] object-cover blur-2xl z-[-10] clip-path opacity-50">
            <DetailBackButton linkHref="/art-library"/>

            <div class="absolute top-0 mx-[27%] my-20 leading-7 w-[50%]">
                <h1 class="text-white font-semibold text-[30px] mb-1 leading-8">{{ ArtLibrary.title_en }}</h1>
                <span class="cursor-default text-gray-100 bg-green-400 bg-opacity-20 px-2 border border-green-400 rounded-sm text-xs font-bold h-fit justify-center text-center">{{ ArtLibrary.type }}</span>

                <table class="text-white mt-3">
                    <tr>
                        <td class="font-semibold">Title (Romaji)</td>
                        <td> : {{ ArtLibrary.title_jp }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Original</td>
                        <td> : {{ ArtLibrary.original }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Series</td>
                        <td> : {{ ArtLibrary.series }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Author / Character Designer</td>
                        <td> : {{ ArtLibrary.author }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Studio</td>
                        <td> : {{ ArtLibrary.studio }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Released Year</td>
                        <td> : {{ ArtLibrary.year }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Language</td>
                        <td> : {{ ArtLibrary.lang }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Page</td>
                        <td> : {{ ArtLibrary.page }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Status</td>
                        <td> : {{ ArtLibrary.status }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Description</td>
                        <td> : {{ ArtLibrary.desc }}</td>
                    </tr>
                </table>
            </div>
            <div class="absolute top-0 w-[15%] h-[80%] mx-[10%] mt-14 rounded-lg">
                <img :src="`/img/library/${ArtLibrary.image_path}`" class="h-full w-full object-cover rounded-lg" @click="openModal()">
            </div>
            <div class="absolute bg-gray-200 h-[55vh] w-[20%] top-0 right-0 bg-opacity-25 rounded-xl my-5 mx-5 p-5 overflow-auto">
                <div class="border-b-2 p-2 w-[100%]" v-for="(subArtLib, index) in SubArtLibrary" :key="index">
                    <p class="text-white text-lg font-semibold leading-6">{{ subArtLib.title }}</p>
                    <p class="text-white mb-2 text-xs font-semibold">{{ subArtLib.sub_desc }}</p>
                    <div class="flex justify-evenly">
                        <a :href="subArtLib.link" target="_blank" class="bg-green-400 text-custom-black-pearl font-bold py-2 px-6 rounded-md inline-flex items-center">
                            <svg class="mr-2" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 13C12.5523 13 13 12.5523 13 12V3C13 2.44771 12.5523 2 12 2H3C2.44771 2 2 2.44771 2 3V6.5C2 6.77614 2.22386 7 2.5 7C2.77614 7 3 6.77614 3 6.5V3H12V12H8.5C8.22386 12 8 12.2239 8 12.5C8 12.7761 8.22386 13 8.5 13H12ZM9 6.5C9 6.5001 9 6.50021 9 6.50031V6.50035V9.5C9 9.77614 8.77614 10 8.5 10C8.22386 10 8 9.77614 8 9.5V7.70711L2.85355 12.8536C2.65829 13.0488 2.34171 13.0488 2.14645 12.8536C1.95118 12.6583 1.95118 12.3417 2.14645 12.1464L7.29289 7H5.5C5.22386 7 5 6.77614 5 6.5C5 6.22386 5.22386 6 5.5 6H8.5C8.56779 6 8.63244 6.01349 8.69139 6.03794C8.74949 6.06198 8.80398 6.09744 8.85143 6.14433C8.94251 6.23434 8.9992 6.35909 8.99999 6.49708L8.99999 6.49738" fill="currentColor"/>
                            </svg>
                            <span class="text-xs">View</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex mt-12">
            <h1 class="text-white flex text-[30px] font-bold w-[70%] ml-12 border-l-4 border-green-400 pl-4">
                Recommended Books
            </h1>
            <h1 class="w-[25%] mx-5">
                <span class="text-white text-[30px] font-bold border-l-4 border-green-400 pl-4">Recently Updated</span>
            </h1>
        </div>

        <div class="flex bottom-0">
            <DataCards 
                imgSrc="library"
                :cardDetailData="cardDetailData"
                :ArtLibrary="ArtLibrary" 
                :filteredArtLibraryData="AllArtLibrary"
            />
            <DataRecentList imgSrc="library" :recent="recent" />
        </div>

        <Transition>
            <div v-if="showModal" @click="closeModal" class="fixed inset-0 flex items-center justify-center z-50 bg-opacity-50 bg-black transition-all ease-in-out duration-500">
                <div class="bg-white p-4 rounded shadow">
                    <img :src="`/img/library/${ArtLibrary.image_path}`" class="w-full h-auto">
                </div>
            </div>
        </Transition>
    </Layout>
</template>

<script setup>
    import { ref } from "vue";
    import Layout from "@/Shared/Layout.vue";
    import Nav from "@/Shared/Nav.vue";
    import DataCards from "@/Shared/DataCards.vue";
    import DataRecentList from "@/Shared/DataRecentList.vue";
    import DetailBackButton from "@/Shared/DetailBackButton.vue";

    const props = defineProps({
        'AllArtLibrary': Object,
        'ArtLibrary': Object,
        'SubArtLibrary': Object,
        'recent': Object,
    });

    const cardDetailData = [
        {
            id: 'title_jp',
            title: 'Title (Romaji)'
        },
        {
            id: 'original',
            title: 'Original',
        },
        {
            id: 'series',
            title: 'Series',
        },
        {
            id: 'studio',
            title: 'Studio',
        },
        {
            id: 'year',
            title: 'Released Year',
        },
        {
            id: 'lang',
            title: 'Language',
        },
        {
            id: 'page',
            title: 'Page',
        },
        {
            id: 'status',
            title: 'Status',
        },
        {
            id: 'desc',
            title: 'Description'
        }
    ];

    const showModal = ref(false)
    const openModal = () => {
        showModal.value = true;
    };
    const closeModal = () => {
      showModal.value = false
    };
</script>

<style scoped>
    .v-enter-active,
    .v-leave-active {
        transition: opacity 0.1s, transform 0.1s;
    }

    .v-enter-from,
    .v-leave-to {
        opacity: 0;
        transform: scale(0.5);
    }

    .v-enter-to,
    .v-leave-from {
        opacity: 1;
        transform: scale(1);
    }
</style>