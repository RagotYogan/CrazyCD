<template>
  <div>
    <FileUpload type="file" @change="handleFileUpload" accept=".csv" />
    <DataTable :value="tableData" v-if="tableData.length">
      <Column field="salarie" header="Salarié"></Column>
      <Column field="besoin" header="Besoin"></Column>
      <Column field="client" header="Client"></Column>
    </DataTable>
  </div>
</template>

<script>
import DataTable from 'primevue/datatable';
import axios from 'axios';
import FileUpload from "primevue/fileupload";

export default {
  components: {
    DataTable,
    FileUpload
  },
  data() {
    return {
      tableData: []
    };
  },
  methods: {
    async handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        const formData = new FormData();
        formData.append('file', file);

        try {
          const response = await axios.post('http://localhost:8080/optimisation', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          });

          // Extract the "affectations" array from the response
          this.tableData = response.data.affectations;
        } catch (error) {
          console.error('Error uploading file:', error);
        }
      }
    }
  }
};
</script>

<style scoped>
/* Add your scoped styles here */
</style>
