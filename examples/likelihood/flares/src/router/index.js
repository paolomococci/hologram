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
      path: '/ponder',
      name: 'ponder',
      component: () => import('../views/PonderView.vue')
    },
    {
      path: '/clip',
      name: 'clip',
      component: () => import('../views/ClipView.vue')
    },
    {
      path: '/estimate',
      name: 'estimate',
      component: () => import('../views/EstimateView.vue')
    },
    {
      path: '/playground',
      name: 'playground',
      component: () => import('../views/PlaygroundView.vue')
    }
  ]
})

export default router
