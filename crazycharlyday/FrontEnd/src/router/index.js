// router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import GestionSalaries from '../components/GestionSalaries.vue';

const routes = [
    { path: '/', component: GestionSalaries },
    // Ajoutez d'autres routes ici si nécessaire
];

const router = createRouter({
    history: createWebHistory("/"),
    routes,
});

export default router;
