<template>
  <div>
    <h1>Gestion des Salariés</h1>

    <Dialog header="Ajouter un Salarié" v-model:visible="showAddSalarieDialog">
      <div class="p-grid p-fluid">
        <div class="p-field p-col">
          <label for="nom">Nom du Salarié</label>
          <InputText id="nom" v-model="newSalarie.nom" />
        </div>
        <div class="p-field p-col">
          <label for="competence">Compétence</label>
          <AutoComplete
              id="competence"
              v-model="newCompetence"
              :suggestions="filteredCompetences"
              @complete="searchCompetence"
              field="nom"
          />
        </div>
        <div class="p-field p-col">
          <label for="interet">Intérêt</label>
          <InputText id="interet" v-model.number="newCompetenceInteret" />
        </div>
        <div class="p-field p-col">
          <Button label="Ajouter Compétence" @click="addCompetenceToSalarie" />
        </div>
      </div>
      <template #footer>
        <Button label="Annuler" @click="hideDialog('addSalarie')" />
        <Button label="Ajouter" @click="addSalarie" />
      </template>
    </Dialog>

    <!-- Tableau des salariés -->
    <DataTable :value="salaries" responsiveLayout="scroll">
      <Column field="nom" header="Nom"></Column>
      <Column field="competences" header="Compétences">
        <template #body="slotProps">
          <ul>
            <li v-for="(competence, index) in slotProps.data.competences" :key="index">
              {{ competence.nom }} ({{ competence.interet }})
            </li>
          </ul>
        </template>
      </Column>
    </DataTable>

    <!-- Bouton pour ajouter un salarié -->
    <Button label="Ajouter un Salarié" @click="showDialog('addSalarie')" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      showAddSalarieDialog: false,
      newSalarie: { nom: '', competences: [] },
      newCompetence: '',
      newCompetenceInteret: null,
      competences: [
        { nom: 'Bricolage', id: 1 },
        { nom: 'Jardinage', id: 2 },
        // Ajoutez d'autres compétences ici
      ],
      salaries: [
        // Exemple de salarié
        {
          nom: 'Alice',
          competences: [
            { nom: 'Bricolage', interet: 4 },
            { nom: 'Ménage', interet: 7 },
          ],
        },
      ],
    };
  },
  methods: {
    showDialog(name) {
      if (name === 'addSalarie') {
        this.showAddSalarieDialog = true;
      }
    },
    hideDialog(name) {
      if (name === 'addSalarie') {
        this.showAddSalarieDialog = false;
      }
    },
    searchCompetence(event) {
      // Logique pour filtrer les compétences
      this.filteredCompetences = this.competences.filter((competence) =>
          competence.nom.toLowerCase().startsWith(event.query.toLowerCase())
      );
    },
    addCompetenceToSalarie() {
      const competence = this.filteredCompetences.find(
          (c) => c.nom === this.newCompetence
      );
      if (competence && this.newCompetenceInteret >= 1 && this.newCompetenceInteret <= 10) {
        this.newSalarie.competences.push({
          nom: competence.nom,
          interet: this.newCompetenceInteret,
        });
        this.newCompetence = '';
        this.newCompetenceInteret = null;
      }
    },
    addSalarie() {
      if (this.newSalarie.nom && this.newSalarie.competences.length > 0) {
        this.salaries.push({ ...this.newSalarie });
        this.newSalarie = { nom: '', competences: [] };
        this.hideDialog('addSalarie');
      }
    },
  },
};
</script>
