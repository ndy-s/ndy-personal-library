<template>
    <Layout>
        <div class="mt-10">
            <div
                class="flex ml-12 w-[70%] z-50 mb-5 transition duration-200 ease-in-out"
                :class="{'fixed top-16 p-2 rounded-b-xl bg-gray-800 bg-opacity-[80%]': isVisible}"
            >
                <select
                    v-model="typeCat"
                    @change="onChange"
                    class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-100 bg-gray-800 border border-gray-500 rounded-l-lg hover:bg-gray-900 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:hover:bg-gray-800 dark:focus:border-blue-500 dark:text-white dark:border-gray-800"
                    title="Category Option"
                >
                    <option
                        value=""
                        selected
                    >No Category</option>
                    <option
                        v-for="(type, index) in types"
                        :key="index"
                        :value="Object.values(type).toString()"
                    >{{ Object.values(type).toString() }}</option>
                </select>
                <div class="relative w-full">
                    <input
                        type="search"
                        v-model="search"
                        class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-l-gray-800  dark:border-gray-800 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                        placeholder="Type to search..."
                        required
                    >
                    <button
                        @click="() => search = ''"
                        class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white rounded-r-lg border bg-gray-800 border-gray-500 focus:ring-2 hover:bg-gray-900 focus:outline-none focus:ring-blue-500 dark:focus:ring-blue-800"
                        title="Clear Search Button"
                        :disabled="search === ''"
                    >
                        <span class="p-1 text-white"><b>&times;</b></span>
                        <span class="sr-only">Clear</span>
                    </button>
                </div>
            </div>

            <div
                class="flex"
                :class="{'mt-24': isVisible}"
            >
                <h1 class="text-white flex text-[30px] font-bold w-[70%] ml-12">
                    Art Library
                    <span
                        class="text-[30px] flex font-normal text-white"
                        v-if="!filteredArtLibraryData.length"
                    >: Data not Found!</span>
                </h1>
                <h1 class="w-[25%] mx-5">
                    <span class="text-white text-[30px] font-bold">Recently Updated</span>
                </h1>
            </div>

            <div class="flex">
                <div class="grid 2xl:grid-cols-4 lg:grid-cols-2 mt-5 gap-8 ml-12 mb-10 w-[70%]">
                    <template
                        v-for="(ArtLib, index) in filteredArtLibraryData"
                        :key="index"
                    >
                        <div class="relative">
                            <div
                                class="relative bg-gray-700 rounded-lg shadow-md transition duration-400 ease-in-out transform"
                                :class="[{'-translate-y-2 shadow-lg': hiddenDivs[index]}]"
                            >
                                <button
                                    @click="typeCat = $event.target.value; onChange();"
                                    class="absolute font-bold text-xs m-2 text-gray-800 border-gray-900 bg-yellow-200 bg-opacity-80 border px-1 start-0 rounded-xl p-1 z-10"
                                    :title="'Category: '+ArtLib.type"
                                    :value="ArtLib.type"
                                >{{ ArtLib.type }}</button>
                                <Link :href="`/art/library/librarydetail-${ArtLib.id}`">
                                    <img
                                        class="w-full h-64 object-cover rounded-t-lg filter grayscale transition duration-300 ease-in-out text-white"
                                        :src="`/img/library/${ArtLib.image_path}`"
                                        loading="lazy"
                                        @load="$event.target.complete ? $event.target.nextElementSibling.classList.add('hidden') : null;"
                                        @mouseover="showHiddenDiv(index, $event)"
                                        @mouseenter.once="infoLoad(index)"
                                        @mouseout="hiddenDivs[index] = false"
                                        :class="[{'filter-none scale-105 shadow-xl': hiddenDivs[index]}]"
                                        alt=""
                                    >
                                    <PulseLoading class="absolute ml-[47%]"/>
                                </Link>
                                <div class="p-4 border-t-8 border-green-400">
                                    <h4
                                        class="font-semibold text-white text-lg line-clamp-2 h-14 cursor-pointer hover:text-green-400 transition duration-400 ease-in-out"
                                        :title="ArtLib.title_en"
                                    ><Link :href="`/art/library/librarydetail-${ArtLib.id}`">{{ ArtLib.title_en }}</Link></h4>
                                </div>
                            </div>
                            <div
                                class="absolute rounded-xl left-3/4 z-10 w-[300px] h-auto right-0 p-3 bg-gray-600 transition duration-300 ease-in-out"
                                :class="[{'top-32': !infoBellow}, {'top-[-100px]': infoBellow}]"
                                v-if="hiddenDivs[index]"
                                @mouseover="hiddenDivs[index] = true"
                                @mouseout="hiddenDivs[index] = false"
                            >
                                <PulseLoading
                                    v-if="showLoader[index]"
                                    class="relative col-span-4 items-center origin-center mx-[49%]"
                                />
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
                                    <table class="text-white text-xs">
                                        <tr>
                                            <td><span class="text-gray-200">Title (Romaji)</span></td>
                                            <td>: {{ ArtLib.title_jp }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-gray-200">Original</span></td>
                                            <td>: {{ ArtLib.original }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-gray-200">Series</span></td>
                                            <td>: {{ ArtLib.series }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-gray-200">Studio</span></td>
                                            <td>: {{ ArtLib.studio }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-gray-200">Released Year</span></td>
                                            <td>: {{ ArtLib.year }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-gray-200">Language</span></td>
                                            <td>: {{ ArtLib.lang }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-gray-200">Page</span></td>
                                            <td>: {{ ArtLib.page }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-gray-200">Status</span></td>
                                            <td>: {{ ArtLib.status }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-gray-200">Description</span></td>
                                            <td>: {{ ArtLib.desc }}</td>
                                        </tr>
                                    </table>
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
                    <PulseLoading
                        class="relative 2xl:col-span-4 lg:col-span-2 mb-10 ml-[49%]"
                        :class="{ 'hidden' : ArtLibrary.current_page === ArtLibrary.last_page }"
                    />
                    <div
                        class="col-span-4 mt-10 flex place-content-center"
                        v-if="!filteredArtLibraryData.length"
                    >
                        <!--Data not found symbol section-->
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
                            <defs></defs>
                            <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                <path d="M 45 90 C 20.187 90 0 69.813 0 45 C 0 20.187 20.187 0 45 0 c 24.813 0 45 20.187 45 45 C 90 69.813 69.813 90 45 90 z M 45 3 C 21.841 3 3 21.841 3 45 c 0 23.159 18.841 42 42 42 c 23.159 0 42 -18.841 42 -42 C 87 21.841 68.159 3 45 3 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                <path d="M 33.734 72.822 c -0.465 0 -0.923 -0.215 -1.216 -0.62 c -0.486 -0.671 -0.336 -1.608 0.335 -2.095 c 8.061 -5.838 16.234 -5.838 24.294 0 c 0.671 0.485 0.821 1.424 0.335 2.095 c -0.485 0.672 -1.425 0.819 -2.095 0.335 c -6.99 -5.061 -13.786 -5.063 -20.775 0 C 34.347 72.729 34.039 72.822 33.734 72.822 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                <path d="M 25.667 40.437 c -1.268 0 -2.536 -0.25 -3.742 -0.751 c -0.765 -0.317 -1.128 -1.195 -0.81 -1.96 c 0.317 -0.765 1.197 -1.127 1.96 -0.81 c 1.668 0.692 3.507 0.693 5.174 0.004 c 1.669 -0.69 2.97 -1.989 3.662 -3.657 c 0.317 -0.766 1.198 -1.127 1.96 -0.81 c 0.765 0.317 1.128 1.195 0.81 1.96 c -1 2.408 -2.877 4.283 -5.286 5.279 C 28.193 40.188 26.93 40.437 25.667 40.437 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                <path d="M 64.333 40.437 c -1.264 0 -2.526 -0.249 -3.729 -0.746 c -2.41 -0.996 -4.287 -2.871 -5.287 -5.279 c -0.317 -0.765 0.046 -1.643 0.811 -1.96 c 0.768 -0.32 1.643 0.045 1.961 0.81 c 0.692 1.668 1.992 2.967 3.661 3.657 c 1.669 0.689 3.506 0.688 5.175 -0.004 c 0.768 -0.318 1.643 0.045 1.961 0.81 c 0.317 0.765 -0.046 1.643 -0.811 1.96 C 66.869 40.186 65.601 40.437 64.333 40.437 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                <circle cx="29.934" cy="50.343999999999994" r="3.794" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                <circle cx="60.064" cy="50.343999999999994" r="3.794" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="top-0 w-[25%] mx-5 mt-5">
                    <div class="bg-gray-700 rounded-xl p-3">
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
                                :href="`/art/library/librarydetail-${subRecent.id}`"
                                class="mx-5 my-auto"
                            >
                                <img
                                    :src="`/img/library/${subRecent.image_path}`"
                                    class="w-[50px] h-[50px] min-w-[50px] min-h-[50px] rounded-lg transition duration-100 ease-in-out text-white hover:scale-110 shadow-xl"
                                    loading="lazy"
                                >
                            </Link>
                            <div class="w-[100%]">
                                <Link
                                    :href="`/art/library/librarydetail-${subRecent.id}`"
                                    class="text-white font-semibold text-sm mb-1 hover:text-green-400 transition duration-400 ease-in-out line-clamp-2"
                                    :title="subRecent.title_en"
                                >{{ subRecent.title_en }}</Link>
                                <div class="flex justify-between">
                                    <p class="text-gray-300 text-[12px]">{{ formatTime(subRecent.updated_at) }}</p>
                                    <button
                                        @click="typeCat = $event.target.value; onChange();"
                                        class="bg-yellow-300 border border-gray-800 px-1 w-fit rounded-lg text-xs mr-1 text-[12px]"
                                        :title="'Category: '+subRecent.type"
                                        :value="subRecent.type"
                                    >{{ subRecent.type }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
<script setup>
    import { onMounted, onUnmounted, ref, watch, computed } from "vue";
    import { router } from "@inertiajs/vue3";
    import { throttle } from "lodash/function";
    import moment from "moment";
    import Layout from "../../Shared/Layout.vue";
    import PulseLoading from "../../Shared/PulseLoading.vue";

    let props = defineProps({
        ArtLibrary: Object,
        types: Object,
        filters: Object,
        recent: Object,
    });

    const isVisible = ref(false);
    const search = ref(props.filters.search);
    let loading = false;
    let typeCat = "";
    const hiddenDivs = ref({});
    const showLoader = ref({});
    const infoBellow = ref({});

    const formatTime = (value) => moment(String(value)).fromNow();

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

    watch(search, debounce(function (value) {
        router.post(props.ArtLibrary.first_page_url, { search: value, type: typeCat }, {
            replace: true,
            preserveScroll: true,
        });

        if (search.value === "") {
            window.addEventListener("scroll", handleScroll);
            filteredData.splice(40, filteredData.length);
        }
    }, 300));

    function onChange() {
        router.post(props.ArtLibrary.first_page_url, { search: search.value, type: typeCat }, {
            replace: true,
            preserveScroll: true,
        });

        if (typeCat === "") {
            window.addEventListener("scroll", handleScroll);
            filteredData.splice(40, filteredData.length);
        }
    }


    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    const handleScroll = throttle(() => {
        let pixelsFromBottom = document.documentElement.offsetHeight - document.documentElement.scrollTop - window.innerHeight;

        if (pixelsFromBottom < 200 && !loading) {
            loading = true;

            if (props.ArtLibrary && props.ArtLibrary.next_page_url) {
                router
                    .post(props.ArtLibrary.next_page_url, {search: search.value, type: typeCat}, {
                        preserveState: true,
                        preserveScroll: true,
                        onSuccess: loading = false,
                        onError: error => {
                            console.error("Failed to load more data:", error);
                            loading = false;
                        }
                    })
            } else {
                loading = false;
            }
        }
    }, 200);

    let filteredData = [];
    const filteredArtLibraryData = computed(() => {
        if (props.ArtLibrary.current_page === 1) {
            filteredData = props.ArtLibrary.data;
        } else {
            filteredData.push(...props.ArtLibrary.data)
        }

        return filteredData;
    });

    onMounted(() => {
        window.addEventListener("scroll", handleScroll);
        window.addEventListener("scroll", () => isVisible.value = document.documentElement.scrollTop > 40);
    });

    onUnmounted(() => {
        window.removeEventListener("scroll", handleScroll);
    });
</script>
