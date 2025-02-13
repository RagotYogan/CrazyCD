// main.js
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import PrimeVue from 'primevue/config';
import "@primevue/themes/lara-light-green/theme.css";
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';
// Importez les composants PrimeVue que vous allez utiliser
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import AutoComplete from 'primevue/autocomplete';

const app = createApp(App);

app.use(router);
app.use(PrimeVue, { ripple: true });
app.component('Button', Button);
app.component('InputText', InputText);
app.component('DataTable', DataTable);
app.component('Column', Column);
app.component('Dialog', Dialog);
app.component('AutoComplete', AutoComplete);

app.mount('#app');
