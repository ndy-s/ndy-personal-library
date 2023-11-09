<template>

    <div v-show="deleteMode" class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div class="modal-container bg-gray-800 mx-auto rounded shadow-lg z-50 overflow-y-auto border border-green-300">
            <div class="modal-content py-4 text-left px-6">
                <div class="relative">
                    <button 
                        type="button" 
                        class="modal-close text-white cursor-pointer flex items-center justify-center w-6 h-6 ml-auto rounded-full hover:bg-green-400 hover:text-gray-800 transition-colors duration-200"
                        @click="closeDeleteModal()"
                        title="Close Modal"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <form @submit.prevent="submit">
                        <div class="p-4 text-center max-w-lg">
                            <svg aria-hidden="true" class="mx-auto mb-6 text-red-500 w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>

                            <h3 class="mb-8 text-lg font-normal text-white">Confirm deletion of <span class="text-green-400 font-bold">"{{ deleteTitle_en }}"</span>?</h3>

                            <button 
                                type="submit" 
                                class="text-white bg-red-600 rounded-md text-sm font-semibold px-4 py-2.5 text-center mr-4 shadow-md transition-colors duration-200 ease-in-out | hover:bg-red-700 focus:ring-2 focus:outline-none focus:ring-red-300"
                            >
                                Yes, confirm!
                            </button>

                            <button 
                                type="button" 
                                class="text-black bg-white rounded-md text-sm font-semibold px-4 py-2.5 shadow-md transition-colors duration-200 ease-in-out | hover:bg-gray-200 focus:ring-2 focus:outline-none focus:ring-gray-300" 
                                @click="closeDeleteModal()"
                            >
                                No, cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        deleteMode: Boolean,
        deleteTitle_en: String,
        closeDeleteModal: Function,
        submit: Function,
    });
</script>