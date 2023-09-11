<template>
    <div class="overflow-x-scroll bg-white shadow-md sm:rounded-lg">
        <div class="flex flex-col">
            <div class="inline-block min-w-full align-middle">
                <div class="border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead class="bg-gray-700">
                            <tr>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Sub Data
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Action
                                </th>
                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('title_en')">
                                        Title
                                        <svg v-if="params.field === 'title_en' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                        </svg>
                                        <svg v-if="params.field === 'title_en' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                        </svg>
                                    </span>
                                </th>
                                <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('original')">
                                        Original
                                        <svg v-if="params.field === 'original' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                        </svg>
                                        <svg v-if="params.field === 'original' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                        </svg>
                                    </span>
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Series
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Author
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Studio
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Year
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Language
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Page
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Status
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Source
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Description
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Type
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Link
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    File Path
                                </th>
                                <th scope="col" class="py-3 px-6 w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                    Image Path
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-if="ArtLibrary.data.length !== 0" v-for="(ArtLib, index) in ArtLibrary.data" :key="ArtLib.id">
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                <button @click="subDataFunc(ArtLib.id)" title="Sub Data Toolbox" class="hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-box-seam" viewBox="0 0 16 16">
                                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                                    </svg>
                                </button>
                                <button @click="relatedDataFunc(ArtLib.id)" title="Related Data Toolbox" class="hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-box-seam" viewBox="0 0 16 16">
                                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                                    </svg>
                                </button>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                <button @click="editFunc(ArtLib)" title="Edit" class="hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                                    <svg width="18" height="18" stroke-width="1.5" viewBox="0 0 24 24" fill="yellow" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.0207 5.82839L15.8491 2.99996L20.7988 7.94971L17.9704 10.7781M13.0207 5.82839L3.41405 15.435C3.22652 15.6225 3.12116 15.8769 3.12116 16.1421V20.6776H7.65669C7.92191 20.6776 8.17626 20.5723 8.3638 20.3847L17.9704 10.7781M13.0207 5.82839L17.9704 10.7781" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                                &nbsp;
                                <button @click="deleteFunc(ArtLib)" title="Delete" class="hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </button>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10">
                                        <img class="w-10 h-10 rounded-full" :src="`/img/library/${ArtLib.image_path}`" alt=""/>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ ArtLib.title_en }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ ArtLib.title_jp }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.original }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.series }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.author }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.studio }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.year }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.lang }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.page }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.status }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.source }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.desc }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.type }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.link }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.path }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                {{ ArtLib.image_path }}
                            </td>
                        </tr>
                        <tr v-else>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap col-span-full text-center" colspan="17">
                                Data not Found!
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap -mb-1 justify-center my-2" v-show="ArtLibrary.links.length > 3">
        <template v-for="(link, key) in ArtLibrary.links" :key="key">
            <div v-if="link.url === null" :key="`${key}-disabled`" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-white border rounded" v-html="link.label"/>
            <Link v-else :key="key" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white hover:text-gray-900 text-gray-200" :class="{ 'bg-white text-gray-900': link.active }" :href="link.url">
                <span v-html="link.label"></span>
            </Link>
        </template>
    </div>
</template>

<script setup>
    const props = defineProps({
        ArtLibrary: Object,
        filters: Object,
        params: Object,
        subDataFunc: Function,
        relatedDataFunc: Function,
        editFunc: Function,
        deleteFunc: Function,
        form: Object,
    });

    const sort = (field) => {
        props.params.field = field;
        props.params.direction = props.params.direction === 'asc' ? 'desc' : 'asc';
    };
</script>
