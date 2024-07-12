<template>
    <Layout>
        <template #nav>
            <Nav />
        </template>

        <div>
            <div class="p-5 mt-8 mx-10 rounded-md">
                <ManagementSearchButton
                    title="Art Course Management"
                    :params="params"
                    :ArtLibrary="ArtLibrary"
                    :openCreateModal="openCreateModal"
                    :uploadDataModal="uploadDataModal"
                />

                <ManagementTable
                    imgSrc="course"
                    :ArtLibrary="ArtLibrary"
                    :SubArtLibrary="SubArtLibrary.map(sub => {
                        return {
                            ...sub,
                            master_id: sub.art_course_id
                        };
                    })"
                    :filters="filters"
                    :params="params"
                    :subDataFunc="subDataFunc"
                    :editFunc="editFunc"
                    :deleteFunc="deleteFunc"
                    :tableHead="tableHead"
                />
            </div>
        </div>

        <ManagementCreateUpdateModal
            imgSrc="course"
            :createMode="createMode"
            :editMode="editMode"
            :closeCreateEditModal="closeCreateEditModal"
            :editFunc="editFunc"
            :tempArtLib="tempArtLib"
            :resetFunc="resetFunc"
            :form="form"
            :submit="submit"
            :modalInput="modalInput"
        />

        <ManagementModalDelete
            :deleteMode="deleteMode"
            :deleteTitle_en="deleteTitle_en"
            :closeDeleteModal="closeDeleteModal"
            :submit="submit"
        />

        <ManagementSubData
            :masterData="masterData"
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

    const tableHead = [
        {
            title: 'Title',
            tableId: 'title_en'
        },
        {
            title: 'Publisher',
            tableId: 'publisher'
        },
        {
            title: 'Author',
            tableId: 'author',
        },
        {
            title: 'Year',
            tableId: 'year',
        },
        {
            title: 'Language',
            tableId: 'lang',
        },
        {
            title: 'Status',
            tableId: 'status',
        },
        {
            title: 'Video',
            tableId: 'video',
        },
        {
            title: 'Source',
            tableId: 'source',
        },
        {
            title: 'Description',
            tableId: 'desc',
        },
        {
            title: 'Link',
            tableId: 'link',
        },
        {
            title: 'File Path',
            tableId: 'path',
        },
        {
            title: 'Image Path',
            tableId: 'image_path'
        }
    ];

    const modalInput = [
        {
            id: 'title_en',
            label: 'Title (English) *',
            placeholder: 'Learn Step by Step from the Basics of Composition to Production.',
        },
        {
            id: 'original',
            label: 'Original',
            placeholder: '段階別に学ぶ作曲の基本から制作まで',
        },
        {
            id: 'publisher',
            label: 'Publisher',
            placeholder: 'Coloso',
        },
        {
            id: 'author',
            label: 'Author',
            placeholder: 'Music Producer, Luna',
        },
        {
            id: 'year',
            label: 'Released Year',
            placeholder: '2023',
        },
        {
            id: 'lang',
            label: 'Language',
            placeholder: 'Japanese',
        },
        {
            id: 'video',
            label: 'Total Video',
            placeholder: '32',
        },
        {
            id: 'status',
            label: 'Status *',
            placeholder: 'Choose a status',
            options: ['Completed', 'Not Completed'],
        },
        {
            id: 'source',
            label: 'Source',
            placeholder: 'https://coloso.jp/products/musicproducer-luna-jp',
        },
        {
            id: 'desc',
            label: 'Description',
            placeholder: '1080p',
        },
        {
            id: 'link',
            label: 'Google Drive Link',
            placeholder: 'https://drive.google.com/drive/folders/1EDKTzQu5ztmfmccmSa4AzcTdQRjWJvhE?usp=share_link',
        },
        {
            id: 'path',
            label: 'File Path',
            placeholder: '#',
        },
    ]

    const params = reactive({
        search: props.filters.search,
        field: props.filters.field,
        direction: props.filters.direction,
    });

    // Form Submission Value
    let form = useForm({
        id: '',
        title_en: '',
        original: '',
        publisher: '',
        author: '',
        year: '',
        lang: '',
        video: '',
        status: '',
        source: '',
        desc: '',
        link: '',
        path: '',
        image_path: '',
        previewImage: '',
    });

    const submit = () => {
        if (!buttonClicked.value) {
            if (editMode.value === false && deleteMode.value === false) {
                // Handle image processing before form submission
                processImage(() => {
                    form.post('art-course-management-create', {
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
                });
            } else if (editMode.value === true) {
                // Handle image processing before form submission
                processImage(() => {
                    form.post('art-course-management-update', {
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
                });
            } else {
                buttonClicked.value = true;
                form.delete('art-course-management-destroy', {
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

    // Function to handle image processing before form submission
    const processImage = (callback) => {
        if (form.image_path instanceof File) {
            const imageFile = form.image_path;
            const reader = new FileReader();

            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    // Calculate new dimensions maintaining aspect ratio based on height
                    const maxHeight = 720;
                    let width = img.width;
                    let height = img.height;

                    if (height > maxHeight) {
                        width *= maxHeight / height;
                        height = maxHeight;
                    }

                    canvas.width = width;
                    canvas.height = height;

                    // Draw image on canvas
                    ctx.drawImage(img, 0, 0, width, height);

                    // Convert canvas to WebP and set quality
                    canvas.toBlob((blob) => {
                        const webpBlob = new File([blob], 'image.webp', { type: 'image/webp' });
                        form.image_path = webpBlob;

                        // Call the callback function after image processing
                        if (typeof callback === 'function') {
                            callback();
                        }
                    }, 'image/webp', 0.9); // 0.9 is the quality (90%)
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(imageFile);
        } else {
            // No image selected, directly call the callback function
            if (typeof callback === 'function') {
                callback();
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
        form.original = ArtLib.original;
        form.publisher = ArtLib.publisher;
        form.author = ArtLib.author;
        form.year = ArtLib.year;
        form.lang = ArtLib.lang;
        form.video = ArtLib.video
        form.status = ArtLib.status;
        form.source = ArtLib.source;
        form.desc = ArtLib.desc;
        form.link = ArtLib.link;
        form.path = ArtLib.path;
        form.image_path = ArtLib.image_path;
        form.previewImage = ArtLib.image_path;

        createMode.value = true;
    }

    const resetFunc = (ArtLib) => {
        form.id = ArtLib.id;
        form.title_en = ArtLib.title_en;
        form.original = ArtLib.original;
        form.publisher = ArtLib.publisher;
        form.author = ArtLib.author;
        form.year = ArtLib.year;
        form.lang = ArtLib.lang;
        form.video = ArtLib.video
        form.status = ArtLib.status;
        form.source = ArtLib.source;
        form.desc = ArtLib.desc;
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
    let masterData = null;
    const subDataFunc = (id) => {
        formData.push(id);
        props.SubArtLibrary.forEach((prop) => {
            if (prop.art_course_id === id) {
                formData.push({
                    'id': prop.art_course_id,
                    'title': prop.title,
                    'sub_desc': prop.sub_desc,
                    'link': prop.link,
                });
            }
        });

        [masterData] = props.ArtLibrary.data.filter((lib) => lib.id == id);
        subData.value = true;
    };

    const submitSub = () => {
        if (!buttonClicked.value) {
            buttonClicked.value = true;
            let requestData = {};
            formData.forEach((data, index) => {
                if (index == 0) requestData['masterId'] = data;
                requestData[`data${index}`] = data;
            });

            router.post('art-course-management-subcreate', requestData, {
                preserveScroll: true,
                onSuccess: () => {
                    buttonClicked.value = false;
                    subData.value = false;
                    formData.splice(0);

                    messageNotification.value = 'Added Sucessfully'
                    successNotification.value = true;
                    setTimeout(() => {
                        successNotification.value = false;
                    }, 3000);
                }
            });
        }
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
