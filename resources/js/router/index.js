import VueRouter from 'vue-router'
import adminRoutes from './admin';
import Login from '../pages/Login';
import Dashboard from '../pages/user/Dashboard'
import Home from '../pages/Home'
import kasirRoutes from './kasir';
import managerRoutes from './manager';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
          auth: true
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
          auth: false
        }
    },
      // USER ROUTES
      {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
          auth: true
        }
      },
    adminRoutes,
    kasirRoutes,
    managerRoutes

];
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
  })

  export default router
