import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/lara-dark-cyan/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';
import 'primeflex/primeflex.css';

import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import AutoComplete from 'primevue/autocomplete';
import Menubar from 'primevue/menubar';
import Menu from 'primevue/menu';
import Dropdown from 'primevue/dropdown';
import InputNumber from "primevue/inputnumber";
import FileUpload from "primevue/fileupload";

const app = createApp(App);

app.use(router);
app.use(PrimeVue);
app.component('Button', Button);
app.component('InputText', InputText);
app.component('DataTable', DataTable);
app.component('Column', Column);
app.component('Dialog', Dialog);
app.component('AutoComplete', AutoComplete);
app.component('Menubar', Menubar);
app.component('Menu', Menu);
app.component('Dropdown', Dropdown);
app.component('InputNumber', InputNumber);
app.component('FileUpload', FileUpload);

app.mount('#app');
