<template>
    <Layout>
        <div class="pb-12">
            <div class="p-5 sm:px-6 lg:px-8">
                <h2 class="text-[30px] font-bold mb-3 text-gray-200">
                    Art Library Management
                </h2>
                <div class="mb-4 flex w-full">
                    <button class="flex text-center text-gray-200 bg-gray-800 border border-gray-400 p-2 rounded-l-lg hover:bg-gray-700 hover:text-gray-50 focus:border-blue-200" @click=" () => isOpen = true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        &nbsp;
                        <span>Create Data</span>
                    </button>
                    <input type="search" v-model="params.search" aria-label="Search" placeholder="Search..." class="block max-w-sm w-full p-2 rounded-r-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                </div>

                <SettingsTable
                    :ArtLibrary="ArtLibrary"
                    :filters="filters"
                    :params="params"
                    :subDataFunc="subDataFunc"
                    :relatedDataFunc="relatedDataFunc"
                    :editFunc="editFunc"
                    :deleteFunc="deleteFunc"
                />
            </div>
        </div>

        <!--Create and Update Modal-->
        <div v-show="isOpen" class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
            <div class="modal-container bg-white w-11/12 md:max-w-screen-lg mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <div class="modal-content py-4 text-left px-6">
                    <div class="flex justify-between items-center pb-3">
                        <p class="text-2xl font-bold">Create Data Modal!</p>
                        <div class="modal-close cursor-pointer z-50 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" @click="closeModal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>

                    <form @submit.prevent="submit" ref="inputForm" enctype="multipart/form-data">
                        <div class="grid gap-6 mb-6 md:grid-cols-3">
                            <div class="h-[100px] w-[100px] mx-auto rounded-full block bg-center bg-cover bg-gray-100 border border-dashed border-gray-500" :style="{ 'background-image': `url(${previewImage})` }" @click="fileInput.click()"></div>
                            <div class="col-span-2">
                                <label for="image" class="block mb-2 text-sm font-medium text-blue-500 dark:text-white">Cover Image <span class="mt-1 text-xs text-blue-500 dark:text-gray-300" :class="{'text-red-800': form.errors.image_path}">(WebP Format)</span>*</label>
                                <input ref="fileInput" type="file" name="image" @input="pickFile" id="image" accept="image/webp" :class="{'text-red-900 placeholder-red-700 border border-red-500': form.errors.image_path}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <div
                                    v-if="form.errors.image_path"
                                    v-text="form.errors.image_path"
                                    class="text-red-700 text-sm mt-1"
                                >
                                </div>
                            </div>
                            <div>
                                <label for="title_en" class="block mb-2 text-sm font-medium text-blue-500 dark:text-white" :class="{'text-red-800': form.errors.title_en}">Title (English)*</label>
                                <input type="text" id="title_en" v-model="form.title_en" name="title_en" :class="{'text-red-900 placeholder-red-700 border border-red-500': form.errors.title_en}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Shin Evangelion Movie Version Animation Genga Illustration Vol. 1">
                                <div
                                    v-if="form.errors.title_en"
                                    v-text="form.errors.title_en"
                                    class="text-red-700 text-sm mt-1"
                                >
                                </div>
                            </div>
                            <div>
                                <label for="title_jp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title (Romaji)</label>
                                <input type="text" id="title_jp" v-model="form.title_jp" name="title_jp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Shin evu~angerion gekijō-ban animēshon genga-shū jōkan">
                            </div>
                            <div>
                                <label for="original" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Original</label>
                                <input type="text" id="original" v-model="form.original" name="original" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="シン・エヴァンゲリオン劇場版アニメーション原画集 上巻">
                            </div>
                            <div>
                                <label for="series" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Series</label>
                                <input type="text" id="series" v-model="form.series" name="series" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Evangelion: 3.0+1.0 Thrice Upon a Time">
                            </div>
                            <div>
                                <label for="author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Author / Character Designer</label>
                                <input type="text" id="author" v-model="form.author" name="author" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Anno, Moyoco">
                            </div>
                            <div>
                                <label for="studio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Studio</label>
                                <input type="text" id="studio" v-model="form.studio" name="studio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Khara">
                            </div>
                            <div>
                                <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Released Year</label>
                                <input type="text" id="year" name="year" v-model="form.year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="2022">
                            </div>
                            <div>
                                <label for="lang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Language</label>
                                <input type="text" id="lang" name="lang" v-model="form.lang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Japanese">
                            </div>
                            <div>
                                <label for="page" class="block mb-2 text-sm font-medium text-blue-500 dark:text-white" :class="{'text-red-800': form.errors.page}">Page*</label>
                                <input type="number" id="page" name="page" v-model="form.page" :class="{'text-red-900 placeholder-red-700 border border-red-500': form.errors.page}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="352" max="1000" required>
                                <div
                                    v-if="form.errors.page"
                                    v-text="form.errors.page"
                                    class="text-red-700 text-sm mt-1"
                                >
                                </div>
                            </div>
                            <div>
                                <label for="status" class="block mb-2 text-sm font-medium text-blue-500 dark:text-white">Status*</label>
                                <select id="status" v-model="form.status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" selected>Choose a status</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Not Completed">Not Completed</option>
                                </select>
                            </div>
                            <div>
                                <label for="source" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Source</label>
                                <input type="text" id="source" v-model="form.source" name="source" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="http://setteidreams.net/artbooks/">
                            </div>
                            <div>
                                <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <input type="text" id="desc" v-model="form.desc" name="desc" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="300 DPI">
                            </div>
                            <div>
                                <label for="type" class="block mb-2 text-sm font-medium text-blue-500 dark:text-white">Type*</label>
                                <select id="type" v-model="form.type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" selected>Choose a type</option>
                                    <option value="Booklet">Booklet</option>
                                    <option value="Color Design">Color Design</option>
                                    <option value="Illustration Book">Illustration Book</option>
                                    <option value="Production Book">Production Book</option>
                                    <option value="Production Sketches">Production Sketches</option>
                                    <option value="Settei">Settei</option>
                                    <option value="Storyboard">Storyboard</option>
                                </select>
                            </div>
                            <div>
                                <label for="link" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Google Drive Link</label>
                                <input type="text" id="link" v-model="form.link" name="link" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="https://drive.google.com/drive/folders/1EDKTzQu5ztmfmccmSa4AzcTdQRjWJvhE?usp=share_link">
                            </div>
                            <div>
                                <label for="path" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">File Path</label>
                                <input type="text" id="path" v-model="form.path" name="path" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="#">
                            </div>
                        </div>
                        <div class="flex items-start mb-6">
                            <div class="flex items-center h-5">
                                <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" required>
                            </div>
                            <label for="remember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">I agree to input these data.</label>
                        </div>
                        <button type="button" v-if="!editMode" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" @click="() => { form.reset(); inputForm.reset(); previewImage = ''}">Reset</button>
                        <button type="button" v-else class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" @click="() => editFunc(tempArtLib)">Reset</button>
                        <button type="submit" v-if="!editMode" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ml-2" :disabled="form.processing">Submit</button>
                        <button type="submit" v-else class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ml-2" :disabled="form.processing">Update</button>
                    </form>
                </div>
            </div>
        </div>

        <!--Delete Modal-->
        <div v-show="deleteMode" class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
            <div class="modal-container md:max-w-screen-lg mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <div class="relative w-full max-w-md max-h-full mx-auto">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="popup-modal" @click="() => deleteMode = false">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Close modal</span>
                        </button>

                        <form @submit.prevent="submit">
                            <div class="p-6 text-center">
                                <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete <b>"{{ deleteTitle_en }}"</b>?</h3>
                                <button data-modal-hide="popup-modal" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                    Yes, I'm sure
                                </button>
                                <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" @click="() => { deleteMode = false }">No, cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Sub Data Modal-->
        <div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center" v-if="subData">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
            <div class="modal-container bg-white w-1/2 md:max-w-screen-lg mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <div class="modal-content py-4 text-left px-6">
                    <div class="flex justify-between items-center pb-3">
                        <p class="text-2xl font-bold">Sub Data Modal!</p>
                        <button type="button" class="top-3 z-50 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="popup-modal" @click="() => {subData = false; formData.splice(0)}">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Close modal</span>
                        </button>

                    </div>

                    <form @submit.prevent="submitSub" enctype="multipart/form-data">
                        <div class="max-h-[80vh] overflow-y-auto pr-3">
                            <div v-for="(data, index) in formData" :key="index">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white">{{ 'Field Sub Data ' + ++index}}</label>
                                <div class="flex justify-evenly gap-4 mb-3 p-2">
                                    <input v-model="data.title" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Title">
                                    <input v-model="data.sub_desc" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Sub Desc">
                                    <input v-model="data.link" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Link">
                                    <button type="button" v-if="formData.length > 1" @click="() => formData.splice(index-1, 1)" title="Delete" class="hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <button type="button" @click="() => formData.push({'id': formData[0].id,'title': '','sub_desc': '','link': ''})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="blue" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/> <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-center mt-5">
                            <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" @click="() => {let idTemp = formData[0].id; formData.splice(0); subDataFunc(idTemp)}">Reset</button>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ml-2" :disabled="form.processing">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Related Data Modal-->
    </Layout>
</template>

<script setup>
    import Layout from "../Shared/Layout.vue";
    import { debounce } from "lodash/function";
    import {reactive, ref, watch} from "vue";
    import { router, useForm } from "@inertiajs/vue3";
    import SettingsTable from "../Shared/SettingsTable.vue";

    const props = defineProps({
        AllArtLibrary: Object,
        ArtLibrary: Object,
        SubArtLibrary: Object,
        filters: Object,
    });

    // Form Submission Reactive
    const inputForm = ref(null);

    // Check if Edit or Delete Mode
    const editMode = ref(false);
    const deleteMode = ref(false);

    // Delete Modal Title
    const deleteTitle_en = ref(null);

    // Input File Image Reactive
    const previewImage = ref(null);
    const fileInput = ref(null);
    const pickFile = () => {
        const input = fileInput.value;
        const file = input.files;
        if (file && file[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.value = e.target.result;
            };
            reader.readAsDataURL(file[0]);
            form.image_path = file[0];
        }
    };

    // Reactivity for Modal Create
    const isOpen = ref(false);
    const params = reactive({
        search: props.filters.search,
        field: props.filters.field,
        direction: props.filters.direction,
    });

    function closeModal() {
        form.reset();
        inputForm.value.reset();
        previewImage.value = '';
        isOpen.value = false;
        editMode.value = false;
    }

    // Temporary Save Input Value in Form
    const tempArtLib = ref(null);
    const editFunc = (ArtLib) => {
        editMode.value = true;
        tempArtLib.value = ArtLib;

        form.id = ArtLib.id;
        form.title_en = ArtLib.title_en;
        form.title_jp = ArtLib.title_jp;
        form.original = ArtLib.original;
        form.series = ArtLib.series;
        form.author = ArtLib.author;
        form.studio = ArtLib.studio;
        form.year = ArtLib.year;
        form.lang = ArtLib.lang;
        form.page = ArtLib.page
        form.status = ArtLib.status;
        form.source = ArtLib.source;
        form.desc = ArtLib.desc;
        form.type = ArtLib.type;
        form.link = ArtLib.link;
        form.path = ArtLib.path;
        form.image_path = ArtLib.image_path;

        previewImage.value = `/img/library/${ArtLib.image_path}`;
        fileInput.value = ArtLib.image_path;

        isOpen.value = true;
    }

    // Delete Modal Function
    const deleteFunc = (ArtLib) => {
        deleteMode.value = true;
        deleteTitle_en.value = ArtLib.title_en;
        form.id = ArtLib.id;
    }

    // Use for Search or Sorting
    const filterObject = (obj) => {
        const filtered = {};
        for (const key in obj) {
            if (obj[key] !== undefined && obj[key] !== null) {
                filtered[key] = obj[key];
            }
        }
        return filtered;
    };

    const handler = debounce(() => {
        const filteredParams = filterObject(params);
        router.get(props.ArtLibrary.first_page_url, filteredParams, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        });
    }, 150);

    watch(() => params, handler, { deep: true });

    // Form Submission Value
    let form = useForm({
        id: '',
        title_en: '',
        title_jp: '',
        original: '',
        series: '',
        author: '',
        studio: '',
        year: '',
        lang: '',
        page: '',
        status: '',
        source: '',
        desc: '',
        type: '',
        link: '',
        path: '',
        image_path: '',
    });

    let submit = () => {
        if (editMode.value === false && deleteMode.value === false) {
            form.post('/settings-library-create', {
                preserveScroll: true,
                onSuccess: () => {
                    form.reset();
                    inputForm.value.reset();
                    previewImage.value = '';
                    closeModal();
                }
            });
        } else if (editMode.value === true) {
            form.post('/settings-library-update', {
                preserveScroll: true,
                onSuccess: () => {
                    form.reset();
                    inputForm.value.reset();
                    previewImage.value = '';
                    closeModal();
                }
            });
        } else {
            form.delete('/settings-library-destroy', {
                preserveScroll: true,
                onSuccess: () => {
                    deleteMode.value = false;
                }
            });
        }
    };

    // Use for Sub Data Modal
    const subData = ref(false);
    let formData = reactive([]);
    const subDataFunc = (id) => {
        props.SubArtLibrary.forEach((prop) => {
            if (prop.art_library_id === id) {
                formData.push({
                    'id': prop.art_library_id,
                    'title': prop.title,
                    'sub_desc': prop.sub_desc,
                    'link': prop.link,
                });
            }
        });

        subData.value = true;
    }
    let submitSub = () => {
        let requestData = {};
        formData.forEach((data, index) => {
            requestData[`data${index}`] = data;
        });

        router.post('/settings-library-subcreate', requestData, {
            preserveScroll: true,
            onSuccess: () => {
                subData.value = false;
                formData.splice(0);
            }
        });
    }

    // Related Data Modal
    const relatedDataFunc = (id) => {
        console.log(id);
    }
</script>
