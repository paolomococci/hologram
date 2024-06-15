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
      path: '/more',
      name: 'more',
      component: () => import('../views/MoreView.vue')
    },
    {
      path: '/upload',
      name: 'upload',
      component: () => import('../views/UploadView.vue')
    },
    {
      path: '/update',
      name: 'update',
      component: () => import('../views/UpdateView.vue')
    },
    {
      path: '/response',
      name: 'response',
      component: () => import('../views/ResponseView.vue')
    }
  ]
})

export default router
