<template>
    <div v-show="createMode" class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div class="modal-container bg-gray-800 w-11/12 mx-auto rounded shadow-lg z-50 overflow-y-auto border border-green-300">
            <div class="modal-content py-4 text-left px-6">
                <form @submit.prevent="submit(); checkbox = false; fileInput.value = null" enctype="multipart/form-data">
                    <div class="flex justify-between items-center">
                        <p class="text-2xl font-bold text-white border-l-4 border-green-400 pl-4">{{ editMode ? 'Edit' : 'Create' }} Data Modal</p>
                        <button 
                            type="reset"
                            class="modal-close text-white cursor-pointer flex items-center justify-center w-6 h-6 ml-auto rounded-full hover:bg-green-400 hover:text-gray-800 transition-colors duration-200" 
                            @click="closeCreateEditModal()"
                            title="Close Modal"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid gap-6 my-4 md:grid-cols-3">
                        <div 
                            class="h-[100px] w-[100px] mx-auto rounded-full block bg-center bg-cover bg-gray-900 border border-dashed border-green-400" 
                            :style="{ 'background-image': editMode && form.previewImage == tempArtLib.image_path ? `url(img/library/${form.previewImage})` : `url(${form.previewImage})` }"
                            @click="fileInput.click()"
                        ></div>
                        <div class="col-span-2">
                            <label 
                                for="image_path" 
                                class="block mb-2 text-sm font-bold text-white"
                            >
                                Cover Image (WebP) *
                            </label>
                            <input 
                                type="file" 
                                ref="fileInput" 
                                name="image_path" 
                                @input="pickFile" 
                                id="image_path" 
                                accept="image/webp"
                                class="bg-gray-900 border border-green-400 text-white text-sm rounded-md focus:ring-green-100 focus:border-green-100 block w-full p-2.5" 
                                :class="{'placeholder-red-500 border-red-500': form.errors.image_path}"
                                :required="!editMode"
                            >
                            <div
                                v-if="form.errors.image_path"
                                v-text="form.errors.image_path"
                                class="text-red-700 text-sm mt-1"
                            >
                            </div>
                        </div>
                        <ManagementInputField 
                            :form="form"
                            id="title_en"
                            label="Title (English) *"
                            placeholder="Shin Evangelion Movie Version Animation Genga Illustration Vol. 1"
                            @formValue="(val) => form.title_en = val"
                        />
                        <ManagementInputField 
                            :form="form"
                            id="title_jp"
                            label="Title (Romaji)"
                            placeholder="Shin evu~angerion gekijō-ban animēshon genga-shū jōkan" 
                            @formValue="(val) => form.title_jp = val"
                        />
                        <ManagementInputField 
                            :form="form"
                            id="original"
                            label="Original"
                            placeholder="シン・エヴァンゲリオン劇場版アニメーション原画集 上巻" 
                            @formValue="(val) => form.original = val"
                        />                        
                        <ManagementInputField 
                            :form="form"
                            id="series"
                            label="Series"
                            placeholder="Evangelion: 3.0+1.0 Thrice Upon a Time" 
                            @formValue="(val) => form.series = val"
                        />                        
                        <ManagementInputField 
                            :form="form"
                            id="author"
                            label="Author / Character Designer"
                            placeholder="Anno, Moyoco" 
                            @formValue="(val) => form.author = val"
                        />                        
                        <ManagementInputField 
                            :form="form"
                            id="studio"
                            label="Studio"
                            placeholder="Khara" 
                            @formValue="(val) => form.studio = val"
                        />                        
                        <ManagementInputField 
                            :form="form"
                            id="year"
                            label="Released Year"
                            placeholder="2022" 
                            @formValue="(val) => form.year = val"
                        />
                        <ManagementInputField 
                            :form="form"
                            id="lang"
                            label="Language"
                            placeholder="Japanese" 
                            @formValue="(val) => form.lang = val"
                        />
                        <ManagementInputField 
                            :form="form"
                            id="page"
                            label="Page"
                            placeholder="352" 
                            @formValue="(val) => form.page = val"
                        />
                        <ManagementInputField 
                            :form="form"
                            id="status"
                            label="Status *"
                            placeholder="Choose a status" 
                            :options="['Completed', 'Not Completed']"
                            @formValue="(val) => form.status = val"
                        />
                        <ManagementInputField 
                            :form="form"
                            id="source"
                            label="Source"
                            placeholder="http://setteidreams.net/artbooks/" 
                            @formValue="(val) => form.source = val"
                        />
                        <ManagementInputField 
                            :form="form"
                            id="desc"
                            label="Description"
                            placeholder="300 DPI" 
                            @formValue="(val) => form.desc = val"
                        />
                        <ManagementInputField 
                            :form="form"
                            id="type"
                            label="Type *"
                            placeholder="Choose a type" 
                            :options="['Booklet', 'Color Design', 'Illustration Book', 'Production Book', 'Production Sketches', 'Settei', 'Storyboard']"
                            @formValue="(val) => form.type = val"
                        />
                        <ManagementInputField 
                            :form="form"
                            id="link"
                            label="Google Drive Link"
                            placeholder="https://drive.google.com/drive/folders/1EDKTzQu5ztmfmccmSa4AzcTdQRjWJvhE?usp=share_link" 
                            @formValue="(val) => form.link = val"
                        />
                        <ManagementInputField 
                            :form="form"
                            id="path"
                            label="File Path"
                            placeholder="#" 
                            @formValue="(val) => form.path = val"
                        />
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="flex items-center mb-4">
                            <input id="remember" type="checkbox" v-model="checkbox" value="" class="w-4 h-4 border border-green-400 focus:outline-none focus:ring-green-400" required>
                            <label for="remember" class="ml-2 text-sm text-white">I agree to input these data</label>
                        </div>

                        <div class="flex w-[15%] gap-4">
                            <button 
                                :type="editMode ? 'button' : 'reset'" 
                                class="text-white bg-red-600 rounded-md text-sm font-semibold w-full px-4 py-2.5 text-center shadow-md transition-colors duration-200 ease-in-out | hover:bg-red-700 focus:ring-2 focus:outline-none focus:ring-red-300" 
                                @click="editMode ? resetFunc(tempArtLib): form.reset(); checkbox = false; fileInput.value = null"
                            >
                                Reset
                            </button>
                            
                            <button 
                                type="submit" 
                                class="text-white bg-green-600 rounded-md text-sm font-semibold w-full px-4 py-2.5 text-center shadow-md transition-colors duration-200 ease-in-out | hover:bg-green-700 focus:ring-2 focus:outline-none focus:ring-green-300"  
                                :disabled="form.processing"
                            >
                                {{ editMode ? 'Update' : 'Submit' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from "vue";
    import ManagementInputField from '@/Shared/ManagementInputField.vue';

    const props = defineProps({
        createMode: Boolean,
        editMode: Boolean,
        closeCreateEditModal: Function,
        editFunc: Function,
        resetFunc: Function,
        tempArtLib: Object,
        closeModal: Function,
        form: Object,
        submit: Function,
    });

    const fileInput = ref(null);
    const pickFile = () => {
        const input = fileInput.value;
        const file = input.files;
        if (file && file[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                props.form.previewImage = e.target.result;
            };
            reader.readAsDataURL(file[0]);
            props.form.image_path = file[0];
        }
    };

    const checkbox = ref(false);
</script>