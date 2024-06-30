import { createRouter, createWebHistory } from 'vue-router'
import HelpView from '../views/HelpView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'help',
      component: HelpView
    },
    {
      path: '/upload',
      name: 'upload',
      component: () => import('../views/UploadView.vue')
    },
    {
      path: '/evaluate',
      name: 'evaluate',
      component: () => import('../views/EvaluateView.vue')
    },
    {
      path: '/feedback',
      name: 'feedback',
      component: () => import('../views/FeedbackView.vue')
    },
    {
      path: '/post',
      name: 'post',
      component: () => import('../views/PostView.vue')
    }
  ]
})

export default router
