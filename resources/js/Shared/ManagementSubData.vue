<template>
    <div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center z-50" v-if="subData">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div class="modal-container bg-gray-800 w-1/2 mx-auto rounded shadow-lg z-50 overflow-y-auto border border-green-300">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold text-white border-l-4 border-green-400 pl-4">Sub Data Modal</p>
                    <button
                        type="button"
                        class="modal-close text-white cursor-pointer flex items-center justify-center w-6 h-6 ml-auto rounded-full hover:bg-green-400 hover:text-gray-800 transition-colors duration-200"
                        @click="$emit('closeSubData')"
                        title="Close Modal"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="submitSub" enctype="multipart/form-data">
                    <div class="max-h-[70vh] overflow-y-auto pr-4">
                        <div class="mt-2">
                            <label class="block mb-2 text-sm text-white font-bold">Master Data</label>
                            <div class="flex justify-evenly gap-4">
                                <input
                                    type="text"
                                    :value="masterData.title_en"
                                    class="bg-gray-900 border text-white text-sm rounded-md focus:ring-green-100 focus:border-green-100 focus:outline-none block w-full p-2.5 opacity-70 border-white cursor-not-allowed"
                                    placeholder="Title"
                                    disabled
                                >
                                <input
                                    type="text"
                                    :value="masterData.desc"
                                    class="bg-gray-900 border text-white text-sm rounded-md focus:ring-green-100 focus:border-green-100 focus:outline-none block w-full p-2.5 opacity-70 border-white cursor-not-allowed"
                                    placeholder="Sub Desc"
                                    disabled
                                >
                                <input
                                    type="text"
                                    :value="masterData.link"
                                    class="bg-gray-900 border text-white text-sm rounded-md focus:ring-green-100 focus:border-green-100 focus:outline-none block w-full p-2.5 opacity-70 border-white cursor-not-allowed"
                                    placeholder="Link"
                                    disabled
                                >

                                <div class="w-fit h-fit rounded-lg text-sm p-2 ml-auto my-auto bg-white cursor-not-allowed | hover:bg-gray-200 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="16" height="16" viewBox="0 0 24 24">
                                        <path d="M 12 1 C 8.6761905 1 6 3.6761905 6 7 L 6 8 C 4.9 8 4 8.9 4 10 L 4 20 C 4 21.1 4.9 22 6 22 L 18 22 C 19.1 22 20 21.1 20 20 L 20 10 C 20 8.9 19.1 8 18 8 L 18 7 C 18 3.6761905 15.32381 1 12 1 z M 12 3 C 14.27619 3 16 4.7238095 16 7 L 16 8 L 8 8 L 8 7 C 8 4.7238095 9.7238095 3 12 3 z M 12 13 C 13.1 13 14 13.9 14 15 C 14 16.1 13.1 17 12 17 C 10.9 17 10 16.1 10 15 C 10 13.9 10.9 13 12 13 z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div v-for="(data, index) in formData" :key="index" class="mt-2">
                            <label v-if="index != 0" class="block mb-2 text-sm text-white">Fields Sub Data {{ ++index }}</label>
                            <div v-if="index != 0" class="flex justify-evenly gap-4">
                                <input
                                    type="text"
                                    v-model="data.title"
                                    class="bg-gray-900 border border-green-400 text-white text-sm rounded-md focus:ring-green-100 focus:border-green-100 focus:outline-none block w-full p-2.5"
                                    placeholder="Title"
                                >
                                <input
                                    type="text"
                                    v-model="data.sub_desc"
                                    class="bg-gray-900 border border-green-400 text-white text-sm rounded-md focus:ring-green-100 focus:border-green-100 focus:outline-none block w-full p-2.5"
                                    placeholder="Sub Desc"
                                >
                                <input
                                    type="text"
                                    v-model="data.link"
                                    class="bg-gray-900 border border-green-400 text-white text-sm rounded-md focus:ring-green-100 focus:border-green-100 focus:outline-none block w-full p-2.5"
                                    placeholder="Link"
                                >

                                <button
                                    type="button"
                                    @click="() => formData.splice(index-1, 1)"
                                    title="Delete Fields"
                                    class="w-fit h-fit rounded-lg text-sm p-2 ml-auto my-auto bg-red-500 | hover:bg-red-600 transition-colors"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button
                            type="button"
                            @click="() => formData.push({'id': formData[0],'title': '','sub_desc': '','link': ''})"
                            title="Add Fields"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="lightgreen" class="bi bi-plus-circle my-5" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/> <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="flex justify-center gap-4">
                        <button
                            type="button"
                            class="text-white bg-red-600 rounded-md text-sm font-semibold w-[15%] px-4 py-2.5 text-center shadow-md transition-colors duration-200 ease-in-out | hover:bg-red-700 focus:ring-2 focus:outline-none focus:ring-red-300"
                            @click="() => {let idTemp = formData[0]; formData.splice(0); subDataFunc(idTemp)}"
                        >
                            <i class="fas fa-sync-alt"></i>&nbsp; Reset
                        </button>

                        <button
                            type="submit"
                            class="text-white bg-green-600 rounded-md text-sm font-semibold w-[15%] px-4 py-2.5 text-center shadow-md transition-colors duration-200 ease-in-out | hover:bg-green-700 focus:ring-2 focus:outline-none focus:ring-green-300"
                        >
                            <i class="fas fa-check"></i>&nbsp; Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        masterData: Object,
        subData: Boolean,
        formData: Array,
        subDataFunc: Function,
        submitSub: Function,
    });
</script>
