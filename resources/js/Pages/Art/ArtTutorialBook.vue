<template>
    <Layout>
        <template #nav>
            <Nav 
                :ArtLibrary="ArtLibrary" 
                :types="types" 
                v-model:search="search" 
                @update:search="val => search = val" 
                v-model:typeCat="typeCat"
                @update:typeCat="(val) => {
                    typeCat = val;
                    onChange();
                }"
                @update:clear="search = ''"
            />
        </template>

        <div class="mt-24">
            <div
                class="flex"
            >
                <h1 class="text-white flex text-[30px] font-bold w-[70%] ml-12 border-l-4 border-green-400 pl-4">
                    Art Tutorial Book
                    <span
                        class="text-[30px] flex font-normal text-white"
                        v-if="!filteredArtLibraryData.length"
                    >: Data not Found!</span>
                </h1>
                <h1 class="w-[25%] mx-5 border-l-4 border-green-400 pl-4">
                    <span class="text-white text-[30px] font-bold">Recently Updated</span>
                </h1>
            </div>

            <div class="flex">
                <DataCards 
                    imgSrc="book"
                    :ArtLibrary="ArtLibrary" 
                    :filteredArtLibraryData="filteredArtLibraryData"
                    @update:typeCat="(val) => {
                        typeCat = val;
                        onChange();
                    }"
                />
                <DataRecentList 
                    imgSrc="book"
                    :recent="recent" 
                    @update:typeCat="(val) => {
                        typeCat = val;
                        onChange();
                    }"
                />
            </div>
        </div>
    </Layout>
</template>

<script setup>
    import { onMounted, onUnmounted, ref, computed, watch } from "vue";
    import { router } from "@inertiajs/vue3";
    import { throttle } from "lodash/function";

    import Layout from "@/Shared/Layout.vue";
    import Nav from "@/Shared/Nav.vue";
    import DataCards from "@/Shared/DataCards.vue";
    import DataRecentList from "@/Shared/DataRecentList.vue";

    let props = defineProps({
        ArtLibrary: Object,
        types: Object,
        filters: Object,
        recent: Object,
    });

    let filteredData = [];
    const filteredArtLibraryData = computed(() => {
        if (props.ArtLibrary.current_page === 1) {
            filteredData = props.ArtLibrary.data;
        } else {
            filteredData.push(...props.ArtLibrary.data)
        }

        return filteredData;
    });

    const search = ref(props.filters.search);
    let typeCat = "";

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

    const loading = ref(false);
    const handleScroll = throttle(() => {
        let pixelsFromBottom = document.documentElement.offsetHeight - document.documentElement.scrollTop - window.innerHeight;

        if (pixelsFromBottom < 200 && !loading.value) {
            loading.value = true;

            if (props.ArtLibrary && props.ArtLibrary.next_page_url) {
                router.post(props.ArtLibrary.next_page_url, {search: search.value, type: typeCat}, {
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess: () => { loading.value = false },
                    onError: error => {
                        console.error("Failed to load more data:", error);
                        loading.value = false;
                    }
                });
            } else {
                loading.value = false;
            }
        }
    }, 200);

    onMounted(() => {
        window.addEventListener("scroll", handleScroll);
    });

    onUnmounted(() => {
        window.removeEventListener("scroll", handleScroll);
    });
</script>