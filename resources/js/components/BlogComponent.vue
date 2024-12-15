<template>
    <div class="app-container">
        <div class="container">

            <div class="header">
                <h2>{{ $t('dashboard.title') }}</h2>
                <div class="select_language">
                    <select v-model="currentLanguage" @change="changeLanguage">
                        <option value="en">English</option>
                        <option value="ru">Русский</option>
                        <option value="uz">O'zbekcha</option>
                    </select>
                </div>

            </div>
            <button @click="openAddModal" class="create-service">
                <i class="fa fa-plus"></i> {{ $t('dashboard.addBlog') }}
            </button>
            <!-- Search Form -->
            <form @submit.prevent="fetchBlogs" class="search-form">
                <div class="search-input-wrapper">
                    <input
                        type="search"
                        v-model="searchQuery"
                        :placeholder="$t('dashboard.searchPlaceholder')"
                        required
                    />
                </div>
            </form>

            <!-- Blog Cards -->
            <div class="blog-card">
                <div v-for="(blog, index) in Blog" :key="blog.id" class="card">
                    <img :src="getMainImage(blog.images)" alt="Main Blog Image" class="card-image" />
                    <div class="card-content">
                        <h3>{{ blog.title }}</h3>
                        <p>{{ blog.text}}</p>
                    </div>
                    <div class="card-buttons">
                        <button @click="openEditModal(blog.id)" class="edit-button">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button @click="openDeleteModal(blog.id)" class="delete-button">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <Teleport to="body">
        <div v-if="showModal" class="modal-overlay">
            <div class="modal">
                <h3>{{ modalTitle }}</h3>
                <div class="lang_buttons">
                    <button
                        v-for="lang in Object.keys(form.title)"
                        :key="lang"
                        :class="{ active: formLanguage === lang }"
                        @click="formLanguage = lang">
                        {{ lang.toUpperCase() }}
                    </button>
                </div>
                <form @submit.prevent="submitForm">
                    <div>
                        <input
                            class="input"
                            autocomplete="off"
                            v-model="form.title[formLanguage]"
                            :placeholder="$t('modal.titlePlaceholder')"
                            required
                        />
                        <textarea
                            rows="3"
                            class="input"
                            autocomplete="off"
                            v-model="form.text[formLanguage]"
                            :placeholder="$t('modal.contentPlaceholder')"
                            required
                        />

                    </div>
                    <input type="file" id="file" ref="file" class="input" multiple @change="handleFileChange($event, 1)" />

                    <!-- Image Previews -->
                    <div v-if="form.images.length > 0" class="image-previews">
                        <div v-for="(image, index) in form.images" :key="index" class="image-preview">
                            <div class="image-card">
                                <div class="card-image-preview">
                                    <img v-if="image.image_url"
                                         :src="image.image_url"
                                         alt="Preview Image"
                                         class="preview-img"
                                         @dragstart="dragStart(index,1)"
                                         @dragover.prevent
                                         @drop="drop(index,1)"
                                         draggable="true"
                                    />
                                    <img v-if="image.url"
                                         :src="image.url"
                                         alt="Preview Image"
                                         class="preview-img"
                                         @dragstart="dragStart(index,1)"
                                         @dragover.prevent
                                         @drop="drop(index,1)"
                                         draggable="true"
                                    />
                                </div>
                                <div class="image-card-actions">
                                    <button class="icon-1" @click="unsetMainImage(index,1)" v-if="image.index === 1">
                                        <i class="fa fa-arrow-up"></i>
                                    </button>
                                    <button v-if="image.index === 0" @click="setMainImage(index,1)">
                                        <i class="fa fa-arrow-up"></i>
                                    </button>
                                    <button @click="removeImage(index,1)"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-buttons">
                        <button @click="closeModal" type="button">{{ $t('dashboard.cancel') }}</button>
                        <button type="submit">{{ $t('dashboard.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </Teleport>
<!--    Edit Modal-->
    <Teleport to="body">
        <div v-if="showEditModal" class="modal-overlay">
            <div class="modal">
                <h3>{{ modalTitle }}</h3>
                <div class="lang_buttons">
                    <button
                        v-for="lang in Object.keys(editBlog.title)"
                        :key="lang"
                        :class="{ active: formLanguage === lang }"
                        @click="formLanguage = lang">
                        {{ lang.toUpperCase() }}
                    </button>
                </div>
                <form @submit.prevent="submitEditForm">
                    <div>
                        <input
                            class="input"
                            autocomplete="off"
                            v-model="editBlog.title[formLanguage]"
                            :placeholder="$t('modal.titlePlaceholder')"
                            required
                        />
                        <textarea
                            rows="3"
                            class="input"
                            autocomplete="off"
                            v-model="editBlog.text[formLanguage]"
                            :placeholder="$t('modal.contentPlaceholder')"
                            required
                        />

                    </div>
                    <input type="file" id="file" ref="file" class="input" multiple @change="handleFileChange($event, 2)" />

                    <!-- Image Previews -->
                    <div v-if="editBlog.images.length > 0" class="image-previews">
                        <div v-for="(image, index) in editBlog.images" :key="index" class="image-preview">
                            <div class="image-card">
                                <div class="card-image-preview">
                                    <img v-if="image.image_url"
                                         :src="image.image_url"
                                         alt="Preview Image"
                                         class="preview-img"
                                         @dragstart="dragStart(index,2)"
                                         @dragover.prevent
                                         @drop="drop(index,2)"
                                         draggable="true"
                                    />
                                    <img v-if="image.url"
                                         :src="image.url"
                                         alt="Preview Image"
                                         class="preview-img"
                                         @dragstart="dragStart(index,2)"
                                         @dragover.prevent
                                         @drop="drop(index,2)"
                                         draggable="true"
                                    />
                                </div>
                                <div class="image-card-actions">
                                    <button class="icon-1" @click="unsetMainImage(index,2)" v-if="image.index === 1">
                                        <i class="fa fa-arrow-up"></i>
                                    </button>
                                    <button v-if="image.index === 0" @click="setMainImage(index,2)">
                                        <i class="fa fa-arrow-up"></i>
                                    </button>
                                    <button @click="removeImage(index,2)"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-buttons">
                        <button @click="closeEditModal" type="button">{{ $t('dashboard.cancel') }}</button>
                        <button type="submit">{{ $t('dashboard.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </Teleport>

    <!-- Delete Confirmation Modal -->
    <Teleport to="body">
        <div v-if="showDeleteModal" class="modal-overlay-delete">
            <div class="modal">
                <h3>{{ $t('dashboard.confirmDeleteTitle') }}</h3>
                <p>{{ $t('dashboard.confirmDelete') }}</p>
                <div class="modal-buttons">
                    <button @click="closeDeleteModal">{{ $t('dashboard.cancel') }}</button>
                    <button @click="confirmDelete">{{ $t('dashboard.delete') }}</button>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { ref, reactive, onMounted, watch } from 'vue';
import axios from 'axios';
import { useI18n } from 'vue-i18n';

defineProps({
    locale: {
        type: String,
        required: true
    },
        urls: {
        type: Object,
        required: true
    }
});

const { t,locale } = useI18n();
const currentLanguage = ref('en');
const formLanguage = ref('en');
const searchQuery = ref('');
const Blog = ref([]);
const showModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const modalTitle = ref(t('modal.addBlogTitle'));
const selectedBlogId = ref(null);
const filteredBlogs = ref([]);
const form = reactive({
    id: null,
    title: {en:'',ru:'',uz:''},
    text: {en:'',ru:'',uz:''},
    images: [],
});
const editBlog = reactive({
    id: null,
    title: {},
    text: {},
    images: [],
});

const changeLanguage = () => {
    locale.value = currentLanguage.value;
    const currentUrl = window.location.pathname;
    const localizedUrl = `/${currentLanguage.value}${currentUrl.replace(/^\/(en|ru|uz)/, '')}`;
    history.pushState(null, '', localizedUrl);
};
const handleFileChange = (event,number) => {
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        // console.log(file);
        const reader = new FileReader();
        reader.onload = (e) => {
            if(number === 1){
                form.images.push({
                    file: file,
                    image_url: e.target.result,
                    index: 0
                });
                // console.log(form.images)
            }
            if(number === 2){
                editBlog.images.push({
                    file: file,
                    image_url: e.target.result,
                    index: 0
                });
                // console.log(editBlog.images)
            }

        };
        // console.log(form.images);
        reader.readAsDataURL(file);
    }
};

const openAddModal = () => {
    showModal.value = true;
    modalTitle.value = t('modal.addBlogTitle');
    form.title = {en:'',ru:'',uz:''};
    form.text  = {en:'',ru:'',uz:''};
    form.images = [];
    formLanguage.value = currentLanguage.value;
};

const getMainImage = (images) => {
    if (Array.isArray(images)) {
        const mainImage = images.find(image => image.index === 1);
        return mainImage ? mainImage.url : '';
    }
    return '';
};

const openEditModal = async (id) => {
    try {
        showEditModal.value = true;
        modalTitle.value = t('modal.editBlogTitle');
        const response = await axios.get(`/api/${id}/blog`);
        editBlog.id = response.data.data.id;
        editBlog.title = response.data.data.title;
        editBlog.text = response.data.data.text;
        editBlog.images = response.data.data.images;
        // console.log(editBlog.images)
        formLanguage.value = currentLanguage.value;
    } catch (error) {
        console.error('Error fetching blog details:', error);
    }
};

const closeModal = () => {
    showModal.value = false;
    form.id = null;
    form.title = {en:'',ru:'',uz:''};
    form.text  = {en:'',ru:'',uz:''};
    form.images = [];
};
const closeEditModal = () => {
    showEditModal.value = false;
    editBlog.id  = null
    editBlog.title  = {}
    editBlog.text  = {}
    editBlog.images  = [];
};

const openDeleteModal = (blogId) => {
    showDeleteModal.value = true;
    selectedBlogId.value = blogId;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
};

const removeImage = (index,number) => {
    if(number === 1){
        form.images.splice(index, 1);
    }
    if(number === 2){
        editBlog.images.splice(index, 1);
    }
};
const setMainImage = (index,number) => {
    if(number === 1){
        form.images.forEach((image, i) => {
            image.index = i === index ? 1 : 0;
            // console.log(image.index);
        });
    }
    if(number === 2){
        editBlog.images.forEach((image, i) => {
            image.index = i === index ? 1 : 0;
            // console.log(image.index);
        });
    }

};
const unsetMainImage = (index,number) => {
    if(number === 1){
        if (form.images[index]) {
            form.images[index].index = 0;
        }
    }
    if(number === 2){
        if (editBlog.images[index]) {
            editBlog.images[index].index = 0;
        }
    }
};

const submitForm = () => {
    const formData = new FormData();
    Object.keys(form.title).forEach((lang) => {
        formData.append(`title[${lang}]`, form.title[lang]);
        formData.append(`text[${lang}]`, form.text[lang]);
    });
    form.images.forEach((image, index) => {
        if (image.file) {
            formData.append(`images[${index}][file]`, image.file);
        }
        formData.append(`images[${index}][url]`, image.url);
        formData.append(`images[${index}][index]`, image.index);
    });
    const method = 'post';
    const url = form.id ? `/blog/${form.id}` : '/blog';
    axios({
        method,
        url,
        data: formData,
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    })
        .then((response) => {
            closeModal();
            fetchBlogs();
            resetForm();
        })
        .catch((error) => {
            console.error('Error submitting form:', error);
        });
};
const submitEditForm = () => {
    const formData = new FormData();
    Object.keys(editBlog.title).forEach((lang) => {
        formData.append(`title[${lang}]`, editBlog.title[lang]);
        formData.append(`text[${lang}]`, editBlog.text[lang]);
    });
    editBlog.images.forEach((image, index) => {
        if (image.file) {
            formData.append(`images[${index}][file]`, image.file);
        }
        formData.append(`images[${index}][url]`, image.url);
        formData.append(`images[${index}][index]`, image.index);
    });
    const method = 'post';
    const url = editBlog.id ? `/blog/${editBlog.id}` : '/blog';
    axios({
        method,
        url,
        data: formData,
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    })
        .then((response) => {
            closeEditModal();
            fetchBlogs();
        })
        .catch((error) => {
            console.error('Error submitting form:', error);
        });
};

const resetForm = () => {
    form.id = null;
    form.title = { en: '', ru: '', uz: '' };
    form.text = { en: '', ru: '', uz: '' };
    form.images = [];
};

const dragStart = (index,number) => {
    if(number===1){
        form.draggedIndex = index;
    }
    if(number===2){
        editBlog.draggedIndex = index;
    }
};
const drop = (index,number) => {
    if(number===1){
        const draggedImage = form.images[form.draggedIndex];
        form.images.splice(form.draggedIndex, 1);
        form.images.splice(index, 0, draggedImage);
        form.draggedIndex = null;
    }
    if(number===2){
        const draggedImage = editBlog.images[editBlog.draggedIndex];
        editBlog.images.splice(editBlog.draggedIndex, 1);
        editBlog.images.splice(index, 0, draggedImage);
        editBlog.draggedIndex = null;
    }
};
const fetchBlogs = () => {
    axios
        .get(`/api/get-blogs?lang=${currentLanguage.value}&search=${searchQuery.value}`)
        .then((response) => {
            Blog.value = response.data.data.data;
            updateFilteredBlogs();
        })
        .catch((error) => console.error(error));
};
const updateFilteredBlogs = () => {
    filteredBlogs.value = Blog.value.map((blog) => ({
        id: blog.id,
        title: blog.title[currentLanguage.value] || '',
        text: blog.text[currentLanguage.value] || '',
        images: blog.images,
    }));
};
const confirmDelete = () => {
    axios
        .delete(`/blog/${selectedBlogId.value}`)
        .then(() => {
            closeDeleteModal();
            fetchBlogs();
        })
        .catch((error) => console.error(error));
};
onMounted(() => {
    fetchBlogs();
});
watch(searchQuery, () => {fetchBlogs();});
watch(currentLanguage, fetchBlogs);
watch(currentLanguage, () => {
    if (!showModal.value) {
        formLanguage.value = currentLanguage.value;
    }
});
</script>

<style scoped>

.input {
    border: none;
    outline: none;
    border-radius: 5px;
    width: 100%;
    margin-bottom: 25px;
    padding: 1em;
    background-color: #ffffff;
    box-shadow: inset 2px 5px 10px rgba(0,0,0,0.3);
    transition: 300ms ease-in-out;
}

.input:focus {
    background-color: white;
    transform: scale(1.03);
    box-shadow: 13px 13px 100px #969696,
    -13px -13px 100px #ffffff;
}

/* Container Styling */
.app-container {
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #f0f2f5, #dfe9f3);
    padding: 20px;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
.container {
    max-width: 1200px;
    width: 100%;
    margin-bottom: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

/* Header Styling */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    color: #333;
}
.header h2 {
    font-size: 2rem;
    font-weight: bold;
    text-transform: uppercase;
    color: #444;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}
.create-service {
    display: inline-flex;
    align-items: center;
    border: none;
    background: linear-gradient(45deg, #4c9bef, #0078d4);
    color: #fff;
    padding: 10px 15px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
}
.create-service:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 5px 15px rgba(0, 120, 212, 0.3);
}


.select_language {
    margin-right: 20px;
}

.select_language select {
    padding: 8px 12px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

.select_language select:focus {
    border-color: #007bff;
    background-color: #e6f0ff;
    outline: none;
}

/* Search Form */
.search-form {
    max-width: 600px;
    margin: 0 auto 20px;
}

.search-input-wrapper {
    position: relative;
}
.search-input-wrapper input {
    width: 100%;
    padding: 12px 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    background-color: #f7f7f7;
    font-size: 1rem;
    box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}
.search-input-wrapper input:focus {
    border-color: #0078d4;
    box-shadow: 0 0 5px rgba(0, 120, 212, 0.3);
}

/* Blog Cards */
.blog-card {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
}
.card {
    background: linear-gradient(135deg, #ffffff, #f3f4f8);
    border-radius: 10px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 30px;
    width: 280px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
    transform: translateY(-5px) scale(1.03);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}
.card-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
}
.card-content {
    padding: 15px;
}
.card-content h3 {
    font-size: 1.3rem;
    font-weight: bold;
    color: #333;
}
.card-content p {
    color: #666;
    font-size: 0.95rem;
    margin-top: 5px;
}
.card-buttons {
    display: flex;
    justify-content: space-around;
    padding: 10px;
}
.edit-button,
.delete-button {
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}
.edit-button {
    background-color: #f0ad4e;
}
.delete-button {
    background-color: #d9534f;
}
.edit-button:hover {
    background-color: #ec971f;
    transform: translateY(-2px);
}
.delete-button:hover {
    background-color: #c9302c;
    transform: translateY(-2px);
}
.lang_buttons{
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    gap: 20px;
    padding: 15px;
    background-color: #fff;
    font-size: 24px;
}
.lang_buttons button:focus{
    color: #2856ef;
}

.modal-overlay,
.modal-overlay-delete
{
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    animation: fadeIn 0.3s forwards;
}

.modal-overlay .modal {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 12px;
    width: 100%;
    height: 100vh;
    overflow-y: auto;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    transform: scale(0.8);
    opacity: 0;
    animation: scaleUp 0.3s forwards;
    text-align: center;
}
.modal-overlay-delete .modal  {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 12px;
    width: 30%;
    height: 30%;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    transform: scale(0.8);
    opacity: 0;
    animation: scaleUp 0.3s forwards;
    text-align: center;
}


.image-preview {
    display: inline-block;
    margin: 20px 0;
    background-color: #f9f9f9;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    position: relative;
    width: 250px;
    height: 280px;
    overflow: hidden;
    ;
}
.image-card {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.preview-img {
    width: 250px;
    height: 180px;
    object-fit: cover;
    border-radius: 5px;
}

.image-card-actions {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-top: 25px;
}

.image-card-actions button {
    padding: 5px 10px;
    background-color: #fff;
    border: 1px solid black;
    border-radius: 5px;
    cursor: pointer;
    font-size: 20px;
    transition: background-color 0.3s ease;
}

.image-card-actions button:hover {
    scale: 1.05;
}
.image-card-actions .icon-1 {
    color: #fff;
    background: blue;
    border-color: blue;
}


.image-previews {
    display: flex;
    flex-wrap: wrap;
    justify-content: start;
}

/* File input styling */
input[type="file"] {
    background-color: #fff;
    padding: 10px;
    border: 2px dashed #ccc;
    cursor: pointer;
    transition: border-color 0.3s;
    margin-top: 10px;
    width: 100%;
}

input[type="file"]:hover {
    border-color: #4c9bef;
}



.modal h3 {
    font-size: 1.8rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
}
.modal form input[type="text"],
.modal form input[type="file"],
.modal form input[type="search"] {
    width: 100%;
    padding: 12px 15px;
    font-size: 1rem;
    color: #333;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    transition: all 0.3s ease;
    margin-top: 10px;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
}

.modal form input[type="text"]:focus,
.modal form input[type="file"]:focus,
.modal form input[type="search"]:focus {
    border-color: #4c9bef;
    box-shadow: 0 0 5px rgba(76, 155, 239, 0.5), inset 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
}

.modal form input::placeholder {
    color: #5c5a5a;
    font-weight: 500;
}


.modal form input[type="file"] {
    background-color: #fff;
    padding: 10px;
    border: 2px dashed #ccc;
    cursor: pointer;
    transition: border-color 0.3s;
}
.modal form input[type="file"]:hover {
    border-color: #4c9bef;
}

.current-image img {
    width: 100%;
    height: auto;
    margin-top: 15px;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.modal label {
    display: block;
    font-size: 0.9rem;
    font-weight: bold;
    color: #555;
    margin-bottom: 5px;
}

.modal-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 25px;
}
.modal-buttons button {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
}
.modal-buttons button:nth-child(1) {
    background-color: #6c757d;
}
.modal-buttons button:nth-child(2) {
    background-color: #0078d4;
}
.modal-buttons button:hover {
    transform: translateY(-3px);
}
.modal-buttons button:nth-child(1):hover {
    background-color: #5a6268;
}
.modal-buttons button:nth-child(2):hover {
    background-color: #0056b3;
}


@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
@keyframes scaleUp {
    from {
        transform: scale(0.8);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}


</style>
