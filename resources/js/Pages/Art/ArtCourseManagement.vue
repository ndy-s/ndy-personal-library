<template>
    <Layout>
        <template #nav>
            <Nav />
        </template>

        <div>
            <div class="p-5 mt-8 mx-10 rounded-md">
                <ManagementSearchButton 
                    :params="params"
                    :ArtLibrary="ArtLibrary"
                    :openCreateModal="openCreateModal"
                    :uploadDataModal="uploadDataModal"
                />

                <ManagementTable
                    :ArtLibrary="ArtLibrary"
                    :filters="filters"
                    :params="params"
                    :subDataFunc="subDataFunc"
                    :editFunc="editFunc"
                    :deleteFunc="deleteFunc"
                />
            </div>
        </div>

        <ManagementCreateUpdateModal
            :createMode="createMode"
            :editMode="editMode"
            :closeCreateEditModal="closeCreateEditModal"
            :editFunc="editFunc"
            :tempArtLib="tempArtLib"
            :resetFunc="resetFunc"
            :form="form"
            :submit="submit"
        />

        <ManagementModalDelete 
            :deleteMode="deleteMode"
            :deleteTitle_en="deleteTitle_en"
            :closeDeleteModal="closeDeleteModal" 
            :submit="submit"
        />

        <ManagementSubData 
            :subData="subData"
            :formData="formData"
            :subDataFunc="subDataFunc"
            :submitSub="submitSub"
            @closeSubData="() => { subData = false; formData.splice(0) }"
        />

        <ManagementUploadData 
            :uploadData="uploadData"
            @closeUploadData="() => { uploadData = false }"
        />

        <Notification :successNotification="successNotification" :messageNotification="messageNotification"/>
    </Layout>
</template>

<script setup>
    import { reactive, ref, watch } from "vue";
    import { router, useForm } from "@inertiajs/vue3";
    import { debounce } from "lodash/function";

    import Layout from "@/Shared/Layout.vue";
    import Nav from "@/Shared/Nav.vue";
    import Notification from "@/Shared/Notification.vue";
    import ManagementSearchButton from "@/Shared/ManagementSearchButton.vue";
    import ManagementTable from "@/Shared/ManagementTable.vue";
    import ManagementCreateUpdateModal from "@/Shared/ManagementCreateUpdateModal.vue";
    import ManagementModalDelete from "@/Shared/ManagementModalDelete.vue";
    import ManagementSubData from "@/Shared/ManagementSubData.vue";
    import ManagementUploadData from "@/Shared/ManagementUploadData.vue";

    const props = defineProps({
        AllArtLibrary: Object,
        ArtLibrary: Object,
        SubArtLibrary: Object,
        filters: Object,
    });

    const params = reactive({
        search: props.filters.search,
        field: props.filters.field,
        direction: props.filters.direction,
    });

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
        previewImage: '',
    });

    const submit = () => {
        if (!buttonClicked.value) {
            if (editMode.value === false && deleteMode.value === false) {
                form.post('art-library-management-create', {
                    preserveScroll: true,
                    onSuccess: () => {
                        form.reset();
                        closeCreateEditModal();

                        messageNotification.value = 'Created Sucessfully'
                        successNotification.value = true;
                        setTimeout(() => {
                            successNotification.value = false;
                        }, 3000);
                    }
                });
            } else if (editMode.value === true) {
                form.post('art-library-management-update', {
                    preserveScroll: true,
                    onSuccess: () => {
                        form.reset();
                        closeCreateEditModal();

                        messageNotification.value = 'Edited Sucessfully'
                        successNotification.value = true;
                        setTimeout(() => {
                            successNotification.value = false;
                        }, 3000);
                    }
                });
            } else {
                buttonClicked.value = true;
                form.delete('art-library-management-destroy', {
                    preserveScroll: true,
                    onSuccess: () => {
                        buttonClicked.value = false;
                        deleteMode.value = false;

                        messageNotification.value = 'Deleted Sucessfully'
                        successNotification.value = true;
                        setTimeout(() => {
                            successNotification.value = false;
                        }, 3000);
                    }
                });
            }
        }
    };

    const openCreateModal = () => createMode.value = true;
    const closeCreateEditModal = () => {
        form.reset();
        createMode.value = false;
        editMode.value = false;
    };
    
    // Create Modal Code
    const createMode = ref(false);

    // Edit Modal Code
    const editMode = ref(false);
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
        form.previewImage = ArtLib.image_path;

        createMode.value = true;
    }

    const resetFunc = (ArtLib) => {
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
        form.previewImage = ArtLib.image_path;
    };

    // Delete Modal Code
    const buttonClicked = ref(false);
    const deleteMode = ref(false);
    const deleteTitle_en = ref(null);

    const deleteFunc = (ArtLib) => {
        deleteMode.value = true;
        deleteTitle_en.value = ArtLib.title_en;
        form.id = ArtLib.id;
    };

    const closeDeleteModal = () => deleteMode.value = false;

    // Sub Data Modal Code
    const subData = ref(false);
    const formData = reactive([]);
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
    };

    const submitSub = () => {
        let requestData = {};
        formData.forEach((data, index) => {
            requestData[`data${index}`] = data;
        });

        router.post('art-library-management-subcreate', requestData, {
            preserveScroll: true,
            onSuccess: () => {
                subData.value = false;
                formData.splice(0);

                messageNotification.value = 'Added Sucessfully'
                successNotification.value = true;
                setTimeout(() => {
                    successNotification.value = false;
                }, 3000);
            }
        });
    };

    // Upload Data Modal
    const uploadData = ref(false);
    const uploadDataModal = () => {
        uploadData.value = true;
    };

    // Notification
    const successNotification = ref(false);
    const messageNotification = ref('No message');
</script>
