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
                            :style="{ 'background-image': editMode && form.previewImage == tempArtLib.image_path ? `url(img/${imgSrc}/${form.previewImage})` : `url(${form.previewImage})` }"
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
                            v-for="(input, index) in modalInput"
                            :key="index"
                            :form="form"
                            :id="input.id"
                            :label="input.label"
                            :placeholder="input.placeholder"
                            :options="input.options ?? null"
                            @formValue="(val) => form[input.id] = val"
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
        imgSrc: String,
        createMode: Boolean,
        editMode: Boolean,
        closeCreateEditModal: Function,
        editFunc: Function,
        resetFunc: Function,
        tempArtLib: Object,
        closeModal: Function,
        form: Object,
        submit: Function,
        modalInput: Array,
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
