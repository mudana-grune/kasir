import user from './modules/user';
import AppBase from '../../components/AppBase';
import dashboard from './modules/dashboard';
import cabang from './modules/cabang';

const MANAGER = 3;
const managerRoutes = {
    path: '/manager',
    name: 'manager.home',
    redirect: { name: 'manager.dashboard'},
    component: AppBase,
    meta: {
        auth: {roles: MANAGER, redirect: {name: 'login'}, forbiddenRedirect: '/403'},
        main: true
    },
    children : [
        ...user,
        ...dashboard,
        ...cabang
    ]
}

export default managerRoutes;
