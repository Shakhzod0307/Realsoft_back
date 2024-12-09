<template>
    <div class="app-container">
        <div class="content">
            <!-- About Section -->
            <div class="header">
                <h2>About</h2>
                <button @click="openAddModal('about')" class="create-service">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <div class="table-container">
                <table class="services-table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(service, index) in Service" :key="service.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ service.phone }}</td>
                        <td>{{ service.email }}</td>
                        <td>{{ service.address }}</td>
                        <td class="action-buttons">
                            <button @click="openEditModal(service, 'about')" class="btn edit-btn">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button @click="openDeleteModal(service.id, 'about')" class="btn delete-btn">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Social Media Section -->
            <div class="header">
                <h2>Social Media</h2>
                <button @click="openAddModal('socialMedia')" class="create-service">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <div class="table-container">
                <table class="services-table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Url</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(social, index) in SocialMedia" :key="social.id">
                        <td>{{ index + 1 }}</td>
                        <td class="table-icon"><i :class="social.class"></i></td>
                        <td>{{ social.name }}</td>
                        <td class="media-class">{{ social.class }}</td>
                        <td>{{ social.url }}</td>
                        <td class="action-buttons">
                            <button @click="openEditModal(social, 'socialMedia')" class="btn edit-btn">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button @click="openDeleteModal(social.id, 'socialMedia')" class="btn delete-btn">
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
                        <!-- Form Fields for Both Sections -->
                        <template v-if="currentSection === 'about'">
                            <input  v-model="form.phone" placeholder="Phone" class="modal-input" required />
                            <input  v-model="form.email" placeholder="Email" class="modal-input" required />
                            <textarea v-model="form.address" placeholder="Address" rows="4" class="modal-input" required></textarea>
                        </template>
                        <template v-else-if="currentSection === 'socialMedia'">
                            <input v-model="form.name" placeholder="Name" class="modal-input" required />
                            <input v-model="form.class" placeholder="Class" class="modal-input" required />
                            <input v-model="form.url" placeholder="Url" class="modal-input" required />
                        </template>
                        <div class="modal-buttons">
                            <button type="button" @click="closeModal" class="btn cancel-btn">Cancel</button>
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
                    <p>Are you sure you want to delete this item?</p>
                    <div class="modal-buttons">
                        <button @click="closeDeleteModal" class="btn cancel-btn">Cancel</button>
                        <button @click="confirmDelete" class="btn delete-btn">Delete</button>
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const Service = ref([]);
const SocialMedia = ref([]);
const showModal = ref(false);
const showDeleteModal = ref(false);
const modalTitle = ref("");
const currentSection = ref("");
const form = ref({});
const itemIdToDelete = ref(null);

const fetchData = async (endpoint, target) => {
    try {
        const response = await axios.get(endpoint);
        target.value = response.data.data;
    } catch (error) {
        console.error("Failed to fetch data:", error);
    }
};

const GetAllServices = () => fetchData("/api/get-contact", Service);
const GetSocialMedia = () => fetchData("/api/get-social-media", SocialMedia);

const openAddModal = (section) => {
    currentSection.value = section;
    modalTitle.value = section === "about" ? "Add New Contact Info" : "Add New Social Media";
    form.value = {};
    showModal.value = true;
};

const openEditModal = (item, section) => {
    currentSection.value = section;
    modalTitle.value = section === "about" ? "Edit Contact Info" : "Edit Social Media";
    form.value = { ...item };
    showModal.value = true;
};

const closeModal = () => (showModal.value = false);

const submitForm = async () => {
    try {
        const endpoint = currentSection.value === "about" ? "/about" : "/social-media";
        if (form.value.id) {
            await axios.post(`${endpoint}/${form.value.id}`, form.value);
        } else {
            await axios.post(endpoint, form.value);
        }
        closeModal();
        currentSection.value === "about" ? await GetAllServices() : await GetSocialMedia();
    } catch (error) {
        console.error("Failed to save data:", error);
    }
};

const openDeleteModal = (id, section) => {
    currentSection.value = section;
    itemIdToDelete.value = id;
    showDeleteModal.value = true;
};

const closeDeleteModal = () => (showDeleteModal.value = false);

const confirmDelete = async () => {
    try {
        const endpoint = currentSection.value === "about" ? "/about" : "/social-media";
        await axios.delete(`${endpoint}/${itemIdToDelete.value}`);
        closeDeleteModal();
        currentSection.value === "about" ? await GetAllServices() : await GetSocialMedia();
    } catch (error) {
        console.error("Failed to delete data:", error);
    }
};

onMounted(() => {
    GetAllServices();
    GetSocialMedia();
});
</script>


<style scoped>

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


.table-container {
    overflow-x: auto;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 10px;
    margin-bottom: 20px;
}
.services-table {
    width: 100%;
    border-collapse: collapse;
}
.media-class{
    color: green;
}
.table-icon i{
    font-size: 24px;
    color: #4060d3;
}
.services-table th, .services-table td {
    padding: 12px 15px;
    text-align: left;
    font-size: 1rem;
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
    width: 400px;
    max-width: 90%;
}
.modal-content h3 {
    text-align: center;
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #333;
}
.modal-content p{
    text-align: center;
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
