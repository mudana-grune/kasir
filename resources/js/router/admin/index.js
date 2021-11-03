import paket from './modules/paket';
import dashboard from './modules/dashboard';
import AppBase from '../../components/AppBase';
import kasir from './modules/kasir';

const ADMIN = 2;
const adminRoutes = {
    path: '/admin',
    name: 'admin.home',
    redirect: { name: 'admin.dashboard'},
    component: AppBase,
    meta: {
        auth: {roles: ADMIN, redirect: {name: 'login'}, forbiddenRedirect: '/403'},
        main: true
    },
    children : [
        ...paket,
        ...kasir,
        ...dashboard
    ]
}

export default adminRoutes;
