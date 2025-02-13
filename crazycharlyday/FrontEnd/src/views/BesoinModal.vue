<template>
    <div v-if="isVisible" class="modal-overlay" @click.self="closeModal">
        <div class="modal">
            <h2>Modifier le besoin</h2>
            <form @submit.prevent="updateBesoin">
                <div class="form-group">
                    <label for="client">Client</label>
                    <input type="text" id="client" v-model="besoin.client" required />
                </div>
                <div class="form-group">
                    <label for="libelle">Libellé</label>
                    <input type="text" id="libelle" v-model="besoin.libelle" required />
                </div>
                <div class="form-group">
                    <label for="competence">Compétence</label>
                    <input type="text" id="competence" v-model="besoin.competence" required />
                </div>
                <button type="submit" class="btn-save">Enregistrer</button>
                <button type="button" class="btn-cancel" @click="closeModal">Annuler</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        besoin: {
            type: Object,
            required: true
        },
        isVisible: {
            type: Boolean,
            required: true
        }
    },
    methods: {
        updateBesoin() {
            // Émettre un événement pour notifier le parent de la mise à jour
            this.$emit('update-besoin', this.besoin);
            this.closeModal();
        },
        closeModal() {
            this.$emit('close-modal');
        }
    }
};
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    width: 300px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
}

button {
    padding: 10px 15px;
    margin-right: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-save {
    background-color: #4CAF50;
    color: white;
}

.btn-cancel {
    background-color: #f44336;
    color: white;
}
</style>