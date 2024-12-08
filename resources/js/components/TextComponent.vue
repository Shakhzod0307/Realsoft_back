<template>
    <div class="app-container">
        <div class="content">
            <div class="header">
                <h2>Texts Dashboard</h2>
                <button @click="openAddModal" class="create-service">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <!-- Search Form -->
            <form @submit.prevent="fetchTexts" class="search-form">
                <div class="search-wrapper">
                    <input
                        type="search"
                        v-model="searchQuery"
                        class="search-input"
                        placeholder="Search..."
                        required
                    />
                </div>
            </form>

            <!-- Table -->
            <div class="table-container">
                <table class="services-table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Heading</th>
                        <th>Text</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(text, index) in Texts" :key="text.id">
                        <td style="padding: 30px">{{ index + 1 }}</td>
                        <td style="padding: 30px">{{ text.title }}</td>
                        <td style="padding: 30px">{{ text.heading }}</td>
                        <td style="padding: 30px" v-if="text.text !== null">
                            {{ text.text.length > 50 ? text.text.slice(0, 50) + ' ...' : text.text }}
                        </td>
                        <td style="padding: 30px" v-else></td>
                        <td style="padding: 30px">{{ text.type }}</td>
                        <td style="padding: 30px; gap: 10px" class="action-buttons">
                            <button @click="openViewModal(text)" class="btn view-btn">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button @click="openEditModal(text)" class="btn edit-btn">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button @click="openDeleteModal(text.id)" class="btn delete-btn">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add/Edit Modal -->
        <Teleport to="body">
            <div v-if="showModal" class="modal-overlay">
                <div class="modal-content">
                    <h3>{{ modalTitle }}</h3>
                    <form @submit.prevent="submitForm" class="modal-form">
                        <input v-model="form.title" placeholder="Title" class="modal-input" />
                        <input v-model="form.heading" placeholder="Heading" class="modal-input" />
                        <input v-model="form.type" placeholder="Type" class="modal-input" />
                        <textarea rows="4" v-model="form.text" placeholder="Text" class="modal-input"></textarea>
                        <div class="modal-buttons">
                            <button @click="closeModal" type="button" class="btn cancel-btn">Cancel</button>
                            <button type="submit" class="btn submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>

        <!-- Delete Confirmation Modal -->
        <Teleport to="body">
            <div v-if="showDeleteModal" class="modal-overlay">
                <div class="modal-content">
                    <h3>Confirm Deletion</h3>
                    <p>Are you sure you want to delete this text?</p>
                    <div class="modal-buttons">
                        <button @click="closeDeleteModal" class="btn cancel-btn">Cancel</button>
                        <button @click="confirmDelete" class="btn delete-btn">Delete</button>
                    </div>
                </div>
            </div>
        </Teleport>

        <!-- View Modal -->
        <Teleport to="body">
            <div v-if="showViewModal" class="modal-overlay">
                <div class="modal-content">
                    <h3>Text Details</h3>
                    <div class="view-details">
                        <p><strong>Title:</strong> {{ viewText.title }}</p>
                        <p><strong>Heading:</strong> {{ viewText.heading }}</p>
                        <p><strong>Type:</strong> {{ viewText.type }}</p>
                        <p><strong>Text:</strong> {{ viewText.text }}</p>
                    </div>
                    <button @click="closeViewModal" class="btn close-view-btn">Close</button>
                </div>
            </div>
        </Teleport>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import axios from "axios";

const Texts = ref([]);
const searchQuery = ref("");
const page = ref(1);
const showModal = ref(false);
const showDeleteModal = ref(false);
const showViewModal = ref(false);
const modalTitle = ref("");
const form = ref({ id: null, title: "", heading: "", text: "", type: "" });
const textIdToDelete = ref(null);
const viewText = ref({});

const GetAllTexts = async () => {
    try {
        const response = await axios.get("/api/get-texts", {
            params: { search: searchQuery.value, page: page.value },
        });
        Texts.value = response.data.data;
    } catch (error) {
        console.error("Failed to fetch texts:", error);
    }
};

const openAddModal = () => {
    modalTitle.value = "Create New Text";
    form.value = { id: null, title: "", heading: "", text: "", type: "" };
    showModal.value = true;
};

const openEditModal = (text) => {
    modalTitle.value = "Edit Text";
    form.value = { ...text };
    showModal.value = true;
};

const closeModal = () => (showModal.value = false);

const submitForm = async () => {
    try {
        if (form.value.id) {
            await axios.post(`/text/${form.value.id}`, form.value);
        } else {
            await axios.post("/text", form.value);
        }
        closeModal();
        await GetAllTexts();
    } catch (error) {
        console.error("Failed to save text:", error);
    }
};

const openDeleteModal = (id) => {
    textIdToDelete.value = id;
    showDeleteModal.value = true;
};

const closeDeleteModal = () => (showDeleteModal.value = false);

const confirmDelete = async () => {
    try {
        await axios.delete(`/text/${textIdToDelete.value}`);
        closeDeleteModal();
        await GetAllTexts();
    } catch (error) {
        console.error("Failed to delete text:", error);
    }
};

const openViewModal = (text) => {
    viewText.value = { ...text };
    showViewModal.value = true;
};

const closeViewModal = () => (showViewModal.value = false);

onMounted(() => GetAllTexts());

watch(searchQuery, () => {
    page.value = 1;
    GetAllTexts();
});
</script>

<style scoped>
.view-btn {
    background-color: #3498db;
}
.view-btn:hover {
    background-color: #2980b9;
}
.close-view-btn {
    background-color: #4caf50;
}
.close-view-btn:hover {
    background-color: #388e3c;
}
.view-details p {
    font-size: 1rem;
    margin-bottom: 10px;
    color: #444;
}


input,textarea {
    border: none;
    outline: none;
    border-radius: 5px;
    width: 100%;
    padding: 1em;
    background-color: #ffffff;
    box-shadow: inset 2px 5px 10px rgba(0,0,0,0.3);
    transition: 300ms ease-in-out;
}

input:focus, textarea:focus {
    background-color: white;
    transform: scale(1.05);
    box-shadow: 13px 13px 100px #969696,
    -13px -13px 100px #ffffff;
}

.app-container {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 20px;
    min-height: 100vh;
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.header h2 {
    font-size: 2rem;
    font-weight: 600;
    color: #333;
}

.create-service {
    border: 1px solid #ccc;
    background-color: #4c9bef;
    color: #fff;
    padding: 10px 15px;
    border-radius: 5px;
    transition: transform 0.3s, background-color 0.3s;
    cursor: pointer;
}
.create-service:hover {
    background-color: #4091d6;
    transform: scale(1.05);
}

/* Search Form */
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
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    font-size: 1rem;
    outline: none;
}
.search-input:focus {
    border-color: #4c9bef;
}

.table-container {
    overflow-x: auto;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 10px;
}
.services-table {
    width: 100%;
    border-collapse: collapse;
}
.services-table th, .services-table td {
    padding: 12px 15px;
    text-align: left;
    font-size: 1rem;
    color: #555;
}
.services-table th {
    background-color: #f0f0f0;
    font-weight: bold;
}
.services-table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.action-buttons {
    display: flex;
    gap: 10px;
}
.btn {
    border: none;
    padding: 6px 10px;
    font-size: 1rem;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
}
.edit-btn {
    background-color: #f0a500;
}
.edit-btn:hover {
    background-color: #d08b00;
}
.delete-btn {
    background-color: #e74c3c;
}
.delete-btn:hover {
    background-color: #c0392b;
}

/* Modals */
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
    width: 500px;
    max-width: 90%;
}
.modal-content h3 {
    text-align: center;
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #333;
}
.modal-form .modal-input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
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


.cancel-btn {
    background-color: #b3b3b3;
}
.submit-btn {
    background-color: #4c9bef;
}
.submit-btn:hover {
    background-color: #4091d6;
}


</style>
