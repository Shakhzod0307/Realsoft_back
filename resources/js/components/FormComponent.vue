
<template>
    <div class="app-container">
        <div class="content">
            <div class="header">
                <h2 class="title">Forms Dashboard</h2>
            </div>

            <!-- Search Form -->
            <form @submit.prevent="fetchForms" class="search-form">
                <div class="search-wrapper">
                    <input
                        type="search"
                        v-model="searchQuery"
                        class="input search-input"
                        placeholder="Search..."
                        required
                    />
                </div>
            </form>

            <!-- Table -->
            <div class="table-container">
                <table class="table forms-table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Company Name</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(form, index) in forms" :key="form.id" class="row">
                        <td>{{ index + 1 }}</td>
                        <td>{{ form.name }}</td>
                        <td>{{ form.company_name }}</td>
                        <td>{{ form.message.length > 50 ? form.message.slice(0, 50) + ' ...' : form.message }}</td>
                        <td>
                            <button @click="viewForm(form)" class="btn view-btn">
                                <i class="fa fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- View Modal -->
        <Teleport to="body">
            <div v-if="showViewModal" class="modal-overlay fade-in">
                <div class="modal-content scale-up">
                    <h3 class="modal-title">Form Details</h3>
                    <p><strong>Name:</strong> {{ selectedForm.name }}</p>
                    <p><strong>Company Name:</strong> {{ selectedForm.company_name }}</p>
                    <p><strong>Number:</strong> {{ selectedForm.number }}</p>
                    <p><strong>Email:</strong> {{ selectedForm.email }}</p>
                    <p><strong>Message:</strong> {{ selectedForm.message }}</p>
                    <p v-if="selectedForm.file">
                        <strong>File: </strong>
                        <template v-if="isImage(selectedForm.file)">
                            <img :src="`/forms/${selectedForm.file}`" alt="Image Preview" class="file-image-preview" />
                        </template>
                        <template v-else>
                            <a :href="`forms/${selectedForm.file}`" target="_blank" class="file-link">{{selectedForm.file}}</a>
                        </template>
                    </p>
                    <div class="modal-buttons">
                        <button @click="closeViewModal" class="btn close-btn">Close</button>
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>

<script setup>
import {ref, onMounted, watch} from "vue";
import axios from "axios";

const forms = ref([]);
const searchQuery = ref("");
const showViewModal = ref(false);
const selectedForm = ref(null);

const fetchForms = async () => {
    try {
        const response = await axios.get("/api/get-forms", {
            params: { search: searchQuery.value },
        });
        forms.value = response.data.result.data;
        // console.log(response.data.result.data)
    } catch (error) {
        console.error("Failed to fetch forms:", error);
    }
};

const viewForm = (form) => {
    selectedForm.value = form;
    showViewModal.value = true;
};

const closeViewModal = () => {
    showViewModal.value = false;
    selectedForm.value = null;
};
const isImage = (fileUrl) => {
    const imageExtensions = [".jpg", ".jpeg", ".png", ".gif", ".webp", ".svg"];
    const fileExtension = fileUrl.toLowerCase().slice(fileUrl.lastIndexOf("."));
    return imageExtensions.includes(fileExtension);
};

onMounted(() => fetchForms());

watch(()=>
    searchQuery.value,
    () => {
        fetchForms();
    })
</script>

<style scoped>

.input {
    border: none;
    outline: none;
    border-radius: 5px;
    width: 100%;
    padding: 1em;
    background-color: #ffffff;
    box-shadow: inset 2px 5px 10px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.input:focus {
    transform: scale(1.05);
    box-shadow: 5px 5px 15px rgba(150, 150, 150, 0.5);
}

.file-image-preview {
    max-width: 100%;
    max-height: 200px;
    display: block;
    margin-top: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.app-container {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 20px;
    min-height: 100vh;
}


.header .title {
    font-size: 2rem;
    font-weight: 600;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}


.search-form {
    max-width: 600px;
    margin: 0 auto 20px;
}
.search-wrapper {
    position: relative;
}
.search-input {
    width: 100%;
    padding: 10px 15px;
    font-size: 1rem;
}


.table-container {
    overflow-x: auto;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 10px;
}
.table {
    width: 100%;
    border-collapse: collapse;
}
.table th,
.table td {
    padding: 12px 15px;
    text-align: left;
    font-size: 1rem;
    color: #555;
}
.table th {
    background-color: #f0f0f0;
    font-weight: bold;
}
.table .row:nth-child(even) {
    background-color: #f9f9f9;
}


.btn {
    border: none;
    padding: 6px 10px;
    font-size: 1rem;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.2s ease, background-color 0.3s ease;
}
.view-btn {
    background-color: #0078d4;
}
.view-btn:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}
.close-btn {
    background-color: #b3b3b3;
}
.close-btn:hover {
    background-color: #969696;
    transform: scale(1.05);
}


.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
}
.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    width: 400px;
    max-width: 90%;
}
.modal-title {
    text-align: center;
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #333;
}
.modal-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
}
.file-link {
    color: #0078d4;
    text-decoration: none;
}
.file-link:hover {
    text-decoration: underline;
}


.fade-in {
    animation: fadeIn 0.3s ease-in-out;
}
.scale-up {
    animation: scaleUp 0.3s ease-in-out;
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

