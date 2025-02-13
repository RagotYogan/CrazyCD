<script>
import InputGroup from "primevue/inputgroup";
import InputGroupAddon from "primevue/inputgroupaddon";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import Button from 'primevue/button';
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css"
import axios from 'axios';

export default {
    name: "CreationBesoins",
    data() {
        return {
            clientName: "",
            libelleBesoins: "",
            competencesRequises: "",
            metierRequis: ""
        };
    },
    components: {
        InputGroup,
        InputGroupAddon,
        InputText,
        Textarea,
        Button,
    },
    methods: {
        async validateForm() {
            if (!this.clientName.trim()) {
                this.afficherToastify("Veuillez saisir un nom de client.");
                return;
            }
            if (!this.libelleBesoins.trim()) {
                this.afficherToastify("Veuillez saisir un libellé pour le besoin.");
                return;
            }
            if (!this.competencesRequises.trim() && !this.metierRequis.trim()) {
                this.afficherToastify("Veuillez saisir au moins une compétence ou un métier.");
                return;
            }

            this.afficherToastify("Formulaire soumis avec succès.");

            const besoin = {
                client: this.clientName,
                libelle: this.libelleBesoins,
                competence: (!this.competencesRequises.trim() ? this.metierRequis : this.competencesRequises),

            }
            const config = {
                headers: {
                    'Content-Type': 'application/json'
                }
            };

            await axios.post('http://docketu.iutnc.univ-lorraine.fr:60000/besoins', besoin, config);
        },
        afficherToastify(message){
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #ff6b6b, #c53030)",
                close: true
            }).showToast();
        }
    }
};
</script>

<template>
    <div class="form-container">
        <InputGroup class="input-field">
            <label for="username">Username</label>
            <InputText id="username" type="email" v-model="clientName" aria-label="Email du client"/>
        </InputGroup>

        <InputGroup class="input-field">
            <label for="libelle">Libelle</label>
            <Textarea id="libelle" v-model="libelleBesoins" autoResize rows="5" cols="30" />
        </InputGroup>

        <InputGroup  v-if="metierRequis === ''" class="input-field">
            <label for="competence">Compétence</label>
            <InputText id="competence" v-model="competencesRequises" aria-label="Compétence"/>
        </InputGroup>
        <InputGroup  v-else class="input-field">
            <label for="competence">Compétence</label>
            <InputText id="competence" v-model="competencesRequises" aria-label="Compétence" disabled/>
        </InputGroup>

        <InputGroup  v-if="competencesRequises === ''" class="input-field">
            <label for="metier">Métier requis</label>
            <InputText id="metier" v-model="metierRequis" aria-label="Métier requis"/>
        </InputGroup>
        <InputGroup  v-else class="input-field">
            <label for="metier">Métier requis</label>
            <InputText id="metier" v-model="metierRequis" aria-label="Métier requis" disabled/>
        </InputGroup>
        <Button label="Submit" @click="validateForm" class="btn-submit"/>
    </div>
</template>

<style scoped>
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

.btn-submit {
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

.btn-submit:hover {
    background: #0056b3; /* Bleu plus foncé au survol */
}

.btn-submit:active {
    transform: scale(0.98); /* Effet de clic */
}

.btn-submit:disabled {
    background: #ccc;
    cursor: not-allowed;
    opacity: 0.7;
}
</style>