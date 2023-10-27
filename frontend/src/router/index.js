import { createRouter, createWebHistory } from 'vue-router';
import GameView from '../views/GameView.vue';
import MenuView from '../views/MenuView.vue';
import NotFoundView from '../views/NotFoundView.vue';
import 'bootstrap/dist/css/bootstrap.css';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'menu',
      component: MenuView,
    },
    {
      path: '/game/:username/play',
      name: 'game',
      component: GameView,
    },
    // Route de correspondance globale pour "Not Found"
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: NotFoundView, // Créez une composante NotFoundView pour la page "Not Found"
    },
  ],
});

export default router;
