import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import creationBesoin from "@/views/creationBesoin.vue";
import GestionSalaries from "@/views/GestionSalaries.vue";
import BesoinsView from "@/views/BesoinsView.vue";
import Optimisation from "@/views/Optimisation.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView,
        },
        {
            path: '/besoins',
            name: 'besoins',
            component: creationBesoin,
        },
        {
            path: '/gestion-salaries',
            name: 'gestion-salaries',
            component: GestionSalaries
        },
        {
            path: '/besoins/liste',
            name: 'listeBesoins',
            component: BesoinsView,
        },
        {
            path: '/optimisation',
            name: 'optimisation',
            component: Optimisation,
        }
        // {
        //     path: '/activites',
        //     name: 'activites',
        //     component: Activites,
        // },
        // {
        //     path: '/signIn',
        //     name:'signIn',
        //     component: () => import('../views/SignIn.vue'),
        // }
    ],
})

export default router