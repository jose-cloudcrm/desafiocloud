import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
        path: '/produtos/create',
        name: 'produtos.create',

        component: () => import('../views/ProdutosView.vue')
    },
    {
        path: '/movements/list',
        name: 'movements.list',

        component: () => import('../views/ListaMoveView.vue')
    },
  ]
})

export default router
