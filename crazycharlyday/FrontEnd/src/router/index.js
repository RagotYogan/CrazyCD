import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import creationBesoin from "@/views/creationBesoin.vue";

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