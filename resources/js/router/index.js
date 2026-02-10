import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import About from '../views/About.vue'
import Shop from '../views/Shop.vue'
import Contacts from '../views/Contacts.vue'

const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/chi-siamo', name: 'about', component: About },
    { path: '/shop', name: 'shop', component: Shop },
    { path: '/contatti', name: 'contacts', component: Contacts },
    {
  path: '/termini-condizioni',
  name: 'terms',
  component: () => import('../views/TerminiCondizioni.vue')
}
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 }
    },
})

export default router
