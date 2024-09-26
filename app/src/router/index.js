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
      path: '/user/create',
      name: 'user.create',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/UserCreateView.vue')
    },
    {
        path: '/produtos/create',
        name: 'produtos.create',

        component: () => import('../views/ProdutosView.vue')
    },
    {
        path: '/movements/create',
        name: 'movements.create',

        component: () => import('../views/MovementsView.vue')
    },
    {
        path: '/movements/list',
        name: 'movements.list',

        component: () => import('../views/ListaMoveView.vue')
    },
  ]
})

export default router
