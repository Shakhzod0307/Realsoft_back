<template>
    <div class="app-container">
        <div class="container">
            <div class="header">
                <h2>Partners Dashboard</h2>
                <button @click="openAddModal" class="create-service">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <!-- Partners Cards -->
            <div class="sector-card">
                <div v-for="(partner, index) in partners" :key="partner.id" class="card">
                    <div class="advantage-image">
                        <img :src="partner.image" alt="Partner Image" class="card-image" />
                    </div>
                    <div class="card-buttons">
                        <button @click="openEditModal(partner)" class="edit-button">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button @click="openDeleteModal(partner.id)" class="delete-button">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <Teleport to="body">
        <div v-if="showModal" class="modal-overlay">
            <div class="modal">
                <h3>{{ modalTitle }}</h3>
                <form @submit.prevent="submitForm">
                    <!-- Show Current Image if Editing -->
                    <div v-if="form.image && typeof form.image === 'string'" class="current-image">
                        <img :src="form.image" alt="Current Image" />
                    </div>
                    <input type="file" @change="handleFileChange" required />
                    <div class="modal-buttons">
                        <button @click="closeModal" type="button">Cancel</button>
                        <button type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </Teleport>

    <!-- Delete Confirmation Modal -->
    <Teleport to="body">
        <div v-if="showDeleteModal" class="modal-overlay">
            <div class="modal">
                <h3>Confirm Deletion</h3>
                <p>Are you sure you want to delete this partner?</p>
                <div class="modal-buttons">
                    <button @click="closeDeleteModal">Cancel</button>
                    <button @click="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const partners = ref([]);
const showModal = ref(false);
const showDeleteModal = ref(false);
const modalTitle = ref("");
const form = ref({ id: null, image: null });
const partnerIdToDelete = ref(null);

const fetchPartners = async () => {
    try {
        const response = await axios.get("/api/get-partners");
        partners.value = response.data.data;
    } catch (error) {
        console.error("Error fetching partners:", error);
    }
};

const openAddModal = () => {
    modalTitle.value = "Add New Partner";
    form.value = { id: null, image: null };
    showModal.value = true;
};

const openEditModal = (partner) => {
    modalTitle.value = "Edit Partner";
    form.value = { ...partner };
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    form.value = { id: null, image: null };
};

const handleFileChange = (event) => {
    form.value.image  = event.target.files[0];
    // console.log(form.value.image);
};

const submitForm = async () => {
    try {
        const formData = new FormData();
        formData.append("image", form.value.image);
        if (form.value.id) {
            await axios.post(`/partner/${form.value.id}`, formData);
        } else {
            await axios.post("/partner", formData);
        }

        closeModal();
        await fetchPartners();
    } catch (error) {
        console.error("Error saving partner:", error);
    }
};

const openDeleteModal = (id) => {
    partnerIdToDelete.value = id;
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    partnerIdToDelete.value = null;
};

const confirmDelete = async () => {
    try {
        if (partnerIdToDelete.value) {
            await axios.delete(`/partner/${partnerIdToDelete.value}`);
        }
        closeDeleteModal();
        await fetchPartners();
    } catch (error) {
        console.error("Error deleting partner:", error);
    }
};

onMounted(() => {
    fetchPartners();
});
</script>

<style scoped>



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
.sector-card {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
}
.card {
    position: relative; /* Ensure positioning for buttons */
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
.advantage-image{
    display: flex;
    text-align: center;
    align-items: center;
    padding: 10px;
    justify-content: center;
}
.card-image {
    padding: 10px;
    width: 100%;
    max-height: 120px;
    object-fit: cover;
    align-items: center;
    text-align: center;
}
.card-content {
    padding: 15px;
    align-items: center;
    text-align: center;
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
    position: absolute;
    top: 0;
    right: 1px;
    display: none; /* Hide buttons by default */
    gap: 5px; /* Space between buttons */
}
.card:hover .card-buttons {
    display: flex; /* Show buttons on hover */
}
.edit-button,
.delete-button {
    border: none;
    padding: 8px;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent background */
}

.edit-button {
    background-color: rgba(240, 173, 78, 0.8);
}

.delete-button {
    background-color: rgba(217, 83, 79, 0.8);
}
.edit-button:hover {
    background-color: rgba(236, 151, 31, 1);
    transform: translateY(-2px);
}

.delete-button:hover {
    background-color: rgba(201, 48, 44, 1);
    transform: translateY(-2px);
}

.modal-overlay {
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

.modal {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 12px;
    width: 400px;
    max-width: 90%;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    transform: scale(0.8);
    opacity: 0;
    animation: scaleUp 0.3s forwards;
    text-align: center;
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

/* Image Display Style for Current Image */
.current-image img {
    width: 300px;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    display: initial;
}

/* Labels (Optional) */
.modal label {
    display: block;
    font-size: 0.9rem;
    font-weight: bold;
    color: #555;
    margin-bottom: 5px;
}

/* Modal Buttons */
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

/* Keyframes for Modal Animations */
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

