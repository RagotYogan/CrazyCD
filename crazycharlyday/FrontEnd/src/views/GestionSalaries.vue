<template>
  <div class="p-fluid p-grid p-nogutter">
    <h1>Gestion des Salariés</h1>

    <!-- Dialogue pour ajouter un salarié -->
    <Dialog header="Ajouter un Salarié" v-model:visible="showAddSalarieDialog" :style="{ width: '40vw' }">
      <div class="p-field p-col-12 p-md-6">
        <label for="nom">Nom du Salarié : </label>
        <InputText id="nom" v-model="newSalarie.nom" class="p-mb-3" />
      </div>
      <template #footer>
        <Button label="Annuler" @click="hideDialog('addSalarie')" class="p-button-text" />
        <Button label="Ajouter" @click="addSalarie" class="p-button-sm" />
      </template>
    </Dialog>

    <!-- Tableau des salariés -->
    <DataTable :value="salaries" responsiveLayout="scroll" class="p-mt-4">
      <Column field="nom" header="Nom"></Column>
      <Column header="Actions">
        <template #body="slotProps">
          <Button icon="pi pi-pencil" label="Modifier" @click="editSalarie(slotProps.data)" class="p-button-sm p-button-text" />
        </template>
      </Column>
    </DataTable>

    <!-- Bouton pour ajouter un salarié -->
    <Button label="Ajouter un Salarié" @click="showDialog('addSalarie')" class="p-mt-3" />

    <!-- Dialogue pour modifier un salarié et ajouter des compétences -->
    <Dialog header="Modifier Salarié" v-model:visible="showEditSalarieDialog" :style="{ width: '40vw' }">
      <div class="p-field p-col-12 p-md-6">
        <label for="nom">Nom du Salarié : </label>
        <InputText id="nom" v-model="currentSalarie.nom" class="p-mb-3" disabled />
      </div>

      <div v-for="(competence, index) in currentSalarie.competences" :key="index" class="p-grid p-nogutter p-mb-3">
        <div class="p-col-6">
          <Dropdown v-model="competence.nom" :options="competences" optionLabel="nom" placeholder="Sélectionner une compétence" class="p-mb-3" />
        </div>
        <div class="p-col-4">
          <InputNumber v-model="competence.interet" :min="1" :max="10" showButtons buttonLayout="horizontal" class="p-mb-3" />
        </div>
        <div class="p-col-2">
          <Button icon="pi pi-trash" class="p-button-danger p-button-sm" @click="removeCompetence(index)" />
        </div>
      </div>

      <div class="p-field p-col-12 p-md-6">
        <Button label="Ajouter Compétence" @click="addNewCompetence" class="p-button-sm" />
      </div>

      <template #footer>
        <Button label="Annuler" @click="hideDialog('editSalarie')" class="p-button-text" />
        <Button label="Enregistrer" @click="saveSalarie" class="p-button-sm" />
      </template>
    </Dialog>

    <!-- Gestion des compétences -->
    <h2 class="p-mt-5">Gestion des Compétences</h2>
    <div class="p-grid">
      <div class="p-col-12 p-md-4">
        <label for="newCompetenceName">Nouvelle Compétence</label>
        <InputText id="newCompetenceName" v-model="newCompetenceName" class="p-mb-3" />
        <Button label="Ajouter Compétence" @click="addCompetence" class="p-button-sm" />
      </div>
    </div>

    <DataTable :value="competences" responsiveLayout="scroll" class="p-mt-3">
      <Column field="nom" header="Nom"></Column>
      <Column header="Actions">
        <template #body="slotProps">
          <Button icon="pi pi-pencil" @click="editCompetence(slotProps.data)" class="p-button-sm p-button-text" />
          <Button icon="pi pi-trash" @click="deleteCompetence(slotProps.data)" class="p-button-sm p-button-danger p-ml-2" />
        </template>
      </Column>
    </DataTable>
  </div>
</template>

<script>
import axios from 'axios';
import Dropdown from 'primevue/dropdown';
import InputNumber from 'primevue/inputnumber';

export default {
  components: {
    Dropdown,
    InputNumber
  },
  data() {
    return {
      showAddSalarieDialog: false,
      showEditSalarieDialog: false,
      newSalarie: { nom: '', competences: [] },
      currentSalarie: { nom: '', competences: [] },
      newCompetenceName: '',
      competences: [],
      salaries: [],
    };
  },
  async mounted() {
      const config = {
          headers: {
              'Content-Type': 'application/json',
          }
      };
      await axios.get('http://docketu.iutnc.univ-lorraine.fr:60000/competences',config)
       .then(response => {
          this.competences = response.data;
       }).catch(error => {
           console.error('Erreur lors de récupération des compétences:', error);
       })
       await axios.get('http://docketu.iutnc.univ-lorraine.fr:60000/salaries', config)
           .then(response => {
                this.salaries = response.data;
                console.log(this.salaries)
                this.competences = this.salaries.competence;
                console.log(this.competences)
           }).catch(error => {
               console.error('Erreur lors de récupération des salariés:', error);
           })
  },
  methods: {
    showDialog(name) {
      if (name === 'addSalarie') {
        this.showAddSalarieDialog = true;
      } else if (name === 'editSalarie') {
        this.showEditSalarieDialog = true;
      }
    },
    hideDialog(name) {
      if (name === 'addSalarie') {
        this.showAddSalarieDialog = false;
      } else if (name === 'editSalarie') {
        this.showEditSalarieDialog = false;
      }
    },
    async addSalarie() {
      if (this.newSalarie.nom) {
        try {
          //await axios.post('api_salaries.php', { nom: this.newSalarie.nom });
          this.salaries.push({ ...this.newSalarie });
          this.newSalarie = { nom: '', competences: [] };
          this.hideDialog('addSalarie');
        } catch (error) {
          console.error('Erreur lors de l\'ajout du salarié:', error);
        }
      }
    },
    editSalarie(salarie) {
      this.currentSalarie = { ...salarie };
      this.showDialog('editSalarie');
    },
    addNewCompetence() {
      this.currentSalarie.competences.push({ nom: '', interet: 1 });
    },
    removeCompetence(index) {
      this.currentSalarie.competences.splice(index, 1);
    },
    saveSalarie() {
      // Logique pour enregistrer les modifications du salarié
        console.log('Save salarie:', this.currentSalarie);
      // Logique pour enregistrer les modifications des compétences du salarié
      this.hideDialog('editSalarie');

    },
    async addCompetence() {
      if (this.newCompetenceName) {
        try {
          const config = {
            headers: {
              'Content-Type': 'application/json',

            }
          };
          await axios.post('http://localhost:8080/competences', { nom: this.newCompetenceName }, config);
          this.competences.push({ nom: this.newCompetenceName, id: this.competences.length + 1 });
          this.newCompetenceName = '';
        } catch (error) {
          console.error('Erreur lors de l\'ajout de la compétence:', error);
        }
      }
    },
    editCompetence(competence) {
      // Logique pour éditer une compétence
      console.log('Edit competence:', competence);
    },
    deleteCompetence(competence) {
      const index = this.competences.indexOf(competence);
      if (index !== -1) {
        this.competences.splice(index, 1);
      }
    },
  },
};
</script>

<style scoped>
.p-field {
  margin-bottom: 1rem;
}
</style>
