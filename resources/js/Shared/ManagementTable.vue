<template>
    <div class="overflow-x-scroll shadow-md border border-green-300 rounded-lg bg-gray-800">
        <table class="min-w-full divide-y divide-green-300 table-fixed">
            <thead>
                <tr>
                    <ManagementTableHead columnTitle="Action"/>
                    <ManagementTableHead 
                        columnTitle="Title" 
                        tableId="title_en" 
                        :params="params"
                        @sort="(val) => sort(val)" 
                    />
                    <ManagementTableHead 
                        v-for="(head, index) in tableHead" 
                        :key="index"
                        :columnTitle="head.title" 
                        :tableId="head.tableId == 'original' || head.tableId =='type' ? head.tableId : ''" 
                        :params="params"
                        @sort="(val) => sort(val)"
                    />
                </tr>
            </thead>

            <tbody class="divide-y divide-green-800">
                <tr v-if="ArtLibrary.data.length !== 0" v-for="(ArtLib) in ArtLibrary.data" :key="ArtLib.id">
                    <td class="py-2 px-6 text-sm text-gray-200 whitespace-nowrap">
                        <button 
                            @click="subDataFunc(ArtLib.id)" 
                            title="Sub Data Toolbox" 
                            class="rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="lightgreen" class="bi bi-box-seam" viewBox="0 0 16 16">
                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                            </svg>
                        </button>

                        <button 
                            @click="editFunc(ArtLib)" 
                            title="Edit" 
                            class="rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600"
                        >
                            <svg width="18" height="18" stroke-width="1.5" viewBox="0 0 24 24" fill="blue" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.0207 5.82839L15.8491 2.99996L20.7988 7.94971L17.9704 10.7781M13.0207 5.82839L3.41405 15.435C3.22652 15.6225 3.12116 15.8769 3.12116 16.1421V20.6776H7.65669C7.92191 20.6776 8.17626 20.5723 8.3638 20.3847L17.9704 10.7781M13.0207 5.82839L17.9704 10.7781" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button 
                            @click="deleteFunc(ArtLib)" 
                            title="Delete" 
                            class="rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#FF7F7F" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                        </button>
                    </td>
                    <td class="py-3 px-6 whitespace-nowrap">
                        <div class="flex items-center">
                            <ManagementImg :imagePath="ArtLib.image_path" @showFull="(val) => openModal(val)"/>

                            <div class="ml-4">
                                <div class="text-sm font-semibold text-white">
                                    {{ ArtLib.title_en }}
                                </div>
                                <div class="text-sm text-gray-200">
                                    {{ ArtLib.title_jp ?? ArtLib.original}}
                                </div>
                            </div>
                        </div>
                    </td>                    
                    <ManagementTableBody 
                        v-for="(head, index) in tableHead" 
                        :key="index"
                        :columnData="ArtLib[head.tableId]"
                    />
                </tr>
                <tr v-else>
                    <td class="py-6 px-6 text-lg font-semibold text-gray-200 whitespace-nowrap col-span-full text-center" colspan="17">
                        Data Not Found!
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex flex-wrap mt-5 justify-center" v-show="ArtLibrary.links.length > 3">
        <template v-for="(link, key) in ArtLibrary.links" :key="key">
            <div 
                v-if="link.url === null" 
                :key="`${key}-disabled`" 
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 bg-gray-800 text-white border border-green-300 rounded cursor-not-allowed" 
                v-html="link.label"
            />
            <Link 
                v-else 
                :key="key" 
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 bg-gray-800 border border-green-300 text-gray-200 rounded hover:bg-white hover:text-gray-900 hover:border-white" 
                :class="{ 'bg-white text-gray-900 border-white': link.active }" 
                :href="link.url"
            >
                <span v-html="link.label"></span>
            </Link>
        </template>
    </div>

    <Transition>
        <div v-if="showModal" @click="closeModal" class="fixed inset-0 flex items-center justify-center z-50 bg-opacity-50 bg-black transition-all ease-in-out duration-500">
            <div class="bg-white p-4 rounded shadow">
                <img :src="`/img/library/${imagePath}`" class="w-full h-auto">
            </div>
        </div>
    </Transition>
</template>

<script setup>
    import { ref } from "vue";
    import ManagementTableHead from '@/Shared/ManagementTableHead.vue';
    import ManagementTableBody from '@/Shared/ManagementTableBody.vue';
    import ManagementImg from '@/Shared/ManagementImg.vue';

    const props = defineProps({
        ArtLibrary: Object,
        filters: Object,
        params: Object,
        subDataFunc: Function,
        editFunc: Function,
        deleteFunc: Function,
        form: Object,
        tableHead: Object,
    });

    const sort = (field) => {
        props.params.field = field;
        props.params.direction = props.params.direction === 'asc' ? 'desc' : 'asc';
    };

    const showModal = ref(false)
    const imagePath = ref(null);
    const openModal = (path) => {
        imagePath.value = path;
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