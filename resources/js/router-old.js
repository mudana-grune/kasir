import VueRouter from 'vue-router'

// Pages
import Home from './pages/Home'
import Register from './pages/Register'
import Login from './pages/Login'
import Dashboard from './pages/user/Dashboard'
import AdminAppBase from './components/AppBase'
import PaketTable  from './pages/admin/paket/PaketTable'
import PaketForm from './pages/admin/paket/PaketForm'

// Routes
const ADMIN = 2;
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
    path: '/register',
    name: 'register',
    component: Register,
    meta: {
      auth: false
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
  // ADMIN ROUTES
  {
    path: '/admin',
    name: 'admin.home',
    redirect: { name: 'admin.dashboard' },
    component: AdminAppBase,
    meta: {
      auth: {roles: ADMIN, redirect: {name: 'login'}, forbiddenRedirect: '/403'}
    },
    children: [
        {
            path: '/admin/paket',
            name: 'admin.paket.list',
            component: PaketTable,
        },
        {
            path: '/admin/paket/add',
            name: 'admin.paket.tambah',
            component: PaketForm
        },
        {
            path: '/admin/paket/edit/:id',
            name: 'admin.paket.edit',
            component: PaketForm,
            meta: {
                editPage: true,
            }
        }
    ]
  },
]

const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})

export default router
