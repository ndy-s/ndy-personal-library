<template>
    <div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center z-50" v-if="uploadData">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div class="modal-container bg-gray-800 w-1/2 mx-auto rounded shadow-lg z-50 overflow-y-auto border border-green-300">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold text-white border-l-4 border-green-400 pl-4">Upload Data Modal</p>
                    <button 
                        type="button" 
                        class="modal-close text-white cursor-pointer flex items-center justify-center w-6 h-6 ml-auto rounded-full hover:bg-green-400 hover:text-gray-800 transition-colors duration-200" 
                        @click="$emit('closeUploadData')"
                        title="Close Modal"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                
                <form @submit.prevent="submitUpload" enctype="multipart/form-data" class="mt-2">
                    <label class="block mb-2 text-sm font-semibold text-white">Excel Data File</label>
                    <input 
                        type="file" 
                        class="bg-gray-900 border border-green-400 text-white text-sm rounded-md focus:ring-green-100 focus:border-green-100 focus:outline-none block w-full p-2.5" 
                        required
                    >
                    <div class="flex justify-center gap-4 mt-4">
                        <button 
                            type="button" 
                            class="text-white bg-green-600 rounded-md text-sm font-semibold w-[15%] px-4 py-2.5 text-center shadow-md transition-colors duration-200 ease-in-out | hover:bg-green-700 focus:ring-2 focus:outline-none focus:ring-green-300" 
                        >
                            Coming Soon
                        </button>
                    </div>
                </form>
            </div>
        </div>
     </div>
</template>

<script setup>
    const props = defineProps({
        uploadData: Boolean,
    });
</script>