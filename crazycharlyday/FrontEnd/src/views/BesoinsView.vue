<script>
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import axios from "axios";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css"
import BesoinModal from "@/views/BesoinModal.vue";

export default {
    name: "ListeBesoins",
    components: {
        BesoinModal,
        InputText,
        Button,

    },
    data() {
        return {
            besoins: [],
            client: "",
            besoin: null,
            isVisible: false
        };
    },
    methods:{
        besoinsByClient() {
            const config = {
                headers: {
                    'Content-Type': 'application/json'
                },
                params: {
                    client: this.client
                }
            };

            axios.get('http://localhost:8080/besoins', config)
                .then(response => {
                    this.besoins = response.data;
                    if (this.besoins.length === 0) {
                        Toastify({
                            text: 'Aucun besoin trouvé pour ce client',
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #ff6b6b, #c53030)",
                            close: true,
                        }).showToast();
                    }
                })
                .catch(error => {
                    console.error("Erreur lors de la récupération des besoins :", error);
                })
        },
        modifierBesoin(besoin) {
            this.besoin = { ...besoin};
            this.isVisible = true;
        },
        closeModal() {
            this.isVisible = false;
        },
        handleUpdateBesoin(updatedBesoin) {
            const besoin = {
                id_besoins: updatedBesoin.id_besoins,
                libelle: updatedBesoin.libelle,
                competence: updatedBesoin.competence,
            };
            const index = this.besoins.findIndex(b => b.id_besoins === updatedBesoin.id_besoins);
            if (index !== -1) {
                this.besoins[index] = updatedBesoin;
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                };
                axios.patch(`http://docketu.iutnc.univ-lorraine.fr:60000/besoins/${updatedBesoin.id_besoins}`, besoin, config)
            }
            this.closeModal();
        }
    }
}
</script>

<template>
    <div>
        <h1>Liste de besoins</h1>

        <div class="form-container">
            <div class="input-field">
                <label for="client">Client:</label>
                <InputText v-model="client" placeholder="Client" />
            </div>
            <div class="input-field">
                <Button @click="besoinsByClient()" class="btn-submit">Rechercher</button>
            </div>
        </div>
        <div class="container">
            <ul>
                <li v-for="besoin in besoins" :key="besoin.id">
                    <h3>Besoin: </h3><p>{{ besoin.libelle }}</p>
                    <h3>Compétence: </h3><p>{{ besoin.competence }}</p>
                    <Button @click="modifierBesoin(besoin)" class="btn-modif">Modification</Button>
                </li>
            </ul>
        </div>
        <BesoinModal
            :besoin=this.besoin
            :isVisible="isVisible"
            @close="isVisible = false"
            @updateBesoin="handleUpdateBesoin"
            @closeModal="closeModal"
        />
    </div>
</template>

<style scoped>
.container{
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 75%;
    margin: 0 auto;
}

ul {
    list-style: none;
    padding: 0;
    width: 75%
}

li {
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 10px;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
}

li:hover {
    transform: scale(1.02);
    background-color: #eef1f4;
}

p {
    margin: 5px 0;
    font-size: 16px;
    color: #333;
}

h3{
    font-weight: bold;
    font-size: 18px;
    color: #007bff;
}


.form-container {
    max-width: 500px;
    margin: 20px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.input-field {
    display: flex;
    flex-direction: column;
}

.input-field label {
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

.input-field .p-inputtext,
.input-field .p-textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s ease-in-out;
}

.input-field .p-inputtext:focus,
.input-field .p-textarea:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.btn-submit, .btn-modif {
    width: 100%;
    padding: 10px;
    background: #007bff; /* Bleu principal */
    color: white;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease-in-out, transform 0.1s ease-in-out;
}

.btn-submit:hover, .btn-modif:hover {

    background: #0056b3; /* Bleu plus foncé au survol */
}

.btn-submit:active, .btn-modif:active {
    transform: scale(0.98); /* Effet de clic */
}

.btn-submit:disabled, .btn-modif:disabled {
    background: #ccc;
    cursor: not-allowed;
    opacity: 0.7;
}
</style>